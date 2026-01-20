<?php

namespace Tests\Feature\Models;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Brand;
use Livewire\Livewire;
use App\Livewire\Brands\BrandIndex;


class BrandManagementTest extends TestCase
{
     use RefreshDatabase, WithFaker;
    private $superadmin;
    private $manager;
    private $viewer;
    private $brand;
    /**
     * A basic feature test example.
     */
    public function setUp(): void
    {
        parent::setUp();
        $this->artisan('db:seed', ['--class' => 'RoleSeeder']);

        $this->superadmin = User::factory()->create()->assignRole('Superadmin');
        $this->manager = User::factory()->create()->assignRole('Manager');
        $this->viewer = User::factory()->create()->assignRole('Viewer');
        $this->brand = Brand::factory()->create();
    }

    public function test_a_superadmin_can_view_the_brand_list(){
        Livewire::actingAs($this->superadmin)
            ->test(BrandIndex::class)
            ->assertStatus(200)
            ->assertSeeText('Lista de marcas');
    }

    public function test_a_manager_and_viewer_can_view_the_brand_list(){

        Livewire::actingAs($this->manager)
            ->test(BrandIndex::class)
            ->assertOk()
            ->assertSee('Lista de marcas');

        Livewire::actingAs($this->viewer)
            ->test(BrandIndex::class)
            ->assertOk()
            ->assertSee('Lista de marcas');
    }

}
