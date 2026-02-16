<ul class="space-y-2 font-medium text-gray-900 dark:text-white">
    <li>
        <x-nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')">
            <x-heroicon-m-squares-plus class="w-5 h-5 shrink-0"/>
            <span class="ms-3">{{ __('Dashboard') }}</span>
        </x-nav-link>
    </li>
    <hr class="my-2 border-gray-200 dark:border-gray-700">
    <li>
        @can('dashboard.users.show')
        <x-nav-link href="{{ route('dashboard.users.show') }}" :active="request()->routeIs('dashboard.users.show')">
            <x-heroicon-s-users class="w-5 h-5 shrink-0"/>
            <span class="ms-3">{{ __('Usuarios') }}</span>
        </x-nav-link>
        @endcan
        @can('dashboard.roles.show')
        <x-nav-link href="{{ route('dashboard.roles.show') }}" :active="request()->routeIs('dashboard.roles.show')">
            <x-heroicon-s-users class="w-5 h-5 shrink-0"/>
            <span class="ms-3">{{ __('Roles') }}</span>
        </x-nav-link>
        @endcan
    </li>
    <hr class="my-2 border-gray-200 dark:border-gray-700">
    <li>
        <x-nav-dropdown
            title="Datos Organizacionales"
            :active="request()->routeIs(['dashboard.collaborators.*', 'dashboard.departments.*', 'dashboard.regionals.*'])">
            <x-slot name="icon">
                <x-heroicon-o-circle-stack class="w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white "/>
            </x-slot>
            @can('dashboard.regionals.show')
            <x-nav-link href="{{ route('dashboard.regionals.show') }}" :active="request()->routeIs('dashboard.regionals.show')">
                <x-wireui-icon name="globe-americas" class="w-5 h-5 shrink-0"/>
                <span class="ms-3">{{ __('Regionales') }}</span>
            </x-nav-link>
            @endcan
            @can('dashboard.departments.show')
            <x-nav-link href="{{ route('dashboard.departments.show') }}" :active="request()->routeIs('dashboard.departments.show')">
                <x-wireui-icon name="building-office" class="w-5 h-5 shrink-0"/>
                <span class="ms-3">{{ __('Areas') }}</span>
            </x-nav-link>
            @endcan
            @can('dashboard.collaborators.show')
            <li>
                <x-nav-link href="{{ route('dashboard.collaborators.show') }}" :active="request()->routeIs('dashboard.collaborators.show')">
                    <x-heroicon-c-user-group class="w-5 h-5 shrink-0"/>
                    <span class="ms-3">{{ __('Colaboradores') }}</span>
                </x-nav-link>
            </li>
            @endcan
            @can('dashboard.occupations.show')
            <li>
                <x-nav-link href="{{ route('dashboard.occupations.show') }}" :active="request()->routeIs('dashboard.occupations.show')">
                    <x-heroicon-c-briefcase class="w-5 h-5 shrink-0"/>
                    <span class="ms-3">{{ __('Cargos') }}</span>
                </x-nav-link>
            </li>
            @endcan

        </x-nav-dropdown>
    </li>
    <hr class="my-2 border-gray-200 dark:border-gray-700">
    <li>
        <x-nav-dropdown
            title="Catálogo Dispositivos"
            :active="request()->routeIs(['dashboard.brands.*', 'dashboard.devicemodels.*'])">

            <x-slot name="icon">
                <x-heroicon-o-cog-6-tooth class="w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white "/>
            </x-slot>
            @can('dashboard.brands.show')
            <li>
                <x-nav-link href="{{ route('dashboard.brands.show') }}" :active="request()->routeIs('dashboard.brands.show')">
                    <x-wireui-icon name="tag" class="w-5 h-5 shrink-0"/>
                    <span class="ms-3">{{ __('Marcas') }}</span>
                </x-nav-link>
            </li>
            @endcan
            @can('dashboard.devicemodels.show')
            <li>
                <x-nav-link href="{{ route('dashboard.devicemodels.show') }}" :active="request()->routeIs('dashboard.devicemodels.show')">
                    <x-wireui-icon name="device-phone-mobile" class="w-5 h-5 shrink-0"/>
                    <span class="ms-3">{{ __('Modelos') }}</span>
                </x-nav-link>
            </li>
             @endcan
        </x-nav-dropdown>
    </li>

    {{-- Sección de Operaciones --}}
    <li>
        @can('dashboard.devices.show')
        <x-nav-link href="#" :active="request()->routeIs('Dispositivos.*')">
            <x-heroicon-o-device-phone-mobile class="w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white"/>
            <span class="ms-3">{{ __('Celulares') }}</span>
        </x-nav-link>
        @endcan
    </li>
</ul>
