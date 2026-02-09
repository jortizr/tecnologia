<?php

namespace App\Livewire\Collaborators;

use App\Models\Collaborator;
use App\Models\Department;
use App\Models\Regional;
use App\Models\Occupation;
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
        $this->authorize('dashboard.collaborators.import');
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
        $this->authorize('dashboard.collaborators.import');
        $this->validate();
        $this->errorsImport = collect();

        if (empty($this->preview)) {
            $this->addError('excel', 'No se puede importar un archivo vacío o inválido.');
            return;
        }

        try {
            $departments = Department::all()->keyBy(fn($item) => strtoupper($item->name));
            $regionals   = Regional::all()->keyBy(fn($item) => strtoupper($item->name));
            $occupations = Occupation::all()->keyBy(fn($item) => strtoupper($item->name));

            $reader = SimpleExcelReader::create($this->excel->getRealPath())->getRows();
            $index = 1;

            $reader->each(function(array $row) use ($departments, $regionals, $occupations, &$index){
                $index++;

                $row = array_change_key_case($row, CASE_LOWER);
                $identificacion = trim($row['identificacion']);
                $nombreCompleto = trim($row['nombres']);
                $cargoNombre = strtoupper(trim(trim($row['cargo'])));
                $areaNombre = strtoupper(trim($row['cc']));
                $ciudadNombre = strtoupper(trim($row['ciudad']));
                $codigoNomina = trim($row['codigo']);

                if(empty($identificacion)) return;

                if(Collaborator::where('identification', $identificacion)->exists()){
                    $this->errorsImport->push(['row' => $index, 'msg' => "La ID $identificacion ya existe."]);
                    return;
                }

                $department = $departments->get($areaNombre);
                $regional   = $regionals->get($ciudadNombre);
                $occupation = $occupations->get($cargoNombre);

                if (!$department) {
                    $this->errorsImport->push([
                        'row' => $index,
                        'msg' => "El Área (CC) '{$areaNombre}' no está registrada en el sistema."
                    ]);
                    return;
                }

                if (!$regional) {
                    $this->errorsImport->push([
                        'row' => $index,
                        'msg' => "La Ciudad/Regional '{$ciudadNombre}' no existe en el catálogo."
                    ]);
                    return;
                }

                if (!$occupation) {
                    $this->errorsImport->push([
                        'row' => $index,
                        'msg' => "El Cargo '{$cargoNombre}' no existe. Debes crearlo primero."
                    ]);
                    return;
                }

                $nameParts = $this->splitName($nombreCompleto);

                Collaborator::create([
                    'names'          => $nameParts['names'],
                    'last_name'      => $nameParts['last_name'],
                    'identification' => $identificacion,
                    'payroll_code'   => $codigoNomina,
                    'department_id'  => $department->id,
                    'regional_id'    => $regional->id,
                    'occupation_id'  => $occupation->id,
                    'is_active'      => true,
                ]);
            });

            if($this->errorsImport->isEmpty()){
                $this->notification()->success('Exito', 'Importacion completada.');
                $this->reset('excel', 'preview');
                $this->dispatch('import-finished');
            } else {
                $this->notification()->warning('Completa con errores', 'Algunos registros fallaron.');
            }
        } catch (\Exception $e) {
            $this->addError('excel', 'Error crítico: ' . $e->getMessage());
        }
    }

    protected function splitName($fullName){
        $parts = explode(' ', trim($fullName));
        $count = count($parts);

        if($count === 1) return ['names' => Str::title($parts[0]), 'last_name' => ''];

        // Caso común: 2 nombres y 2 apellidos (o similar)
        // Intentamos separar los últimos dos como apellidos
        if($count >= 4) {
            $last_names = $parts[0] . ' ' . $parts[1];
            $names = implode(' ', array_slice($parts, 2));
        } else {
            // Caso de 2 o 3 palabras: el primero es nombre, el resto apellidos
            $names = $parts[0];
            $last_names = implode(' ', array_slice($parts, 1));
        }

        return [
            'names' => Str::title($names),
            'last_name' => Str::title($last_names),
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
