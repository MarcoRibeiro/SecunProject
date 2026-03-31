// @vitest-environment node

import { execFile, spawnSync } from 'node:child_process';
import { mkdtemp, readFile, rm, writeFile } from 'node:fs/promises';
import { tmpdir } from 'node:os';
import path from 'node:path';
import { promisify } from 'node:util';

import { afterEach, describe, expect, it } from 'vitest';

const execFileAsync = promisify(execFile);
const tempDirectories: string[] = [];

afterEach(async () => {
  await Promise.all(tempDirectories.splice(0).map((directory) => rm(directory, { force: true, recursive: true })));
});

describe('cpanel start helper', () => {
  it('exposes the required env keys and rejects missing startup configuration', async () => {
    const { getRequiredEnvKeys, validateRequiredEnv } = await import('../../scripts/cpanel-start.mjs');

    expect(getRequiredEnvKeys()).toEqual([
      'DATABASE_URL',
      'AUTH_SECRET',
      'AUTH_TRUST_HOST',
      'APP_URL',
      'STORAGE_ROOT',
      'PDF_OUTPUT_DIR',
      'UPLOAD_OUTPUT_DIR',
    ]);

    expect(() => validateRequiredEnv({ APP_URL: 'http://localhost:3000' })).toThrowError(
      /DATABASE_URL.*AUTH_SECRET.*AUTH_TRUST_HOST.*STORAGE_ROOT.*PDF_OUTPUT_DIR.*UPLOAD_OUTPUT_DIR/s,
    );
  });

  it('ignores .env.example and fails validation when no real runtime env is present', async () => {
    const tempDirectory = await mkdtemp(path.join(tmpdir(), 'secun-cpanel-start-'));
    tempDirectories.push(tempDirectory);
    const scriptPath = path.resolve(process.cwd(), 'scripts/cpanel-start.mjs');

    await writeFile(
      path.join(tempDirectory, '.env.example'),
      [
        'DATABASE_URL="mysql://example:example@localhost:3306/secun"',
        'AUTH_SECRET="example-secret"',
        'AUTH_TRUST_HOST="true"',
        'APP_URL="https://example.invalid"',
        'STORAGE_ROOT="./storage"',
        'PDF_OUTPUT_DIR="./storage/pdf"',
        'UPLOAD_OUTPUT_DIR="./storage/uploads"',
      ].join('\n'),
    );

    await expect(
      execFileAsync(process.execPath, [scriptPath], {
        cwd: tempDirectory,
        env: {},
      }),
    ).rejects.toMatchObject({
      stderr: expect.stringMatching(/Missing required environment variables: DATABASE_URL, AUTH_SECRET/),
    });
  });
});

describe('cpanel build helper', () => {
  it('uses npm_execpath so nested npm scripts run in this environment', async () => {
    const tempDirectory = await mkdtemp(path.join(tmpdir(), 'secun-cpanel-build-'));
    tempDirectories.push(tempDirectory);
    const scriptPath = path.resolve(process.cwd(), 'scripts/cpanel-build.mjs');
    const runnerLogPath = path.join(tempDirectory, 'runner-log.txt');
    const fakeNpmPath = path.join(tempDirectory, 'fake-npm.js');
    const childEnv = {
      PATH: process.env.PATH,
      SystemRoot: process.env.SystemRoot,
      ComSpec: process.env.ComSpec,
      TMP: process.env.TMP,
      TEMP: process.env.TEMP,
      RUNNER_LOG_PATH: runnerLogPath,
      npm_execpath: fakeNpmPath,
      npm_node_execpath: process.execPath,
    };

    await writeFile(
      fakeNpmPath,
      [
        "const fs = require('node:fs');",
        "fs.appendFileSync(process.env.RUNNER_LOG_PATH, JSON.stringify(process.argv.slice(2)) + '\\n');",
      ].join('\n'),
    );

    const result = spawnSync(process.execPath, [scriptPath], {
      cwd: process.cwd(),
      env: childEnv,
      encoding: 'utf8',
    });

    expect(result.status).toBe(0);
    const runnerLog = await readFile(runnerLogPath, 'utf8');

    expect(runnerLog).toBe('["run","prisma:generate"]\n["run","build"]\n');
  });
});
