<div  class="py-6">
    <div class="flex justify-center items-center">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Gestion de Estados Operacionales') }}
        </h2>
        <x-badge-title :count="$this->operationalStates->total()" />
    </div>
</div>
