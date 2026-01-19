@props([
    'data' => collect(),
])

<div class="py-12">
    <div class="max-w-8xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
            <div class="bg-gray-900 text-gray-100 p-6 rounded-lg shadow-xl">

                {{-- BARRA DE HERRAMIENTAS (Buscador y Botones) --}}
                @if(isset($toolbar))
                    <div class="flex flex-col gap-y-4 sm:flex-row sm:items-end sm:justify-between mb-4">
                        {{ $toolbar }}
                    </div>
                @endif

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-700">
                        <thead>
                            {{ $headers }}
                        </thead>
                        <tbody class="divide-y divide-gray-700">
                            {{ $dataTBody }}
                        </tbody>
                    </table>

                    {{-- Paginación --}}
                    @if ($data instanceof \Illuminate\Pagination\AbstractPaginator)
                        <div class="mt-4">
                            {{ $data->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
