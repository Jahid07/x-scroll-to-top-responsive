import { test, expect } from '@playwright/test';
import { login } from './helpers.mjs';

test('color controls share one alpha picker and preserve settings until published', async ({ page }) => {
  const errors = [];
  page.on('pageerror', error => errors.push(error.message));
  await login(page);
  await page.goto('/wp-admin/customize.php?autofocus[section]=xscroll_general_settings');
  const fields = ['icon_color', 'icon_bg_color', 'icon_hover_color', 'icon_hover_bg_color'];
  const control = key => page.locator('[id="customize-control-xstr_option-' + key + '"]');
  await control(fields[0]).locator('.xscroll-color-toggle').waitFor({ state: 'visible' });
  const original = await page.evaluate(keys => keys.map(key => wp.customize('xstr_option[' + key + ']').get()), fields);
  for (const key of fields) {
    await control(key).locator('.xscroll-color-toggle').click();
    await expect(page.locator('.xscroll-color-popover')).toHaveCount(1);
    await expect(page.getByRole('slider', { name: 'Alpha', exact: true })).toBeVisible();
  }
  expect(await page.evaluate(keys => keys.map(key => wp.customize('xstr_option[' + key + ']').get()), fields)).toEqual(original);
  const input = page.locator('.xscroll-color-popover').getByRole('textbox', { name: 'Hex color', exact: true });
  await input.fill('12345680');
  await input.press('Tab');
  await expect.poll(() => page.evaluate(() => wp.customize('xstr_option[icon_hover_bg_color]').get())).toBe('#12345680');
  await page.locator('.xscroll-color-popover').getByRole('button', { name: 'Reset', exact: true }).click();
  const defaultColor = await control('icon_hover_bg_color').locator('.xscroll-color-picker').getAttribute('data-default');
  await expect.poll(() => page.evaluate(() => wp.customize('xstr_option[icon_hover_bg_color]').get())).toBe(defaultColor);
  await page.evaluate(value => wp.customize('xstr_option[icon_hover_bg_color]').set(value), original[3]);
  await page.keyboard.press('Escape');
  await expect(page.locator('.xscroll-color-popover')).toHaveCount(0);
  expect(await page.locator('script[src*="/js/dist/components"]').count()).toBe(1);
  expect(errors).toEqual([]);
});

test('color picker dependencies are absent from the public site', async ({ page }) => {
  await page.goto('/');
  expect(await page.locator('script[src*="customizer-colors"], script[src*="/js/dist/components"]').count()).toBe(0);
});
