<?php

use App\Http\Controllers\LogController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth'])->group(function() {
    /*to be defined before resource controller*/
    Route::get('/logs/trash', [LogController::class, 'trash'])->name('logs.trash');
    Route::post('/logs/{id}/restore', [LogController::class, 'restore'])->name('logs.restore');
    Route::delete('/logs/{id}/force-delete', [LogController::class, 'forceDelete'])->name('logs.forceDelete');
    Route::get('/logs/audit', [LogController::class, 'audit'])->name('logs.audit');
    /*to be defined before resource controller*/

    Route::resource('logs', LogController::class);
    Route::get('/logs/{log}/history', [LogController::class, 'history'])->name('logs.history');



});
require __DIR__.'/auth.php';
