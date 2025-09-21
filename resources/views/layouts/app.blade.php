<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        {{-- ... tu head sigue igual ... --}}
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])

        @livewireStyles
    </head>
    <body class="font-sans antialiased">
        <x-banner />

        <div x-data="{ sidebarOpen: false }" class="min-h-screen bg-gray-100 dark:bg-gray-900 mx-50">

            <aside class="hidden lg:block bg-gray-800 text-white w-64 space-y-6 py-7 px-2 fixed inset-y-0 left-0 z-20">
                <a href="{{ route('dashboard') }}" class="text-white flex items-center space-x-2 px-4">
                    <x-application-mark class="block h-9 w-auto" />
                    <span class="text-2xl font-extrabold">Tu App</span>
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
                class="bg-gray-800 text-white w-64 space-y-6 py-7 px-2 fixed inset-y-0 left-0 z-30 lg:hidden">
                <a href="{{ route('dashboard') }}" class="text-white flex items-center space-x-2 px-4">
                    <x-application-mark class="block h-9 w-auto" />
                    <span class="text-2xl font-extrabold">Tu App</span>
                </a>
                @include('components.sidebar-links')
            </aside>
            <div class="lg:ml-64">
                <header class="bg-white dark:bg-gray-800 shadow flex items-center justify-between px-4 sm:px-6 lg:px-8">
                    <button @click.stop="sidebarOpen = !sidebarOpen" class="lg:hidden text-gray-500 focus:outline-none">
                        <svg class="size-6" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M4 6h16M4 12h16M4 18h16" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path></svg>
                    </button>

                    <div class="flex-1">
                        @if (isset($header))
                            <div class="max-w-7xl mx-auto py-6">
                                {{ $header }}
                            </div>
                        @endif

                    </div>

                    @livewire('navigation-menu')
                </header>
                        <main>
                            {{ $slot }}
                        </main>
            </div>

        </div>

        @stack('modals')
        @livewireScripts
    </body>
</html>
