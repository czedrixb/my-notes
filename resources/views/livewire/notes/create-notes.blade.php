<?php

use Livewire\Volt\Component;

new class extends Component {
    public $title;
    public $body;

    public function store()
    {
        $validated = $this->validate([
            'title' => 'required',
            'body' => 'required',
        ]);

        auth()->user()->notes()->create($validated);

        session()->flash('message', 'Note successfully created!');

        redirect(route('dashboard'));
    }
}; ?>

<div>
    <form wire:submit="store">
        <div class="space-y-5">
            <x-input wire:model="title" label="Note Title" placeholder="Note title" />
            <x-input wire:model="body" label="Content" placeholder="What would you like to note" />
            <div class="flex justify-end">
                <div class="flex gap-1">
                    <x-button wire:navigate href="{{ route('dashboard') }}" label="Back" negative flat></x-button>
                    <x-button type="submit" label="Submit" spinner></x-button>
                </div>
            </div>
            <x-errors />
        </div>
    </form>
</div>
