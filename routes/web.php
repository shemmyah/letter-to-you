<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DedicationController;
use App\Http\Controllers\MemoryController;

Route::get('/', [DedicationController::class, 'search'])->name('dedication.search');

Route::get('/debug-dedications', function () {
    return \App\Models\Dedication::count();
});

Route::get('/admin/dedicate', [DedicationController::class, 'index']);
Route::put('/admin/dedicate/update/{id}', [DedicationController::class, 'update']);
Route::post('/send', [DedicationController::class, 'store'])->name('send.dedication');

Route::get('/memories', [MemoryController::class, 'index'])->name('memories.index');
Route::get('/admin/gallery', [MemoryController::class, 'admin']);
Route::post('/admin/gallery/store', [MemoryController::class, 'store'])->name('memories.store');
Route::put('/admin/gallery/update/{id}', [MemoryController::class, 'update'])->name('gallery.update');



