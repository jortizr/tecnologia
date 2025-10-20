<?php

namespace App\Livewire\Superadmin\Collaborator;

use Livewire\Component;
use Spatie\SimpleExcel\SimpleExcelReader;

class CollaboratorImport extends Component
{
    public $dataExcel;

    public function importExcel()
    {

    }

    public function render()
    {
        return view('livewire.superadmin.collaborator.collaborator-import');
    }
}
