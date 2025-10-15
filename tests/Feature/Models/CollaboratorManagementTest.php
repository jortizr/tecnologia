<?php

namespace Tests\Feature\Models;

use App\Models\Department;
use App\Models\Occupation;
use App\Models\Regional;
use App\Policies\CollaboratorPolicy;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;
use App\Models\User;
use App\Livewire\Superadmin\Collaborator\CreateCollaboratorForm;
use App\Livewire\Superadmin\Collaborator\CollaboratorList;
use App\Models\Collaborator;
use App\Livewire\Superadmin\Collaborator\CollaboratorEdit;

class CollaboratorManagementTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    private $superadmin;
    private $manager;
    private $viewer;
    private $collaborator;

    public function setUp(): void
    {
        parent::setUp();
        $this->artisan('db:seed', ['--class' => 'RoleSeeder']);

        $this->superadmin = User::factory()->create()->assignRole('Superadmin');
        $this->manager = User::factory()->create()->assignRole('Manager');
        $this->viewer = User::factory()->create()->assignRole('Viewer');
        $this->collaborator = Collaborator::factory()->create();
    }

    public function test_a_superadmin_can_view_the_colaborator_list(): void
    {
        $this->actingAs($this->superadmin);
        $collaborators = Collaborator::factory()->count(3)->create();
        $livewire = Livewire::test(CollaboratorList::class)
            ->assertStatus(200);

        foreach ($collaborators as $collaborator) {
            $livewire->assertSee($collaborator->names);
            $livewire->assertSee($collaborator->last_name);
        }
    }

    public function test_a_superadmin_can_view_the_livewire_collaborator_creation_form(){
        $this->actingAs($this->superadmin);
        Livewire::test(CreateCollaboratorForm::class)
            ->assertStatus(200)
            ->assertseeText('Crear Colaborador')
            ->assertSee('Nombres')
            ->assertSee('Apellidos')
            ->assertSee('Identificacion')
            ->assertSee('Codigo de nomina')
            ->assertSeeInOrder(['Buscar area...'])
            ->assertSeeInOrder(['Buscar cargo...'])
            ->assertSeeInOrder(['Buscar regional...']);
    }


    public function test_a_superadmin_can_create_a_collaborator(){
        $this->actingAs($this->superadmin);
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

        Livewire::test(CreateCollaboratorForm::class)
            ->set('names', $collaboratorNew['names'])
            ->set('last_name', $collaboratorNew['last_name'])
            ->set('identification', $collaboratorNew['identification'])
            ->set('payroll_code', $collaboratorNew['payroll_code'])
            ->set('department_id', $collaboratorNew['department_id'])
            ->set('regional_id', $collaboratorNew['regional_id'])
            ->set('occupation_id', $collaboratorNew['occupation_id'])
            ->set('is_active', $collaboratorNew['is_active'])
            ->call('store')
            ->assertHasNoErrors()
            ->assertDispatched('collaboratorCreated');

        $this->assertDatabaseHas('collaborators', [
            'names'=> $collaboratorNew['names'],
            'last_name'=> $collaboratorNew['last_name'],
            'payroll_code'=> $collaboratorNew['payroll_code'],
            'identification'=> $collaboratorNew['identification'],
        ]);
    }

    public function test_a_superadmin_can_edit_a_collaborator(){
        // 1. GIVEN: un superadmin autenticado y un usuario a editar
        $superadmin = User::factory()->superadmin()->create();
        $collaboratorToEdit = Collaborator::factory()->create();

        // 2. WHEN: el superadmin monta el componente CollaboratorList y hace clic en "editar"
        Livewire::actingAs($superadmin)
            ->test(CollaboratorEdit::class, ['collaborator' => $collaboratorToEdit])
                ->assertSet('names', $collaboratorToEdit->names)
                ->assertSet('last_name', $collaboratorToEdit->last_name)
                ->assertSet('identification', $collaboratorToEdit->identification)
                ->assertSet('payroll_code', $collaboratorToEdit->payroll_code)
                ->assertSeeText('Editar Colaborador');

    }

    // Policy Tests

    public function test_superadmin_can_view_any_collaborator()
    {
        $policy = new CollaboratorPolicy();
        $this->assertTrue($policy->viewAny($this->superadmin));
    }

    public function test_manager_can_view_any_collaborator()
    {
        $policy = new CollaboratorPolicy();
        $this->assertTrue($policy->viewAny($this->manager));
    }

    public function test_viewer_can_view_any_collaborator()
    {
        $policy = new CollaboratorPolicy();
        $this->assertTrue($policy->viewAny($this->viewer));
    }

    public function test_superadmin_can_view_a_collaborator()
    {
        $policy = new CollaboratorPolicy();
        $this->assertTrue($policy->view($this->superadmin, $this->collaborator));
    }

    public function test_manager_can_view_a_collaborator()
    {
        $policy = new CollaboratorPolicy();
        $this->assertTrue($policy->view($this->manager, $this->collaborator));
    }

    public function test_viewer_can_view_a_collaborator()
    {
        $policy = new CollaboratorPolicy();
        $this->assertTrue($policy->view($this->viewer, $this->collaborator));
    }

    public function test_superadmin_can_create_a_collaborator_policy()
    {
        $policy = new CollaboratorPolicy();
        $this->assertTrue($policy->create($this->superadmin));
    }

    public function test_manager_can_create_a_collaborator_policy()
    {
        $policy = new CollaboratorPolicy();
        $this->assertTrue($policy->create($this->manager));
    }

    public function test_viewer_cannot_create_a_collaborator_policy()
    {
        $policy = new CollaboratorPolicy();
        $this->assertFalse($policy->create($this->viewer));
    }

    public function test_superadmin_can_update_a_collaborator_policy()
    {
        $policy = new CollaboratorPolicy();
        $this->assertTrue($policy->update($this->superadmin, $this->collaborator));
    }

    public function test_manager_can_update_a_collaborator_policy()
    {
        $policy = new CollaboratorPolicy();
        $this->assertTrue($policy->update($this->manager, $this->collaborator));
    }

    public function test_viewer_cannot_update_a_collaborator_policy()
    {
        $policy = new CollaboratorPolicy();
        $this->assertFalse($policy->update($this->viewer, $this->collaborator));
    }

    public function test_superadmin_can_delete_a_collaborator_policy()
    {
        $policy = new CollaboratorPolicy();
        $this->assertTrue($policy->delete($this->superadmin, $this->collaborator));
    }

    public function test_manager_cannot_delete_a_collaborator_policy()
    {
        $policy = new CollaboratorPolicy();
        $this->assertFalse($policy->delete($this->manager, $this->collaborator));
    }

    public function test_viewer_cannot_delete_a_collaborator_policy()
    {
        $policy = new CollaboratorPolicy();
        $this->assertFalse($policy->delete($this->viewer, $this->collaborator));
    }

    public function test_a_viewer_cannot_see_the_create_collaborator_button()
    {
        $this->actingAs($this->viewer);
        Livewire::test(CollaboratorList::class)
            ->assertStatus(200)
            ->assertDontSee('Crear Colaborador');
    }

    public function test_a_manager_can_see_the_create_collaborator_button()
    {
        $this->actingAs($this->manager);
        Livewire::test(CollaboratorList::class)
            ->assertStatus(200)
            ->assertSeeText('Crear Colaborador');
    }

    public function test_a_viewer_is_forbidden_from_creating_a_collaborator()
    {
        $this->actingAs($this->viewer);

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

        Livewire::test(CreateCollaboratorForm::class)
            ->set('names', $collaboratorNew['names'])
            ->set('last_name', $collaboratorNew['last_name'])
            ->set('identification', $collaboratorNew['identification'])
            ->set('payroll_code', $collaboratorNew['payroll_code'])
            ->set('department_id', $collaboratorNew['department_id'])
            ->set('regional_id', $collaboratorNew['regional_id'])
            ->set('occupation_id', $collaboratorNew['occupation_id'])
            ->set('is_active', $collaboratorNew['is_active'])
            ->call('store')
            ->assertForbidden();
    }

    public function test_a_manager_is_forbidden_from_deleting_a_collaborator()
    {
        $this->actingAs($this->manager);
        $collaborator = Collaborator::factory()->create();

        Livewire::test(CollaboratorList::class)
            ->call('delete', $collaborator->id)
            ->assertForbidden();
    }

    public function test_a_superadmin_can_delete_a_collaborator()
    {
        $this->actingAs($this->superadmin);
        $collaborator = Collaborator::factory()->create();

        Livewire::test(CollaboratorList::class)
            ->call('delete', $collaborator->id)
            ->assertHasNoErrors();

        $this->assertDatabaseMissing('collaborators', ['id' => $collaborator->id]);
    }
}
