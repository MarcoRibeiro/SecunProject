import type { ReactNode } from 'react';

import { redirect } from 'next/navigation';

import { getVisibleNavItems } from '@/src/lib/app-shell';
import { getCurrentSessionUser, signOut } from '@/src/lib/auth';

type AppLayoutProps = {
  children: ReactNode;
};

export default async function AppLayout({ children }: AppLayoutProps) {
  const currentUser = await getCurrentSessionUser();

  if (!currentUser) {
    redirect('/sign-in');
  }

  const visibleNavItems = getVisibleNavItems(currentUser.permissions);

  return (
    <div style={{ minHeight: '100vh', backgroundColor: '#f4f4f5', color: '#18181b' }}>
      <header
        style={{
          display: 'grid',
          gap: '1rem',
          padding: '1.5rem 2rem',
          borderBottom: '1px solid #e4e4e7',
          backgroundColor: '#ffffff',
        }}
      >
        <div
          style={{
            display: 'flex',
            justifyContent: 'space-between',
            alignItems: 'center',
            gap: '1rem',
            flexWrap: 'wrap',
          }}
        >
          <div>
            <strong>Secun Dashboard</strong>
            <div style={{ marginTop: '0.35rem', color: '#52525b' }}>{currentUser.email}</div>
          </div>

          <form
            action={async () => {
              'use server';
              await signOut({ redirectTo: '/sign-in' });
            }}
          >
            <button
              type="submit"
              style={{
                padding: '0.75rem 1rem',
                borderRadius: '0.75rem',
                border: '1px solid #d4d4d8',
                backgroundColor: '#ffffff',
                cursor: 'pointer',
              }}
            >
              Sign out
            </button>
          </form>
        </div>

        <nav
          aria-label="Primary navigation"
          style={{ display: 'flex', gap: '0.75rem', flexWrap: 'wrap' }}
        >
          {visibleNavItems.map((item) => (
            <a
              key={item.label}
              href={item.href}
              style={{
                display: 'inline-flex',
                padding: '0.75rem 0.875rem',
                borderRadius: '0.75rem',
                textDecoration: 'none',
                backgroundColor: item.module ? '#f4f4f5' : '#18181b',
                fontWeight: item.module ? 500 : 600,
                color: item.module ? '#18181b' : '#fafafa',
              }}
            >
              {item.label}
            </a>
          ))}
        </nav>
      </header>

      <main style={{ padding: '2rem' }}>{children}</main>
    </div>
  );
}
