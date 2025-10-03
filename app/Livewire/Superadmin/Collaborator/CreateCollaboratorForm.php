<?php

namespace App\Livewire\Superadmin\Collaborator;

use App\Models\Collaborator;
use App\Models\Occupation;
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
    public $is_active= false;

    //busqueda del input
    public $searchOccupation = '';
    public $searchDepartment = '';
    public $searchRegional = '';
    public $occupations = [];
    public $departments = [];
    public $regionals = [];
    public $selectedOccupationName = '';
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

    public function mount(){
        //autorizacion de la accion create con el form
        //$this->authorize("create", Collaborator::class);
    }

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
        $this->reset(['names', 'last_name', 'identification', 'payroll_code', 'department_id', 'regional_id', 'occupation_id']);
    }

    public function updatedSearchOccupation($value){
        //limpia cuando se escriba en el input
        $this->occupation_id = '';
        $this->selectedOccupationName = '';

        if(strlen($value) >= 3){
            $this->occupations = Occupation::where('name', 'like', '%' . $value . '%')
            ->limit(10)
            ->get()
            ->toArray();
        }
    }

    public function selectOccupation($occupationId, $occupationName){
        $this->occupation_id = $occupationId;
        $this->selectedOccupationName = $occupationName;
        $this->searchOccupation = '';
        $this->occupations = [];
        $this->resetErrorBag('occupation_id');
    }

    public function render()
    {
        if($this->occupation_id && !$this->selectedOccupationName){
            $occupation = Occupation::find($this->occupation_id);
            if($occupation){
                $this->selectedOccupationName = $occupation->name;
            }
        }
        return view('livewire.superadmin.collaborator.create-collaborator-form');
    }
}
