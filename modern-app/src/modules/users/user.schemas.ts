import { z } from 'zod';

export const credentialsSchema = z.object({
  email: z.string().trim().toLowerCase().email(),
  password: z.string().min(1),
});

export type CredentialsInput = z.input<typeof credentialsSchema>;
export type CredentialsData = z.output<typeof credentialsSchema>;
