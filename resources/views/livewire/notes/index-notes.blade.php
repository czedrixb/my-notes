<?php

use Livewire\Volt\Component;
use App\Models\Note;
new class extends Component {
    public function with(): array
    {
        // 'notes' => Auth::user()->notes()->orderBy('created_at', 'asc')->get(),

        $notes = Note::get()->map(fn($note) => $note->setAttribute('color', $this->getRandomColor()));

        return [
            'notes' => $notes,
        ];
    }

    private function getRandomColor(): string
    {
        $colors = ['bg-red-200', 'bg-blue-200', 'bg-green-200', 'bg-yellow-200', 'bg-purple-200', 'bg-pink-200', 'bg-orange-200'];
        return $colors[array_rand($colors)];
    }

    public function delete($id)
    {
        $note = Note::find($id);
        $note->delete();
        session()->flash('message', 'Note successfully deleted!');
        redirect(route('dashboard'));
    }
}; ?>

<div>
    <div class="flex justify-end mb-8">
        <x-button wire:navigate href="{{ route('notes.create') }}" label="Create Note" icon="pencil"></x-button>
    </div>

    @if ($notes->isEmpty())
        <div class="flex justify-center items-center">
            <div class="text-center">
                <div class="text-2xl mb-3">You don't have notes yet.</div>
                <x-button wire:navigate href="{{ route('notes.create') }}" label="Create Note" icon="pencil"></x-button>
            </div>
        </div>
    @else
        <div class="grid gird-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-3">
            @foreach ($notes as $note)
                <x-card>
                    <x-slot name="slot" :class="$note->color . ' min-h-full flex flex-col justify-between'">
                        <div>
                            <a href="" class="text-md font-bold hover:underline">
                                {{ Str::limit($note->title, 20, '...') }}
                            </a>
                        </div>
                        <div class="mt-5">
                            {{ Str::limit($note->body, 80, '...') }}
                        </div>
                        <div class="flex justify-between items-center mt-5">
                            <div class="text-xs">{{ $note->created_at->format('M d, Y') }}</div>
                            <div class="flex justify-end gap-x-1">
                                <x-mini-button rounded icon="eye" primary></x-mini-button>
                                <x-mini-button rounded icon="trash" wire:click="delete('{{ $note->id }}')"
                                    negative></x-mini-button>
                            </div>
                        </div>
                    </x-slot>
                </x-card>
            @endforeach
        </div>
    @endif
</div>
