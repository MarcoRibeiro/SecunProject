import { access, readFile } from 'node:fs/promises';
import { constants } from 'node:fs';
import path from 'node:path';
import { spawnSync } from 'node:child_process';
import { fileURLToPath } from 'node:url';

const REQUIRED_ENV_KEYS = [
  'DATABASE_URL',
  'AUTH_SECRET',
  'AUTH_TRUST_HOST',
  'APP_URL',
  'STORAGE_ROOT',
  'PDF_OUTPUT_DIR',
  'UPLOAD_OUTPUT_DIR',
];

const ENV_FILE_CANDIDATES = [
  '.env.production.local',
  '.env.local',
  '.env.production',
  '.env',
];

export function getRequiredEnvKeys() {
  return [...REQUIRED_ENV_KEYS];
}

function stripWrappingQuotes(value) {
  if (
    value.length >= 2
    && ((value.startsWith('"') && value.endsWith('"')) || (value.startsWith("'") && value.endsWith("'")))
  ) {
    return value.slice(1, -1);
  }

  return value;
}

function parseEnvFile(source) {
  const parsed = {};

  for (const rawLine of source.split(/\r?\n/u)) {
    const line = rawLine.trim();

    if (!line || line.startsWith('#')) {
      continue;
    }

    const separatorIndex = line.indexOf('=');

    if (separatorIndex === -1) {
      continue;
    }

    const key = line.slice(0, separatorIndex).trim();
    const value = stripWrappingQuotes(line.slice(separatorIndex + 1).trim());

    if (key) {
      parsed[key] = value;
    }
  }

  return parsed;
}

async function fileExists(filePath) {
  try {
    await access(filePath, constants.F_OK);
    return true;
  } catch {
    return false;
  }
}

export async function loadDefaultEnvFiles(cwd = process.cwd()) {
  const loadedFiles = [];

  for (const fileName of ENV_FILE_CANDIDATES) {
    const filePath = path.join(cwd, fileName);

    if (!(await fileExists(filePath))) {
      continue;
    }

    const fileContents = await readFile(filePath, 'utf8');
    const parsed = parseEnvFile(fileContents);

    for (const [key, value] of Object.entries(parsed)) {
      process.env[key] ??= value;
    }

    loadedFiles.push(fileName);
  }

  return loadedFiles;
}

export function validateRequiredEnv(input = process.env) {
  const missingKeys = REQUIRED_ENV_KEYS.filter((key) => {
    const value = input[key];
    return typeof value !== 'string' || value.trim() === '';
  });

  if (missingKeys.length > 0) {
    throw new Error(`Missing required environment variables: ${missingKeys.join(', ')}`);
  }

  if (!['true', 'false'].includes(String(input.AUTH_TRUST_HOST))) {
    throw new Error('AUTH_TRUST_HOST must be either true or false');
  }

  try {
    new URL(String(input.APP_URL));
  } catch {
    throw new Error('APP_URL must be a valid URL');
  }

  return Object.fromEntries(REQUIRED_ENV_KEYS.map((key) => [key, String(input[key]) ]));
}

function ensureNextBuildExists(cwd = process.cwd()) {
  return fileExists(path.join(cwd, '.next', 'BUILD_ID'));
}

function runNextStart() {
  const command = process.platform === 'win32' ? 'npm.cmd' : 'npm';
  const result = spawnSync(command, ['run', 'start'], {
    cwd: process.cwd(),
    env: process.env,
    stdio: 'inherit',
  });

  if (result.status !== 0) {
    throw new Error('next start exited with a non-zero status');
  }
}

async function main() {
  const loadedFiles = await loadDefaultEnvFiles();
  const validatedEnv = validateRequiredEnv();
  const shouldServe = process.argv.includes('--serve');

  console.log(`Validated cPanel startup env keys: ${getRequiredEnvKeys().join(', ')}`);

  if (loadedFiles.length > 0) {
    console.log(`Loaded env defaults from: ${loadedFiles.join(', ')}`);
  }

  console.log(`Storage root: ${validatedEnv.STORAGE_ROOT}`);

  if (!shouldServe) {
    console.log('Validation complete. Re-run with --serve after a successful build to launch Next.js.');
    return;
  }

  if (!(await ensureNextBuildExists())) {
    throw new Error('Cannot start Next.js because .next/BUILD_ID is missing. Run npm run cpanel:build first.');
  }

  runNextStart();
}

const currentFilePath = fileURLToPath(import.meta.url);

if (process.argv[1] && path.resolve(process.argv[1]) === currentFilePath) {
  await main();
}
