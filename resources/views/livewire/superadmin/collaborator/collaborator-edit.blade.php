<x-form-card>

    <x-form-section submit="update">
        <x-slot name="title">
            Editar Colaborador
        </x-slot>
        <x-slot name="description">
            Actualiza la información del colaborador.
        </x-slot>
        <x-slot name="form">

            <div class="w-full">
                <x-label for="names" value="Nombres" class="text-center block"/>
                <x-input id="names" type="text" class="mt-1 block w-full text-center" wire:model="names" />
                <x-input-error for="names" class="mt-2 text-center"/>
            </div>

            <div class="w-full">
                <x-label for="last_name" value="Apellidos" class="text-center block"/>
                <x-input id="last_name" type="text" class="mt-1 block w-full text-center" wire:model="last_name"/>
                <x-input-error for="last_name" class="mt-2 text-center"/>
            </div>

            <div class="w-full">
                <x-label for="identification" value="identification" class="text-center block"/>
                <x-input id="identification" type="number" class="mt-1 block w-full text-center" wire:model="identification"/>
                <x-input-error for="identification" class="mt-2 text-center"/>
            </div>

            <div class="w-full">
                <x-label for="department_id" value="Area" class="text-center block"/>
                <div
                    wire:ignore
                    x-data="{
                        selectedId: @entangle('department_id'),
                        init() {
                            let select = new TomSelect(this.$refs.select, {
                                // Opciones de Tom Select
                                sortField: {
                                    field: 'text',
                                    direction: 'asc'
                                }
                            });

                            // Asegura que Livewire se actualice cuando Tom Select cambie el valor
                            select.on('change', (value) => {
                                this.selectedId = value;
                            });
                        }
                    }"
                >
                    <select
                        id="department_id"
                        x-ref="select"
                        class="mt-1 block w-full"
                        placeholder="Seleccionar un Departamento..."
                    >
                        <option value="">Seleccione un Departamento...</option>
                        {{-- 🟢 Iteramos sobre los datos cargados desde Livewire --}}
                        @foreach($allDepartments as $department)
                            <option
                                value="{{ $department->id }}"
                                @if($department->id == $department_id) selected @endif
                            >
                                {{ $department->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <x-input-error for="department_id" class="mt-2 text-center"/>
            </div>

            <div class="w-full">
                <x-forms.searchable-select
                    placeholder="Buscar cargo..."
                    wire:model.live.debounce.200ms="searchOccupation"
                    wire:select="selectOccupation"
                    :items="$occupations"
                    :selectedName="$selectedOccupationName"
                    noResultsMessage="No existe el cargo"
                    class="mb-1 text-white"
                />
                <x-input-error for="occupation_id" class="mt-2 text-center"/>
            </div>

            <div class="w-full">
                <x-forms.searchable-select
                placeholder="Buscar regional..."
                wire:model.live.debounce.200ms="searchRegional"
                wire:select="selectRegional"
                :items="$regionals"
                :selectedName="$selectedRegionalName"
                noResultsMessage="No existe la regional"
                class="mb-1 text-white"
            />
            </div>

            <div class="w-full flex justify-center mt-6 space-x-4">
                <x-button wire:loading.attr="disabled" wire:click="cancel">
                    Cancelar
                </x-button>
                <x-button wire:loading.attr="disabled" wire:target="update">
                    Actualizar Usuario
                </x-button>
            </div>
        </x-slot>
    </x-form-section>



</x-form-card>
