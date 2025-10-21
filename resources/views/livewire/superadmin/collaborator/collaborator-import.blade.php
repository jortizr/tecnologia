<div>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2
                class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight"
            >
                {{ __("Importacion de colaboradores") }}
            </h2>
        </div>
    </x-slot>
    <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="bg-gray-800 text-gray-100 p-6 rounded-lg shadow-xl mt-4 mb-4">
                        <h2 class="text-center mb-3">Importacion de colaboradores desde Excel</h2>

                        <x-form-section wire:submit.prevent="importExcel" enctype="multipart/form-data">
                            <x-slot name="title">Importacion de datos</x-slot>
                            <x-slot name="description">
                                    Seleccione el archivo Excel (.xlsx) que contiene los datos de los colaboradores a importar. Asegúrese de que el formato del archivo sea correcto.
                            </x-slot>
                            <div class="mb-4">
                                <x-label for="excel" value="Archivo Excel.xlxs"/>
                                <x-input id="excel" type="file" wire:model="excel" class="mt-1 w-full"/>
                                <x-input-error for="excel" class="mt-2"/>
                            </div>
                            <x-slot name="buttonText">Importar</x-slot>
                        </x-form-section>
                        @if($errorsImport->isNotEmpty())
                            <div class="mt-4 text-red-600 text-sm">
                                <p>Algunas filas no se pudieron importar:</p>
                                <ul class="list-disc ml-6">
                                    @foreach($errorsImport as $e)
                                        <li>Fila {{ $e['row'] }}: {{ $e['msg']}}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                    </div>
                </div>
            </div>
            @if($preview)
            <section>
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-6">
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                        <div class="bg-gray-900 text-gray-100 p-6 rounded-lg shadow-xl">
                            <div class="overflow-x-auto">
                                <!-- tabla de colaboradores -->
                                <x-data-table :data="$preview" class="mt-4">
                                    <x-slot name="headers">
                                        <tr class="bg-gray-800 text-gray-100">
                                            <th class="px-4 py-2">Nombres</th>
                                            <th class="px-4 py-2">Apellidos</th>
                                            <th class="px-4 py-2">Identificacion</th>
                                            <th class="px-4 py-2">Codigo de nomina</th>
                                            <th class="px-4 py-2">Area</th>
                                            <th class="px-4 py-2">Cargo</th>
                                            <th class="px-4 py-2">Regional</th>
                                        </tr>
                                    </x-slot>
                                    <x-slot name="dataTBody">
                                        @foreach($row as $v)
                                            <tr class="border-b border-gray-700">
                                                <td class="px-4 py-2">{{ $v }}</td>
                                            </tr>
                                        @endforeach
                                    </x-slot>
                                </x-data-table>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            @endif
    </div>
</div>
