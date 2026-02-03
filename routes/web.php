<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FriendController;
use App\Http\controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::post('/friends/{user}', [FriendController::class, 'send'])->name('friends.send');
    Route::post('/friends/{friendRequest}/accept', [FriendController::class, 'accept'])->name('friends.accept');
    Route::post('/friends/{friendRequest}/reject', [FriendController::class, 'reject'])->name('friends.reject');
    Route::delete('/friends/{user}/remove', [FriendController::class, 'remove'])->name('friends.remove');

    Route::get('/users/{user}', [UserController::class, 'show'])->name('users.show');
    Route::get('/messages/{user}/create', [MessageController::class, 'create'])->name('messages.create');
});

require __DIR__.'/auth.php';
