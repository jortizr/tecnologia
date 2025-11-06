<div>
    <button wire:click="openModal"
        class="cursor-pointer transition-all
    bg-gray-700 text-white px-6 py-2 rounded-lg
    border-indigo-400
    border-b-[4px] hover:brightness-110 hover:-translate-y-[1px]
    active:border-b-[2px] active:brightness-90 active:translate-y-[1px] hover:shadow-lg hover:shadow-indigo-300 shadow-indigo-300 active:shadow-none">
        @if (isset($icon))
        <span class="inline sm:hidden">
            {{ $icon }}
        </span>

        <span class="hidden sm:inline">
            {{ $buttonCreate }}
        </span>
        @else
            {{ $buttonCreate }}
        @endif
    </button>
    <div x-data="{ showModal: @entangle('isOpen') }" x-show="showModal"
        x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-90"
        x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-300"
        x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-90"
        class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true"
        style="display: none;">
        <div x-show="showModal" class="fixed inset-0 bg-gray-900 bg-opacity-75 transition-opacity"
            x-on:click="showModal = false"></div>

        <div class="fixed inset-0 flex items-center justify-center p-4">
            <div x-show="showModal" x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">

                <div class="flex flex-col items-center justify-center h-screen dark">
                    <div class="w-full max-w-md bg-gray-800 rounded-lg shadow-md p-6">
                        <div class="flex justify-between items-center pb-3">
                            <h2 class="text-2xl font-bold text-gray-200 mb-2" id="modal-title">{{ $title}}</h2>
                            <button type="button" class="text-gray-400 hover:text-gray-500" x-on:click="showModal = false">
                                <span class="sr-only">Cerrar</span>
                                <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>

                        <form wire:submit="store" class="flex flex-col">
                            {{ $contentForm }}
                            <button
                                class="bg-gradient-to-r from-indigo-500 to-blue-500 text-white font-bold py-2 px-4 rounded-md mt-4 hover:bg-indigo-600 hover:to-blue-600 transition ease-in-out duration-150"
                                type="submit">
                                {{ $buttonText }}
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


