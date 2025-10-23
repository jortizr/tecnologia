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
                        @if (session()->has('message'))
                        <div class="mb-4 p-4 text-sm text-green-700 bg-green-100 rounded-lg dark:bg-green-200 dark:text-green-800">
                            {{ session('message') }}
                        </div>
                        @endif

                        <x-form-section submit="importExcel">
                            <x-slot name="title">Importacion de colaboradores</x-slot>
                            <x-slot name="description">Seleccione un archivo Excel con la estructura correcta para importar los colaboradores.</x-slot>
                            <x-slot name="form">
                                <div class="col-span-6 sm:col-span-4">
                                    <x-label for="excel" value="Archivo Excel.xlxs"/>
                                    <x-input id="excel" type="file" wire:model="excel" class="mt-1 w-full"/>
                                    <div wire:loading wire:target="excel" class="mt-2 text-sm text-yellow-400">
                                        Cargando previsualizacion...
                                    </div>
                                    <x-input-error for="excel" class="mt-2"/>
                                </div>
                            </x-slot>
                            <x-slot name="actions">
                                {{-- Aquí aplicamos el paso 2 --}}
                                <x-button wire:loading.attr="disabled" wire:target="importExcel"
                                @disabled(empty($preview))
                                >
                                <span wire:loading wire:target="importExcel">
                                            Importando...
                                </span>
                                <span wire:loading.remove wire:target="importExcel">
                                        Importar
                                </span>
                                </x-button>
                            </x-slot>
                        </x-form-section>
                        {{--lista de errores --}}
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
            @if(!empty($preview))
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
                                        {{-- Iteramos sobre la variable $preview que SÍ existe --}}
                                        @foreach($preview as $row)
                                            <tr class="border-b border-gray-700">
                                                <td class="px-4 py-2">{{ $row['Nombres'] }}</td>
                                                <td class="px-4 py-2">{{ $row['Apellidos'] ?? 'N/A' }}</td>
                                                <td class="px-4 py-2">{{ $row['Identificacion'] }}</td>
                                                <td class="px-4 py-2">{{ $row['Codigo'] }}</td>
                                                <td class="px-4 py-2">{{ $row['CC'] ?? 'N/A' }}</td>
                                                <td class="px-4 py-2">{{ $row['Cargo'] }}</td>
                                                <td class="px-4 py-2">{{ $row['Ciudad'] ?? 'N/A' }}</td>
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
