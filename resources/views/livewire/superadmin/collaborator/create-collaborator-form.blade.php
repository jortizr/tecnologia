<div>
    @hasrole('Superadmin')
    <x-forms.create-form>
        <x-slot name="title">Formulario colaborador</x-slot>
        <x-slot name="buttonCreate">Crear Colaborador</x-slot>
        <x-slot name="contentForm">
            <x-input placeholder="Nombres" type="text" wire:model="names" class="mb-1"/>
            <x-input placeholder="Apellidos" type="text" wire:model="last_name" class="mb-1"/>
            <x-input placeholder="Identificacion" type="number" wire:model="identification" class="mb-1"/>
            <x-input placeholder="Codigo de nomina" type="text" wire:model="payroll_code" class="mb-1"/>
            <x-input placeholder="Area" type="text" wire:model="department_id" class="mb-1"/>
            <x-input id="searchOccupation" placeholder="Buscar cargo..." type="text" wire:model.live.debounce.300ms="searchOccupation" autocomplete="off" class="mb-1"
            value="{{$selectedOccupationName ?: $searchOccupation}}"
            />
            <x-input type="hidden" wire:model="occupation_id" />
            @error('occupation_id')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
                @if (!empty($occupations) && strlen($searchOccupation) > 2)
            <ul class="absolute z-50 w-full bg-white border border-gray-300 rounded-b-md shadow-lg max-h-60 overflow-y-auto">
            @foreach ($occupations as $occupation)
                <li
                    wire:click="selectOccupation({{ $occupation['id'] }}, '{{ $occupation['name'] }}')"
                    class="p-2 cursor-pointer hover:bg-gray-100"
                >
                    {{ $occupation['name'] }}
                </li>
            @endforeach
            </ul>
            @endif
            @if ($occupation_id && empty($searchOccupation))
                <p class="mt-2 text-sm text-gray-500">Seleccionado: **{{ $selectedOccupationName }}**</p>
            @endif

        </x-slot>
        <x-slot name="buttonText">Crear</x-slot>
    </x-forms.create-form>
    @endhasrole
</div>
