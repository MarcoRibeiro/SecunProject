import { expect, test } from '@playwright/test';

test('shows module navigation for an authorized user', async ({ page }) => {
  await page.goto('/dashboard');

  await expect(page).toHaveURL(/\/sign-in$/);

  await page.getByLabel('Email').fill('admin@secun.local');
  await page.getByLabel('Password').fill('change-me');
  await page.getByRole('button', { name: 'Sign in' }).click();

  await expect(page).toHaveURL(/\/dashboard$/);
  await expect(page.getByRole('navigation', { name: 'Primary navigation' })).toBeVisible();

  for (const item of [
    { label: 'Dashboard', href: '/dashboard' },
    { label: 'Clients', href: '/dashboard?module=clients' },
    { label: 'Equipment', href: '/dashboard?module=equipment' },
    { label: 'Repairs', href: '/dashboard?module=repairs' },
    { label: 'Stock', href: '/dashboard?module=stock' },
    { label: 'Users', href: '/dashboard?module=users' },
    { label: 'Settings', href: '/dashboard?module=settings' },
    { label: 'Reports', href: '/dashboard?module=reports' },
  ]) {
    await expect(page.getByRole('link', { name: item.label })).toHaveAttribute('href', item.href);
  }

  await page.getByRole('link', { name: 'Users' }).click();
  await expect(page).toHaveURL(/\/dashboard\?module=users$/);
  await expect(page.getByRole('heading', { name: 'Users overview' })).toBeVisible();

  await page.getByRole('link', { name: 'Reports' }).click();
  await expect(page).toHaveURL(/\/dashboard\?module=reports$/);
  await expect(page.getByRole('heading', { name: 'Reports overview' })).toBeVisible();

  await expect(page.getByRole('button', { name: 'Sign out' })).toBeVisible();
});
