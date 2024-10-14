<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WeatherController;
use App\Http\Controllers\UserController;


// User API routes
Route::get('/users', [UserController::class, 'index']);
Route::post('/users', [UserController::class, 'store']);
Route::get('/users/{id}', [UserController::class, 'show']);
Route::put('/users/{id}', [UserController::class, 'update']);
Route::delete('/users/{id}', [UserController::class, 'destroy']);

Route::get('/users', [UserController::class, 'apiIndex']);
Route::get('/users/{id}', [UserController::class, 'apiIndex']);
Route::get('/users/{id}', [UserController::class, 'show']);

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('contacts', [App\Http\Controllers\ContactController::class, 'contacts']);

Route::get('/weather/{latitude}/{longitude}', [WeatherController::class, 'getWeather']);