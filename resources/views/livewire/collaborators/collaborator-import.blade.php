<div>
    <div class="space-y-4">
        <div class="mb-4 flex justify-end">
            <x-wireui-button
                sm
                flat
                primary
                label="Descargar plantilla .xlsx"
                icon="arrow-down-circle"
                wire:click="downloadTemplate"
            />
        </div>
        <x-wireui-input label="Archivo Excel (.xlsx, .csv)" type="file" wire:model="excel" />

        <div class="flex justify-end mt-4">
            <x-wireui-button primary label="Importar" wire:click="importExcel" wire:loading.attr="disabled" :disabled="empty($preview)"/>
        </div>

        @if($errorsImport->isNotEmpty())
            <div class="bg-red-50 border-l-4 border-red-400 p-4 mt-4">
                <div class="flex">
                    <div class="ml-3">
                        <p class="text-sm text-red-700">
                            Errores encontrados (Filas no importadas)
                        </p>
                        <ul class="list-disc ml-5 space-y-1 mt-2 text-xs text-red-600 max-h-32 overflow-y-auto">
                            @foreach($errorsImport as $e)
                                <li>Fila {{ $e['row'] }}: {{ $e['msg'] }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif
    </div>

    @if(!empty($preview))
        <div class="mt-6 border-t pt-4">
            <h3 class="text-sm font-medium text-gray-700 mb-2">Previsuakización (Primeros 20)</h3>
            <div class="overflow-x-auto border rounded-lg">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-3 py-2 text-xs font-medium text-gray-500 uppercase">Identificación</th>
                            <th class="px-3 py-2 text-xs font-medium text-gray-500 uppercase">Nombre</th>
                            <th class="px-3 py-2 text-xs font-medium text-gray-500 uppercase">Cargo</th>
                            <th class="px-3 py-2 text-xs font-medium text-gray-500 uppercase">Ciudad</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($preview as $row)
                            <tr>
                                <td class="px-3 py-2 text-xs text-gray-900">{{ $row['Identificacion'] }}</td>
                                <td class="px-3 py-2 text-xs text-gray-900">{{ $row['Nombres'] }} {{ $row['Apellidos'] ?? '' }}</td>
                                <td class="px-3 py-2 text-xs text-gray-900">{{ $row['Cargo'] }}</td>
                                <td class="px-3 py-2 text-xs text-gray-900">{{ $row['Ciudad'] ?? '' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif
</div>
