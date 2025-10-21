<?php

namespace App\Livewire\Superadmin\Collaborator;

use Livewire\Component;
use Spatie\SimpleExcel\SimpleExcelReader;
use Illuminate\Support\Collection;
use Livewire\WithFileUploads;

class CollaboratorImport extends Component
{
    use WithFileUploads;
    public $excel;
    public Collection $errorsImport;
    public $preview = [];

    protected $rules = [
        'excel' => 'required|file|mimes:xlsx,xls,csv|max:5120', // Max size 2MB
    ];

    public function mount()
    {
        $this->errorsImport = collect();
    }

    public function importExcel()
    {
        $this->validate();

        $path = $this->excel->getRealPath();

        $this->preview = SimpleExcelReader::create($this->excel->getRealPath())
            ->useHeaders(['Ciudad', 'Codigo', 'Nombres', 'Identificacion', 'Cargo', 'Jefe', 'CC', 'Empresa'])
            ->getRows()
            ->take(20)
            ->toArray();

//         SimpleExcelReader::create($this->file)
//             ->useHeaders(['Ciudad', 'Codigo', 'Nombres', 'Identificacion
// ', 'Cargo', 'Jefe', 'CC', 'Empresa'])
//             ->getRows()
//             ->each(function (array $rowProperties) {
//                 // Process each row as needed
//                 dump($rowProperties);
//             });

    }

    public function render()
    {
        return view('livewire.superadmin.collaborator.collaborator-import');
    }
}
