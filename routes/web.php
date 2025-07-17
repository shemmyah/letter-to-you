<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DedicationController;

Route::get('/', [DedicationController::class, 'search'])->name('dedication.search');

Route::get('/debug-dedications', function () {
    return \App\Models\Dedication::count();
});

Route::get('/admin/dedicate', [DedicationController::class, 'index']);
Route::put('/admin/dedicate/update/{id}', [DedicationController::class, 'update']);
Route::post('/send', [DedicationController::class, 'store'])->name('send.dedication');

