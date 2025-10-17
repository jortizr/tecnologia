<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Superadmin\User\UserList;
use App\Livewire\Superadmin\User\CreateUserForm;
use App\Livewire\Superadmin\User\EditUser;
use App\Livewire\Superadmin\Collaborator\CollaboratorList;
use App\Livewire\Superadmin\Collaborator\CollaboratorEdit;


Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
    'user.active' //se agrega el middleware para validar el estado del usuario
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
    Route::get('dashboard/users/{user}/edit/', EditUser::class)
                ->name('dashboard.users.edit');
    Route::get('dashboard/collaborators/show',CollaboratorList::class )
    ->name('dashboard.collaborators.show');
    Route::get('dashboard/collaborators/{collaborator}/edit/', CollaboratorEdit::class)->name('dashboard.collaborators.edit');
});

