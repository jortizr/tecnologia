<?php

use App\Livewire\Brands\BrandIndex;
use Illuminate\Support\Facades\Route;
use App\Livewire\Users\UserIndex;
use App\Livewire\Collaborators\CollaboratorIndex;
use App\Livewire\Collaborators\CollaboratorImport;
use App\Livewire\Devices\ModelIndex;

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

    Route::get('dashboard/users/show', UserIndex::class)
                ->name('dashboard.users.show');

    Route::get('dashboard/collaborators/show',CollaboratorIndex::class )
    ->name('dashboard.collaborators.show');

    Route::get('dashboard/collaborators/import', CollaboratorImport::class)->name('dashboard.collaborators.import');

    Route::get('dashboard/brands/show', BrandIndex::class)->name('dashboard.brands.show');

    Route::get('dashboard/devicemodels/show', ModelIndex::class)->name('dashboard.devicemodels.show');

});

