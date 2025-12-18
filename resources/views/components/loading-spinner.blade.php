@props(['size' => 'h-5 w-5', 'target' => ''])

<div {{ $attributes->merge(['class' => 'inline-block']) }}
     wire:loading
     @if($target) wire:target="{{ $target }}" @endif>
    <div class="{{ $size }} animate-spin">
        <svg class="w-full h-full" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <defs>
                <linearGradient id="spinner-gradient" x1="0%" y1="0%" x2="100%" y2="100%">
                    <stop offset="0%" stop-color="currentColor" />
                    <stop offset="100%" stop-color="bg-red-600" stop-opacity="0" />
                </linearGradient>
            </defs>
            <path
                d="M12 2C6.47715 2 2 6.47715 2 12C2 17.5228 6.47715 22 12 22C17.5228 22 22 17.5228 22 12"
                stroke="url(#spinner-gradient)"
                stroke-width="3"
                stroke-linecap="round"
            />
        </svg>
    </div>


</div>
