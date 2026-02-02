<ul class="space-y-2 font-medium text-gray-900 dark:text-white">
    <li>
        <x-nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')">
            <x-heroicon-m-squares-plus class="w-5 h-5 shrink-0"/>
            <span class="ms-3">{{ __('Dashboard') }}</span>
        </x-nav-link>
    </li>
    <hr class="my-2 border-gray-200 dark:border-gray-700">
    <li>
        @hasrole('Superadmin')
        <x-nav-link href="{{ route('dashboard.users.show') }}" :active="request()->routeIs('dashboard.users.show')">
            <x-heroicon-s-users class="w-5 h-5 shrink-0"/>
            <span class="ms-3">{{ __('Usuarios') }}</span>
        </x-nav-link>
        <x-nav-link href="{{ route('dashboard.roles.show') }}" :active="request()->routeIs('dashboard.roles.show')">
            <x-heroicon-s-users class="w-5 h-5 shrink-0"/>
            <span class="ms-3">{{ __('Roles') }}</span>
        </x-nav-link>
        @endhasrole
    </li>
    <li>
        <x-nav-link href="{{ route('dashboard.collaborators.show') }}" :active="request()->routeIs('dashboard.collaborators.show')">
            <x-heroicon-c-user-group class="w-5 h-5 shrink-0"/>
            <span class="ms-3">{{ __('Colaboradores') }}</span>
        </x-nav-link>
    </li>
    <li>
        <x-nav-link href="{{ route('dashboard.departments.show') }}" :active="request()->routeIs('dashboard.departments.show')">
            <x-wireui-icon name="building-office" class="w-5 h-5 shrink-0"/>
            <span class="ms-3">{{ __('Areas') }}</span>
        </x-nav-link>
    </li>
    <hr class="my-2 border-gray-200 dark:border-gray-700">
    {{-- Dropdown de Configuración de Equipos --}}
    <li>
        <x-nav-dropdown
            title="Catálogo Dispositivos"
            :active="request()->routeIs(['dashboard.brands.*', 'dashboard.devicemodels.*'])">

            <x-slot name="icon">
                <x-heroicon-o-cog-6-tooth class="w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white "/>
            </x-slot>
            <li>
                <x-nav-link href="{{ route('dashboard.brands.show') }}" :active="request()->routeIs('dashboard.brands.show')">
                    <span class="ms-3">{{ __('Marcas') }}</span>
                </x-nav-link>
            </li>
            <li>
                <x-nav-link href="{{ route('dashboard.devicemodels.show') }}" :active="request()->routeIs('dashboard.devicemodels.show')">
                    <span class="ms-3">{{ __('Modelos') }}</span>
                </x-nav-link>
            </li>
        </x-nav-dropdown>
    </li>

    {{-- Sección de Operaciones --}}
    <li>
        <x-nav-link href="#" :active="request()->routeIs('Dispositivos.*')">
            <x-heroicon-o-device-phone-mobile class="w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white"/>
            <span class="ms-3">{{ __('Celulares') }}</span>
        </x-nav-link>
    </li>
</ul>
