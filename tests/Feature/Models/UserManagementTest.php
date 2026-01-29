<?php

namespace Tests\Feature\Models;

use App\Livewire\Users\UserIndex;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Database\Seeders\RoleSeeder;
use Spatie\Permission\Models\Role;
use App\Models\User;
use Livewire\Livewire;
use Illuminate\Foundation\Testing\WithFaker;
use App\Livewire\Superadmin\User\CreateUserForm;
use App\Livewire\Superadmin\User\EditUser;



class UserManagementTest extends TestCase
{
    use RefreshDatabase, WithFaker;
    /**
     * A basic feature test example.
     */
    public function setUp(): void
    {
        parent::setUp();
        $this->seed(RoleSeeder::class);
    }

    public function test_a_superadmin_can_view_the_user_list(): void
    {
        $superadmin = User::factory()->superadmin()->create();
        $otherUser = User::factory()->create(['name' => 'Juanito']);

        Livewire::actingAs($superadmin)
            ->test(UserIndex::class)
            ->assertStatus(200)
            ->assertSee('Lista de Usuarios')
            ->assertSee($superadmin->name)
            ->assertSee('Juanito');
    }

    public function test_a_superadmin_can_open_the_create_user_modal()
    {
        $superadmin = User::factory()->superadmin()->create();

        Livewire::actingAs($superadmin)
            ->test(UserIndex::class)
            ->call('create') // Llamamos al método create del componente
            ->assertSet('userModal', true) // Verificamos que el modal se abra
            ->assertSet('isEditing', false)
            ->assertSet('is_active', true) // Verificamos valores por defecto
            ->assertSee('Nuevo Usuario'); // Verificamos el título del modal
    }

    public function test_a_superadmin_can_create_a_new_user(){
        $superadmin = User::factory()->superadmin()->create();
        $roleId = Role::where('name', 'Viewer')->first()->id;

        Livewire::actingAs($superadmin)
            ->test(UserIndex::class)
            ->call('create')
            ->set('name', 'Nuevo')
            ->set('last_name', 'Usuario')
            ->set('email', 'nuevo@test.com')
            ->set('password', 'password123')
            ->set('role', $roleId)
            ->set('is_active', true)
            ->call('save') // Ejecutamos guardar
            ->assertHasNoErrors()
            ->assertSet('userModal', false); // El modal debe cerrarse

        // Verificamos base de datos
        $this->assertDatabaseHas('users', [
            'email' => 'nuevo@test.com',
            'name' => 'Nuevo'
        ]);

        // Verificar rol asignado
        $newUser = User::where('email', 'nuevo@test.com')->first();
        $this->assertTrue($newUser->hasRole('Viewer'));
    }

    public function test_a_superadmin_can_open_the_edit_modal()
    {
        $superadmin = User::factory()->superadmin()->create();
        $userToEdit = User::factory()->create();

        Livewire::actingAs($superadmin)
            ->test(UserIndex::class)
            ->call('edit', $userToEdit->id) // Llamamos a editar con el ID
            ->assertSet('userModal', true)
            ->assertSet('isEditing', true)
            ->assertSet('userId', $userToEdit->id)
            ->assertSet('name', $userToEdit->name) // Verificamos que cargó los datos
            ->assertSet('email', $userToEdit->email)
            ->assertSee('Editar Usuario');
    }

    public function test_a_superadmin_can_update_a_user()
    {
        $superadmin = User::factory()->superadmin()->create();
        $userToEdit = User::factory()->create(['name' => 'Old Name']);
        $roleId = Role::where('name', 'Manager')->first()->id;

        Livewire::actingAs($superadmin)
            ->test(UserIndex::class)
            ->call('edit', $userToEdit->id)
            ->set('name', 'New Name Updated')
            ->set('role', $roleId)
            ->call('save')
            ->assertHasNoErrors()
            ->assertSet('userModal', false);

        $this->assertDatabaseHas('users', [
            'id' => $userToEdit->id,
            'name' => 'New Name Updated',
        ]);
    }


    public function test_validation_rules_work_correctly()
    {
        $superadmin = User::factory()->superadmin()->create();

        Livewire::actingAs($superadmin)
            ->test(UserIndex::class)
            ->call('create')
            ->set('name', '') // Nombre vacío
            ->set('email', 'not-an-email') // Email inválido
            ->call('save')
            ->assertHasErrors(['name', 'email']);
    }

    /** @test */
    public function test_a_superadmin_can_toggle_user_status()
    {
        $superadmin = User::factory()->superadmin()->create();
        $user = User::factory()->create(['is_active' => true]);

        Livewire::actingAs($superadmin)
            ->test(UserIndex::class)
            ->call('toggleStatus', $user->id); // Llamamos al listener/método

        // Recargamos el usuario desde la BD
        $this->assertFalse($user->fresh()->is_active);
    }

    /** @test */
    public function test_a_viewer_cannot_access_user_list()
    {
        $viewer = User::factory()->viewer()->create();

        Livewire::actingAs($viewer)
            ->test(UserIndex::class)
            ->assertForbidden();
    }

    /** @test */
    public function test_search_functionality_works()
    {
        $superadmin = User::factory()->superadmin()->create();
        $targetUser = User::factory()->create(['name' => 'Zendaya', 'email' => 'zen@test.com']);
        $otherUser = User::factory()->create(['name' => 'Tom', 'email' => 'tom@test.com']);

        Livewire::actingAs($superadmin)
            ->test(UserIndex::class)
            ->set('search', 'Zendaya') // Buscamos
            ->assertSee('Zendaya')
            ->assertDontSee('Tom'); // Tom no debería aparecer
    }
}
