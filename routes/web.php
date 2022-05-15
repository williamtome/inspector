<?php

use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\ImportationsController;
use App\Http\Controllers\TransactionsController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/login');
});

Route::middleware(['auth'])->group(function () {
    Route::get('register/{user}', [RegisteredUserController::class, 'edit'])
                ->name('register.edit');

    Route::put('register/{user}', [RegisteredUserController::class, 'update'])
                ->name('register.update');

    Route::delete('register/{user}', [RegisteredUserController::class, 'delete'])
                ->name('register.destroy');

    Route::get('/dashboard', [RegisteredUserController::class, 'index'])
        ->name('dashboard');

    Route::get('/upload', [ImportationsController::class, 'index'])
        ->name('upload');

    Route::post('/upload', [TransactionsController::class, 'upload'])
        ->name('upload');

    Route::get('/transactions/{importation}', [TransactionsController::class, 'show'])
        ->name('importation.show');
});

require __DIR__.'/auth.php';
