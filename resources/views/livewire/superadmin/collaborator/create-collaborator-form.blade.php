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
            <x-forms.searchable-select
                placeholder="Buscar area..."
                wire:model.live.debounce.300ms="searchDepartment"
                wire:select="selectDepartment"
                :items="$departments"
                
                noResultsMessage="la area no existe"
                class="mb-1 text-white"
            />
            @error('department_id')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            <x-forms.searchable-select
                placeholder="Buscar cargo..."
                wire:model.live.debounce.300ms="searchOccupation"
                wire:select="selectOccupation"
                :items="$occupations"
                :selectedName="$selectedOccupationName"
                noResultsMessage="No se encontraron resultados"
                class="mb-1 text-white"

            />
            @error('occupation_id')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror

        </x-slot>
        <x-slot name="buttonText">Crear</x-slot>
    </x-forms.create-form>
    @endhasrole
</div>
