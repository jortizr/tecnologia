<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserRoleController;
use App\Http\Controllers\UserController;
use App\Livewire\User\UserList;

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
    //ruta para el componente Livewire de la lista de usuarios
    Route::get('/livewire/user/user-list', UserList::class)->name('livewire.user.user-list');
});


Route::post('/users/{user}/role/assign',  [UserRoleController::class, 'assignRole'])
    ->name('users.role.assign')
    ->middleware('auth');

    //ruta para la crud de los usuarios
Route::resource('users', UserController::class)
    ->middleware('auth')
    ->except(['show', 'edit', 'update', 'destroy'])
    ->names('users');
