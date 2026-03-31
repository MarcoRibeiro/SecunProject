import { AuthError } from 'next-auth';
import { redirect } from 'next/navigation';

import { signIn } from '@/src/lib/auth';

type SignInPageProps = {
  searchParams?: Promise<{
    error?: string;
  }>;
};

async function signInAction(formData: FormData) {
  'use server';

  try {
    await signIn('credentials', {
      email: formData.get('email'),
      password: formData.get('password'),
      redirectTo: '/dashboard',
    });
  } catch (error) {
    if (error instanceof AuthError && error.type === 'CredentialsSignin') {
      redirect('/sign-in?error=invalid_credentials');
    }

    throw error;
  }
}

export default async function SignInPage({ searchParams }: SignInPageProps) {
  const params = await searchParams;
  const hasError = params?.error === 'invalid_credentials';

  return (
    <main
      style={{
        minHeight: '100vh',
        display: 'grid',
        placeItems: 'center',
        padding: '2rem',
      }}
    >
      <form
        action={signInAction}
        style={{
          width: '100%',
          maxWidth: '24rem',
          display: 'grid',
          gap: '1rem',
          padding: '2rem',
          border: '1px solid #d4d4d8',
          borderRadius: '1rem',
          backgroundColor: '#ffffff',
        }}
      >
        <div>
          <h1 style={{ margin: 0, fontSize: '1.875rem' }}>Sign in</h1>
          <p style={{ margin: '0.5rem 0 0', color: '#52525b' }}>
            Use your Secun credentials to continue.
          </p>
        </div>

        <label style={{ display: 'grid', gap: '0.5rem' }}>
          <span>Email</span>
          <input
            required
            name="email"
            type="email"
            style={{ padding: '0.75rem', borderRadius: '0.75rem', border: '1px solid #d4d4d8' }}
          />
        </label>

        <label style={{ display: 'grid', gap: '0.5rem' }}>
          <span>Password</span>
          <input
            required
            name="password"
            type="password"
            style={{ padding: '0.75rem', borderRadius: '0.75rem', border: '1px solid #d4d4d8' }}
          />
        </label>

        {hasError ? (
          <p style={{ margin: 0, color: '#b91c1c' }}>Invalid email or password.</p>
        ) : null}

        <button
          type="submit"
          style={{
            padding: '0.875rem 1rem',
            borderRadius: '0.75rem',
            border: 0,
            backgroundColor: '#18181b',
            color: '#fafafa',
            fontWeight: 600,
            cursor: 'pointer',
          }}
        >
          Sign in
        </button>
      </form>
    </main>
  );
}
