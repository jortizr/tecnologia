<div>
    <x-app-layout>
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Dashboard') }}
            </h2>
        </x-slot>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                    <form wire:submit.prevent="assignRole">
                        <div>
                            <label for="selectedRole" class="block font-medium text-sm text-gray-700">Role</label>
                            <select wire:model="selectedRole" id="selectedRole" class="form-select mt-1 block w-full">
                                <option value="">Seleccione un rol</option>
                                @foreach($roles as $role)
                                    <option value="{{ $role->id }}">{{ $role->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mt-4">
                            <button type="submit" class="btn btn-primary">
                                Asignar Rol
                            </button>
                        </div>
                    </form>
                    @if (session()->has('message'))
                        <div class="mt-4 text-green-600">
                            {{ session('message') }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </x-app-layout>
</div>
