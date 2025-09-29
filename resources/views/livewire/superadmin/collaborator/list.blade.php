        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="bg-gray-900 text-gray-100 p-6 rounded-lg shadow-xl">
                        <div class="overflow-x-auto">
                            <!-- tabla de usuarios -->
                            <table class="min-w-full divide-y divide-gray-700">
                                <thead>
                                    <tr class="bg-gray-800 text-gray-100">
                                        <th class="px-4 py-2 justification-start">ID</th>
                                        <th class="px-4 py-2">Nombres</th>
                                        <th class="px-4 py-2">Apellidos</th>
                                        <th class="px-4 py-2">Identificacion</th>
                                        <th class="px-4 py-2">Codigo de nomina</th>
                                        <th class="px-4 py-2">Area</th>
                                        <th class="px-4 py-2">Cargo</th>
                                        <th class="px-4 py-2">Regional</th>
                                        <th class="px-4 py-2">Estado</th>
                                        <th class="px-4 py-2">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($collaborators as $collaborator)
                                        <tr class="border-b border-gray-700">
                                            <td class="px-4 py-2">{{ $collaborator->id }}</td>
                                            <td class="px-4 py-2">{{ $collaborator->names}}</td>
                                            <td class="px-4 py-2">{{$collaborator->last_name}}</td>
                                            <td class="px-4 py-2">{{ $collaborator->identification }}</td>
                                            <td class="px-4 py-2">{{ $collaborator->payroll_code }}</td>
                                            <td class="px-4 py-2">{{ $collaborator->department?->name ?? 'Sin area' }}</td>
                                            <td class="px-4 py-2">{{ $collaborator->occupation?->name ?? 'Sin cargo' }}</td>
                                            <td class="px-4 py-2">{{ $collaborator->regional?->name ?? 'Sin regional' }}</td>
                                            <td class="px-4 py-2">
                                                <x-buttons.toggle-status toggleId="{{ $collaborator->id }}" :isActive="$collaborator->is_active"/>
                                            </td>
                                            <td class="px-4 py-2">
                                                <x-buttons.actions-button editRoute="{{route('dashboard.collaborators.show', $collaborator)}}"
                                                deleteId="{{$collaborator->id}}"/>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="mt-4">
                                {{ $collaborators->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
