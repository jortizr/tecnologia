<?php
namespace App\Livewire\Users;

use App\Models\User;
use App\Traits\WithSearch;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Locked;
use Livewire\Attributes\On;
use Livewire\Component;
use Spatie\Permission\Models\Role;
use WireUi\Traits\WireUiActions;

class UserIndex extends Component
{
    use WithPagination, AuthorizesRequests, WireUiActions, WithSearch;

    public bool $userModal = false;
    public bool $isEditing = false;
    public $canManage;
    public $filterStatus = '';

    protected $casts = [
        'is_active' => 'boolean',
    ];
    // Propiedades del formulario
    public $name, $last_name, $email, $password, $role, $is_active;

    #[Locked]
    public $userId;

    #[Computed]
    public function users()
    {
        return User::query()
            ->with(['roles'])
            ->when(filled($this->filterStatus), function ($query) {
                $query->where('is_active', (bool) $this->filterStatus);
            })
            ->when($this->search, function ($query) {
                $query->where(function($q){
                    $q->where('name', 'like', "%        {$this->search}%")
                    ->orWhere('last_name', 'like', "%{$this->search}%")
                    ->orWhere('email', 'like', "%{$this->search}%")
                    ->orWhereHas('roles', fn($qr) => $qr->where('name', 'like', "%{$this->search}%"));
                });
            })
            ->latest()
            ->paginate(10);
    }

    #[Computed]
    public function rolesList()
    {
        return Role::select('id', 'name')->orderBy('name')->get();
    }

    public function mount()
    {
        // ESTO FALTABA: Bloquea la entrada si no tiene permiso 'viewAny'
        $this->authorize('viewAny', User::class);
    }

    public function create()
    {
        $this->authorize('create', User::class);
        $this->reset(['name', 'last_name', 'email', 'password', 'role', 'userId', 'isEditing', 'is_active']);
        $this->is_active = true;
        $this->userModal = true;
    }

    public function save()
    {
        $rules = [
            'name'      => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email'     => 'required|email|unique:users,email,' . $this->userId,
            'role'      => 'required|exists:roles,id',
            'is_active' => 'boolean',
        ];

        if (! $this->isEditing) {
            $rules['password'] = 'required|min:8';
        }

        $this->validate($rules);

        if ($this->isEditing) {
            $user = User::findOrFail($this->userId);
            $user->update([
                'name'      => $this->name,
                'last_name' => $this->last_name,
                'email'     => $this->email,
                'is_active' => $this->is_active,
            ]);
            $user->syncRoles([Role::find($this->role)->name]);
            $this->notification()->success('Usuario actualizado');
        } else {
                $user = User::create([
                    'name'      => $this->name,
                    'last_name' => $this->last_name,
                    'email'     => $this->email,
                    'password'  => $this->password,
                    'is_active' => $this->is_active,
                    ]);
                $user->assignRole(Role::find($this->role)->name);
                $this->notification()->success('Usuario creado');
        }

        $this->userModal = false;
        unset($this->users);              // Limpiar caché de propiedad computada
        $this->dispatch('model-updated'); // Actualiza el badge del header
    }

    public function confirmDelete($userId)
    {
        $this->dialog()->confirm([                                            'title'       => '¿Eliminar colaborador?',
        'description' => 'Esta acción no se puede deshacer.',
        'icon'        => 'error',
        'accept'      => [
            'label'  => 'Eliminar',
            'method' => 'delete', // Llama a tu función delete existente
            'params' => $userId,
        ],
            'reject' => [
                'label' => 'Cancelar',
            ],
        ]);
    }

    public function delete($id)
    {
        User::findOrFail($id)->delete();
        unset($this->users);
        $this->dispatch('model-updated');
        $this->notification()->success('Usuario eliminado');
    }

    public function edit($id)
    {
        $user            = User::findOrFail($id);
        $this->userId    = $id;
        $this->name      = $user->name;
        $this->last_name = $user->last_name;
        $this->email     = $user->email;
        $this->is_active = $user->is_active;
        $this->role      = $user->roles->first()?->id;
        $this->isEditing = true;
        $this->userModal = true;
    }

    #[On('toggleStatus')]
    public function toggleStatus($userId)
    {
        try {
            $user = User::findOrFail($userId);

            if (Auth::id() === $user->id) {
            $this->notification()->error('Acción no permitida', 'No puedes desactivar tu propia cuenta.');
            return;
        }

            $this->authorize('update', $user);
            // Cambiamos el estado explícitamente
            $newStatus = !$user->is_active;
            $user->update(['is_active' => $newStatus]);

            unset($this->users);

            // Disparamos la notificación basada en el nuevo estado real
            if ($newStatus) {
                $this->notification()->success('Usuario Activado', "{$user->names} ahora está activo.");
            } else {
                $this->notification()->warning('Usuario Desactivado', "{$user->names} ha sido desactivado.");
            }


        } catch (\Exception $e) {
            $this->notification()->error('Error', 'No se pudo actualizar el estado: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.users.user-index');
    }
}
