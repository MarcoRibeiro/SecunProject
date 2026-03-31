import NextAuth from 'next-auth';

import { authConfig } from '@/src/lib/auth.config';

export const { auth } = NextAuth(authConfig);
