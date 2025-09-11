<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserRoleController;
use App\Http\Controllers\UserController;
use App\Livewire\Superadmin\User\UserList;
use App\Livewire\Superadmin\User\CreateUserForm;
use App\Models\User;

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

//rutas del Superadmin
    // Route::middleware(['role:Superadmin'])->group(function () {
    //     Route::get('dashboard/users/show', UserList::class)
    //         ->name('dashboard.users.show');
    //     Route::get('dashboard/users/create', CreateUserForm::class)
    //         ->name('dashboard.users.create');
    // });

Route::get('dashboard/users/show', UserList::class)
            ->name('dashboard.users.show');
        Route::get('dashboard/users/create', CreateUserForm::class)
            ->name('dashboard.users.create');


});

