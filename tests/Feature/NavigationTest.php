<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Volt\Volt;
use Tests\TestCase;

class NavigationTest extends TestCase
{
    use RefreshDatabase;

    /**
     * The header uses WireUI's <x-dropdown>, which renders its children through the
     * component's default slot — not a named "content" slot like Breeze's local
     * <x-dropdown> component. Wrapping the menu items in <x-slot name="content"> would
     * silently drop them. This guards against that regression.
     */
    public function test_dropdown_menu_shows_profile_and_logout_links(): void
    {
        $user = User::factory()->create(['name' => 'Demo User']);
        $this->actingAs($user);

        Volt::test('layout.navigation')
            ->assertSee('Demo User')
            ->assertSee('Profile')
            ->assertSee('Log out')
            ->assertSee(route('profile'), false);
    }
}
