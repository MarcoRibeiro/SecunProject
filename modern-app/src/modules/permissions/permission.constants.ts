export const PERMISSION_MODULES = [
  'clients',
  'equipment',
  'repairs',
  'stock',
  'users',
  'settings',
  'reports',
] as const;

export const PERMISSION_ACTIONS = ['view', 'create', 'update', 'delete'] as const;

export type PermissionModule = (typeof PERMISSION_MODULES)[number];
export type PermissionAction = (typeof PERMISSION_ACTIONS)[number];
