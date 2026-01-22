<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        {{-- ... tu head sigue igual ... --}}
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <wireui:scripts />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @livewireStyles
        <script>
            // Se ejecuta antes de que Alpine cargue para evitar el flash blanco
            if (localStorage.getItem('darkMode') === 'true' ||
                (!('darkMode' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }
        </script>

        <style>
            [x-cloak] { display: none !important; }
        </style>
    </head>
    <body class="font-sans antialiased text-gray-900 dark:text-gray-100">
        <div x-data="{ sidebarOpen: false }" class="min-h-screen bg-gray-100 dark:bg-gray-900">
            <aside class="hidden lg:block bg-white dark:bg-gray-800 text-gray-900 dark:text-white w-64 border-r border-gray-200 dark:border-gray-700 space-y-6 py-7 px-2 fixed inset-y-0 left-0 z-20 transition-colors duration-300">
                <a href="{{ route('dashboard') }}" class="flex items-center space-x-2 px-4 mb-6">
                    <x-application-mark class="block h-9 w-auto" />
                    <span class="text-xl font-bold dark:text-white text-gray-800">Inventario IT</span>
            </a>
                </a>
                @include('components.sidebar-links')
            </aside>
            <aside
                x-show="sidebarOpen"
                @click.away="sidebarOpen = false"
                x-transition:enter="transition ease-in-out duration-300"
                x-transition:enter-start="-translate-x-full"
                x-transition:enter-end="translate-x-0"
                x-transition:leave="transition ease-in-out duration-300"
                x-transition:leave-start="translate-x-0"
                x-transition:leave-end="-translate-x-full"
                class="bg-white dark:bg-gray-800 text-gray-900 dark:text-white w-64 space-y-6 py-7 px-2 fixed inset-y-0 left-0 z-30 lg:hidden border-r border-gray-200 dark:border-gray-700">
                <a href="{{ route('dashboard') }}" class="flex items-center space-x-2 px-4">
                    <x-application-mark class="block h-9 w-auto" />
                    <span class="text-2xl font-extrabold">Inventario</span>
                </a>
                @include('components.sidebar-links')
            </aside>
            <div class="lg:ml-64 min-h-screen flex flex-col">
                <header class="bg-white dark:bg-gray-800 shadow-sm flex items-center justify-between px-4 h-16 sm:px-6 lg:px-8 border-b border-gray-200 dark:border-gray-700">
                    <button @click.stop="sidebarOpen = !sidebarOpen" class="lg:hidden text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200 focus:outline-none">
                        <svg class="size-6" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                        <path d="M4 6h16M4 12h16M4 18h16" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                        </svg>
                    </button>

                    <div class="flex-1 px-4">
                        @if (isset($header))
                            <div class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                                {{ $header }}
                            </div>
                        @endif

                    </div>
                    <div class="flex items-center space-x-4">
                        @livewire('dark-mode-toggle')
                    <div class="dark:text-white">
                        @livewire('navigation-menu')
                    </div>
                </div>
                </header>
                        <main class="p-6">
                            <x-wireui-notifications />
                            <x-wireui-dialog />
                            {{ $slot }}
                        </main>
            </div>

        </div>

        @stack('modals')
        @livewireScripts
    </body>
</html>
