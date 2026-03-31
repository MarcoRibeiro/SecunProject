import 'dotenv/config';

import { defineConfig } from 'prisma/config';

const fallbackDatabaseUrl = 'mysql://root:root@localhost:3306/secun';

process.env.DATABASE_URL ??= fallbackDatabaseUrl;

export default defineConfig({
  schema: 'prisma/schema.prisma',
  migrations: {
    path: 'prisma/migrations',
    seed: 'tsx prisma/seed.ts',
  },
});
