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


    public function updateExcel($file)
    {
        //valida el archivo cunado se selecciona
        $this->validateOnly('excel');

        //limpia errores
        $this->errorsImport = collect();
        $this->preview = [];

        try{
            //genera la vista previa
            $this->preview = SimpleExcelReader::create($this->excel->getRealPath())
            ->useHeaders(['Ciudad', 'Codigo', 'Nombres', 'Apellidos','Identificacion', 'Cargo','CC', 'Empresa'])
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

        //se valida la previsualizacion si esta vacio o fallo
        if (empty($this->preview)) {
            $this->addError('excel', 'No se puede importar un archivo vacío o con errores.');
            return;
        }

        try{

            SimpleExcelReader::create($this->excel->getRealPath())
                ->useHeaders(['Ciudad', 'Codigo', 'Nombres', 'Apellidos', 'Identificacion', 'Cargo', 'Jefe', 'CC', 'Empresa'])
                ->getRows()
                ->each(function (array $rowProperties) {
                    \App\Models\Collaborator::create([
                        'names' => $rowProperties['Nombres'],
                        'last_names' => $rowProperties['Apellidos'] ?? null,
                        'identification' => $rowProperties['Identificacion'],
                        'payroll_code' => $rowProperties['Codigo'],
                        'department_id' => $rowProperties['CC'],
                        'regional_id' => $rowProperties['Ciudad'],
                        'occupation_id' => $rowProperties['Cargo'],
                        'is_active' => true,
                    ]);
                });

                session()->flash('message', 'Colaboradores importados con éxito.');
                $this->reset('excel', 'preview', 'errorsImport');

        } catch (\Exception $e) {
            // Si ocurre un error durante la importación, muestra un error
            $this->addError('excel', 'Ocurrió un error durante la importación: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.superadmin.collaborator.collaborator-import');
    }
}
