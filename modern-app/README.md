# modern-app

## Local development

1. Copy `.env.docker.example` to `.env.docker`.
2. Copy `.env.example` to `.env`.
3. Install dependencies with `npm install`.
4. Start local dependencies with `npm run docker:up`.
5. Generate the Prisma client with `npm run prisma:generate`.
6. Push the schema into the dev database with `npx prisma db push`.
7. Seed the dev database with `npm run prisma:seed`.
8. Start the Next.js dev server with `npm run dev`.

Adminer is available at `http://127.0.0.1:8081` by default.

## Tests

- Run all unit tests with `npm test`.
- Run integration coverage with `npm run test:integration`.
- Run end-to-end coverage with `npm run test:e2e`; Playwright prefers `DATABASE_URL_TEST` and defaults to the Docker `secun_test` database.
- Run the cPanel startup validation helper with `npm run cpanel:start` after exporting real env vars or creating a real `.env` file.

## cPanel deployment

1. Upload the `modern-app` project to the server and install dependencies with `npm install`.
2. Create a real `.env` file from `.env.example` and replace every placeholder with production-safe values; `npm run cpanel:start` ignores `.env.example` on purpose.
3. Run `npm run cpanel:build` to execute `prisma generate` and `next build`. This requires the current dev dependencies because the Prisma CLI is shipped from `devDependencies`.
4. Run `npm run cpanel:start` to validate the runtime configuration before handing control to the hosted process manager.
5. Configure the cPanel Node.js application to execute `node scripts/cpanel-start.mjs --serve` for the app startup command after the build artifacts exist.

## Required environment variables

- `DATABASE_URL`
- `DATABASE_URL_TEST`
- `AUTH_SECRET`
- `AUTH_TRUST_HOST`
- `APP_URL`
- `STORAGE_ROOT`
- `PDF_OUTPUT_DIR`
- `UPLOAD_OUTPUT_DIR`

## Docker services

- `mysql` runs on `127.0.0.1:${MYSQL_PORT}` from `.env.docker`.
- `adminer` runs on `127.0.0.1:${ADMINER_PORT}` from `.env.docker`.
- The container initializes two databases: `secun_dev` and `secun_test`.
- Stop the local stack with `npm run docker:down`.
