<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SalesReportController;
use App\Http\Controllers\SalesReportCommentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SalesTargetController;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');

    Route::middleware(['role:admin,manager,sales'])->group(function () {
        Route::resource('sales-reports', SalesReportController::class);
        Route::post('sales-reports/{salesReport}/comments',[SalesReportCommentController::class, 'store'])->name('sales-reports.comments.store');
        Route::get('sales-reports/{salesReport}/print',[SalesReportController::class, 'print'])->name('sales-reports.print');
        Route::get('sales-reports-print',[SalesReportController::class, 'printIndex'])->name('sales-reports.print-index');

    });
    Route::middleware(['role:admin'])->group(function () {
        Route::resource('users', UserController::class);
        Route::resource('sales-targets', SalesTargetController::class);
    });

});

require __DIR__.'/auth.php';