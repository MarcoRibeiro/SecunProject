import {
  PERMISSION_ACTIONS,
  PERMISSION_MODULES,
  type PermissionModule,
} from '@/src/modules/permissions/permission.constants';

type ModulePermissions = Record<PermissionModule, string[]>;

export const MODULE_PERMISSIONS = PERMISSION_MODULES.reduce<ModulePermissions>(
  (permissionsByModule, moduleName) => {
    permissionsByModule[moduleName] = PERMISSION_ACTIONS.map(
      (action) => `${moduleName}.${action}`,
    );

    return permissionsByModule;
  },
  {} as ModulePermissions,
);

export const ALL_MODULE_PERMISSIONS = PERMISSION_MODULES.flatMap(
  (moduleName) => MODULE_PERMISSIONS[moduleName],
);

const KNOWN_PERMISSIONS = new Set(ALL_MODULE_PERMISSIONS);

export function normalizePermissions(grantedPermissions: Iterable<unknown> | null | undefined) {
  const normalizedPermissions: string[] = [];
  const seenPermissions = new Set<string>();

  if (!grantedPermissions) {
    return normalizedPermissions;
  }

  for (const permission of grantedPermissions) {
    if (typeof permission !== 'string') {
      continue;
    }

    const normalizedPermission = permission.trim();

    if (!KNOWN_PERMISSIONS.has(normalizedPermission) || seenPermissions.has(normalizedPermission)) {
      continue;
    }

    seenPermissions.add(normalizedPermission);
    normalizedPermissions.push(normalizedPermission);
  }

  return normalizedPermissions;
}

export function hasModuleAccess(
  grantedPermissions: Iterable<string>,
  moduleName: PermissionModule,
) {
  const grantedPermissionSet = new Set(normalizePermissions(grantedPermissions));

  return MODULE_PERMISSIONS[moduleName].some((permission) =>
    grantedPermissionSet.has(permission),
  );
}

export function canAccessModule(
  grantedPermissions: Iterable<unknown> | null | undefined,
  moduleName: PermissionModule,
) {
  return hasModuleAccess(normalizePermissions(grantedPermissions), moduleName);
}
