import { defineConfig } from '@playwright/test';

const port = process.env.PLAYWRIGHT_PORT ?? '3100';
const baseURL = `http://127.0.0.1:${port}`;
const databaseURL =
  process.env.DATABASE_URL_TEST ??
  process.env.DATABASE_URL ??
  'mysql://secun:secun@127.0.0.1:3307/secun_test';

export default defineConfig({
  testDir: './tests/e2e',
  use: {
    baseURL,
  },
  webServer: {
    command: `npx prisma db push --skip-generate && npx prisma db seed && npm run dev -- --hostname 127.0.0.1 --port ${port}`,
    env: {
      ...process.env,
      DATABASE_URL: databaseURL,
      AUTH_SECRET: process.env.AUTH_SECRET ?? 'playwright-e2e-secret',
      AUTH_TRUST_HOST: process.env.AUTH_TRUST_HOST ?? 'true',
      APP_URL: process.env.APP_URL ?? baseURL,
      STORAGE_ROOT: process.env.STORAGE_ROOT ?? './storage',
      PDF_OUTPUT_DIR: process.env.PDF_OUTPUT_DIR ?? 'pdf',
      UPLOAD_OUTPUT_DIR: process.env.UPLOAD_OUTPUT_DIR ?? 'uploads',
    },
    url: baseURL,
    reuseExistingServer: !process.env.CI,
  },
});
