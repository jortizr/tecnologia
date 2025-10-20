<div>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2
                class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight"
            >
                {{ __("Importacion de colaboradores") }}
            </h2>
        </div>
    </x-slot>
    <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="bg-gray-800 text-gray-100 p-6 rounded-lg shadow-xl mt-4 mb-4">
                        <h2 class="text-center mb-3">Importacion de colaboradores desde Excel</h2>
                        <x-input type="file" />
                        <x-button>Cargar archivo</x-button>
                        <x-button >Guardar Importacion</x-button>
                    </div>
                </div>
            </div>

            <section>
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-6">
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                        <div class="bg-gray-900 text-gray-100 p-6 rounded-lg shadow-xl">
                            <div class="overflow-x-auto">
                                <!-- tabla de colaboradores -->

                            </div>
                        </div>
                    </div>
                </div>
            </section>
    </div>
</div>
