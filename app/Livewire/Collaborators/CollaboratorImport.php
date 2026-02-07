<?php

namespace App\Livewire\Collaborators;

use App\Models\Department;
use Livewire\Component;
use Spatie\SimpleExcel\SimpleExcelReader;
use Illuminate\Support\Collection;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Spatie\SimpleExcel\SimpleExcelWriter;
use WireUi\Traits\WireUiActions;

class CollaboratorImport extends Component
{
    use WithFileUploads, WireUiActions;
    public $excel;
    public Collection $errorsImport;
    public $preview = [];

    protected $rules = [
        'excel' => 'required|file|mimes:xlsx,csv|max:5120', // Max size 2MB
    ];

    public function mount()
    {
        $this->authorizw('dashboard.collaborators.import');
        $this->errorsImport = collect();
    }


    public function updatedExcel()
    {
        $this->validateOnly('excel');
        $this->errorsImport = collect();
        $this->preview = [];

        try{
            $reader = SimpleExcelReader::create($this->excel->getRealPath());
            // Obtenemos las filas y tomamos 20
            $rows = $reader->getRows()->take(20);

            $this->preview = $rows->map(function($row) {
                // *** CORRECCIÓN CLAVE: Normalizar claves a minúsculas ***
                // Esto convierte 'Nombres', 'NOMBRES', 'nombres' -> 'nombres'
                $row = array_change_key_case($row, CASE_LOWER);

                // Ahora accedemos siempre en minúsculas
                $nombresCompletos = $row['nombres'] ?? '';
                $partes = $this->splitName($nombresCompletos);

                return [
                    'Identificacion' => isset($row['identificacion']) ? trim($row['identificacion']) : '---',
                    'Nombres'        => $partes['names'],
                    'Apellidos'      => $partes['last_name'],
                    'Cargo'          => isset($row['cargo']) ? trim($row['cargo']) : '---',
                    'Ciudad'         => isset($row['ciudad']) ? trim($row['ciudad']) : '---',
                    'Codigo'         => isset($row['codigo']) ? trim($row['codigo']) : '---',
                    // Nota: 'cc' es corto, a veces da problemas si hay espacios, usamos trim
                    'CC'             => isset($row['cc']) ? trim($row['cc']) : '---',
                ];
            })->toArray();

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
            $this->addError('excel', 'No se puede importar un archivo vacío o inválido.');
            return;
        }

        try {
             $this->authorize('create', Department::class);
            $departments = \App\Models\Department::all()->keyBy(fn($item) => strtoupper($item->name));
            $regionals   = \App\Models\Regional::all()->keyBy(fn($item) => strtoupper($item->name));
            $occupations = \App\Models\Occupation::all()->keyBy(fn($item) => strtoupper($item->name));

            $reader = SimpleExcelReader::create($this->excel->getRealPath())    ->getRows();
            $index = 1;

            $reader->each(function(array $row) use ($departments, $regionals, $occupations, &$index){
                $index++;

                $identificacion = trim($row['Identificacion']);
                $nombreCompleto = trim($row['Nombres']);
                $cargoNombre = strtoupper(trim(trim($row['Cargo'])));
                $areaNombre = strtoupper(trim($row['CC']));
                $ciudadNombre = strtoupper(trim($row['Ciudad']));
                $codigoNomina = trim($row['Codigo']);

                if(empty($identificacion)) return;

                if(\App\Models\Collaborator::where('identification', $identificacion)->exists()){
                    // $this->errorsImport->push(['row' => $index, 'msg' => "La ID $identificacion ya existe."]);
                    return;
                }

                $department = $departments->get($areaNombre);
                $regional   = $regionals->get($ciudadNombre);
                $occupation = $occupations->get($cargoNombre);

                if (!$department) {
                    $this->errorsImport->push(['row' => $index, 'msg' => "El área '$areaNombre' no existe en sistema."]);
                    return;
                }
                if (!$regional) {
                    $this->errorsImport->push(['row' => $index, 'msg' => "La regional '$ciudadNombre' no existe."]);
                    return;
                }
                if (!$occupation) {
                    $this->errorsImport->push(['row' => $index, 'msg' => "El cargo '$cargoNombre' no existe."]);
                    return;
                }

                $nameParts = $this->splitName($nombreCompleto);

                \App\Models\Collaborator::create([
                    'names'          => $nameParts['names'],
                    'last_name'      => $nameParts['last_name'],
                    'identification' => $identificacion,
                    'payroll_code'   => $codigoNomina,
                    'department_id'  => $department->id,
                    'regional_id'    => $regional->id,
                    'occupation_id'  => $occupation->id,
                    'is_active'      => true,
                    'created_by'     => Auth::id(),
                ]);
            });

            if($this->errorsImport->isEmpty()){
                $this->notification()->success('Proceso finalizado', 'Carga masiva completada con éxito.');
                $this->reset('excel', 'preview');
                $this->dispatch('import-finished');
            } else {
                $this->notification()->warning('Atención', 'Se importaron algunos registros, pero hubo errores');
            }
        } catch (\Exception $e) {
            $this->addError('excel', 'Ocurrió un error durante la importación: ' . $e->getMessage());
        }
    }

    protected function splitName($fullName){
        $fullName = trim($fullName);
        $parts = explode(' ', $fullName);
        $count = count($parts);

        $names = '';
        $last_name = '';

        if($count === 1){
            $names = $parts[0];//para una palabra
            $last_name = '';
        } elseif($count === 2){//para 1 apellidos y 1 nombre
            $last_name = $parts[0] . ' ' . $parts[1];
            $names = $parts[2];
        } elseif ($count === 3) {//para 2 apellidos y 1 nombre
            $last_name = $parts[0] . ' ' . $parts[1];
            $names = $parts[2];
        }else {//para 2 apellidos y 2 nombres
            $last_name = $parts[0] . ' ' . $parts[1];
            $names = implode(' ', array_slice($parts, 2));
        }

        return [
            'names' => Str::title($names),
            'last_name' => Str::title($last_name),
        ];

    }

    public function downloadTemplate()
    {
        // Definimos el nombre del archivo
        $fileName = 'plantilla-colaboradores.xlsx';

        return response()->streamDownload(function () {
            // Creamos el escritor apuntando a php://output y forzando formato xlsx
            $writer = SimpleExcelWriter::create('php://output', 'xlsx');

            // Agregamos una fila con los encabezados exactos que espera tu importador
            // Basado en tu Excel: Ciudad, Codigo, Nombres, Identificacion, Cargo, CC
            $writer->addRow([
                'Ciudad'         => 'IBAGUE', // Ejemplo
                'Codigo'         => 'L00001',
                'Nombres'        => 'PEREZ LOPEZ JUAN CARLOS', // Formato sugerido
                'Identificacion' => '123456789',
                'Cargo'          => 'AUXILIAR LOGISTICO',
                'CC'             => 'LOGISTICA' // Área/Departamento
            ]);

            // Opcional: Agregar una segunda fila vacía o con instrucciones
            // $writer->addRow(['...', '...', '...', '...', '...', '...']);

            $writer->close(); // Cerramos el stream

        }, $fileName);
    }

    public function render()
    {
        return view('livewire.collaborators.collaborator-import');
    }
}
