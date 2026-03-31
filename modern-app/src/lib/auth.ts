import 'server-only';

import bcrypt from 'bcryptjs';
import { cache } from 'react';
import NextAuth from 'next-auth';
import Credentials from 'next-auth/providers/credentials';

import {
  logAuditEvent,
  normalizeAuditLogInput,
  type AuditLogInput,
} from '@/src/lib/audit';
import { authConfig as baseAuthConfig } from '@/src/lib/auth.config';
import { applyTokenToSession, applyUserToToken } from '@/src/lib/auth.shared';
import { normalizePermissions } from '@/src/lib/permissions';
import { credentialsSchema } from '@/src/modules/users/user.schemas';
import {
  userRepository,
  type UserRecord,
  type UserRepository,
} from '@/src/modules/users/user.repository';

type AuthenticatedUser = Omit<UserRecord, 'passwordHash'>;
type ComparePassword = (password: string, passwordHash: string) => Promise<boolean>;
type AuditLogger = (entry: AuditLogInput) => Promise<unknown>;
type SessionUserInput = {
  id?: string | null;
  email?: string | null;
  name?: string | null;
  isActive?: boolean | null;
  permissions?: string[] | null;
};
type AuthorizeCredentialsOptions = {
  auditLogger?: AuditLogger;
  request?: Request;
};
type SessionLike = {
  user?: SessionUserInput | null;
} | null;

function extractCredentialEmail(credentials: unknown) {
  if (typeof credentials !== 'object' || credentials === null) {
    return null;
  }

  const email = Reflect.get(credentials, 'email');

  if (typeof email !== 'string') {
    return null;
  }

  const normalizedEmail = email.trim();

  return normalizedEmail.length > 0 ? normalizedEmail : null;
}

function getRequestAuditMetadata(request?: Request) {
  const forwardedFor = request?.headers.get('x-forwarded-for');
  const ipAddress =
    forwardedFor?.split(',')[0]?.trim() || request?.headers.get('x-real-ip')?.trim() || null;
  const userAgent = request?.headers.get('user-agent')?.trim() || null;
  const normalizedAuditInput = normalizeAuditLogInput({
    action: 'audit.preview',
    entityType: 'auth',
    ipAddress,
    userAgent,
  });

  return {
    ipAddress: normalizedAuditInput.ipAddress ?? null,
    userAgent: normalizedAuditInput.userAgent ?? null,
  };
}

async function safeLogAuditEvent(auditLogger: AuditLogger | undefined, entry: AuditLogInput) {
  if (!auditLogger) {
    return;
  }

  try {
    await auditLogger(entry);
  } catch (error) {
    console.error('Failed to write audit log entry.', error);
  }
}

async function logSignInAuditEvent(
  auditLogger: AuditLogger | undefined,
  request: Request | undefined,
  details: {
    action: 'sign_in.success' | 'sign_in.failure';
    actorId?: string | null;
    entityId?: string | null;
    email?: string | null;
    reason?: string;
  },
) {
  const metadata: Record<string, string> = {};

  if (details.email) {
    metadata.email = details.email;
  }

  if (details.reason) {
    metadata.reason = details.reason;
  }

  await safeLogAuditEvent(auditLogger, {
    actorId: details.actorId ?? null,
    action: details.action,
    entityType: 'auth',
    entityId: details.entityId ?? null,
    metadata,
    ...getRequestAuditMetadata(request),
  });
}

export async function authorizeCredentials(
  credentials: unknown,
  repository: UserRepository = userRepository,
  comparePassword: ComparePassword = bcrypt.compare,
  options: AuthorizeCredentialsOptions = {},
): Promise<AuthenticatedUser | null> {
  const credentialEmail = extractCredentialEmail(credentials);
  const parsedCredentials = credentialsSchema.safeParse(credentials);

  if (!parsedCredentials.success) {
    await logSignInAuditEvent(options.auditLogger, options.request, {
      action: 'sign_in.failure',
      email: credentialEmail,
      reason: 'invalid_payload',
    });

    return null;
  }

  const user = await repository.findByEmail(parsedCredentials.data.email);

  if (!user) {
    await logSignInAuditEvent(options.auditLogger, options.request, {
      action: 'sign_in.failure',
      email: parsedCredentials.data.email,
      reason: 'user_not_found',
    });

    return null;
  }

  if (!user.isActive) {
    await logSignInAuditEvent(options.auditLogger, options.request, {
      action: 'sign_in.failure',
      actorId: user.id,
      entityId: user.id,
      email: user.email,
      reason: 'inactive_user',
    });

    return null;
  }

  const passwordMatches = await comparePassword(
    parsedCredentials.data.password,
    user.passwordHash,
  );

  if (!passwordMatches) {
    await logSignInAuditEvent(options.auditLogger, options.request, {
      action: 'sign_in.failure',
      actorId: user.id,
      entityId: user.id,
      email: user.email,
      reason: 'invalid_password',
    });

    return null;
  }

  const authenticatedUser = {
    id: user.id,
    email: user.email,
    name: user.name,
    isActive: user.isActive,
    permissions: user.permissions,
  };

  await logSignInAuditEvent(options.auditLogger, options.request, {
    action: 'sign_in.success',
    actorId: user.id,
    entityId: user.id,
    email: user.email,
  });

  return authenticatedUser;
}

export async function resolveSessionUser(
  sessionUser: SessionUserInput | null | undefined,
  repository: UserRepository = userRepository,
) {
  if (!sessionUser?.id) {
    return null;
  }

  const currentUser = await repository.findById(sessionUser.id);

  if (!currentUser || !currentUser.isActive) {
    return null;
  }

  return currentUser;
}

export const getCurrentSessionUser = cache(async (getSession: () => Promise<SessionLike> = auth) => {
  const session = await getSession();
  const sessionUser = session?.user;

  if (!sessionUser?.id || sessionUser.isActive !== true) {
    return null;
  }

  return {
    id: sessionUser.id,
    email: sessionUser.email ?? '',
    name: sessionUser.name ?? '',
    isActive: true,
    permissions: normalizePermissions(sessionUser.permissions),
  };
});

export const authConfig = {
  ...baseAuthConfig,
  providers: [
    Credentials({
      credentials: {
        email: { label: 'Email', type: 'email' },
        password: { label: 'Password', type: 'password' },
      },
      authorize: (credentials, request) =>
        authorizeCredentials(credentials, userRepository, bcrypt.compare, {
          auditLogger: logAuditEvent,
          request,
        }),
    }),
  ],
  callbacks: {
    ...baseAuthConfig.callbacks,
    jwt({ token, user }) {
      return applyUserToToken(token, user);
    },
    async session({ session, token }) {
      const sessionWithToken = applyTokenToSession(session, token);
      const currentUser = await resolveSessionUser(sessionWithToken.user);

      if (!sessionWithToken.user) {
        return sessionWithToken;
      }

      if (!currentUser) {
        sessionWithToken.user.isActive = false;
        sessionWithToken.user.permissions = [];
        return sessionWithToken;
      }

      sessionWithToken.user.id = currentUser.id;
      sessionWithToken.user.email = currentUser.email;
      sessionWithToken.user.name = currentUser.name;
      sessionWithToken.user.isActive = currentUser.isActive;
      sessionWithToken.user.permissions = currentUser.permissions;

      return sessionWithToken;
    },
  },
} satisfies Parameters<typeof NextAuth>[0];

export const { handlers, auth, signIn, signOut } = NextAuth(authConfig);
