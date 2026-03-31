import type { NextAuthConfig } from 'next-auth';
import Credentials from 'next-auth/providers/credentials';

import {
  applyTokenToSession,
  applyUserToToken,
  authPrefixes,
  matchesPrefix,
  protectedPrefixes,
} from '@/src/lib/auth.shared';

export const authConfig = {
  pages: {
    signIn: '/sign-in',
  },
  session: {
    strategy: 'jwt',
  },
  providers: [
    Credentials({
      credentials: {
        email: { label: 'Email', type: 'email' },
        password: { label: 'Password', type: 'password' },
      },
      authorize: () => null,
    }),
  ],
  callbacks: {
    authorized({ auth, request }) {
      const { pathname } = request.nextUrl;
      const isAuthenticated = Boolean(auth?.user);
      const isActive = auth?.user?.isActive === true;

      if (matchesPrefix(pathname, protectedPrefixes)) {
        return isAuthenticated && isActive;
      }

      if (matchesPrefix(pathname, authPrefixes) && isAuthenticated && isActive) {
        return Response.redirect(new URL('/dashboard', request.nextUrl));
      }

      return true;
    },
    jwt({ token, user }) {
      return applyUserToToken(token, user);
    },
    session({ session, token }) {
      return applyTokenToSession(session, token);
    },
  },
} satisfies NextAuthConfig;
