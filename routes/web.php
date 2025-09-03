<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserRoleController;
use App\Http\Controllers\UserController;
use App\Livewire\Superadmin\User\UserList;
use App\Livewire\Manager\Dashboard as ManagerDashboard;
use App\Livewire\Viewer\Dashboard as ViewerDashboard;


Route::get('/', function () {
    return view('welcome');
});

Route::get('users/create', \App\Livewire\Superadmin\User\CreateUserForm::class)->middleware('auth')
->name('users.create');


Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('/livewire/superadmin/dashboard');
    })->name('dashboard');

    //enruta a todos los usuarios con el rol de manager
    Route::get('/dashboard/manager', ManagerDashboard::class)->name('dashboard.manager');


    //enruta a todos los usuarios con el rol de viewer
    Route::get('/dashboard/viewer',ViewerDashboard::class)->name('dashboard.viewer');

    //ruta para el componente Livewire de la lista de usuarios
    Route::get('/dashboard/user/user-list', UserList::class)->name('dashboard.user-list');
});


Route::post('/users/{user}/role/assign',  [UserRoleController::class, 'assignRole'])
    ->name('users.role.assign')
    ->middleware('auth');

    //ruta para la crud de los usuarios
Route::resource('users', UserController::class)
    ->middleware('auth')
    ->except(['create', 'edit', 'update', 'destroy'])
    ->names('users');
