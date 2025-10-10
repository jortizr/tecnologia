<?php

namespace App\Livewire\Superadmin\Collaborator;

use App\Models\Collaborator;
use App\Models\Department;
use App\Models\Occupation;
use App\Models\Regional;
use App\Models\User;
use Livewire\Component;
use Laravel\Jetstream\InteractsWithBanner;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class CreateCollaboratorForm extends Component
{
    use InteractsWithBanner;
    use AuthorizesRequests;
    public bool $isOpen = false;
    public $names;
    public $last_name;
    public $identification;
    public $payroll_code;
    public $department_id;
    public $regional_id;
    public $occupation_id;
    public $is_active= true;

    //busqueda del input
    public $searchOccupation = '';
    public $searchDepartment = '';
    public $searchRegional = '';
    public $occupations = [];
    public $departments = [];
    public $regionals = [];
    public $selectedOccupationName = '';
    public $selectedDepartmentName = '';
    public $selectedRegionalName = '';
    public $selectedDepartment = '';
    public $selectedRegional = '';

    protected $rules = [
        'names' => 'required|string|max:255',
        'last_name' => 'required|string|max:255',
        'identification' => 'required|string|max:255',
        'payroll_code' => 'required|string|max:255',
        'department_id' => 'required|exists:departments,id',
        'regional_id' => 'required|exists:regionals,id',
        'occupation_id' => 'required|exists:occupations,id',
        'is_active' => 'boolean',
    ];

    protected $messages = [
        'names.same' => 'Ingrese el nombre.',
        'last_name.same' => 'Ingrese un apellido.',
        'identification.same' => 'Ingrese una identificacion.',
        'payroll_code.same' => 'Ingrese un codigo de nomina.',
        'department_id.same' => 'Seleccione un area.',
        'regional_id.same' => 'Seleccione una regional.',
        'occupation_id.same' => 'Seleccione un cargo.',
    ];

    public function openModal()
    {
        $this->resetForm();
        $this->isOpen = true;
    }

    public function closeModal()
    {
        $this->isOpen = false;
        $this->resetValidation();
    }
    public function resetForm()
    {
        $this->reset(['names', 'last_name', 'identification', 'payroll_code', 'department_id', 'regional_id', 'occupation_id','searchOccupation', 'searchDepartment', 'searchRegional', 'selectedOccupationName', 'selectedDepartmentName', 'selectedRegionalName', 'occupations', 'departments', 'regionals']);
    }

    public function updatedSearchOccupation($value){
        if($this->occupation_id && $value !== $this->selectedOccupationName){
            $this->occupation_id = null;
            $this->selectedOccupationName = '';
        }

        if(strlen($value) >= 3){
            $this->occupations = Occupation::where('name', 'like', '%' . $value . '%')
            ->limit(10)
            ->get()
            ->map(function($occupation){
                return [
                    'id' => $occupation->id,
                    'name' => $occupation->name,
                ];
            })
            ->toArray();
        }else {
            $this->occupations = [];
        }
    }

    public function selectOccupation($occupationId, $occupationName){
        $this->occupation_id = $occupationId;
        $this->selectedOccupationName = $occupationName;
        $this->searchOccupation = $occupationName;
        $this->occupations = [];
        $this->resetErrorBag('occupation_id');
    }

    public function clearOccupation(){
        $this->occupation_id = null;
        $this->selectedOccupationName = '';
        $this->searchOccupation = '';
        $this->occupations = [];
    }

    public function updatedSearchDepartment($value){
        if($this->department_id && $value !== $this->selectedDepartmentName){
            $this->department_id = null;
            $this->selectedDepartmentName = '';
        }

        if(strlen($value) >= 3){
            $this->departments = Department::where('name', 'like', '%' . $value . '%')
            ->limit(10)
            ->get()
            ->map(function($department){
                return [
                    'id' => $department->id,
                    'name' => $department->name,
                ];
            })
            ->toArray();
        }else {
            $this->departments = [];
        }
    }

        public function selectDepartment($departmentId, $departmentName){
        $this->department_id = $departmentId;
        $this->selectedDepartmentName = $departmentName;
        $this->searchDepartment = $departmentName;
        $this->departments = [];
        $this->resetErrorBag('department_id');
    }

    public function clearDepartment(){
        $this->department_id = null;
        $this->selectedDepartmentName = '';
        $this->searchDepartment = '';
        $this->departments = [];
    }


    public function updatedSearchRegional($value){
        if($this->regional_id && $value !== $this->selectedRegionalName){
            $this->regional_id = null;
            $this->selectedRegionalName = '';
        }

        if(strlen($value) >= 3){
            $this->regionals = Regional::where('name', 'like', '%' . $value . '%')
            ->limit(10)
            ->get()
            ->map(function($department){
                return [
                    'id' => $department->id,
                    'name' => $department->name,
                ];
            })
            ->toArray();
        }else {
            $this->departments = [];
        }
    }

        public function selectRegional($regionalId, $regionalName){
        $this->regional_id = $regionalId;
        $this->selectedRegionalName = $regionalName;
        $this->searchRegional = $regionalName;
        $this->regionals = [];
        $this->resetErrorBag('regional_id');
    }

    public function clearRegional(){
        $this->regional_id = null;
        $this->selectedRegionalName = '';
        $this->searchRegional = '';
        $this->regionals = [];
    }

    public function store(){
        $this->authorize('create', Collaborator::class);
        $this->validate();
        try {
            $collaborate = Collaborator::create([
                'names' => $this->names,
                'last_name' => $this->last_name,
                'identification' => $this->identification,
                'payroll_code' => $this->payroll_code,
                'department_id' => $this->department_id,
                'regional_id' => $this->regional_id,
                'occupation_id' => $this->occupation_id,
                'is_active' => $this->is_active
            ]);
            $this->banner('Colaborador creado exitosamente');
            $this->closeModal();
            $this->resetForm();
            $this->dispatch('collaboratorCreated');
        } catch (\Exception $e){
            $this->addError('general', 'Error al crear el colaborador: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.superadmin.collaborator.create-collaborator-form');
    }
}
