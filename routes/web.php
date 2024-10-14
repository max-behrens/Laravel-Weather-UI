<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

// Route to display the user list
Route::get('/users', [UserController::class, 'index'])->name('users.index');

// Route to display the formatted user list for the Vue component
Route::get('/users/formatted', [UserController::class, 'getFormattedUsers']);

// Show user details page (web)
Route::get('/users/{id}', [UserController::class, 'show'])->name('users.show');

// Route to add a new user
Route::get('/users/add', [UserController::class, 'create'])->name('users.add');

// Route to handle the form submission for creating a user
Route::post('/users', [UserController::class, 'store'])->name('users.store');

// Route to edit an existing user
Route::get('/users/edit/{id}', [UserController::class, 'edit'])->name('users.edit');

// Route to update a user
Route::put('/users/{id}', [UserController::class, 'update'])->name('users.update');
// Route::post('/users/{id}', [UserController::class, 'show']);


// Route to delete a user
Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy');

// Optional: Catch-all route for Vue router
Route::get('/{any}', function () {
    return view('users.index');
})->where('any', '.*');