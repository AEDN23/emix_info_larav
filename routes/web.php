<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\LoginController;

Route::get('/', function () {
    return redirect()->route('login');
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

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard')->middleware('auth');

Route::middleware('auth')->group(function () {
    Route::resource('coa', CoaController::class);
    Route::resource('wi', WiController::class);
    Route::resource('std', StdController::class);
    Route::resource('msds', MsdsController::class);
});

Route::middleware(['auth', 'admin'])->group(function () {
    Route::resource('users', UserController::class);
});
