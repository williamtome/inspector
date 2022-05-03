<?php

use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\TransactionsController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/login');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [RegisteredUserController::class, 'index'])
        ->name('dashboard');

    Route::get('/home', [TransactionsController::class, 'index']);

    Route::post('/upload', [TransactionsController::class, 'upload'])
        ->name('upload');
});

require __DIR__.'/auth.php';
