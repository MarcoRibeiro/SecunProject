import { redirect } from 'next/navigation';

import { getModulePlaceholder, isPermissionModule } from '@/src/lib/app-shell';
import { getCurrentSessionUser } from '@/src/lib/auth';
import { canAccessModule } from '@/src/lib/permissions';

type DashboardPageProps = {
  searchParams?: Promise<{
    module?: string;
  }>;
};

export default async function DashboardPage({ searchParams }: DashboardPageProps) {
  const currentUser = await getCurrentSessionUser();

  if (!currentUser) {
    redirect('/sign-in');
  }

  const params = await searchParams;
  const requestedModule = isPermissionModule(params?.module) ? params.module : null;
  const activeModule =
    requestedModule && canAccessModule(currentUser.permissions, requestedModule)
      ? requestedModule
      : null;
  const modulePlaceholder = activeModule ? getModulePlaceholder(activeModule) : null;

  return (
    <section style={{ display: 'grid', gap: '1.5rem' }}>
      <div>
        <p style={{ margin: 0, color: '#52525b' }}>Protected route</p>
        <h1 style={{ margin: '0.5rem 0 0', fontSize: '2rem' }}>Dashboard</h1>
      </div>

      <article
        style={{
          padding: '1.5rem',
          borderRadius: '1rem',
          backgroundColor: '#ffffff',
          border: '1px solid #e4e4e7',
        }}
      >
        <h2 style={{ marginTop: 0 }}>Welcome back</h2>
        <p style={{ color: '#52525b' }}>
          Signed in as {currentUser?.name ?? currentUser?.email}.
        </p>
        <p style={{ color: '#52525b' }}>
          Permissions: {currentUser?.permissions.join(', ') || 'none'}
        </p>
      </article>

      {modulePlaceholder ? (
        <article
          style={{
            padding: '1.5rem',
            borderRadius: '1rem',
            backgroundColor: '#ffffff',
            border: '1px solid #e4e4e7',
          }}
        >
          <p style={{ margin: 0, color: '#52525b' }}>Module placeholder</p>
          <h2 style={{ margin: '0.5rem 0 0' }}>{modulePlaceholder.heading}</h2>
          <p style={{ marginBottom: 0, color: '#52525b' }}>{modulePlaceholder.description}</p>
        </article>
      ) : null}
    </section>
  );
}
