<?php

use App\Http\Controllers\Dashboard\Admin\AdminController;
use App\Http\Controllers\Dashboard\ExportController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Dashboard\CategoryController;
use App\Http\Controllers\Dashboard\TransactionController;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware(['auth', 'verified', 'check.active'])->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    Route::resource('categories', CategoryController::class);
    Route::resource('transactions', TransactionController::class);

    Route::get('/export', [ExportController::class, 'index'])
        ->name('export.index');
    Route::post('/export/download', [ExportController::class, 'download'])
        ->name('export.download');

    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');

    Route::middleware(['admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/', [AdminController::class, 'index'])
            ->name('index');
        Route::post('/users/{user}/toggle-role', [AdminController::class, 'toggleRole'])
            ->name('toggle-role');
        Route::post('/users/{user}/toggle-status', [AdminController::class, 'toggleStatus'])
            ->name('toggle-status');
    });

});

require __DIR__.'/auth.php';