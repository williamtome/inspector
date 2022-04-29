<?php

use App\Http\Controllers\TransactionsController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::get('/home', [TransactionsController::class, 'index']);
Route::post('/upload', [TransactionsController::class, 'upload'])
    ->name('upload');

require __DIR__.'/auth.php';
