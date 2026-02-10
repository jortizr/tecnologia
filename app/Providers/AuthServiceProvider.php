<?php

namespace App\Providers;

use App\Models\Collaborator;
use App\Models\Brand;
use App\Models\DeviceModel;
use App\Policies\CollaboratorPolicy;
use App\Policies\BrandPolicy;
use App\Policies\DeviceModelPolicy;
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
        Brand::class => BrandPolicy::class,
        DeviceModel::class => DeviceModelPolicy::class,

    ];



    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();
    }
}
