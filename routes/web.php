<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserRoleController;
use App\Http\Controllers\UserController;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/users/{user}', [UserController::class, 'show'])->name('users.show');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});


Route::post('/users/{user}/role/assign',  [UserRoleController::class, 'assignRole'])
    ->name('users.role.assign')
    ->middleware('auth');
