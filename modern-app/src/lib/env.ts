import 'server-only';

import { z } from 'zod';

const booleanString = z.preprocess((value) => {
  if (typeof value === 'boolean') {
    return value;
  }

  if (typeof value === 'string') {
    if (value === 'true') {
      return true;
    }

    if (value === 'false') {
      return false;
    }
  }

  return value;
}, z.boolean());

const envSchema = z.object({
  DATABASE_URL: z.string().min(1, 'DATABASE_URL is required'),
  AUTH_SECRET: z.string().min(1, 'AUTH_SECRET is required'),
  AUTH_TRUST_HOST: booleanString,
  APP_URL: z.string().url('APP_URL must be a valid URL'),
  STORAGE_ROOT: z.string().min(1, 'STORAGE_ROOT is required'),
  PDF_OUTPUT_DIR: z.string().min(1, 'PDF_OUTPUT_DIR is required'),
  UPLOAD_OUTPUT_DIR: z.string().min(1, 'UPLOAD_OUTPUT_DIR is required'),
});

export function buildEnv(input: Record<string, unknown>) {
  return envSchema.parse(input);
}

export const env = buildEnv(process.env);
