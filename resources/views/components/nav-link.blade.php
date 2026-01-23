@props(['active'])

@php
$baseClasses = 'group flex items-center p-2 text-sm font-medium rounded-lg transition-all duration-200 ease-in-out';

// Estado ACTIVO: Fondo Rojo Corporativo (#b91c1c), Texto Blanco
$activeClasses = 'text-brand-primary text-dark shadow-md dark:bg-custom-dark-700';

// Estado INACTIVO: Texto Gris Oscuro (#374151) / Texto Claro en Dark (#f6f7f9)
$inactiveClasses = 'text-custom-dark-500 dark:text-custom-dark-50 hover:bg-gray-200 dark:hover:bg-gray-700 hover:text-custom-dark-700 dark:hover:text-white';

$classes = ($active ?? false) ? "$baseClasses $activeClasses" : "$baseClasses $inactiveClasses";

// Forzamos que el contenido (icono y texto) sea blanco solo si está activo
$contentClasses = ($active ?? false)
    ? 'text-dark flex items-center w-full'
    : 'flex items-center w-full';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    <div class="{{ $contentClasses }}">
        {{ $slot }}
    </div>
</a>
