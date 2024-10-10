<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MyController; // Update to your new controller name

Route::get('/', function () {
    return view('users.index');
});


Route::get('/dbconn', function(){
    return view('dbconn');
});

// User routes
Route::resource('users', UserController::class);

// This is the route to display the user list
Route::get('/users', [UserController::class, 'index'])->name('users.index');

// The route to handle the insert action
Route::post('/users/insert', [MyController::class, 'insert'])->name('users.insert'); // Ensure the method exists

// Route to display the create user form
Route::get('/users/create', [UserController::class, 'create'])->name('users.create');

// Route to handle the form submission
Route::post('/users', [UserController::class, 'store'])->name('users.store');

// MyController routes
Route::get('/hello', [MyController::class, 'hello']);
Route::get('/edit', [MyController::class, 'edit']);
Route::get('/read', [MyController::class, 'read']);
Route::get('/delete', [MyController::class, 'delete']);