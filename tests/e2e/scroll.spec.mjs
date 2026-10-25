import { test, expect } from '@playwright/test';
import { login, assertHealthy } from './helpers.mjs';

test('plugin stays active and admin pages load', async ({ page }) => {
  await login(page);
  await page.goto('/wp-admin/plugins.php');
  await assertHealthy(page);
  await expect(page.locator('[data-plugin="x-scroll-to-top-responsive/plugin-hook.php"]')).toHaveClass(/active/);
});

test('the scroll button returns a long page to the top', async ({ page }) => {
  await page.goto('/');
  await assertHealthy(page);
  await page.evaluate(() => window.scrollTo(0, 1000));
  const button = page.locator('.scroll-to-top a');
  await expect(button).toBeVisible();
  await button.click();
  await expect.poll(() => page.evaluate(() => window.scrollY)).toBeLessThan(10);
});

test('the button remains usable at a mobile viewport', async ({ page }) => {
  await page.setViewportSize({ width: 390, height: 844 });
  await page.goto('/');
  await page.evaluate(() => window.scrollTo(0, 1000));
  await expect(page.locator('.scroll-to-top a')).toBeVisible();
  await page.locator('.scroll-to-top a').click();
  await expect.poll(() => page.evaluate(() => window.scrollY)).toBeLessThan(10);
});
