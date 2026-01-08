<?php

namespace App\Livewire\Superadmin\Collaborator;

use App\Models\Collaborator;
use Livewire\Component;
use Laravel\Jetstream\InteractsWithBanner;
use App\Models\Occupation;
use App\Models\Department;
use App\Models\Regional;


class CollaboratorEdit extends Component
{
    use InteractsWithBanner;
    public Collaborator $collaborator;
    public $names;
    public $last_name;
    public $identification;
    public $payroll_code;
    public $department_id;
    public $regional_id;
    public $occupation_id;
    public $is_active;
    public $is_cancelled = false;

    public $occupationOptions = [];
    public $departmentOptions = [];
    public $regionalOptions = [];
    public $selectedOccupationName = '';
    public $selectedDepartmentName = '';
    public $selectedRegionalName = '';
    public $selectedDepartment = '';
    public $selectedRegional = '';

    public function mount(Collaborator $collaborator)
    {
        //carga las relaciones para usarlas en el form
        $this->collaborator = $collaborator->load('occupation', 'department', 'regional');


        $this->names = $collaborator->names;
        $this->last_name = $collaborator->last_name;
        $this->identification = $collaborator->identification;
        $this->payroll_code = $collaborator->payroll_code;
        $this->is_active = $collaborator->is_active;
        //asignacion de los ids y nombres seleccionados
        $this->department_id = $collaborator->department_id;
        $this->regional_id = $collaborator->regional_id;
        $this->occupation_id = $collaborator->occupation_id;

        $this->selectedOccupationName = $collaborator->occupation->name ?? '';
        $this->selectedDepartmentName = $collaborator->department->name ?? '';
        $this->selectedRegionalName = $collaborator->regional->name ?? '';

        //cargar los datos del select
        $this->departmentOptions = Department::all('id', 'name');
        $this->occupationOptions = Occupation::all('id', 'name');
        $this->regionalOptions = Regional::all('id', 'name');
    }

    public function update(){
        $this->authorize('update', $this->collaborator);

        $validatedData = $this->validate([
            'names' => 'required',
            'last_name' => 'required',
            'identification' => 'required|unique:collaborators,identification,'. $this->collaborator->id,
            'payroll_code' => 'required|string|max:255|unique:collaborators,payroll_code,'. $this->collaborator->id,
            'department_id' => 'required|exists:departments,id',
            'regional_id' => 'required|exists:regionals,id',
            'occupation_id' => 'required|exists:occupations,id',
        ]);

        $this->collaborator->update($validatedData);

        $this->banner('Colaborador actualizado con éxito');
        $this->dispatch('collaborator-updated');
        return redirect()->route('dashboard.collaborators.show');

    }

    public function cancel(){
        $this->is_cancelled = true;
        return redirect()->back();
    }
    public function render()
    {
        $this->is_cancelled = false;
        return view('livewire.superadmin.collaborator.collaborator-edit');
    }
}
