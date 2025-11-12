<?php

use App\Livewire\Superadmin\Brand\BrandList;
use Illuminate\Support\Facades\Route;
use App\Livewire\Superadmin\User\UserList;
use App\Livewire\Superadmin\User\CreateUserForm;
use App\Livewire\Superadmin\User\EditUser;
use App\Livewire\Superadmin\Collaborator\CollaboratorList;
use App\Livewire\Superadmin\Collaborator\CollaboratorEdit;
use App\Livewire\Superadmin\Collaborator\CollaboratorImport;


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

    Route::get('dashboard/users/show', UserList::class)
                ->name('dashboard.users.show');
    Route::get('dashboard/users/{user}/edit/', EditUser::class)
                ->name('dashboard.users.edit');
    Route::get('dashboard/collaborators/show',CollaboratorList::class )
    ->name('dashboard.collaborators.show');
    Route::get('dashboard/collaborators/{collaborator}/edit/', CollaboratorEdit::class)->name('dashboard.collaborators.edit');
    Route::get('dashboard/collaborators/import', CollaboratorImport::class)->name('dashboard.collaborators.import');
    Route::get('dashboard/brands/show', BrandList::class)->name('dashboard.brands.show');
});

