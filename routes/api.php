<?php

use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\PatientController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
Route::get('/patients', [PatientController::class, 'index']);
Route::post('/patients', [PatientController::class, 'create']);
Route::put('/patient/{id}', [PatientController::class, 'update']);
Route::delete('/patient/{id}', [PatientController::class, 'delete']);
Route::get('/patients/search', [PatientController::class, 'search']);

