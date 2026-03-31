import { canAccessModule } from '@/src/lib/permissions';
import {
  PERMISSION_MODULES,
  type PermissionModule,
} from '@/src/modules/permissions/permission.constants';

export type AppNavItem = {
  href: string;
  label: string;
  module?: PermissionModule;
};

type ModulePlaceholder = {
  heading: string;
  description: string;
};

export const APP_NAV_ITEMS: AppNavItem[] = [
  { href: '/dashboard', label: 'Dashboard' },
  { href: '/dashboard?module=clients', label: 'Clients', module: 'clients' },
  { href: '/dashboard?module=equipment', label: 'Equipment', module: 'equipment' },
  { href: '/dashboard?module=repairs', label: 'Repairs', module: 'repairs' },
  { href: '/dashboard?module=stock', label: 'Stock', module: 'stock' },
  { href: '/dashboard?module=users', label: 'Users', module: 'users' },
  { href: '/dashboard?module=settings', label: 'Settings', module: 'settings' },
  { href: '/dashboard?module=reports', label: 'Reports', module: 'reports' },
];

const MODULE_PLACEHOLDERS: Record<PermissionModule, ModulePlaceholder> = {
  clients: {
    heading: 'Clients overview',
    description: 'Review client records, intake status, and upcoming follow-ups for the selected account list.',
  },
  equipment: {
    heading: 'Equipment overview',
    description: 'Track serialized equipment, service readiness, and device assignments for the active queue.',
  },
  repairs: {
    heading: 'Repairs overview',
    description: 'Monitor repair intake, technician handoffs, and completion checkpoints for open work orders.',
  },
  stock: {
    heading: 'Stock overview',
    description: 'Watch stock availability, low-balance alerts, and replenishment priorities for core inventory.',
  },
  users: {
    heading: 'Users overview',
    description: 'Inspect team access, active staff coverage, and onboarding readiness across system users.',
  },
  settings: {
    heading: 'Settings overview',
    description: 'Review operational defaults, security settings, and workspace configuration status.',
  },
  reports: {
    heading: 'Reports overview',
    description: 'Open the reporting workspace for operational trends, audit visibility, and executive snapshots.',
  },
};

export function getVisibleNavItems(grantedPermissions: Iterable<unknown> | null | undefined) {
  return APP_NAV_ITEMS.filter(
    (item) => !item.module || canAccessModule(grantedPermissions, item.module),
  );
}

export function isPermissionModule(value: string | null | undefined): value is PermissionModule {
  return typeof value === 'string' && PERMISSION_MODULES.includes(value as PermissionModule);
}

export function getModulePlaceholder(moduleName: PermissionModule) {
  return MODULE_PLACEHOLDERS[moduleName];
}
