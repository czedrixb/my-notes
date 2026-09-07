<?php

use Livewire\Volt\Component;
use App\Models\Note;

new class extends Component {
    public string $search = '';

    private const PALETTE = [
        'bg-note-sage', 'bg-note-pink', 'bg-note-mint',
        'bg-note-peach', 'bg-note-lilac', 'bg-note-sky',
    ];

    public function with(): array
    {
        return [
            'notes' => Auth::user()->notes()
                ->when($this->search !== '', fn ($query) => $query
                    ->where('title', 'like', "%{$this->search}%")
                    ->orWhere('body', 'like', "%{$this->search}%"))
                ->orderBy('updated_at', 'desc')
                ->get()
                ->map(fn ($note) => $note->setAttribute('color', $this->colorFor($note->id))),
        ];
    }

    /**
     * Deterministic pastel color per note, so a card doesn't change color on every render.
     */
    private function colorFor(string $id): string
    {
        return self::PALETTE[crc32($id) % count(self::PALETTE)];
    }

    public function delete($id)
    {
        $note = Note::find($id);
        $this->authorize('delete', $note);
        $note->delete();
        $this->dispatch('toast', message: 'Note successfully deleted!');
    }
}; ?>

<div class="relative">
    <div class="flex justify-center mb-10 animate-fade-up">
        <div class="relative w-full max-w-xl group">
            <div class="pointer-events-none absolute inset-y-0 left-5 flex items-center text-slate-400 transition-colors duration-200 group-focus-within:text-primary-500">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-5 w-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                </svg>
            </div>
            <input
                type="text"
                wire:model.live.debounce.300ms="search"
                placeholder="Search notes"
                class="w-full rounded-full border border-slate-200 bg-slate-50 py-3.5 pl-12 pr-5 text-sm text-slate-700 placeholder:text-slate-400 transition-all duration-200 focus:border-primary-300 focus:bg-white focus:ring-4 focus:ring-primary-100 focus:outline-none focus:shadow-lg focus:shadow-primary-100"
            />
        </div>
    </div>

    @if ($notes->isEmpty())
        <div class="flex justify-center items-center py-16">
            <div class="text-center animate-fade-up">
                @if ($search !== '')
                    <div class="mx-auto mb-4 h-16 w-16 rounded-full bg-primary-50 flex items-center justify-center animate-wiggle">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-8 w-8 text-primary-400">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                        </svg>
                    </div>
                    <div class="text-xl font-medium text-slate-700 mb-1">No notes match "{{ $search }}"</div>
                    <div class="text-sm text-slate-400">Try a different search term.</div>
                @else
                    <div class="mx-auto mb-4 h-16 w-16 rounded-full bg-primary-50 flex items-center justify-center animate-wiggle">
                        <x-application-logo class="h-9 w-9" />
                    </div>
                    <div class="text-2xl font-medium text-slate-700 mb-4">You don't have notes yet.</div>
                    <x-button wire:navigate href="{{ route('notes.create') }}" label="Create Note" icon="pencil" primary></x-button>
                @endif
            </div>
        </div>
    @else
        <div wire:loading.delay.class="opacity-40 blur-[1px]" wire:target="search" class="masonry transition duration-200">
            @foreach ($notes as $note)
                <div
                    wire:key="note-{{ $note->id }}"
                    data-note-card
                    x-data
                    class="masonry-item group animate-fade-up animate-delay-{{ min($loop->iteration, 12) }}"
                >
                    <div class="relative rounded-2xl p-6 {{ $note->color }} transition-all duration-300 ease-out hover:-translate-y-1.5 hover:rotate-[-0.4deg] hover:shadow-xl hover:shadow-slate-200/70">
                        <a wire:navigate href="{{ route('notes.edit', $note) }}" class="block">
                            <div class="text-2xl font-medium text-slate-800 leading-snug">
                                {{ Str::limit($note->title, 28, '...') }}
                            </div>
                            <div class="mt-4 text-slate-600 leading-relaxed">
                                {{ Str::limit($note->body, 220, '...') }}
                            </div>
                        </a>

                        <div class="flex justify-between items-center mt-6">
                            <div class="text-[11px] text-slate-500">
                                last opened {{ $note->updated_at->diffForHumans() }}
                            </div>
                            <div class="flex justify-end gap-x-1">
                                <a
                                    wire:navigate
                                    href="{{ route('notes.edit', $note) }}"
                                    class="inline-flex items-center justify-center h-8 w-8 rounded-full bg-white/70 text-slate-600 opacity-0 -translate-y-1 scale-90 transition-all duration-200 delay-[0ms] group-hover:opacity-100 group-hover:translate-y-0 group-hover:scale-100 hover:bg-white hover:text-primary-600"
                                    title="Open note"
                                >
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-4 w-4">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                </a>
                                <button
                                    type="button"
                                    x-on:click="
                                        Swal.fire({
                                            title: 'Delete this note?',
                                            text: 'This action cannot be undone.',
                                            icon: 'warning',
                                            showCancelButton: true,
                                            confirmButtonText: 'Delete',
                                            cancelButtonText: 'Cancel',
                                            confirmButtonColor: '#ef4444',
                                            cancelButtonColor: '#94a3b8',
                                            reverseButtons: true,
                                        }).then((result) => {
                                            if (! result.isConfirmed) return;
                                            $el.closest('[data-note-card]').querySelector('.rounded-2xl').classList.add('animate-card-out');
                                            setTimeout(() => $wire.delete('{{ $note->id }}'), 280);
                                        })
                                    "
                                    class="inline-flex items-center justify-center h-8 w-8 rounded-full bg-white/70 text-slate-600 opacity-0 -translate-y-1 scale-90 transition-all duration-200 delay-[60ms] group-hover:opacity-100 group-hover:translate-y-0 group-hover:scale-100 hover:bg-red-50 hover:text-red-500"
                                    title="Delete note"
                                >
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-4 w-4">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div wire:loading.delay.flex wire:target="search" class="hidden masonry" aria-hidden="true">
            @for ($i = 0; $i < 3; $i++)
                <div class="masonry-item">
                    <div class="rounded-2xl p-6 bg-slate-100 skeleton-shimmer animate-shimmer h-40"></div>
                </div>
            @endfor
        </div>
    @endif

    <a
        wire:navigate
        href="{{ route('notes.create') }}"
        class="group fixed bottom-8 right-8 z-20 flex h-14 w-14 items-center justify-center rounded-full bg-gradient-to-br from-red-400 to-rose-500 text-white shadow-lg shadow-rose-400/30 transition-transform duration-200 hover:scale-110 active:scale-95"
        style="animation: pop-in .45s cubic-bezier(.34,1.56,.64,1) both, float-y 3.5s ease-in-out .45s infinite;"
        title="Create note"
    >
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="h-6 w-6 transition-transform duration-300 group-hover:rotate-90">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
        </svg>
    </a>
</div>
