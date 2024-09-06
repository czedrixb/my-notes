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
    <div class="container flex justify-center max-auto px-5 max-w-7xl mx-auto lg:px-8">
        <div class="w-full md:max-w-md">
            <x-card>
                @php
                    $colors = [
                        'bg-red-200',
                        'bg-blue-200',
                        'bg-green-200',
                        'bg-yellow-200',
                        'bg-purple-200',
                        'bg-pink-200',
                        'bg-orange-200',
                    ];
                    $color = $colors[array_rand($colors)];
                @endphp
                <x-slot name="slot" :class="$color">
                    <form wire:submit="update">
                        <div class="space-y-5">
                            <x-input wire:model="title" label="Note Title" placeholder="Note title" />
                            <x-input wire:model="body" label="Content" placeholder="What would you like to note" />
                            <div class="flex justify-end">
                                <div class="flex gap-1">
                                    <x-button wire:navigate href="{{ route('dashboard') }}" label="Back" negative
                                        flat></x-button>
                                    <x-button type="submit" label="Submit" spinner></x-button>
                                </div>
                            </div>
                            <x-errors />
                        </div>
                    </form>

                </x-slot>
            </x-card>
        </div>
    </div>
</div>
