<div>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    {{ __('Lista de Usuarios') }}
            </h2>
            <div class="">
                <div class="flex justify-end mb-4">
                    @livewire('superadmin.user.create-user-form')
                </div>
                    @if (session()->has('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mt-4" role="alert">
                        <span class="block sm:inline">{{ session('success') }}</span>
                        </div>
                    @endif
                </div>
            </div>
    </x-slot>

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
                                        <th class="px-4 py-2">Email</th>
                                        <th class="px-4 py-2">Roles</th>
                                        <th class="px-4 py-2">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($users as $user)
                                        <tr class="border-b border-gray-700">
                                            <td class="px-4 py-2">{{ $user->id }}</td>
                                            <td class="px-4 py-2">{{ $user->name}}</td>
                                            <td class="px-4 py-2">{{$user->last_name}}</td>
                                            <td class="px-4 py-2">{{ $user->email }}</td>
                                            <td class="px-4 py-2">
                                                @foreach($user->roles as $role)
                                                    {{ $role->name }}{{ !$loop->last ? ', ' : '' }}
                                                @endforeach
                                            </td>
                                            <td class="px-4 py-2">
                                                <x-buttons.actions-button :editRoute="route('dashboard.users.edit', $user)"
                                                :deleteId="$user->id"
                                                />
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</div>
