<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Inventario Tecnológico</title>

        <wireui:scripts />
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />
    </head>
    <body class="antialiased bg-brand-soft text-brand-dark font-sans">

    <nav class="bg-white border-b border-gray-100 sticky top-0 z-50 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                <div class="flex items-center">
                    <a href="/">
                        <img src="https://envia.co/images/header_logo.png" alt="Envia Logo" class="h-10 w-auto">
                    </a>
                    <div class="ml-3 pl-3 border-l border-gray-200">
                        <span class="text-sm font-bold tracking-widest text-brand-dark uppercase">
                            Inventario <span class="text-brand-primary">Tech</span>
                        </span>
                    </div>
                </div>

                <div class="flex items-center gap-4">
                    @if (Route::has('login'))
                        @auth
                            <x-wireui-button href="{{ url('/dashboard') }}" primary label="Dashboard" right-icon="arrow-right" />
                        @else
                            <x-wireui-button href="{{ route('login') }}" flat secondary label="Entrar" />
                        @endauth
                    @endif
                </div>
            </div>
        </div>
    </nav>

        <header class="relative bg-white overflow-hidden py-16 lg:py-24">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
                <div class="lg:grid lg:grid-cols-2 lg:gap-8 items-center">
                    <div>
                        <h1 class="text-4xl font-extrabold text-brand-dark sm:text-5xl md:text-6xl mb-6">
                            Gestión de <span class="text-brand-primary">Dispositivos TI</span> con precisión
                        </h1>
                        <p class="text-lg text-gray-600 mb-8 max-w-lg leading-relaxed">
                            Controla el hardware, celulares corporativos, tablets y asignaciones de tu equipo desde una plataforma centralizada y segura.
                        </p>

                        <div class="flex flex-wrap gap-4">
                            <x-wireui-button size="lg" primary label="Explorar Inventario" icon="circle-stack" />
                            <x-wireui-button size="lg" outline secondary label="Soporte Técnico" icon="wrench-screwdriver" />
                        </div>
                    </div>

                    <div class="mt-12 lg:mt-0 flex justify-center">
                        <div class="relative w-full max-w-md">
                            <div class="absolute -top-6 -left-6 w-72 h-72 bg-brand-primary/10 rounded-full blur-3xl"></div>
                            <x-wireui-card title="Estado del Sistema" shadow="2xl">
                                <div class="space-y-4">
                                    <div class="flex justify-between items-center border-b pb-2">
                                        <span class="text-sm font-medium">Equipos Activos</span>
                                        <x-wireui-badge label="128" positive pill />
                                    </div>
                                    <div class="flex justify-between items-center border-b pb-2">
                                        <span class="text-sm font-medium">En Reparación</span>
                                        <x-wireui-badge label="12" warning pill />
                                    </div>
                                    <x-wireui-button fluid outline label="Ver Detalles Rápidos" />
                                </div>
                            </x-wireui-card>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <section class="py-20 bg-brand-soft">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-center">
                    <div class="p-6">
                        <x-wireui-icon name="shield-check" class="w-12 h-12 text-brand-primary mx-auto mb-4" />
                        <h3 class="font-bold text-xl">Seguridad Spatie</h3>
                        <p class="text-gray-500 mt-2">Permisos granulares para cada usuario del sistema.</p>
                    </div>
                    <div class="p-6">
                        <x-wireui-icon name="bolt" class="w-12 h-12 text-brand-primary mx-auto mb-4" />
                        <h3 class="font-bold text-xl">Interfaz WireUI</h3>
                        <p class="text-gray-500 mt-2">Componentes reactivos y rápidos para una mejor UX.</p>
                    </div>
                    <div class="p-6">
                        <x-wireui-icon name="clipboard-document-list" class="w-12 h-12 text-brand-primary mx-auto mb-4" />
                        <h3 class="font-bold text-xl">Historial Completo</h3>
                        <p class="text-gray-500 mt-2">Trazabilidad total de quién tiene qué equipo.</p>
                    </div>
                </div>
            </div>
        </section>

        <footer class="bg-custom-dark-bg text-white py-12">
            <div class="max-w-7xl mx-auto px-4 text-center">
                <p class="text-gray-400">© {{ date('Y') }} - TechStock Inventory System</p>
            </div>
        </footer>
    </body>
</html>
