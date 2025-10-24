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
        'excel' => 'required|file|mimes:xlsx,csv|max:5120', // Max size 2MB
    ];

    public function mount()
    {
        $this->errorsImport = collect();
    }


    public function updatedExcel()
    {
        //valida el archivo cunado se selecciona
        $this->validateOnly('excel');

        //limpia errores
        $this->errorsImport = collect();
        $this->preview = [];

        try{
            //genera la vista previa
            $this->preview = SimpleExcelReader::create($this->excel->getRealPath())
            ->useHeaders(['Ciudad', 'Codigo', 'Nombres', 'Apellidos', 'Identificacion', 'Cargo', 'CC'])
            ->getRows()
            ->take(20)
            ->toArray();

        } catch (\Exception $e) {
            // Si el archivo está mal, muestra un error
            $this->addError('excel', 'El archivo no tiene el formato esperado o está dañado. ' . $e->getMessage());
        }
    }

    public function importExcel()
    {
        $this->validate();
        $this->errorsImport = collect();

        if (empty($this->preview)) {
            $this->addError('excel', 'No se puede importar un archivo vacío o con errores.');
            return;
        }

        try {
            // 1. Pre-load data for efficiency
            $departments = \App\Models\Department::all()->keyBy('name');
            $regionals = \App\Models\Regional::all()->keyBy('name');
            $occupations = \App\Models\Occupation::all()->keyBy('name');

            $rows = SimpleExcelReader::create($this->excel->getRealPath())
            ->useHeaders(['Ciudad', 'Codigo', 'Nombres', 'Apellidos', 'Identificacion', 'Cargo', 'CC'])
            ->getRows()
            ->toArray();

            dd($rows);
            foreach ($rows as $rowProperties) {
                // 2. Look up IDs
                $department = $departments->get($rowProperties['CC']);
                $regional = $regionals->get($rowProperties['Ciudad']);
                $occupation = $occupations->get($rowProperties['Cargo']);

                // 3. Validate IDs
                if (!$department) {
                    $this->errorsImport->push(['row' => $rowIndex, 'msg' => "El departamento '{$rowProperties['CC']}' no existe."]);
                    continue; // Skip this row
                }
                if (!$regional) {
                    $this->errorsImport->push(['row' => $rowIndex, 'msg' => "La regional '{$rowProperties['Ciudad']}' no existe."]);
                    continue; // Skip this row
                }
                if (!$occupation) {
                    $this->errorsImport->push(['row' => $rowIndex, 'msg' => "El cargo '{$rowProperties['Cargo']}' no existe."]);
                    continue; // Skip this row
                }

                // 4. Create collaborator if all data is valid
                \App\Models\Collaborator::create([
                    'names' => $rowProperties['Nombres'],
                    'last_names' => $rowProperties['Apellidos'] ?? null,
                    'identification' => $rowProperties['Identificacion'],
                    'payroll_code' => $rowProperties['Codigo'],
                    'department_id' => $department->id,
                    'regional_id' => $regional->id,
                    'occupation_id' => $occupation->id,
                    'is_active' => true,
                ]);
            }

            if ($this->errorsImport->isEmpty()) {
                session()->flash('message', 'Colaboradores importados con éxito.');
                $this->reset('excel', 'preview');
            }

        } catch (\Exception $e) {
            $this->addError('excel', 'Ocurrió un error durante la importación: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.superadmin.collaborator.collaborator-import');
    }
}
