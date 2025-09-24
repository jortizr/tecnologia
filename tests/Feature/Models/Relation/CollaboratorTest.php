<?php

namespace Tests\Feature\Models\Relation;

use App\Models\Collaborator;
use App\Models\department;
use App\Models\Occupation;
use App\Models\Regional;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CollaboratorTest extends TestCase
{
    use RefreshDatabase, WithFaker;
    /**
     * A basic feature test example.
     */
    public function test_collaborator_belongs_to_regional(): void
    {
        //GIVEN
        $regional = Regional::factory()->create();
        $collaborator = Collaborator::factory()->create([
            'regional_id' => $regional->id
        ]);

        //WHEN
        $this->assertInstanceOf(Regional::class, $collaborator->regional);

        //THEN
        $this->assertEquals($regional->id, $collaborator->regional->id);
    }

    public function test_collaborator_belongs_to_department(): void
    {
        //GIVEN
        $department = Department::factory()->create();
        $collaborator = Collaborator::factory()->create([
            'department_id' => $department->id
        ]);

        //WHEN
        $this->assertInstanceOf(Department::class, $collaborator->department);

        //THEN
        $this->assertEquals($department->id, $collaborator->department->id);
    }

        public function test_collaborator_belongs_to_occupation(): void
    {
        //GIVEN
        $occupation = Occupation::factory()->create();
        $collaborator = Collaborator::factory()->create([
            'occupation_id' => $occupation->id
        ]);

        //WHEN
        $this->assertInstanceOf(Occupation::class, $collaborator->occupation);

        //THEN
        $this->assertEquals($occupation->id, $collaborator->occupation->id);
    }

    public function test_collaborator_can_be_created_with_all_relationships()
    {
        //GIVEN
        $regional = Regional::factory()->create();
        $department = Department::factory()->create();
        $occupation = Occupation::factory()->create();

        //WHEN
        $collaborator = Collaborator::factory()->create([
            'names' => 'Jefferson',
            'last_name' => 'Ortiz',
            'identification' => '1110522123',
            'payroll_code' => 'L05060',
            'department_id' =>  $department->id,
            'regional_id' => $regional->id,
            'occupation_id' => $occupation->id,
            'is_active' => true,
        ]);

        $this->assertDatabaseHas('collaborators', [
            'id' => $collaborator->id,
            'department_id' => $department->id,
            'regional_id'=> $regional->id,
            'occupation_id'=> $occupation->id,
        ]);

        //THEN
        $this->assertInstanceOf(Department::class, $collaborator->department);
        $this->assertInstanceOf(Regional::class, $collaborator->regional);
        $this->assertInstanceOf(Occupation::class, $collaborator->occupation);
    }
}
