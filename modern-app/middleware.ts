import { NextResponse } from 'next/server';

import { auth } from '@/src/lib/auth-edge';
import { authPrefixes, matchesPrefix, protectedPrefixes } from '@/src/lib/auth.shared';

export default auth((request) => {
  const { pathname } = request.nextUrl;
  const isAuthenticated = Boolean(request.auth?.user);
  const isActive = request.auth?.user?.isActive === true;

  if ((!isAuthenticated || !isActive) && matchesPrefix(pathname, protectedPrefixes)) {
    return NextResponse.redirect(new URL('/sign-in', request.nextUrl));
  }

  if (isAuthenticated && isActive && matchesPrefix(pathname, authPrefixes)) {
    return NextResponse.redirect(new URL('/dashboard', request.nextUrl));
  }

  return NextResponse.next();
});

export const config = {
  matcher: ['/((?!api/auth|_next/static|_next/image|favicon.ico|.*\\..*).*)'],
};
