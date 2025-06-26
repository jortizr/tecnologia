<?php

namespace Tests\Feature\Models;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Role;
use Livewire\Livewire;
use App\Livewire\UserRoleManager;


class UserRoleAssignmentTest extends TestCase
{
    //reinicia la BD para cada test
    use RefreshDatabase;
        protected function setUp(): void
        {
            parent::setUp();

            //verifica los roles basicos en la BD
            Role::firstOrCreate(['name' => 'Administrator', 'description' => 'Administrator']);
            Role::firstOrCreate(['name' => 'Moderator', 'description' => 'Moderator User']);
            Role::firstOrCreate(['name' => 'Viewer', 'description' => 'Content Viewer']);
        }

        public function test_an_administrator_can_assign_a_role_to_an_user(){
            //se crea el usuario super admin que creara el nuevo usuario
            $admin = User::factory()->administrator()->create();
            $user = User::factory()->create();
            $targetRole = Role::where('name', 'Moderator')->first();

            //validar que el usuario no tengal el rol
            $this->assertFalse($user->hasRole($targetRole->name));
            $this->assertDatabaseMissing('role_user', [
                'user_id' => $user->id,
                'role_id' => $targetRole->id,
            ]);

            //verificamos en la vista que el usuario este logueado en livewire
            Livewire::actingAs($admin)
                //instanciamos el componente livewire y le pasamos el usuario
                ->test(UserRoleManager::class, ['user' => $user])
                //simulamos la seleccion del rol a asignar
                ->set('selectedRole', $targetRole->id)
                //se llama al metodo del componente que asigna el rol al usuario
                ->call('assignRole');

            //verificamos que el modelo del user reconozca el rol asignado
            $user->refresh(); // Refresca el modelo para obtener los datos actualizados
            $this->assertTrue($user->hasRole($targetRole->name));
            //verificamos en la tabla intermedia de role_user que se haya creado el registro
            $this->assertDatabaseHas('role_user', [
                'user_id' => $user->id,
                'role_id' => $targetRole->id,
            ]);

            //simulacion de la request del Admin para asignar el rol al usuario desde un formulario Livewire
            $response = $this->actingAs($admin)
                ->post(route('users.role.assign', $user), [
                    'role_id' => $targetRole->id,
                ]);

            //verifica que la respuesta sea correcta y sin errores, redireccionando a la vista del usuario
            $response->assertSessionHasNoErrors();
            $response->assertRedirect(route('users.show', $user));

            // Verifica que el registro siga existiendo en la tabla intermedia
            $this->assertDatabaseHas('role_user', [
                'user_id' => $user->id,
                'role_id' => $targetRole->id,
            ]);
        }
}
