import { expect, test } from '@playwright/test';

test('admin can complete the sign-in smoke flow and reach the dashboard', async ({ page }) => {
  await page.goto('/dashboard');

  await expect(page).toHaveURL(/\/sign-in$/);
  await expect(page.getByRole('heading', { name: 'Sign in' })).toBeVisible();

  await page.getByLabel('Email').fill('admin@secun.local');
  await page.getByLabel('Password').fill('change-me');
  await page.getByRole('button', { name: 'Sign in' }).click();

  await expect(page).toHaveURL(/\/dashboard$/);
  await expect(page.getByRole('heading', { name: 'Dashboard' })).toBeVisible();
  await expect(page.getByText('admin@secun.local')).toBeVisible();
  await expect(page.getByText('Signed in as System Administrator.')).toBeVisible();

  await page.goto('/sign-in');

  await expect(page).toHaveURL(/\/dashboard$/);
  await expect(page.getByRole('heading', { name: 'Dashboard' })).toBeVisible();
});
