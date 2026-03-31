import { readFile } from 'node:fs/promises';

import { describe, expect, it } from 'vitest';

describe('permissions helpers', () => {
  it('exposes module permissions, a flattened list, and module access checks', async () => {
    const permissionsModule = await import('@/src/lib/permissions');
    const appShellModule = await import('@/src/lib/app-shell');

    expect(permissionsModule.MODULE_PERMISSIONS).toEqual({
      clients: ['clients.view', 'clients.create', 'clients.update', 'clients.delete'],
      equipment: ['equipment.view', 'equipment.create', 'equipment.update', 'equipment.delete'],
      repairs: ['repairs.view', 'repairs.create', 'repairs.update', 'repairs.delete'],
      stock: ['stock.view', 'stock.create', 'stock.update', 'stock.delete'],
      users: ['users.view', 'users.create', 'users.update', 'users.delete'],
      settings: ['settings.view', 'settings.create', 'settings.update', 'settings.delete'],
      reports: ['reports.view', 'reports.create', 'reports.update', 'reports.delete'],
    });

    expect(permissionsModule.ALL_MODULE_PERMISSIONS).toEqual([
      'clients.view',
      'clients.create',
      'clients.update',
      'clients.delete',
      'equipment.view',
      'equipment.create',
      'equipment.update',
      'equipment.delete',
      'repairs.view',
      'repairs.create',
      'repairs.update',
      'repairs.delete',
      'stock.view',
      'stock.create',
      'stock.update',
      'stock.delete',
      'users.view',
      'users.create',
      'users.update',
      'users.delete',
      'settings.view',
      'settings.create',
      'settings.update',
      'settings.delete',
      'reports.view',
      'reports.create',
      'reports.update',
      'reports.delete',
    ]);

    expect(typeof permissionsModule.hasModuleAccess).toBe('function');
    expect(permissionsModule.hasModuleAccess(['stock.update'], 'stock')).toBe(true);
    expect(permissionsModule.hasModuleAccess(['clients.view'], 'reports')).toBe(false);
    expect(permissionsModule.hasModuleAccess([], 'users')).toBe(false);

    expect(typeof permissionsModule.normalizePermissions).toBe('function');
    expect(
      permissionsModule.normalizePermissions([
        ' reports.view ',
        'reports.view',
        'users.update',
        'unknown.permission',
        '',
      ]),
    ).toEqual(['reports.view', 'users.update']);

    expect(typeof permissionsModule.canAccessModule).toBe('function');
    expect(
      permissionsModule.canAccessModule([' reports.view ', 'users.update'], 'reports'),
    ).toBe(true);
    expect(
      permissionsModule.canAccessModule([' reports.view ', 'users.update'], 'settings'),
    ).toBe(false);

    expect(appShellModule.getVisibleNavItems(['reports.view', 'users.update'])).toEqual([
      expect.objectContaining({ href: '/dashboard', label: 'Dashboard' }),
      expect.objectContaining({ href: '/dashboard?module=users', label: 'Users' }),
      expect.objectContaining({ href: '/dashboard?module=reports', label: 'Reports' }),
    ]);
    expect(appShellModule.getVisibleNavItems(['reports.view', 'users.update'])).toHaveLength(3);
    expect(appShellModule.getModulePlaceholder('reports')).toEqual(
      expect.objectContaining({
        heading: 'Reports overview',
        description: expect.stringContaining('reporting workspace'),
      }),
    );
  });
});

describe('seed helpers', () => {
  it('keeps the admin password hash only for user creation data', async () => {
    const seedModule = await import('@/prisma/seed');

    expect(seedModule.DEFAULT_ADMIN_PASSWORD_HASH).toMatch(
      /^\$2[aby]\$\d{2}\$[./A-Za-z0-9]{53}$/,
    );
    expect(seedModule.DEFAULT_ADMIN_PASSWORD_HASH).not.toBe('change-me');

    const adminUserSeedData = seedModule.buildAdminUserSeedData();

    expect(adminUserSeedData.create.passwordHash).toBe(
      seedModule.DEFAULT_ADMIN_PASSWORD_HASH,
    );
    expect(adminUserSeedData.update).toEqual({
      name: 'System Administrator',
      isActive: true,
    });
  });
});

describe('db module', () => {
  it('is marked as server-only', async () => {
    const dbSource = await readFile('src/lib/db.ts', 'utf8');

    expect(dbSource).toContain("import 'server-only';");
  });
});
