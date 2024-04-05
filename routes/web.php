<?php

use Illuminate\Support\Facades\Route;
use App\Models\Event;

Route::view('/', 'welcome');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('my-events', 'my-events')
    ->middleware(['auth', 'verified'])
    ->name('my-events');

Route::get('/event/{event}', function (Event $event) {
    if($event->user_id !== auth()->id()) {
        return redirect()->route('dashboard');
    }
    return view('event', ['event' => $event]);
})->middleware(['auth', 'verified'])->name('event');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__ . '/auth.php';
