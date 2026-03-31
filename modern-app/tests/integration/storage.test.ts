// @vitest-environment node

import { mkdtemp, rm, stat } from 'node:fs/promises';
import { tmpdir } from 'node:os';
import path from 'node:path';

import { afterEach, describe, expect, it } from 'vitest';

const tempRoots: string[] = [];

afterEach(async () => {
  await Promise.all(
    tempRoots.splice(0).map(async (root) => {
      await rm(root, { force: true, recursive: true });
    }),
  );
});

describe('storage primitives', () => {
  it('validates upload metadata and prepares sanitized storage paths', async () => {
    const root = await mkdtemp(path.join(tmpdir(), 'secun-storage-'));
    tempRoots.push(root);

    const { uploadMetadataSchema } = await import('@/src/modules/uploads/upload.schemas');
    const { ensureStorageDirectories, resolveStoragePath } = await import('@/src/lib/storage');

    expect(
      uploadMetadataSchema.parse({
        fileName: '../Inspection Photo 01.PNG',
        mimeType: 'image/png',
        sizeBytes: 10 * 1024 * 1024,
      }),
    ).toEqual({
      fileName: '../Inspection Photo 01.PNG',
      mimeType: 'image/png',
      sizeBytes: 10 * 1024 * 1024,
    });

    expect(() =>
      uploadMetadataSchema.parse({
        fileName: 'malware.exe',
        mimeType: 'application/octet-stream',
        sizeBytes: 512,
      }),
    ).toThrowError(/mime/i);

    expect(() =>
      uploadMetadataSchema.parse({
        fileName: 'oversized.pdf',
        mimeType: 'application/pdf',
        sizeBytes: 10 * 1024 * 1024 + 1,
      }),
    ).toThrowError(/10MB|size/i);

    await ensureStorageDirectories(root, ['generated-pdfs', 'equipment/uploads']);

    await expect(stat(path.join(root, 'generated-pdfs'))).resolves.toMatchObject({
      isDirectory: expect.any(Function),
    });
    await expect(stat(path.join(root, 'equipment', 'uploads'))).resolves.toMatchObject({
      isDirectory: expect.any(Function),
    });

    const pdfPath = resolveStoragePath({
      root,
      pdfOutputDir: 'generated-pdfs',
      uploadOutputDir: 'equipment/uploads',
      category: 'pdf',
      fileName: '../Quarterly Report 2026.pdf',
    });
    const uploadPath = resolveStoragePath({
      root,
      pdfOutputDir: 'generated-pdfs',
      uploadOutputDir: 'equipment/uploads',
      category: 'uploads',
      fileName: 'equip<>ment image.webp',
    });

    expect(pdfPath).toBe(path.join(root, 'generated-pdfs', 'quarterly-report-2026.pdf'));
    expect(uploadPath).toBe(path.join(root, 'equipment', 'uploads', 'equip-ment-image.webp'));
  });

  it('rejects storage directories that escape the configured root', async () => {
    const root = await mkdtemp(path.join(tmpdir(), 'secun-storage-'));
    tempRoots.push(root);

    const { ensureStorageDirectories } = await import('@/src/lib/storage');

    await expect(ensureStorageDirectories(root, ['pdf', '../outside'])).rejects.toThrowError(
      /storage root|outside|escape/i,
    );
  });

  it('sanitizes windows-reserved file basenames', async () => {
    const root = await mkdtemp(path.join(tmpdir(), 'secun-storage-'));
    tempRoots.push(root);

    const { resolveStoragePath } = await import('@/src/lib/storage');

    expect(
      resolveStoragePath({
        root,
        pdfOutputDir: 'generated-pdfs',
        uploadOutputDir: 'equipment/uploads',
        category: 'uploads',
        fileName: 'CON.txt',
      }),
    ).toBe(path.join(root, 'equipment', 'uploads', 'file-con.txt'));

    expect(
      resolveStoragePath({
        root,
        pdfOutputDir: 'generated-pdfs',
        uploadOutputDir: 'equipment/uploads',
        category: 'pdf',
        fileName: 'nul.PDF',
      }),
    ).toBe(path.join(root, 'generated-pdfs', 'file-nul.pdf'));
  });
});
