<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserRoleController;
use App\Http\Controllers\UserController;
use App\Livewire\User\UserList;

Route::get('/', function () {
    return view('welcome');
});

Route::get('users/create', \App\Livewire\User\CreateUserForm::class)->middleware('auth')
->name('users.create');


Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
    //enruta a todos los usuarios con el rol de manager
    Route::get('/dashboard-manager', function () {
        return view('dashboard-manager');
    })->name('dashboard.manager');

    //enruta a todos los usuarios con el rol de viewer
    Route::get('/dashboard-viewer', function () {
        return view('dashboard-viewer');
    })->name('dashboard.viewer');

    //ruta para el componente Livewire de la lista de usuarios
    Route::get('/livewire/user/user-list', UserList::class)->name('livewire.user.user-list');
});


Route::post('/users/{user}/role/assign',  [UserRoleController::class, 'assignRole'])
    ->name('users.role.assign')
    ->middleware('auth');

    //ruta para la crud de los usuarios
Route::resource('users', UserController::class)
    ->middleware('auth')
    ->except(['create', 'edit', 'update', 'destroy'])
    ->names('users');
