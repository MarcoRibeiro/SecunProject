import { spawnSync } from 'node:child_process';
import path from 'node:path';
import { fileURLToPath } from 'node:url';

const BUILD_STEPS = ['prisma:generate', 'build'];

export function resolveNpmInvocation(env = process.env) {
  const npmExecPath = env.npm_execpath;
  const nodeExecPath = env.npm_node_execpath || process.execPath;

  if (typeof npmExecPath === 'string' && npmExecPath.length > 0) {
    const extension = path.extname(npmExecPath).toLowerCase();

    if (extension === '.js' || extension === '.cjs' || extension === '.mjs') {
      return {
        command: nodeExecPath,
        args: [npmExecPath],
        shell: false,
      };
    }

    return {
      command: npmExecPath,
      args: [],
      shell: false,
    };
  }

  return {
    command: process.platform === 'win32' ? 'npm' : 'npm',
    args: [],
    shell: process.platform === 'win32',
  };
}

export function runNpmScript(scriptName, options = {}) {
  const invocation = resolveNpmInvocation(options.env);
  const result = spawnSync(invocation.command, [...invocation.args, 'run', scriptName], {
    cwd: options.cwd || process.cwd(),
    env: options.env || process.env,
    stdio: 'inherit',
    shell: invocation.shell,
  });

  if (result.status !== 0) {
    throw new Error(`cpanel build step failed: ${scriptName}`);
  }
}

export function runBuildSteps(options = {}) {
  for (const step of BUILD_STEPS) {
    console.log(`Running ${step}...`);
    runNpmScript(step, options);
  }

  console.log('cPanel build completed successfully.');
}

const currentFilePath = fileURLToPath(import.meta.url);

if (process.argv[1] && path.resolve(process.argv[1]) === currentFilePath) {
  runBuildSteps();
}
