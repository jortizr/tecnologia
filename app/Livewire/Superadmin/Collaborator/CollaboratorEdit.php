<?php

namespace App\Livewire\Superadmin\Collaborator;

use App\Models\Collaborator;
use Livewire\Component;
use Laravel\Jetstream\InteractsWithBanner;

class CollaboratorEdit extends Component
{
    use InteractsWithBanner;
    public $names;
    public $last_name;
    public $identification;
    public $payroll_code;
    public $department_id;
    public $regional_id;
    public $occupation_id;
    public $is_active;
    public $is_cancelled = false;

    public function mount(Collaborator $collaborator)
    {
        dd( $collaborator);
        $this->names = $collaborator->names;
        $this->last_name = $collaborator->last_name;
        $this->identification = $collaborator->identification;
        $this->payroll_code = $collaborator->payroll_code;
        $this->department_id = $collaborator->department_id;
        $this->regional_id = $collaborator->regional_id;
        $this->occupation_id = $collaborator->occupation_id;
        $this->is_active = $collaborator->is_active;
    }


    public function cancel(){
        $this->is_cancelled = true;
        return redirect()->back();
    }
    public function render()
    {
        $this->is_cancelled = false;
        return view('livewire..superadmin.collaborator.collaborator-edit', [
            'collaborator' => Collaborator::where('identification', $this->identification)->first(),
        ]);
    }
}
