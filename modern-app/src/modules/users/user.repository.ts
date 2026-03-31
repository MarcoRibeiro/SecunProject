import 'server-only';

import { db } from '@/src/lib/db';

export type UserRecord = {
  id: string;
  email: string;
  name: string;
  passwordHash: string;
  isActive: boolean;
  permissions: string[];
};

export type UserSessionRecord = Omit<UserRecord, 'passwordHash'>;

export type UserRepository = {
  findByEmail(email: string): Promise<UserRecord | null>;
  findById(id: string): Promise<UserSessionRecord | null>;
};

function mapUserRecord(user: {
  id: string;
  email: string;
  name: string;
  isActive: boolean;
  roles: Array<{
    role: {
      permissions: Array<{
        permission: {
          key: string;
        };
      }>;
    };
  }>;
}) {
  const permissions = Array.from(
    new Set(
      user.roles.flatMap((membership) =>
        membership.role.permissions.map((grant) => grant.permission.key),
      ),
    ),
  );

  return {
    id: user.id,
    email: user.email,
    name: user.name,
    isActive: user.isActive,
    permissions,
  };
}

export const userRepository: UserRepository = {
  async findByEmail(email) {
    const user = await db.user.findUnique({
      where: { email },
      select: {
        id: true,
        email: true,
        name: true,
        passwordHash: true,
        isActive: true,
        roles: {
          select: {
            role: {
              select: {
                permissions: {
                  select: {
                    permission: {
                      select: {
                        key: true,
                      },
                    },
                  },
                },
              },
            },
          },
        },
      },
    });

    if (!user) {
      return null;
    }

    return {
      ...mapUserRecord(user),
      passwordHash: user.passwordHash,
    };
  },
  async findById(id) {
    const user = await db.user.findUnique({
      where: { id },
      select: {
        id: true,
        email: true,
        name: true,
        isActive: true,
        roles: {
          select: {
            role: {
              select: {
                permissions: {
                  select: {
                    permission: {
                      select: {
                        key: true,
                      },
                    },
                  },
                },
              },
            },
          },
        },
      },
    });

    if (!user) {
      return null;
    }

    return mapUserRecord(user);
  },
};
