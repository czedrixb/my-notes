<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;


Route::redirect('/', '/login');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('dashboard', 'dashboard')->name('dashboard');
    Route::view('notes/create', 'notes.create')->name('notes.create');
    Volt::route('notes/{note}/edit', 'notes.edit-note')->name('notes.edit');
});

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__ . '/auth.php';
