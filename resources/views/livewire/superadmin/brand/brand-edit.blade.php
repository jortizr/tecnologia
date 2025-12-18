<x-form-card>
    <x-form-section submit="update">
        <x-slot name="title">
            Editar Fabricante
        </x-slot>
        <x-slot name="description">
            Actualiza la información del fabricante o marca de los dispositivos.
        </x-slot>
        <x-slot name="form">
            <div class="w-full">
                <x-label for="names" value="Nombre" class="text-center block"/>
                <x-input id="names" type="text" class="mt-1 block w-full text-center" wire:model="name" />
                <x-input-error for="name" class="mt-2 text-center"/>
            </div>
            <div class="w-full flex justify-center mt-6 space-x-4">
                <x-button wire:loading.attr="disabled" wire:click="cancel">
                    Cancelar
                </x-button>
                <x-button wire:click="update" wire:loading.attr="disabled" wire:target="update">
                    <span wire:loading.remove wire:target="update">
                        Actualizar Fabricante
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
