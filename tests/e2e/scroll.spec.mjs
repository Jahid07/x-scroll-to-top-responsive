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

test('scrolling starts promptly when the theme enables CSS smooth scrolling', async ({ page }) => {
  await page.goto('/', { waitUntil: 'networkidle' });
  await page.addStyleTag({ content: 'html, body { scroll-behavior: smooth !important; }' });
  await page.evaluate(() => window.scrollTo({ top: 1800, behavior: 'instant' }));
  await expect(page.locator('.scroll-to-top a')).toBeVisible();
  const movement = await page.evaluate(() => new Promise(resolve => {
    const startY = window.scrollY;
    document.querySelector('.scroll-to-top a').click();
    const start = performance.now();
    function sample() {
      if (performance.now() - start >= 350) resolve(startY - window.scrollY);
      else requestAnimationFrame(sample);
    }
    requestAnimationFrame(sample);
  }));
  expect(movement).toBeGreaterThan(100);
  await expect.poll(() => page.evaluate(() => window.scrollY)).toBeLessThan(10);
  expect(await page.evaluate(() => getComputedStyle(document.documentElement).scrollBehavior)).toBe('smooth');
});

test('reduced motion returns to the top without animation', async ({ page }) => {
  await page.emulateMedia({ reducedMotion: 'reduce' });
  await page.goto('/', { waitUntil: 'networkidle' });
  await page.addStyleTag({ content: 'html { scroll-behavior: smooth !important; }' });
  await page.evaluate(() => window.scrollTo({ top: 1800, behavior: 'instant' }));
  await expect(page.locator('.scroll-to-top a')).toBeVisible();
  const position = await page.evaluate(() => {
    document.querySelector('.scroll-to-top a').click();
    return window.scrollY;
  });
  expect(position).toBe(0);
});

test('higher speed finishes sooner without theme smooth-scroll interference', async ({ page }) => {
  await page.goto('/', { waitUntil: 'networkidle' });
  await page.addStyleTag({ content: 'html { scroll-behavior: smooth !important; }' });
  const times = [];
  for (const speed of [1, 10]) {
    await page.evaluate(speed => {
      document.querySelector('.scroll-to-top').dataset.scrollSpeed = speed;
      window.scrollTo({ top: 1800, behavior: 'instant' });
    }, speed);
    await expect(page.locator('.scroll-to-top a')).toBeVisible();
    times.push(await page.evaluate(() => new Promise(resolve => {
      const start = performance.now();
      document.querySelector('.scroll-to-top a').click();
      function sample() {
        if (window.scrollY < 1) resolve(performance.now() - start);
        else requestAnimationFrame(sample);
      }
      requestAnimationFrame(sample);
    })));
  }
  expect(times[0]).toBeGreaterThan(1000);
  expect(times[1]).toBeLessThan(500);
  expect(times[0] - times[1]).toBeGreaterThan(600);
});
