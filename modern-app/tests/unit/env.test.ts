import { afterEach, beforeAll, describe, expect, it, vi } from 'vitest';

const validInput = {
  DATABASE_URL: 'postgresql://postgres:postgres@localhost:5432/secun',
  AUTH_SECRET: 'super-secret-value',
  AUTH_TRUST_HOST: 'true',
  APP_URL: 'http://localhost:3000',
  STORAGE_ROOT: './storage',
  PDF_OUTPUT_DIR: './storage/pdf',
  UPLOAD_OUTPUT_DIR: './storage/uploads',
};

beforeAll(() => {
  vi.stubEnv('DATABASE_URL', validInput.DATABASE_URL);
  vi.stubEnv('AUTH_SECRET', validInput.AUTH_SECRET);
  vi.stubEnv('AUTH_TRUST_HOST', validInput.AUTH_TRUST_HOST);
  vi.stubEnv('APP_URL', validInput.APP_URL);
  vi.stubEnv('STORAGE_ROOT', validInput.STORAGE_ROOT);
  vi.stubEnv('PDF_OUTPUT_DIR', validInput.PDF_OUTPUT_DIR);
  vi.stubEnv('UPLOAD_OUTPUT_DIR', validInput.UPLOAD_OUTPUT_DIR);
});

afterEach(() => {
  vi.unstubAllEnvs();

  vi.stubEnv('DATABASE_URL', validInput.DATABASE_URL);
  vi.stubEnv('AUTH_SECRET', validInput.AUTH_SECRET);
  vi.stubEnv('AUTH_TRUST_HOST', validInput.AUTH_TRUST_HOST);
  vi.stubEnv('APP_URL', validInput.APP_URL);
  vi.stubEnv('STORAGE_ROOT', validInput.STORAGE_ROOT);
  vi.stubEnv('PDF_OUTPUT_DIR', validInput.PDF_OUTPUT_DIR);
  vi.stubEnv('UPLOAD_OUTPUT_DIR', validInput.UPLOAD_OUTPUT_DIR);
});

describe('buildEnv', () => {
  it('parses a valid environment object', async () => {
    const { buildEnv } = await import('@/src/lib/env');

    expect(buildEnv(validInput)).toEqual({
      DATABASE_URL: validInput.DATABASE_URL,
      AUTH_SECRET: validInput.AUTH_SECRET,
      AUTH_TRUST_HOST: true,
      APP_URL: validInput.APP_URL,
      STORAGE_ROOT: validInput.STORAGE_ROOT,
      PDF_OUTPUT_DIR: validInput.PDF_OUTPUT_DIR,
      UPLOAD_OUTPUT_DIR: validInput.UPLOAD_OUTPUT_DIR,
    });
  });

  it('rejects invalid environment values', async () => {
    const { buildEnv } = await import('@/src/lib/env');

    expect(() =>
      buildEnv({
        ...validInput,
        APP_URL: 'not-a-url',
        AUTH_TRUST_HOST: 'maybe',
      }),
    ).toThrowError(/APP_URL|AUTH_TRUST_HOST/);
  });
});
