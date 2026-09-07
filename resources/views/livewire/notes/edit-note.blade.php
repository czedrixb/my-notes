<?php

use Livewire\Volt\Component;
use Livewire\Attributes\Layout;
use App\Models\Note;

new #[Layout('layouts.app')] class extends Component {
    public Note $note;
    public $title;
    public $body;

    public function mount(Note $note)
    {
        $this->authorize('update', $note);
        $this->fill($note);
    }

    public function update()
    {
        $validated = $this->validate([
            'title' => 'required',
            'body' => 'required',
        ]);

        $this->note->update($validated);
        session()->flash('message', 'Note successfully updated!');
        redirect(route('notes.edit', $this->note));
    }
}; ?>

<div class="py-12">
    <div class="container flex justify-center px-5 max-w-7xl mx-auto lg:px-8">
        <div class="w-full md:max-w-xl animate-fade-up">
            <div class="rounded-3xl bg-white shadow-[0_8px_40px_rgba(109,40,217,0.08)] p-8">
                <form wire:submit="update">
                    <div class="space-y-5">
                        <x-input wire:model="title" label="Note Title" placeholder="Note title" />
                        <x-textarea wire:model="body" label="Content" placeholder="What would you like to note" rows="8" />
                        <div class="flex justify-end">
                            <div class="flex gap-2">
                                <x-button wire:navigate href="{{ route('dashboard') }}" label="Back" flat></x-button>
                                <x-button type="submit" label="Submit" spinner primary></x-button>
                            </div>
                        </div>
                        <x-errors />
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
