// @vitest-environment node

import { readFile } from 'node:fs/promises';

import { describe, expect, it, vi } from 'vitest';

vi.mock('next-auth', () => ({
  default: () => ({
    handlers: {
      GET: () => null,
      POST: () => null,
    },
    auth: vi.fn(),
    signIn: vi.fn(),
    signOut: vi.fn(),
  }),
}));

vi.mock('next-auth/providers/credentials', () => ({
  default: (config: unknown) => config,
}));

const activeUser = {
  id: 'user_admin',
  email: 'admin@secun.local',
  name: 'System Administrator',
  passwordHash:
    '$2b$10$ueHCQTJJz2KCV.A1c6Igbep1DvVt8GXNEVvEW0YuKB.FEYdJ3vFji',
  isActive: true,
  permissions: ['users.view', 'reports.view'],
};

describe('auth options', () => {
  it('authorizes an active user and exposes permissions on the returned identity', async () => {
    const { authorizeCredentials } = await import('@/src/lib/auth');
    const comparePassword = vi.fn(async () => true);

    const user = await authorizeCredentials({
      email: 'admin@secun.local',
      password: 'change-me',
    }, {
      findByEmail: async () => activeUser,
    }, comparePassword);

    expect(user).toEqual(
      expect.objectContaining({
        id: 'user_admin',
        name: 'System Administrator',
        email: 'admin@secun.local',
        isActive: true,
        permissions: expect.arrayContaining(['users.view', 'reports.view']),
      }),
    );
    expect(comparePassword).toHaveBeenCalledWith('change-me', activeUser.passwordHash);
  });

  it('rejects missing, invalid, or inactive users', async () => {
    const { authorizeCredentials } = await import('@/src/lib/auth');
    const comparePassword = vi.fn(async () => true);

    await expect(
      authorizeCredentials({
        email: 'not-an-email',
        password: '',
      }, {
        findByEmail: async () => activeUser,
      }, comparePassword),
    ).resolves.toBeNull();

    await expect(
      authorizeCredentials({
        email: 'missing@secun.local',
        password: 'change-me',
      }, {
        findByEmail: async () => null,
      }, comparePassword),
    ).resolves.toBeNull();

    await expect(
      authorizeCredentials({
        email: 'inactive@secun.local',
        password: 'change-me',
      }, {
        findByEmail: async () => ({
          ...activeUser,
          email: 'inactive@secun.local',
          isActive: false,
        }),
      }, comparePassword),
    ).resolves.toBeNull();

    await expect(
      authorizeCredentials({
        email: 'admin@secun.local',
        password: 'wrong-password',
      }, {
        findByEmail: async () => activeUser,
      }, async () => false),
    ).resolves.toBeNull();
  });

  it('records sign-in success and failure audit events without breaking authorization', async () => {
    const { authorizeCredentials } = await import('@/src/lib/auth');
    const auditLogger = vi.fn(async () => undefined);
    const oversizedIp = '203.0.113.10'.repeat(5);
    const oversizedUserAgent = 'Vitest Browser '.repeat(30);
    const request = new Request('http://127.0.0.1:3000/sign-in', {
      headers: {
        'x-forwarded-for': `${oversizedIp}, 10.0.0.1`,
        'user-agent': oversizedUserAgent,
      },
    });

    await expect(
      authorizeCredentials(
        {
          email: 'admin@secun.local',
          password: 'change-me',
        },
        {
          findByEmail: async () => activeUser,
        },
        async () => true,
        {
          auditLogger,
          request,
        },
      ),
    ).resolves.toEqual(
      expect.objectContaining({
        id: 'user_admin',
        email: 'admin@secun.local',
      }),
    );

    expect(auditLogger).toHaveBeenCalledWith(
      expect.objectContaining({
        actorId: 'user_admin',
        action: 'sign_in.success',
        entityType: 'auth',
        entityId: 'user_admin',
        ipAddress: oversizedIp.slice(0, 45),
        userAgent: oversizedUserAgent.slice(0, 255),
        metadata: expect.objectContaining({
          email: 'admin@secun.local',
        }),
      }),
    );

    auditLogger.mockClear();

    await expect(
      authorizeCredentials(
        {
          email: 'admin@secun.local',
          password: 'wrong-password',
        },
        {
          findByEmail: async () => activeUser,
        },
        async () => false,
        {
          auditLogger,
          request,
        },
      ),
    ).resolves.toBeNull();

    expect(auditLogger).toHaveBeenCalledWith(
      expect.objectContaining({
        action: 'sign_in.failure',
        entityType: 'auth',
        ipAddress: oversizedIp.slice(0, 45),
        userAgent: oversizedUserAgent.slice(0, 255),
        metadata: expect.objectContaining({
          email: 'admin@secun.local',
          reason: 'invalid_password',
        }),
      }),
    );
  });

  it('reuses the validated session user on protected app surfaces', async () => {
    const { getCurrentSessionUser } = await import('@/src/lib/auth');

    await expect(
      getCurrentSessionUser(async () => ({
        user: {
          id: 'user_admin',
          email: 'admin@secun.local',
          name: 'System Administrator',
          isActive: true,
          permissions: ['reports.view'],
        },
      })),
    ).resolves.toEqual(
      expect.objectContaining({
        id: 'user_admin',
        permissions: ['reports.view'],
      }),
    );

    const layoutSource = await readFile('app/(app)/layout.tsx', 'utf8');
    const dashboardPageSource = await readFile('app/(app)/dashboard/page.tsx', 'utf8');

    expect(layoutSource).toContain("getCurrentSessionUser");
    expect(layoutSource).not.toContain("resolveSessionUser");
    expect(dashboardPageSource).toContain("getCurrentSessionUser");
    expect(dashboardPageSource).not.toContain("resolveSessionUser");
  });

  it('keeps middleware on an edge-safe auth path and re-checks deactivated users after sign-in', async () => {
    const { authConfig } = await import('@/src/lib/auth');
    const middlewareSource = await readFile('middleware.ts', 'utf8');

    expect(middlewareSource).toContain("@/src/lib/auth-edge");
    expect(middlewareSource).not.toContain("@/src/lib/auth'");
    expect(authConfig.callbacks?.authorized).toBeTypeOf('function');

    expect(
      authConfig.callbacks?.authorized?.({
        auth: {
          user: {
            id: 'user_admin',
            isActive: false,
          },
        },
        request: {
          nextUrl: new URL('http://localhost:3000/dashboard'),
        },
      } as never),
    ).toBe(false);
  });

  it('limits invalid-credentials UI to CredentialsSignin and removes seeded defaults', async () => {
    const signInPageSource = await readFile('app/(auth)/sign-in/page.tsx', 'utf8');

    expect(signInPageSource).toContain("error.type === 'CredentialsSignin'");
    expect(signInPageSource).not.toContain('defaultValue="admin@secun.local"');
    expect(signInPageSource).not.toContain('defaultValue="change-me"');
  });

  it('revalidates session users against the repository for protected routes', async () => {
    const { resolveSessionUser } = await import('@/src/lib/auth');

    await expect(
      resolveSessionUser(
        { id: 'user_admin', email: 'admin@secun.local', name: 'System Administrator' },
        {
          findById: async () => ({
            id: 'user_admin',
            email: 'admin@secun.local',
            name: 'System Administrator',
            isActive: false,
            permissions: ['users.view'],
          }),
          findByEmail: async () => activeUser,
        },
      ),
    ).resolves.toBeNull();
  });

  it('uses a supported prisma config shape for builds', async () => {
    const prismaConfigSource = await readFile('prisma.config.ts', 'utf8');

    expect(prismaConfigSource).not.toContain('datasource:');
  });
});
