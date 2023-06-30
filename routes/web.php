<?php

use App\Http\Controllers\MainController;
use App\Http\Controllers\TelegramAccountController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [MainController::class, 'index'])->name('main.index');

Route::get('/telegram-account', [TelegramAccountController::class, 'index'])->name('t.a.index');
