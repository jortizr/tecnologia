<?php

namespace Tests\Feature\Models;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Role;
use App\Models\User;
use Livewire\Livewire;
use App\Livewire\User\UserList;
use Illuminate\Foundation\Testing\WithFaker;

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
        Role::firstOrCreate(['name' => 'Administrator', 'description' => 'Administrator']);
        Role::firstOrCreate(['name' => 'Moderator', 'description' => 'Moderator User']);
        Role::firstOrCreate(['name' => 'Viewer', 'description' => 'Content Viewer']);
    }

    public function test_an_administrator_can_view_the_user_list(): void
    {
        //GIVEN: usuario admin autenticado
        $admin = User::factory()->administrator()->create();
        //GIVEN: usuario autenticado
        $this->actingAs($admin);

        //WHEN: El componente UserList es montado
        //livewire::test() monta el componente en un entorno de testing
        $component = Livewire::test(UserList::class);

        //THEN: el componente debe renderizarse exitosamente
        $component->assertStatus(200);

        //THEN: el componente debe mostrar la lista de usuarios
        $component->assertSee('Lista de Usuarios');
        //verificar que aparezca al menos un usuario si hay datos
        $component->assertSee($admin->name);
    }



    public function test_an_administrator_can_create_a_new_user(): void
    {
        //GIVEN: usuario admin autenticado
        $admin = User::factory()->administrator()->create();

        //GIVEN: datos del nuevo usuario
        $newUserData = [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'password' => 'password',
            'password_confirmation' => 'password',
            'role' => Role::where('name', 'Viewer')->first()->id, // Asignar rol Viewer
        ];

        //WHEN: el admin hace una solicitud POST a la ruta
        $response = $this->actingAs($admin)->post(route('users.store'), $newUserData);

        //THEN: 1. la respuesta debe ser exitosa con una redireccion (HTTP 302) sin errores
        $response->assertStatus(302);
        $response->assertSessionHasNoErrors();
        $response->assertRedirect(route('users.index'));

        //THEN: 2. El nuevo usuario debe existir en la base de datos
        $this->assertDatabaseHas('users',
            [
                'name' => $newUserData['name'],
                'email' => $newUserData['email'],
            ]
        );

        //THEN: 3. El nuevo usuario debe tener el rol asignado
        $createdUser = User::where('email', $newUserData['email'])->first();
        //comprobamos que fue encontrado
        $this->assertNotNull($createdUser);
        $this->assertTrue($createdUser->hasRole('Viewer'));
    }

    public function test_user_search_functionality(){
        //GIVEN: usuario admin autenticado
        $admin = User::factory()->administrator()->create();
        $this->actingAs($admin);

        //GIVEN: varios usuarios en la base de datos
        $users = User::factory()->count(5)->create();

        //WHEN: se monta el componente UserList
        $component = Livewire::test(UserList::class);

        //THEN: el componente debe renderizarse exitosamente
        $component->assertStatus(200);

        //WHEN: se busca un usuario por nombre
        $searchTerm = $users->first()->name;
        $component->set('search', $searchTerm);

        //THEN: el componente debe mostrar solo los usuarios que coinciden con la búsqueda
        $component->assertSee($searchTerm);
        foreach ($users as $user) {
            if ($user->name !== $searchTerm) {
                $component->assertDontSee($user->name);
            }
        }
    }
}
