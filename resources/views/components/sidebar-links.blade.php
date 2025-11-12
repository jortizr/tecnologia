<ul class="space-y-2 font-medium">
    <li>
        <x-nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')">
        <x-heroicon-m-squares-plus class="w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-indigo-700"/>
            <span class="ms-3">{{ __('Dashboard') }}</span>
        </x-nav-link>
    </li>
    <li>
        @hasrole('Superadmin')
        <x-nav-link href="{{ route('dashboard.users.show') }}" :active="request()->routeIs('dashboard.users.show')">
            <x-heroicon-s-users class="w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-indigo-700"/>
            <span class="ms-3">{{ __('Usuarios') }}</span>
        </x-nav-link>
        @endhasrole
    </li>
    <li>
        <x-nav-link href="{{route ('dashboard.collaborators.show')}}" :active="request()->routeIs('dashboard.collaborators.show')">
            <x-heroicon-c-user-group class="w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-indigo-700"/>
            <span class="ms-3">{{ __('Colaboradores') }}</span>
        </x-nav-link>
    </li>
        <li>
        <x-nav-link href="{{route('dashboard.brands.show') }}" :active="request()->routeIs('dashboard.brands.show')">
            <x-phosphor-list-plus-fill class="w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-indigo-700"/>
            <span class="ms-3">{{ __('Marcas dispositivos') }}</span>
        </x-nav-link>
    </li>
    <li>
        <x-nav-link href="{{-- tu ruta --}}" :active="request()->routeIs('Dispositivos.*')">
            <x-heroicon-o-device-phone-mobile class="w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-indigo-700"/>
            <span class="ms-3">{{ __('Celulares') }}</span>
        </x-nav-link>
    </li>
    <li>
        <x-nav-link href="{{-- tu ruta --}}" :active="request()->routeIs('Clausulas.*')">
            <x-heroicon-o-document-text class="w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-indigo-700"/>
            <span class="ms-3">{{ __('Clausulas') }}</span>
        </x-nav-link>
    </li>
</ul>
