@props(['active'])

@php
// Clases para el enlace ACTIVO
$activeClasses = 'bg-gray-900 text-white group flex items-center px-2 py-2 text-sm font-medium rounded-md';
// Clases para el enlace INACTIVO
$inactiveClasses = 'text-gray-300 hover:bg-gray-700 hover:text-white group flex items-center px-2 py-2 text-sm font-medium rounded-md';

$classes = ($active ?? false) ? $activeClasses : $inactiveClasses;
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
