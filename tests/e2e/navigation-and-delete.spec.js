import { test, expect } from '@playwright/test';

const EMAIL = 'e2e-test@example.com';
const PASSWORD = 'password';

async function login(page) {
    await page.goto('/login');
    await page.locator('#email').fill(EMAIL);
    await page.locator('#password').fill(PASSWORD);
    await page.getByRole('button', { name: 'Log in' }).click();
    await expect(page).toHaveURL(/dashboard/);
}

test('user menu opens and shows Profile and Log out', async ({ page }) => {
    await login(page);

    const menuButton = page.locator('nav button').last();
    await menuButton.click();

    const profileLink = page.getByRole('link', { name: 'Profile' });
    const logoutButton = page.getByText('Log out');

    await expect(profileLink).toBeVisible();
    await expect(logoutButton).toBeVisible();

    await profileLink.click();
    await expect(page).toHaveURL(/profile/);
});

test('deleting a note asks for confirmation and shows a success toast', async ({ page }) => {
    await login(page);

    // Ensure there is at least one note to delete.
    const noteCardCount = await page.locator('[data-note-card]').count();
    if (noteCardCount === 0) {
        await page.getByRole('link', { name: 'Create Note', exact: true }).click();
        await page.getByPlaceholder('Note title').fill('E2E Delete Target');
        await page.getByPlaceholder('What would you like to note').fill('This note exists only to be deleted by the e2e test.');
        await page.getByRole('button', { name: 'Submit' }).click();
        await expect(page).toHaveURL(/dashboard/);
    }

    const card = page.locator('[data-note-card]').first();
    await card.hover();
    await card.getByTitle('Delete note').click();

    // Confirmation dialog should appear and block the delete until confirmed.
    await expect(page.getByText('Delete this note?')).toBeVisible();
    const cardCountBeforeConfirm = await page.locator('[data-note-card]').count();

    await page.getByRole('button', { name: 'Cancel' }).click();
    await expect(page.getByText('Delete this note?')).toBeHidden();
    await expect(page.locator('[data-note-card]')).toHaveCount(cardCountBeforeConfirm);

    // Now actually confirm the deletion.
    await card.hover();
    await card.getByTitle('Delete note').click();
    await page.getByRole('button', { name: 'Delete', exact: true }).click();

    await expect(page.getByText('Note successfully deleted!')).toBeVisible();
    await expect(page.locator('[data-note-card]')).toHaveCount(cardCountBeforeConfirm - 1);
});
