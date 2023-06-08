<?php

use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\UserController;
use \App\Http\Controllers\FileController;

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
Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard', [UserController::class, 'dashboard']);
    Route::get('/patient', [UserController::class, 'patient']);
    Route::any('/profile', [UserController::class, 'profile']);
    Route::any('/logout', [UserController::class, 'logout']);
});

Route::get('/', [UserController::class, 'login']);
Route::post('/', [UserController::class, 'login']);
Route::any('/login', [UserController::class, 'login']);
Route::get('/file/view/{hash}', [FileController::class, 'view']);

