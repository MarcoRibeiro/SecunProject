import type { DefaultSession } from 'next-auth';

declare module 'next-auth' {
  interface Session {
    user: DefaultSession['user'] & {
      id: string;
      permissions: string[];
      isActive: boolean;
    };
  }

  interface User {
    id: string;
    permissions: string[];
    isActive: boolean;
  }
}

declare module 'next-auth/jwt' {
  interface JWT {
    id?: string;
    permissions?: string[];
    isActive?: boolean;
  }
}

export {};
