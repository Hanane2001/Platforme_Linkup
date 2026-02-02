<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FriendController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/friends/send/{id}', [FriendController::class, 'send'])->name('friends.send');
    Route::post('/friends/accept/{id}', [FriendController::class, 'accept'])->name('friends.accept');
    Route::post('/friends/reject/{id}', [FriendController::class, 'reject'])->name('friends.reject');
});

// Route::middleware('auth')->group(function () {
//     Route::post('/friends/send/{id}', [FriendController::class, 'send'])->name('friends.send');
//     Route::post('/friends/accept/{id}', [FriendController::class, 'accept'])->name('friends.accept');
//     Route::post('/friends/reject/{id}', [FriendController::class, 'reject'])->name('friends.reject');
// });

require __DIR__.'/auth.php';
