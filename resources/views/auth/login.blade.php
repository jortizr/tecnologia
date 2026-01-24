<x-guest-layout>
    <x-authentication-card>
        <x-slot name="logo">
            {{-- Personalizando el logo con tu color corporativo --}}
            <div class="flex items-center gap-2">
                <a href="/">
                        <img src="https://envia.co/images/header_logo.png" alt="Envia Logo" class="h-10 w-auto">
                </a>
                <x-wireui-icon name="cpu-chip" class="w-12 h-12 text-brand-primary" />
                <span class="text-2xl font-bold tracking-tight text-brand-dark uppercase">Tech<span class="text-brand-primary">Stock</span></span>
            </div>
        </x-slot>

        <div class="mb-4 text-center text-sm text-gray-600 dark:text-gray-400">
            {{ __('Bienvenido de nuevo. Por favor, ingresa tus credenciales para acceder al inventario.') }}
        </div>

        <x-validation-errors class="mb-4" />
        <x-flash-message />

        @session('status')
            <div class="mb-4 font-medium text-sm text-green-600 dark:text-green-400">
                {{ $value }}
            </div>
        @endsession

        <form method="POST" action="{{ route('login') }}" class="space-y-4">
            @csrf

            {{-- Input de Email con WireUI --}}
            <x-wireui-input
                icon="home"
                label="Correo Electrónico"
                placeholder="tu@empresa.com"
                id="email"
                type="email"
                name="email"
                :value="old('email')"
                required
                autofocus
            />

            {{-- Input de Contraseña con WireUI (permite ver/ocultar) --}}
            <x-wireui-password
                label="Contraseña"
                id="password"
                name="password"
                required
                autocomplete="current-password"
            />

            <div class="flex items-center justify-between">
                <x-wireui-checkbox
                    id="remember_me"
                    name="remember"
                    label="Recuérdame"
                />

                @if (Route::has('password.request'))
                    <a class="text-sm text-brand-primary hover:text-brand-dark transition-colors" href="{{ route('password.request') }}">
                        {{ __('¿Olvidaste tu contraseña?') }}
                    </a>
                @endif
            </div>

            <div class="pt-2">
                <x-wireui-button
                    type="submit"
                    primary
                    lg
                    fluid
                    label="Iniciar Sesión"
                    right-icon="arrow-right"
                />
            </div>
        </form>
    </x-authentication-card>
</x-guest-layout>
