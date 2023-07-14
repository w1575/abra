<?php

use App\Http\Controllers\BotTokenController;
use App\Http\Controllers\CloudStorageController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\TelegramAccountController;
use App\Http\Controllers\UserController;
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

Route::get('/user', [UserController::class, 'index'])->name('user.index');

Route::get('/telegram-account', [TelegramAccountController::class, 'index'])->name('t.a.index');

Route::get('/bot-token', [BotTokenController::class, 'index'])->name('b.t.index');

Route::get('/bot-token/create', [BotTokenController::class, 'index'])->name('b.t.create');

Route::get('/storages', [CloudStorageController::class, 'index'])->name('c.s.index');
