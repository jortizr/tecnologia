@props(['label', 'icon' => null])

<button {{ $attributes->merge([
    'class' => 'inline-flex items-center justify-center cursor-pointer transition-all
                bg-gray-700 text-white px-4 py-2 rounded-lg border-red-700 border-b-[4px]
                hover:brightness-110 hover:-translate-y-[1px] hover:border-b-[4px]
                active:border-b-[2px] active:brightness-90 active:translate-y-[2px]
                hover:shadow-lg hover:shadow-red-600/50 shadow-md active:shadow-none'
]) }}>
    @if($icon)
        <div class="mr-1">
            {{ $icon }}
        </div>
    @endif
    <span class="font-bold">{{ $label ?? $slot }}</span>
</button>
