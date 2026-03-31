import { z } from 'zod';

const maxUploadBytes = 10 * 1024 * 1024;
const allowedMimeTypes = [
  'image/jpeg',
  'image/png',
  'image/webp',
  'application/pdf',
] as const;

export const uploadMetadataSchema = z.object({
  fileName: z.string().trim().min(1),
  mimeType: z.enum(allowedMimeTypes),
  sizeBytes: z
    .number()
    .int()
    .nonnegative()
    .max(maxUploadBytes, 'File size must be 10MB or less'),
});

export type UploadMetadataInput = z.input<typeof uploadMetadataSchema>;
export type UploadMetadata = z.output<typeof uploadMetadataSchema>;
export const UPLOAD_MAX_BYTES = maxUploadBytes;
