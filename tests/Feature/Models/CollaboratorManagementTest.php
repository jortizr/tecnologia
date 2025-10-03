<?php

namespace Tests\Feature\Models;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;
use App\Models\User;
use App\Livewire\Superadmin\Collaborator\CreateCollaboratorForm;
use App\Livewire\Superadmin\Collaborator\CollaboratorList;
use App\Models\Collaborator;
use App\Models\Department;
use App\Models\Occupation;
use App\Models\Regional;

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
        //GIVEN: usuarrio superadmin creado
        $superadmin = User::factory()->superadmin()->create();

        // AND: Crea algunos colaboradores en la BD
        $collaborators = Collaborator::factory()->count(3)->create();

        // WHEN: cuando los colaboradores esten renderizados en la lista
        $livewire = Livewire::actingAs($superadmin)
            ->test(CollaboratorList::class)
            ->assertStatus(200);

        // THEN: Los colaboradores deben versen en la vista
        foreach ($collaborators as $collaborator) {
            $livewire->assertSee($collaborator->names);
            $livewire->assertSee($collaborator->last_name);
        }
    }

    public function test_a_superadmin_can_view_the_livewire_collaborator_creation_form(){
        //GIVEN: usuarrio superadmin creado
        $superadmin = User::factory()->superadmin()->create();

        //WHEN: cuando el superadmin intenta acceder al formulario de creación de colaborador
        Livewire::actingAs($superadmin)
            ->test(CreateCollaboratorForm::class)
            ->assertStatus(200)
            ->assertseeText('Crear Colaborador')
            ->assertSee('Nombres')
            ->assertSee('Apellidos')
            ->assertSee('Identificacion')
            ->assertSee('Codigo de nomina')
            ->assertSeeInOrder(['Seleccione el area'])
            ->assertSeeInOrder(['Seleccione la regional'])
            ->assertSeeInOrder(['Seleccione el cargo']);
    }


    public function test_a_superadmin_can_create_a_collaborator(){
        //GIVEN: usuarrio superadmin creado
        $superadmin = User::factory()->superadmin()->create();

        //datos del nuevo colaborador
        $collaboratorNew =[
            'names'=> 'Smith',
            'last_name'=> 'Swinderar',
            'identification'=> '123456897',
            'payroll_code'=> 'L15632',
            'department_id'=> Department::factory()->create()->id,
            'regional_id'=> Regional::factory()->create()->id,
            'occupation_id'=> Occupation::factory()->create()->id,
            'is_active'=> true,
        ];

        //WHEN: el superadmin intenta crear un colaborador
        Livewire::actingAs($superadmin)
            ->test(CreateCollaboratorForm::class)
            ->set('names', $collaboratorNew['names'])
            ->set('last_name', $collaboratorNew['last_name'])
            ->set('identification', $collaboratorNew['identification'])
            ->set('payroll_code', $collaboratorNew['payroll_code'])
            ->set('department_id', $collaboratorNew['department_id'])
            ->set('regional_id', $collaboratorNew['regional_id'])
            ->set('occupation_id', $collaboratorNew['occupation_id'])
            ->set('is_active', $collaboratorNew['is_active'])
            ->call('save')
            ->assertDatabaseHas('collaborators');


            // THEN: verificacion del colaborador nuevo en la BD
        $this->assertDatabaseHas('collaborators', [
            'names'=> $collaboratorNew['names'],
            'last_name'=> $collaboratorNew['last_name'],
            'payroll_code'=> $collaboratorNew['payroll_code'],
            'identification'=> $collaboratorNew['identification'],
        ]);
    }
}
