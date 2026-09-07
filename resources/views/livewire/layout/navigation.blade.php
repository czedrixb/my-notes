<?php

use App\Livewire\Actions\Logout;
use Livewire\Volt\Component;

new class extends Component {
    /**
     * Log the current user out of the application.
     */
    public function logout(Logout $logout): void
    {
        $logout();

        $this->redirect('/', navigate: true);
    }
}; ?>

<nav class="relative z-10 max-w-7xl mx-auto px-5 lg:px-8 py-6">
    <div class="flex items-center justify-between">
        <a href="{{ route('dashboard') }}" wire:navigate class="group flex items-center gap-3">
            <x-application-logo class="h-10 w-10" />
            <span class="relative text-2xl font-bold text-primary-600">
                Notes
                <span class="absolute -bottom-1 left-0 h-0.5 w-full bg-primary-400 origin-left scale-x-0 transition-transform duration-300 group-hover:scale-x-100"></span>
            </span>
        </a>

        <div class="flex items-center gap-x-3">
            <div class="hidden sm:flex flex-col items-end leading-tight">
                <span class="text-sm font-semibold text-slate-700">{{ auth()->user()->name }}</span>
                <span class="text-xs text-slate-400">{{ auth()->user()->email }}</span>
            </div>

            <div class="h-10 w-10 rounded-full bg-gradient-to-br from-red-400 to-rose-500 text-white flex items-center justify-center font-semibold shadow-md shadow-rose-400/20 transition-transform duration-200 hover:scale-105">
                {{ Str::of(auth()->user()->name)->explode(' ')->map(fn ($part) => Str::substr($part, 0, 1))->take(2)->implode('') }}
            </div>

            <x-dropdown position="bottom-end">
                <x-slot name="trigger">
                    <button
                        class="inline-flex items-center justify-center h-10 w-10 rounded-full text-slate-500 hover:text-primary-600 hover:bg-primary-50 transition-colors duration-200 focus:outline-none">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                </x-slot>

                <x-dropdown.item href="{{ route('profile') }}" wire:navigate icon="user-circle" label="Profile" />
                <x-dropdown.item wire:click="logout" icon="arrow-left-start-on-rectangle" label="Log out" />
            </x-dropdown>
        </div>
    </div>
</nav>
