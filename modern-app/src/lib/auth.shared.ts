import type { Session, User } from 'next-auth';
import type { JWT } from 'next-auth/jwt';

export const protectedPrefixes = ['/dashboard'];
export const authPrefixes = ['/sign-in'];

export function matchesPrefix(pathname: string, prefixes: string[]) {
  return prefixes.some(
    (prefix) => pathname === prefix || pathname.startsWith(`${prefix}/`),
  );
}

export function applyUserToToken(token: JWT, user?: User) {
  if (user) {
    token.id = user.id;
    token.permissions = user.permissions;
    token.isActive = user.isActive;
  }

  return token;
}

export function applyTokenToSession(session: Session, token: JWT) {
  if (session.user) {
    session.user.id = token.id ?? '';
    session.user.permissions = Array.isArray(token.permissions)
      ? token.permissions.filter((permission): permission is string => typeof permission === 'string')
      : [];
    session.user.isActive = token.isActive === true;
  }

  return session;
}
