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
        redirect(route('dashboard'));
    }
}; ?>

<div>
    <form wire:submit="store">
        <div class="space-y-5">
            <x-input wire:model="title" label="Note Title" placeholder="Note title" />
            <x-input wire:model="body" label="Content" placeholder="What would you like to note" />
            <div class="flext justify-end">
                <x-button type="submit" label="Submit"></x-button>
            </div>
            <x-errors />
        </div>
    </form>
</div>
