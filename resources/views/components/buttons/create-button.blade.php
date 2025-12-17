@props(['route'])

<a href="{{ $route }}" {{ $attributes->merge([
    'class' => 'inline-flex items-center justify-center cursor-pointer transition-all
                bg-gray-700 text-white px-6 rounded-lg
                border-red-700
                border-b-[4px] hover:brightness-110 hover:-translate-y-[1px] hover:border-b-[6px]
                active:border-b-[2px] active:brightness-90 active:translate-y-[2px]
                hover:shadow-lg hover:shadow-red-600 shadow-red-500 active:shadow-none'
    ]) }}>

    @if (isset($icon))
        <span class="inline sm:hidden">
            {{ $icon }}
        </span>

        <span class="hidden sm:inline">
            {{ $slot }}
        </span>
    @else
        {{ $slot }}
    @endif

</a>
