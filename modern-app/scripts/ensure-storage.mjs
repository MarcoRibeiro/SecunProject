import { createRequire } from 'node:module';

const require = createRequire(import.meta.url);
const {
  buildStorageRuntimeConfig,
  ensureStorageDirectories,
  resolveStorageDirectories,
} = require('../src/lib/storage.ts');

const runtimeConfig = buildStorageRuntimeConfig(process.env);
const storageDirectories = resolveStorageDirectories(runtimeConfig);

await ensureStorageDirectories(runtimeConfig.STORAGE_ROOT, [
  runtimeConfig.PDF_OUTPUT_DIR,
  runtimeConfig.UPLOAD_OUTPUT_DIR,
]);

console.log(
  `Storage directories ready: ${storageDirectories.root}, ${storageDirectories.pdf}, ${storageDirectories.uploads}`,
);
