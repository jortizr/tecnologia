<?php

namespace Tests\Feature\Models;

use App\Livewire\Superadmin\User\UserList;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Database\Seeders\RoleSeeder;
use App\Models\User;
use Livewire\Livewire;
use Illuminate\Foundation\Testing\WithFaker;
use App\Livewire\Superadmin\User\CreateUserForm;
use App\Livewire\Superadmin\User\EditUser;
use Illuminate\Auth\Access\AuthorizationException;


class UserManagementTest extends TestCase
{
    use RefreshDatabase, WithFaker;
    /**
     * A basic feature test example.
     */
    public function setUp(): void
    {
        parent::setUp();
        // Ejecutar seeders UNA SOLA VEZ al inicio
        $this->artisan('db:seed', ['--class' => 'RoleSeeder']);
    }

    public function test_a_superadmin_can_view_the_user_list(): void
    {
        //GIVEN: usuario admin autenticado
        $superadmin = User::factory()->superadmin()->create();

        //WHEN: El componente UserList es montado livewire::test() monta el componente en un entorno de testing
         Livewire::actingAs($superadmin)
            ->test(UserList::class)
            ->assertStatus(status: 200)
            ->assertSeeText( 'ID', 'Nombre')
            //verificar que aparezca al menos un usuario si hay datos
            ->assertSee($superadmin->name);
    }

    public function test_a_superadmin_can_view_the_livewire_user_creation_form(){
        //GIVEN: usuario superadmin autenticado
        $superadmin = User::factory()->superadmin()->create();


        //WHEN: usuario autenticado como admin intenta acceder al formulario de creación de usuario
        Livewire::actingAs($superadmin)
                ->test(CreateUserForm::class)
                ->assertStatus(200) // Verifica que el componente se renderiza sin errores
                ->assertSeeText('Crear Usuario')
                ->assertSee('Nombre')
                ->assertSee('Email')
                ->assertSee('Contraseña')
                ->assertSee('Rol') // Nuevo: Verifica la etiqueta del selector de rol
                ->assertSee('is_active') // Nuevo: Verifica la etiqueta del checkbox is_active
                ->assertSee('Crear usuario')
                ->assertSeeInOrder(['Superadmin']); // Nuevo: Verifica que los nombres de los roles aparecen en el selector
    }


    public function test_a_superadmin_can_edit_an_user(){
         // 1. GIVEN: un superadmin autenticado y un usuario a editar
        $superadmin = User::factory()->superadmin()->create();
        $userToEdit = User::factory()->viewer()->create();

        // 2. WHEN: el superadmin monta el componente UserList y hace clic en "editar"
        $component = Livewire::actingAs($superadmin)
            ->test(EditUser::class, ['user' => $userToEdit])
                ->assertSet('name', $userToEdit->name)
                ->assertSet('last_name', $userToEdit->last_name)
                ->assertSet('email', $userToEdit->email)
                ->assertSet('role', $userToEdit->roles->first()->name)
                ->assertSeeText('Editar Usuario');

    }

    public function test_a_viewer_cannot_access_to_user_list()
    {
        $viewer = User::factory()->viewer()->create();

        //el viewer no puede acceder a la lista de usuarios
        Livewire::actingAs($viewer)
            ->test(UserList::class)
            ->assertForbidden();
    }

    public function test_policies_and_ui_authorization_are_consistent()
    {
        // 1. PREPARACIÓN: Crear un usuario "conejillo de indias" para las pruebas
        $userToTest = User::factory()->viewer()->create();
        // Este usuario será el "objetivo" sobre el que otros usuarios intentarán hacer acciones

        // 2. PRUEBA PARA SUPERADMIN
        $superadmin = User::factory()->superadmin()->create();

        // Verificar permisos del SUPERADMIN:
        $canViewAny = $superadmin->can('viewAny', User::class); // ¿Puede ver lista de usuarios?
        $canUpdate = $superadmin->can('update', $userToTest);// ¿Puede editar usuarios?
        $canDelete = $superadmin->can('delete', $userToTest);// ¿Puede eliminar usuarios?

         // EXPECTATIVAS: Superadmin debería poder hacer TODO
        $this->assertTrue($canViewAny, 'Superadmin should be able to view any users');
        $this->assertTrue($canUpdate, 'Superadmin should be able to update users');
        $this->assertTrue($canDelete, 'Superadmin should be able to delete users');

        // Verificar permisos del VIEWER - no puede hacer nada con usuarios:
        $viewer = User::factory()->viewer()->create();

        // Verificar permisos del VIEWER :
        $canViewAnyViewer = $viewer->can('viewAny', User::class);// ¿Puede ver lista?
        $canUpdate = $viewer->can('update', $userToTest);// ¿Puede editar usuarios?
        $canDelete = $viewer->can('delete', $userToTest);// ¿Puede eliminar?

        // EXPECTATIVAS: Viewer NO debería poder hacer NADA con usuarios
        $this->assertFalse($canViewAnyViewer, 'Viewer should not be able to view any users');
        $this->assertFalse($canUpdate, 'Viewer should not be able to update users');
        $this->assertFalse($canDelete, 'Viewer should not be able to delete users');

        // 4. PRUEBA PARA MANAGER
        $manager = User::factory()->manager()->create();

        // Verificar permisos del MANAGER - NO puede gestionar usuarios :
        $canViewAnyManager = $manager->can('viewAny', User::class);
        $canUpdate = $manager->can('update', $userToTest);
        $canDelete = $manager->can('delete', $userToTest);

        $this->assertFalse($canViewAnyManager, 'Manager should not be able to view any users');
        $this->assertFalse($canUpdate, 'Manager should not be able to update users');
        $this->assertFalse($canDelete, 'Manager should not be able to delete users');

    }

    public function test_superadmin_cannot_delete_themselves()
    {
        $superadmin = User::factory()->superadmin()->create();

        $canDeleteSelf = $superadmin->can('delete', $superadmin);

        $this->assertFalse($canDeleteSelf,'Superadmin should not be able to delete themselves');
    }

    public function test_a_superadmin_can_delete_an_user()
    {
        // 1. GIVEN: un superadmin autenticado y un usuario a eliminar
        $superadmin = User::factory()->superadmin()->create();
        $userToDelete = User::factory()->viewer()->create();

        // 2. WHEN: el superadmin monta el componente UserList y hace clic en "eliminar"
        Livewire::actingAs($superadmin)
            ->test(UserList::class)
            ->call('delete', $userToDelete->id);

        // 3. THEN: el usuario es eliminado de la base de datos
        $this->assertDatabaseMissing('users', [
            'id' => $userToDelete->id,
        ]);
    }

    public function test_debug_roles_are_assigned_correctly()
    {
        // creacion de usuarios
        $superadmin = User::factory()->superadmin()->create();
        $manager = User::factory()->manager()->create();
        $viewer = User::factory()->viewer()->create();

        // Verificar que los roles se asignaron correctamente
        $this->assertTrue($superadmin->hasRole('Superadmin'), 'Superadmin role not assigned');
        $this->assertTrue($manager->hasRole('Manager'), 'Manager role not assigned');
        $this->assertTrue($viewer->hasRole('Viewer'), 'Viewer role not assigned');

        // Verificar que los roles existen en la base de datos
        $this->assertDatabaseHas('roles', ['name' => 'Superadmin']);
        $this->assertDatabaseHas('roles', ['name' => 'Manager']);
        $this->assertDatabaseHas('roles', ['name' => 'Viewer']);

        // Verificar las relaciones en model_has_roles
        $this->assertDatabaseHas('model_has_roles', [
            'model_id' => $superadmin->id,
            'model_type' => User::class,
        ]);

        echo "✅ Roles asignados correctamente\n";
        echo "Superadmin roles: " . $superadmin->roles->pluck('name')->implode(', ') . "\n";
        echo "Manager roles: " . $manager->roles->pluck('name')->implode(', ') . "\n";
        echo "Viewer roles: " . $viewer->roles->pluck('name')->implode(', ') . "\n";

    }

    public function test_debug_simple_authorization(){
        $viewer = User::factory()->viewer()->create();

        // Debug básico
        $this->assertNotNull($viewer, 'Usuario no fue creado');
        $this->assertTrue($viewer->hasRole('Viewer'), 'Usuario no tiene rol Viewer');
        $this->assertFalse($viewer->hasRole('Superadmin'), 'Usuario no debería tener rol Superadmin');
        $this->assertFalse($viewer->can('viewAny', User::class), 'Viewer no debería poder viewAny User');

        // Verificar que existe la policy
        $policy = app(\Illuminate\Contracts\Auth\Access\Gate::class)->getPolicyFor(User::class);
        $this->assertNotNull($policy, 'UserPolicy no está registrada');
    }

}
