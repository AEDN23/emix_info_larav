<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\LoginController;

Route::get('/', function () {
    return redirect()->route('dashboard');
});

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login')->middleware('guest');
Route::post('/login', [LoginController::class, 'login'])->middleware('guest');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

use App\Http\Controllers\CoaController;
use App\Http\Controllers\WiController;
use App\Http\Controllers\StdController;
use App\Http\Controllers\MsdsController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

// Protected Resource Routes (Modifying)
Route::middleware('auth')->group(function () {
    Route::resource('coa', CoaController::class)->except(['index', 'show']);
    Route::resource('wi', WiController::class)->except(['index', 'show']);
    Route::resource('std', StdController::class)->except(['index', 'show']);
    Route::resource('msds', MsdsController::class)->except(['index', 'show'])->parameters([
        'msds' => 'msds'
    ]);
});

// Public Resource Routes (Reading)
Route::resource('coa', CoaController::class)->only(['index', 'show']);
Route::resource('wi', WiController::class)->only(['index', 'show']);
Route::resource('std', StdController::class)->only(['index', 'show']);
Route::resource('msds', MsdsController::class)->only(['index', 'show'])->parameters([
    'msds' => 'msds'
]);

Route::middleware(['auth', 'admin'])->group(function () {
    Route::resource('users', UserController::class);
});
