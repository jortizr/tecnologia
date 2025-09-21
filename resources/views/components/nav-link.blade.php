@props(['active'])

@php
// Clases para el enlace ACTIVO
$activeClasses = 'bg-gray-900 text-white group flex items-center p-2 text-sm font-medium rounded-lg hover:bg-gray-700';
// Clases para el enlace INACTIVO
$inactiveClasses = 'flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group';




$classes = ($active ?? false) ? $activeClasses : $inactiveClasses;
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
