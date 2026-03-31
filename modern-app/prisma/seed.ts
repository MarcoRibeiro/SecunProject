import { pathToFileURL } from 'node:url';

import { PrismaClient } from '@prisma/client';

import { ALL_MODULE_PERMISSIONS } from '@/src/lib/permissions';

const prisma = new PrismaClient();

const ADMIN_ROLE_KEY = 'admin';
const ADMIN_EMAIL = 'admin@secun.local';
export const DEFAULT_ADMIN_PASSWORD_HASH =
  '$2b$10$ueHCQTJJz2KCV.A1c6Igbep1DvVt8GXNEVvEW0YuKB.FEYdJ3vFji';

export function buildAdminUserSeedData() {
  return {
    update: {
      name: 'System Administrator',
      isActive: true,
    },
    create: {
      email: ADMIN_EMAIL,
      name: 'System Administrator',
      passwordHash: DEFAULT_ADMIN_PASSWORD_HASH,
      isActive: true,
    },
  };
}

export async function main() {
  for (const permissionKey of ALL_MODULE_PERMISSIONS) {
    const [moduleName, action] = permissionKey.split('.');

    await prisma.permission.upsert({
      where: { key: permissionKey },
      update: {
        module: moduleName,
        action,
        description: `${moduleName} ${action}`,
      },
      create: {
        key: permissionKey,
        module: moduleName,
        action,
        description: `${moduleName} ${action}`,
      },
    });
  }

  const adminRole = await prisma.role.upsert({
    where: { key: ADMIN_ROLE_KEY },
    update: {
      name: 'Administrator',
      description: 'Default platform administrator role',
    },
    create: {
      key: ADMIN_ROLE_KEY,
      name: 'Administrator',
      description: 'Default platform administrator role',
    },
  });

  const permissions = await prisma.permission.findMany({
    where: {
      key: {
        in: ALL_MODULE_PERMISSIONS,
      },
    },
    select: {
      id: true,
    },
  });

  for (const permission of permissions) {
    await prisma.rolePermission.upsert({
      where: {
        roleId_permissionId: {
          roleId: adminRole.id,
          permissionId: permission.id,
        },
      },
      update: {},
      create: {
        roleId: adminRole.id,
        permissionId: permission.id,
      },
    });
  }

  const adminUserSeedData = buildAdminUserSeedData();

  const adminUser = await prisma.user.upsert({
    where: { email: ADMIN_EMAIL },
    update: adminUserSeedData.update,
    create: adminUserSeedData.create,
  });

  await prisma.userRole.upsert({
    where: {
      userId_roleId: {
        userId: adminUser.id,
        roleId: adminRole.id,
      },
    },
    update: {},
    create: {
      userId: adminUser.id,
      roleId: adminRole.id,
    },
  });
}

const isDirectExecution =
  process.argv[1] !== undefined && import.meta.url === pathToFileURL(process.argv[1]).href;

if (isDirectExecution) {
  main()
    .catch((error) => {
      console.error(error);
      process.exit(1);
    })
    .finally(async () => {
      await prisma.$disconnect();
    });
}
