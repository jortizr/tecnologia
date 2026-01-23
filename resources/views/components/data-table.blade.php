@props(['data' => collect()])

<div class="py-4"> <div class="max-w-8xl mx-auto">
        <div class="bg-white dark:bg-custom-dark-bg overflow-hidden shadow-xl sm:rounded-lg border-t-4 border-brand-primary">
            <div class="p-6">
                @if(isset($toolbar))
                    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between mb-6">
                        {{ $toolbar }}
                    </div>
                @endif

                <div class="overflow-x-auto rounded-lg border border-gray-200 dark:border-gray-700">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-200 dark:bg-custom-dark-header">
                            {{ $headers }}
                        </thead>
                        <tbody class="bg-white dark:bg-custom-dark-bg divide-y divide-gray-200 dark:divide-gray-700">
                            {{ $dataTBody }}
                        </tbody>
                    </table>
                </div>

                @if ($data instanceof \Illuminate\Pagination\AbstractPaginator)
                    <div class="mt-4">
                        {{ $data->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
