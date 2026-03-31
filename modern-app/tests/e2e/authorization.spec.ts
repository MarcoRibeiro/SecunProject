import { expect, test } from '@playwright/test';

test('shows module navigation for an authorized user', async ({ page }) => {
  await page.goto('/dashboard');

  await expect(page).toHaveURL(/\/sign-in$/);

  await page.getByLabel('Email').fill('admin@secun.local');
  await page.getByLabel('Password').fill('change-me');
  await page.getByRole('button', { name: 'Sign in' }).click();

  await expect(page).toHaveURL(/\/dashboard$/);
  await expect(page.getByRole('navigation', { name: 'Primary navigation' })).toBeVisible();

  for (const label of [
    'Dashboard',
    'Clients',
    'Equipment',
    'Repairs',
    'Stock',
    'Users',
    'Settings',
    'Reports',
  ]) {
    await expect(page.getByRole('link', { name: label })).toBeVisible();
  }

  await expect(page.getByRole('button', { name: 'Sign out' })).toBeVisible();
});
