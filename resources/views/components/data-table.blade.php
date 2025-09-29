@props([
    'headers' => [],
    'data' => collect(),
    'class' => '',
])

<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div
            class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
            <div class="bg-gray-900 text-gray-100 p-6 rounded-lg shadow-xl">
                <div class="overflow-x-auto">
                    <!-- tabla de usuarios -->
                    <table class="min-w-full divide-y divide-gray-700">
                        <thead>
                            {{$headers}}
                        </thead>
                        <tbody>
                            {{$dataTBody}}
                        </tbody>
                    </table>
                    <div class="mt-4">
                        {{ $data->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
