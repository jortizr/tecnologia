@props([
    'toggleId' => null,
    'isActive' => false,
    'size' => 'sm', // sm, md, lg
    'disabled' => false,
])

@php
    $sizes = [
        'sm' => 'w-12 h-6 after:h-4 after:w-4 peer-checked:after:translate-x-6',
        'md' => 'w-16 h-8 after:h-6 after:w-6 peer-checked:after:translate-x-8',
        'lg' => 'w-20 h-10 after:h-8 after:w-8 peer-checked:after:translate-x-10',
    ];
    $sizeClasses = $sizes[$size] ?? $sizes['md'];
@endphp

@if($toggleId)
<div class="flex items-center space-x-2" title="Activar/Desactivar este registro">
    <span class="text-sm text-gray-600 dark:text-gray-400 min-w-20 text-center">
        {{ $isActive ? 'Activo' : 'Inactivo' }}
    </span>

    <label class="relative inline-flex items-center cursor-pointer {{ $disabled ? 'cursor-not-allowed opacity-50' : '' }}">
        <input
            type="checkbox"
            class="sr-only peer"
            wire:change="$dispatch('toggleStatus', { userId: {{ $toggleId }} })"
            {{ $isActive ? 'checked' : '' }}
            {{ $disabled ? 'disabled' : '' }}
        />
        <div class="group peer bg-white rounded-full duration-300 {{ $sizeClasses }} ring-2 ring-red-500 after:duration-300 after:bg-red-500 peer-checked:after:bg-green-500 peer-checked:ring-green-500 after:rounded-full after:absolute after:top-1 after:left-1 after:flex after:justify-center after:items-center peer-hover:after:scale-95 {{ $disabled ? 'pointer-events-none' : '' }}"></div>
    </label>
</div>
@endif
