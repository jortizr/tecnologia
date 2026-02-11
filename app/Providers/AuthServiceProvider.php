<?php

namespace App\Providers;

use App\Models\Collaborator;
use App\Models\Brand;
use App\Models\Department;
use App\Models\DeviceModel;
use App\Models\User;
use App\Policies\CollaboratorPolicy;
use App\Policies\BrandPolicy;
use App\Policies\DepartmentPolicy;
use App\Policies\DeviceModelPolicy;
use App\Policies\UserPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        \Spatie\Permission\Models\Role::class => \App\Policies\RolePolicy::class,
        Collaborator::class => CollaboratorPolicy::class,
        Department::class => DepartmentPolicy::class,
        Brand::class => BrandPolicy::class,
        DeviceModel::class => DeviceModelPolicy::class,
        User::class => UserPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();
    }
}
