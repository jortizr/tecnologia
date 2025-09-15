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

class UserManagementTest extends TestCase
{
    use RefreshDatabase, WithFaker;
    /**
     * A basic feature test example.
     */
    public function setUp(): void
    {
        parent::setUp();
        //verifica los roles basicos en la BD
        $this->seed(RoleSeeder::class);
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


        // 3. THEN: el modal de edición se abre y contiene la información correcta del usuario

    }


}
