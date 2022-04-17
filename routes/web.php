<?php

use App\Http\Controllers\TransactionsController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/home');
});

Route::get('/home', function () {
    return view('form-upload');
});

Route::get('/transactions', [TransactionsController::class, 'index']);
Route::post('/upload', [TransactionsController::class, 'upload'])
    ->name('upload');

