<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Traits\HasRoles;

class NavigationSidebar extends Component
{
    use HasRoles;

    public $menuItems = [];

    public function mount()
    {
        $this->menuItems =[
            [
                'name' => 'Dashboard',
                'route'=> 'dashboard',
                'icon' => 'home',
                'roles' => [],
            ],
            [
                'name'=> 'Usuarios',
                'route'=> 'dashboard.users.show',
                'icon'=> 'users',
                'roles'=> ['Superadmin'],
                'submenu'=>
                    [
                        'name'=> 'Crear Usuario',
                        'route'=> 'dashboard.users.create',
                        'roles'=>['Superadmin'],
                    ]
            ],
            [
                'name' => 'Colaboradores',
                'route' => 'dashboard',
                'icon' => 'user-group',
                'roles' => ['Superadmin', 'Manager'],
            ],
                        [
                'name' => 'Dispositivos',
                'route' => 'dashboard',
                'icon' => 'device-mobile',
                'roles' => ['Superadmin', 'Manager', 'Viewer'],
            ],
                        [
                'name' => 'Cláusulas',
                'route' => 'dashboard',
                'icon' => 'document-text',
                'roles' => ['Superadmin', 'Manager', 'Viewer'],
            ],
                        [
                'name' => 'SimCards',
                'route' => 'dashboard',
                'icon' => 'credit-card',
                'roles' => ['Superadmin', 'Manager', 'Viewer'],
            ],
                        [
                'name' => 'Soporte',
                'route' => 'dashboard',
                'icon' => 'support',
                'roles' => ['Superadmin', 'Manager', 'Viewer'],
            ],
            [
                'name' => 'Préstamos',
                'route' => 'dashboard',
                'icon' => 'currency-dollar',
                'roles' => ['Superadmin', 'Manager', 'Viewer'],
            ],

        ];

    }

    public function hasAccess($roles)
    {
        //si no hay roles especificados, es accesible para todos
        if(empty($roles)){
            return true;
        }

        $user = Auth::user();

        foreach ($roles as $role){
            if($user->hasRole($role)){
                return true;
            }
        }

        return false;
    }

    public function hasAccessWithPermissions($roles, $permissions = [])
{
    if (empty($roles) && empty($permissions)) {
        return true;
    }

    $user = Auth::user();

    // Verificar roles O permisos
    $hasRole = !empty($roles) ? $user->hasAnyRole($roles) : false;
    $hasPermission = !empty($permissions) ? $user->hasAnyPermission($permissions) : false;

    return $hasRole || $hasPermission;
}

    public function render()
    {
        return view('livewire.navigation-sidebar');
    }
}
