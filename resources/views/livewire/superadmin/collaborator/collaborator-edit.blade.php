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
                <x-label for="identification" value="Identificacion" class="text-center block"/>
                <x-input id="identification" type="number" class="mt-1 block w-full text-center" wire:model="identification"/>
                <x-input-error for="identification" class="mt-2 text-center"/>
            </div>

            <div class="w-full">
                <x-label for="department_id" value="Area" class="text-center block"/>
                <x-wireui-select
                placeholder="Selecciona una area"
                wire:model.defer="department_id"
                :options="$departmentOptions"
                option-label="name"
                option-value="id"/>
                <x-input-error for="department_id" class="mt-2 text-center"/>
            </div>

            <div class="w-full">
                <x-label for="occupation_id" value="Cargo" class="text-center block"/>
                <x-wireui-select
                    placeholder="Selecciona un cargo"
                    wire:models.defer="occupation_id"
                    :options="$occupationOptions"
                    option-label="name"
                    option-value="id"
                />
                <x-input-error for="occupation_id" class="mt-2 text-center"/>
            </div>

            <div class="w-full">
                <x-label for="regional_id" value="Regional" class="text-center block"/>
                <x-wireui-select
                    placeholder="Selecciona una regional"
                    wire:models.defer="regional_id"
                    :options="$regionalOptions"
                    option-label="name"
                    option-value="id"
                />
                <x-input-error for="regional_id" class="mt-2 text-center"/>
            </div>

            <div class="w-full flex justify-center mt-6 space-x-4">
                <x-button wire:loading.attr="disabled" wire:click="cancel">
                    Cancelar
                </x-button>
                <x-button wire:click="update" wire:loading.attr="disabled" wire:target="update">
                    <span wire:loading.remove wire:target="update">
                        Actualizar
                    </span>
                    <div wire:loading wire:target="update" class="flex items-center">
                        <x-loading-spinner size="w-5 h-5" fill="fill-white" class="mr-2" />
                        <span>Procesando...</span>
                    </div>
                </x-button>
            </div>
        </x-slot>
    </x-form-section>
</x-form-card>
