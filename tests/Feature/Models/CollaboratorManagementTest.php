<?php

namespace Tests\Feature\Models;

use App\Models\Department;
use App\Models\Occupation;
use App\Models\Regional;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;
use Database\Seeders\RoleSeeder;
use App\Models\User;
use App\Livewire\Collaborators\CollaboratorIndex;
use App\Models\Collaborator;
use PHPUnit\Framework\Attributes\Test;

class CollaboratorManagementTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    private $superadmin;
    private $manager;
    private $viewer;

    public function setUp(): void
    {
        parent::setUp();
        // Seeder de roles esencial para permisos
        $this->seed(RoleSeeder::class);

        $this->superadmin = User::factory()->superadmin()->create();
        $this->manager = User::factory()->manager()->create();
        $this->viewer = User::factory()->viewer()->create();
    }

    #[Test]
    public function a_superadmin_can_view_the_collaborator_list()
    {
        $collaborators = Collaborator::factory()->count(3)->create();

        Livewire::actingAs($this->superadmin)
            ->test(CollaboratorIndex::class)
            ->assertStatus(200)
            ->assertSee('Lista de colaboradores') // Ajusta según tu título real
            ->assertSee($collaborators->first()->names)
            ->assertSee($collaborators->first()->last_name);
    }

    #[Test]
    public function a_superadmin_can_create_a_collaborator_via_modal()
    {
        // 1. Datos necesarios para los selects (Foreign Keys)
        $department = Department::factory()->create();
        $regional = Regional::factory()->create();
        $occupation = Occupation::factory()->create();

        // 2. Simular apertura del modal y llenado
        Livewire::actingAs($this->superadmin)
            ->test(CollaboratorIndex::class)
            ->call('create') // Abre el modal
            ->assertSet('collaboratorModal', true) // Verifica estado del modal
            ->assertSee('Agregar Colaborador')
            ->set('names', 'John')
            ->set('last_name', 'Doe')
            ->set('identification', '123456789')
            ->set('payroll_code', 'PAY-001')
            ->set('department_id', $department->id)
            ->set('regional_id', $regional->id)
            ->set('occupation_id', $occupation->id)
            ->set('is_active', true)
            ->call('save') // Guarda (método unificado save)
            ->assertHasNoErrors()
            ->assertSet('collaboratorModal', false); // El modal debe cerrarse

        // 3. Verificar en BD
        $this->assertDatabaseHas('collaborators', [
            'identification' => '123456789',
            'names' => 'John',
            'payroll_code' => 'PAY-001'
        ]);
    }

    #[Test]
    public function a_superadmin_can_edit_a_collaborator_via_modal()
    {
        $collaborator = Collaborator::factory()->create();

        Livewire::actingAs($this->superadmin)
            ->test(CollaboratorIndex::class)
            ->call('edit', $collaborator->id) // Cargar datos en el modal
            ->assertSet('collaboratorModal', true)
            ->assertSet('isEditing', true)
            ->assertSet('names', $collaborator->names) // Verificar que cargó los datos
            ->set('names', 'Nombre Actualizado') // Cambiar dato
            ->call('save')
            ->assertHasNoErrors()
            ->assertSet('collaboratorModal', false);

        $this->assertDatabaseHas('collaborators', [
            'id' => $collaborator->id,
            'names' => 'Nombre Actualizado'
        ]);
    }

    #[Test]
    public function validation_rules_are_enforced()
    {
        Livewire::actingAs($this->superadmin)
            ->test(CollaboratorIndex::class)
            ->call('create')
            ->set('names', '') // Campo requerido vacío
            ->set('identification', '')
            ->call('save')
            ->assertHasErrors(['names', 'identification']);
    }

    #[Test]
    public function a_superadmin_can_delete_a_collaborator()
    {
        $collaborator = Collaborator::factory()->create();

        Livewire::actingAs($this->superadmin)
            ->test(CollaboratorIndex::class)
            ->call('delete', $collaborator->id)
            ->assertHasNoErrors();

        $this->assertDatabaseMissing('collaborators', [
            'id' => $collaborator->id
        ]);
    }

    #[Test]
    public function a_viewer_cannot_create_or_delete_collaborators()
    {
        $collaborator = Collaborator::factory()->create();

        // Intento de Crear
        Livewire::actingAs($this->viewer)
            ->test(CollaboratorIndex::class)
            ->call('create') // Intentar abrir modal de creación
            ->assertForbidden(); // O assertStatus(403) según tu manejo

        // Intento de Borrar
        Livewire::actingAs($this->viewer)
            ->test(CollaboratorIndex::class)
            ->call('delete', $collaborator->id)
            ->assertForbidden();
    }

    #[Test]
    public function search_functionality_works_for_collaborators()
    {
        Collaborator::factory()->create(['names' => 'Maria', 'identification' => '11111']);
        Collaborator::factory()->create(['names' => 'Pedro', 'identification' => '22222']);

        Livewire::actingAs($this->superadmin)
            ->test(CollaboratorIndex::class)
            ->set('search', 'Maria')
            ->assertSee('Maria')
            ->assertDontSee('Pedro');
    }
}
