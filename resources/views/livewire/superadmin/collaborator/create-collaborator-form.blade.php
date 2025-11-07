<div>
    @hasrole(['Superadmin', 'Manager'])
    <x-forms.create-form>
        <x-slot name="title">Formulario colaborador</x-slot>
        <x-slot name="buttonCreate">
            <!-- aqui el boton de crear --->
            Crear Colaborador
            <x-slot name="icon">
                <svg id="add-user-5" data-name="Line Color" xmlns="http://www.w3.org/2000/svg" class="icon line-color w-6 h-6"><g id="SVGRepo_iconCarrier"><path id="secondary" d="M17,17h4m-2-2v4" style="fill: none; stroke: #2ca9bc; stroke-linecap: round; stroke-linejoin: round; stroke-width: 2;"></path><path id="primary" d="M15,13.1a4.71,4.71,0,0,0-1-.1H8a5,5,0,0,0-5,5v1s2,2,8,2a22,22,0,0,0,3-.19c.35,0,.69-.1,1-.17" style="fill: none; stroke: #ffff; stroke-linecap: round; stroke-linejoin: round; stroke-width: 2;"></path><circle id="primary-2" data-name="primary" cx="11" cy="8" r="5" style="fill: none; stroke: #ffff; stroke-linecap: round; stroke-linejoin: round; stroke-width: 2;"></circle></g></svg>
            </x-slot>
        </x-slot>
        <x-slot name="contentForm">
            <x-input placeholder="Nombres" type="text" wire:model="names" class="mb-1"/>
            <x-input placeholder="Apellidos" type="text" wire:model="last_name" class="mb-1"/>
            <x-input placeholder="Identificacion" type="number" wire:model="identification" class="mb-1"/>
            <x-input placeholder="Codigo de nomina" type="text" wire:model="payroll_code" class="mb-1"/>
            <x-forms.searchable-select
                placeholder="Buscar area..."
                wire:model.live.debounce.200ms="searchDepartment"
                wire:select="selectDepartment"
                :items="$departments"
                :selectedName="$selectedDepartmentName"
                noResultsMessage="la area no existe"
                class="mb-1 text-white"
            />
            @error('department_id')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            <x-forms.searchable-select
                placeholder="Buscar cargo..."
                wire:model.live.debounce.200ms="searchOccupation"
                wire:select="selectOccupation"
                :items="$occupations"
                :selectedName="$selectedOccupationName"
                noResultsMessage="No existe el cargo"
                class="mb-1 text-white"
            />
            @error('occupation_id')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
             <x-forms.searchable-select
                placeholder="Buscar regional..."
                wire:model.live.debounce.200ms="searchRegional"
                wire:select="selectRegional"
                :items="$regionals"
                :selectedName="$selectedRegionalName"
                noResultsMessage="No existe la regional"
                class="mb-1 text-white"
            />
            @error('regional_id')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror

             <label class="text-sm mb-2 text-gray-200 cursor-pointer">
                                Estado usuario
                            <input type="checkbox" class="sr-only peer" value="true" wire:model="is_active" />
                                <div
                                    class="group peer bg-gray-700 rounded-full duration-300 w-8 h-4 ring-1 ring-red-500 after:duration-300 after:bg-red-500 peer-checked:after:bg-green-500 peer-checked:ring-green-500 after:rounded-full after:absolute after:h-4 after:w-4 after:left-0.1 after:flex after:justify-center after:items-center peer-checked:after:translate-x-4 peer-hover:after:scale-95"
                                ></div>
                            </label>

        </x-slot>
        <x-slot name="buttonText">Crear</x-slot>
    </x-forms.create-form>
    @endhasrole
</div>
