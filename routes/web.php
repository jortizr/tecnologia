<?php

use App\Livewire\Brands\BrandIndex;
use Illuminate\Support\Facades\Route;
use App\Livewire\Users\UserIndex;
use App\Livewire\Collaborators\CollaboratorIndex;
use App\Livewire\Collaborators\CollaboratorImport;
use App\Livewire\Devices\ModelIndex;
use App\Livewire\Roles\RoleIndex;
use App\Livewire\Departments\DepartmentIndex;
use App\Livewire\Regionals\RegionalIndex;
use App\Livewire\Occupations\OccupationIndex;
use App\Livewire\PhysicalStates\PhysicalStateIndex;

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
        ->middleware('permission:dashboard.users.show')
        ->name('dashboard.users.show');

    Route::get('dashboard/collaborators/show',CollaboratorIndex::class )
        ->middleware('permission:dashboard.collaborators.show')
        ->name('dashboard.collaborators.show');

    Route::get('dashboard/collaborators/import', CollaboratorImport::class)
        ->middleware('permission:dashboard.collaborators.import')
    ->name('dashboard.collaborators.import');

    Route::get('dashboard/brands/show', BrandIndex::class)
        ->middleware('permission:dashboard.brands.show')
        ->name('dashboard.brands.show');

    Route::get('dashboard/devicemodels/show', ModelIndex::class)
        ->middleware('permission:dashboard.devicemodels.show')
        ->name('dashboard.devicemodels.show');

    Route::get('dashboard/roles/show', RoleIndex::class)
        ->middleware('permission:dashboard.roles.show')
        ->name('dashboard.roles.show');
    Route::get('dashboard/departments/show', DepartmentIndex::class)
    ->middleware('permission:dashboard.departments.show')
        ->name('dashboard.departments.show');

    Route::get('dashboard/regionals/show', RegionalIndex::class)
        ->middleware('permission:dashboard.regionals.show')
        ->name('dashboard.regionals.show');

    Route::get('dashboard/occupations/show', OccupationIndex::class)
        ->middleware('permission:dashboard.occupations.show')
        ->name('dashboard.occupations.show');

    Route::get('dashboard/physicalstates/show', PhysicalStateIndex::class)
        ->middleware('permission:dashboard.physicalstates.show')
        ->name('dashboard.physicalstates.show');

});

