<?php

namespace Tests\Feature\Models;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;
use App\Models\User;
use App\Livewire\Superadmin\Collaborator\CollaboratorList;
use App\Models\Collaborator;


class CollaboratorManagementTest extends TestCase
{
    use RefreshDatabase, WithFaker;

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
        //GIVEN: An authenticated superadmin user
        $superadmin = User::factory()->superadmin()->create();

        // AND: Some collaborators exist in the database
        $collaborators = Collaborator::factory()->count(3)->create();

        // WHEN: The CollaboratorList component is rendered
        $livewire = Livewire::actingAs($superadmin)
            ->test(CollaboratorList::class)
            ->assertStatus(200);

        // THEN: The collaborators' details are visible in the list
        foreach ($collaborators as $collaborator) {
            $livewire->assertSee($collaborator->names);
            $livewire->assertSee($collaborator->last_name);
        }
    }
}
