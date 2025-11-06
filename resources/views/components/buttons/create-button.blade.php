@props(['route'])

<a href="{{ $route }}" {{ $attributes->merge([
    'class' => 'inline-flex items-center justify-center cursor-pointer transition-all
                bg-gray-700 text-white px-6 py-2 rounded-lg
                border-indigo-400
                border-b-[4px] hover:brightness-110 hover:-translate-y-[1px] hover:border-b-[6px]
                active:border-b-[2px] active:brightness-90 active:translate-y-[2px]
                hover:shadow-lg hover:shadow-indigo-300 shadow-indigo-300 active:shadow-none'
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
