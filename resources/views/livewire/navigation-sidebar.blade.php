<div class="flex flex-col h-full bg-white dark:bg-gray-800 shadow-lg">
    <!-- Logo -->
    <div class="flex items-center justify-center h-16 px-4 bg-indigo-600 dark:bg-indigo-700">
        <a href="{{ route('dashboard') }}" class="flex items-center">
            <x-application-mark class="block h-8 w-auto text-white" />
            <span class="ml-2 text-xl font-bold text-white">
                {{ config('app.name', 'Laravel') }}
            </span>
        </a>
    </div>

    <!-- Navegación -->
    <nav class="flex-1 px-4 py-4 space-y-2 overflow-y-auto">
        @foreach($menuItems as $item)
            @if($this->hasAccess($item['roles']))
                <div x-data="{ open: {{ request()->routeIs($item['route'] . '*') ? 'true' : 'false' }} }">
                    @if(isset($item['submenu']))
                        <!-- Item con submenú -->
                        <div>
                            <button @click="open = !open"
                                    class="w-full flex items-center justify-between px-3 py-2 text-sm font-medium rounded-lg transition-colors duration-200 {{ request()->routeIs($item['route'] . '*')
                                        ? 'bg-indigo-100 dark:bg-indigo-900 text-indigo-700 dark:text-indigo-200'
                                        : 'text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 hover:text-gray-900 dark:hover:text-white' }}">
                                <div class="flex items-center">
                                    <x-dynamic-component :component="'heroicon-o-' . $item['icon']"
                                                       class="w-5 h-5 mr-3 {{ request()->routeIs($item['route'] . '*')
                                                           ? 'text-indigo-500 dark:text-indigo-300'
                                                           : 'text-gray-400 dark:text-gray-400' }}" />
                                    {{ $item['name'] }}
                                </div>
                                <svg class="w-4 h-4 transition-transform duration-200"
                                     :class="{ 'rotate-180': open }"
                                     fill="none"
                                     viewBox="0 0 24 24"
                                     stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>

                            <!-- Submenú -->
                            <div x-show="open"
                                 x-transition:enter="transition ease-out duration-100"
                                 x-transition:enter-start="transform opacity-0 scale-95"
                                 x-transition:enter-end="transform opacity-100 scale-100"
                                 x-transition:leave="transition ease-in duration-75"
                                 x-transition:leave-start="transform opacity-100 scale-100"
                                 x-transition:leave-end="transform opacity-0 scale-95"
                                 class="mt-2 ml-8 space-y-1">
                                @foreach($item['submenu'] as $subItem)
                                    @if($this->hasAccess($subItem['roles']))
                                        <a href="{{ route($subItem['route']) }}"
                                           class="block px-3 py-2 text-sm rounded-lg transition-colors duration-200 {{ request()->routeIs($subItem['route'])
                                               ? 'bg-indigo-50 dark:bg-indigo-900/50 text-indigo-600 dark:text-indigo-300 border-l-2 border-indigo-500'
                                               : 'text-gray-500 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-700/50 hover:text-gray-700 dark:hover:text-gray-200' }}">
                                            {{ $subItem['name'] }}
                                        </a>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    @else
                        <!-- Item simple -->
                        <a href="{{ route($item['route']) }}"
                           class="flex items-center px-3 py-2 text-sm font-medium rounded-lg transition-colors duration-200 {{ request()->routeIs($item['route'])
                               ? 'bg-indigo-100 dark:bg-indigo-900 text-indigo-700 dark:text-indigo-200'
                               : 'text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 hover:text-gray-900 dark:hover:text-white' }}">
                            <x-dynamic-component :component="'heroicon-o-' . $item['icon']"
                                               class="w-5 h-5 mr-3 {{ request()->routeIs($item['route'])
                                                   ? 'text-indigo-500 dark:text-indigo-300'
                                                   : 'text-gray-400 dark:text-gray-400' }}" />
                            {{ $item['name'] }}
                        </a>
                    @endif
                </div>
            @endif
        @endforeach
    </nav>

    <!-- Información del usuario (parte inferior) -->
    <div class="flex-shrink-0 p-4 border-t border-gray-200 dark:border-gray-700">
        <div class="flex items-center">
            @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                <img class="w-8 h-8 rounded-full object-cover"
                     src="{{ Auth::user()->profile_photo_url }}"
                     alt="{{ Auth::user()->name }}">
            @else
                <div class="w-8 h-8 rounded-full bg-gray-300 dark:bg-gray-600 flex items-center justify-center">
                    <span class="text-xs font-medium text-gray-700 dark:text-gray-200">
                        {{ substr(Auth::user()->name, 0, 1) }}
                    </span>
                </div>
            @endif
            <div class="ml-3 flex-1 min-w-0">
                <p class="text-sm font-medium text-gray-900 dark:text-gray-100 truncate">
                    {{ Auth::user()->name }}
                </p>
                <p class="text-xs text-gray-500 dark:text-gray-400 truncate">
                    @if(Auth::user()->roles->isNotEmpty())
                        {{ Auth::user()->roles->first()->name }}
                    @else
                        Usuario
                    @endif
                </p>
            </div>
        </div>
    </div>
</div>
