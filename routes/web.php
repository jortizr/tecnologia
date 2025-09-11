<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserRoleController;
use App\Http\Controllers\UserController;
use App\Livewire\Superadmin\User\UserList;
use App\Livewire\Superadmin\User\CreateUserForm;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('/dashboard');
    })->name('dashboard');


    //ruta para el componente Livewire de la lista de usuarios
    Route::get('dashboard/user/user-list', UserList::class)->name('superadminuser.user-list');
});
