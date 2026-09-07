<?php

namespace Tests\Feature;

use App\Models\Note;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class NotesIndexTest extends TestCase
{
    use RefreshDatabase;

    public function test_dashboard_renders_the_redesigned_notes_grid(): void
    {
        $user = User::factory()->create();
        $note = Note::factory()->for($user)->create([
            'title' => 'Grocery List',
            'body' => 'Milk, eggs, bread',
        ]);

        $response = $this->actingAs($user)->get(route('dashboard'));

        $response->assertOk();
        $response->assertSee('Search notes');
        $response->assertSee('masonry', false);
        $response->assertSee('bg-note-', false);
        $response->assertSee($note->title);
    }

    public function test_search_filters_notes_by_title_or_body(): void
    {
        $user = User::factory()->create();
        Note::factory()->for($user)->create(['title' => 'Trip to Japan', 'body' => 'Book flights']);
        Note::factory()->for($user)->create(['title' => 'Grocery List', 'body' => 'Milk, eggs, bread']);

        $response = $this->actingAs($user)->get(route('dashboard'));
        $response->assertSee('Trip to Japan')->assertSee('Grocery List');

        \Livewire\Volt\Volt::test('notes.index-notes')
            ->set('search', 'Japan')
            ->assertSee('Trip to Japan')
            ->assertDontSee('Grocery List');
    }

    public function test_empty_state_shows_when_user_has_no_notes(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('dashboard'));

        $response->assertOk();
        $response->assertSee('have notes yet');
    }
}
