<?php

namespace Tests\Feature\Models;

use App\Livewire\Superadmin\User\UserList;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Role;
use App\Models\User;
use Livewire\Livewire;
use Illuminate\Foundation\Testing\WithFaker;
use App\Livewire\Superadmin\User\CreateUserForm;

class UserManagementTest extends TestCase
{
    use RefreshDatabase, WithFaker;
    /**
     * A basic feature test example.
     */
    public function setUp(): void
    {
        parent::setUp();

    }

    public function test_an_superadmin_can_view_the_user_list(): void
    {
        //GIVEN: usuario admin autenticado
        $superadmin = User::factory()->superadmin()->create();
        //GIVEN: usuario autenticado
        $this->actingAs($superadmin);

        //WHEN: El componente UserList es montado
        //livewire::test() monta el componente en un entorno de testing
        $component = Livewire::test(UserList::class);

        //THEN: el componente debe renderizarse exitosamente
        $component->assertStatus(200);

        //THEN: el componente debe mostrar la lista de usuarios
        $component->assertSeeText( 'ID', 'Nombre');
        //verificar que aparezca al menos un usuario si hay datos
        $component->assertSee($superadmin->name);
    }

    public function test_an_superadmin_can_view_the_livewire_user_creation_form(){
        //GIVEN: usuario admin autenticado
        $superadmin = User::factory()->superadmin()->create();


        //WHEN: usuario autenticado como admin intenta acceder al formulario de creación de usuario
        Livewire::actingAs($superadmin)
                ->test(CreateUserForm::class)
                ->assertStatus(200) // Verifica que el componente se renderiza sin errores
                ->assertSeeText('Crear Usuario')
                ->assertSee('Nombre')
                ->assertSee('Email')
                ->assertSee('Contraseña')
                ->assertSee('Confirmar contraseña')
                ->assertSee('Rol') // Nuevo: Verifica la etiqueta del selector de rol
                ->assertSee('is_active') // Nuevo: Verifica la etiqueta del checkbox is_active
                ->assertSee('Crear usuario')
                ->assertSeeInOrder(['Superadmin']); // Nuevo: Verifica que los nombres de los roles aparecen en el selector
    }

    public function test_non_superadmin_cannot_view_the_livewire_user_creation_form()
    {
        //GIVEN: usuario autenticado que no es administrador
        $user = User::factory()->viewer()->create();

        //WHEN: usuario autenticado intenta acceder al formulario de creación de usuario
        Livewire::actingAs($user)
            ->test(CreateUserForm::class)
            ->assertForbidden(); // Verifica que el acceso está prohibido
    }

    // public function test_an_administrator_can_create_a_new_user_with_livewire_component(): void
    // {
    //     //GIVEN: usuario admin autenticado
    //     $admin = User::factory()->administrator()->create();

    //     //GIVEN: datos del nuevo usuario
    //     $viewerRole = Role::where('name', 'Viewer')->first();


    //     //WHEN: el admin usa el componente Livewire para crear un nuevo usuario
    //     Livewire::actingAs($admin)
    //         ->test(CreateUserForm::class)
    //         ->set('name', $this->faker->name())
    //         ->set('email', $this->faker->unique()->safeEmail())
    //         ->set('password', 'password123')
    //         ->set('password_confirmation', 'password123')
    //         ->set('role_id', $viewerRole->id) // Asignar rol Viewer
    //         ->set('is_active', true) // Asignar estado activo
    //         ->call('createUser')
    //         ->assertRedirect(route('users.index'))
    //         ->assertSessionHas('success', 'Usuario creado exitosamente.');

    //     //THEN: el nuevo usuario debe existir en la base de datos
    //     $this->assertDatabaseHas('users', [
    //         'name' => $this->faker->name(),
    //         'email' => $this->faker->unique()->safeEmail(),
    //         'role_id' => $viewerRole->id,
    //         'is_active' => true,
    //     ]);

    //     //THEN: validamos que el usuario no tenga errores de validación
    //     Livewire::actingAs($admin)
    //         ->test(CreateUserForm::class)
    //         ->set('name', '') // Nombre vacío
    //         ->set('email', 'invalid-email') // Email inválido
    //         ->set('password', 'short') // Contraseña demasiado corta
    //         ->set('password_confirmation', 'mismatch') // Confirmación de contraseña no coincide
    //         ->call('createUser')
    //         ->assertHasErrors(['name', 'email', 'password', 'password_confirmation']);


    // }

    // public function test_user_search_functionality(){
    //     //GIVEN: usuario admin autenticado
    //     $admin = User::factory()->administrator()->create();
    //     $this->actingAs($admin);

    //     //GIVEN: varios usuarios en la base de datos
    //     $users = User::factory()->count(5)->create();

    //     //WHEN: se monta el componente UserList
    //     $component = Livewire::test(UserList::class);

    //     //THEN: el componente debe renderizarse exitosamente
    //     $component->assertStatus(200);

    //     //WHEN: se busca un usuario por nombre
    //     $searchTerm = $users->first()->name;
    //     $component->set('search', $searchTerm);

    //     //THEN: el componente debe mostrar solo los usuarios que coinciden con la búsqueda
    //     $component->assertSee($searchTerm);
    //     foreach ($users as $user) {
    //         if ($user->name !== $searchTerm) {
    //             $component->assertDontSee($user->name);
    //         }
    //     }
    // }
}
