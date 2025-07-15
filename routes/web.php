<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DedicationController;

Route::get('/', [DedicationController::class, 'search'])->name('dedication.search');

// Protected by secret code in URL
Route::get('/admin/dedicate', [DedicationController::class, 'index']);
Route::post('/send', [DedicationController::class, 'store'])->name('send.dedication');

