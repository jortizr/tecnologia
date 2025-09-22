<?php

namespace Tests\Feature\Models;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;
use App\Models\User;
use App\Livewire\Superadmin\Colaborator\ColaboratorList;


class ColaboratorManagementTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        // Ejecutar seeders UNA SOLA VEZ al inicio
        $this->artisan('db:seed', ['--class' => 'RoleSeeder']);
    }

    /**
     * A basic feature test example.
     */
    public function test_a_superadmin_can_view_the_colaborator_list(): void
    {
        //GIVEN: usuario admin autenticado
        $superadmin = User::factory()->superadmin()->create();

        //WHEN: El componente UserList es montado livewire::test() monta el componente en un entorno de testing
         Livewire::actingAs($superadmin)
            ->test(ColaboratorList::class)
            ->assertStatus(200)
            ->assertSeeHtml($colaborators[0]->name);

    }
}
