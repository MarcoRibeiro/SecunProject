import { mkdir } from 'node:fs/promises';
import path from 'node:path';

export type StorageCategory = 'pdf' | 'uploads';

export const DEFAULT_STORAGE_ROOT = './storage';

const defaultStorageDirectories = {
  pdf: 'pdf',
  uploads: 'uploads',
} as const;

const windowsReservedBasenames = new Set([
  'con',
  'prn',
  'aux',
  'nul',
  'com1',
  'com2',
  'com3',
  'com4',
  'com5',
  'com6',
  'com7',
  'com8',
  'com9',
  'lpt1',
  'lpt2',
  'lpt3',
  'lpt4',
  'lpt5',
  'lpt6',
  'lpt7',
  'lpt8',
  'lpt9',
]);

type StorageRuntimeConfigInput = {
  STORAGE_ROOT?: string;
  PDF_OUTPUT_DIR?: string;
  UPLOAD_OUTPUT_DIR?: string;
};

type ResolvedStorageDirectories = {
  root: string;
  pdf: string;
  uploads: string;
};

type ResolveStoragePathInput = {
  root: string;
  pdfOutputDir?: string;
  uploadOutputDir?: string;
  category: StorageCategory;
  fileName: string;
};

function isWithinRoot(root: string, target: string) {
  const relativePath = path.relative(root, target);

  return relativePath === '' || (!relativePath.startsWith('..') && !path.isAbsolute(relativePath));
}

function resolveRootConfinedDirectory(root: string, directory: string) {
  const normalizedRoot = path.resolve(root);
  const candidates = path.isAbsolute(directory)
    ? [path.resolve(directory)]
    : [path.resolve(directory), path.resolve(normalizedRoot, directory)];

  for (const candidate of candidates) {
    if (isWithinRoot(normalizedRoot, candidate)) {
      return candidate;
    }
  }

  throw new Error(`Storage directory must stay within the storage root: ${directory}`);
}

export function buildStorageRuntimeConfig(input: StorageRuntimeConfigInput = {}) {
  const storageRoot = input.STORAGE_ROOT || DEFAULT_STORAGE_ROOT;

  return {
    STORAGE_ROOT: storageRoot,
    PDF_OUTPUT_DIR: input.PDF_OUTPUT_DIR || path.join(storageRoot, defaultStorageDirectories.pdf),
    UPLOAD_OUTPUT_DIR:
      input.UPLOAD_OUTPUT_DIR || path.join(storageRoot, defaultStorageDirectories.uploads),
  };
}

export function resolveStorageDirectories(
  input: StorageRuntimeConfigInput & { root?: string; pdfOutputDir?: string; uploadOutputDir?: string },
): ResolvedStorageDirectories {
  const runtimeConfig = buildStorageRuntimeConfig({
    STORAGE_ROOT: input.STORAGE_ROOT || input.root,
    PDF_OUTPUT_DIR: input.PDF_OUTPUT_DIR || input.pdfOutputDir,
    UPLOAD_OUTPUT_DIR: input.UPLOAD_OUTPUT_DIR || input.uploadOutputDir,
  });
  const root = path.resolve(runtimeConfig.STORAGE_ROOT);

  return {
    root,
    pdf: resolveRootConfinedDirectory(root, runtimeConfig.PDF_OUTPUT_DIR),
    uploads: resolveRootConfinedDirectory(root, runtimeConfig.UPLOAD_OUTPUT_DIR),
  };
}

function sanitizeFileName(fileName: string) {
  const parsed = path.parse(fileName.replaceAll('\\', '/').split('/').pop() ?? 'file');
  const extension = parsed.ext.toLowerCase().replace(/[^a-z0-9.]/g, '');
  const baseName = parsed.name
    .toLowerCase()
    .replace(/[^a-z0-9]+/g, '-')
    .replace(/^-+|-+$/g, '');

  let safeBaseName = baseName || 'file';

  if (windowsReservedBasenames.has(safeBaseName)) {
    safeBaseName = `file-${safeBaseName}`;
  }

  return `${safeBaseName}${extension}`;
}

export function resolveStoragePath({
  root,
  pdfOutputDir,
  uploadOutputDir,
  category,
  fileName,
}: ResolveStoragePathInput) {
  const directories = resolveStorageDirectories({
    root,
    pdfOutputDir,
    uploadOutputDir,
  });

  return path.join(directories[category], sanitizeFileName(fileName));
}

export async function ensureStorageDirectories(root: string, directories: string[]) {
  const normalizedRoot = path.resolve(root);

  await mkdir(normalizedRoot, { recursive: true });

  await Promise.all(
    directories.map(async (directory) => {
      await mkdir(resolveRootConfinedDirectory(normalizedRoot, directory), { recursive: true });
    }),
  );
}
