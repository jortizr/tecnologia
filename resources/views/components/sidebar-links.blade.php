<nav>
    <div class="flex flex-col space-y-1">
        <x-nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')">
            {{ __('Dashboard') }}
        </x-nav-link>

        <x-nav-link href="{{ route('dashboard.users.show') }}" :active="request()->routeIs('dashboard.users.show')">
            {{ __('Usuarios') }}
        </x-nav-link>

        <x-nav-link href="{{-- tu ruta --}}" :active="request()->routeIs('clausula.*')">
            {{ __('Clausula') }}
        </x-nav-link>

        <x-nav-link href="{{-- tu ruta --}}" :active="request()->routeIs('permisos.*')">
            {{ __('Permisos') }}
        </x-nav-link>

        <x-nav-link href="{{-- tu ruta --}}" :active="request()->routeIs('dispositivo.*')">
            {{ __('Dispositivo') }}
        </x-nav-link>

        {{-- ... y así con todos tus otros enlaces ... --}}
    </div>
</nav>
