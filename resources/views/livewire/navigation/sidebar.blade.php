<div class="flex h-full flex-col bg-gray-900 text-gray-300">
    <div class="flex h-16 flex-shrink-0 items-center px-4">
        <a href="{{ route('dashboard') }}">
            <x-heroicon-o-bolt class="h-8 w-auto text-indigo-500" />
        </a>
    </div>

    <nav class="flex flex-1 flex-col overflow-y-auto px-2">
        <ul role="list" class="flex flex-1 flex-col gap-y-7">
            <li>
                <ul role="list" class="-mx-2 space-y-1">
                    @php
                        // El array ahora solo contiene el nombre del componente del icono.
                        // Usamos los nombres de Heroicons (o = outline, s = solid).
                        $navItems = [
                            ['route' => 'dashboard', 'label' => 'Dashboard', 'icon' => 'heroicon-o-home'],
                            ['route' => '#', 'label' => 'Team', 'icon' => 'heroicon-o-users'],
                            ['route' => '#', 'label' => 'Projects', 'icon' => 'heroicon-o-folder'],
                            ['route' => '#', 'label' => 'Calendar', 'icon' => 'heroicon-o-calendar-days'],
                            ['route' => '#', 'label' => 'Documents', 'icon' => 'heroicon-o-document-duplicate'],
                        ];
                    @endphp

                    @foreach ($navItems as $item)
                    <li>
                        <a href="{{ $item['route'] !== '#' ? route($item['route']) : '#' }}"
                           @class([
                                'bg-gray-800 text-white' => request()->routeIs($item['route']),
                                'text-gray-400 hover:text-white hover:bg-gray-800',
                                'group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold'
                           ])>

                            <x-dynamic-component :component="$item['icon']" class="h-6 w-6 shrink-0" />

                            {{ $item['label'] }}
                        </a>
                    </li>
                    @endforeach

                    @can('view-reports') {{-- Define este "gate" en tu AuthServiceProvider --}}
                        <li>
                            <a href="#" class="text-gray-400 hover:text-white hover:bg-gray-800 group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold">
                                <x-heroicon-o-chart-bar class="h-6 w-6 shrink-0" />
                                Reports
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>

            @if ($teams->isNotEmpty())
            <li>
                <div class="text-xs font-semibold leading-6 text-gray-400">Your teams</div>
                <ul role="list" class="-mx-2 mt-2 space-y-1">
                    @foreach ($teams as $team)
                    <li>
                        <a href="{{ route('teams.show', $team) }}"
                           @class([
                                'bg-gray-800 text-white' => Auth::user()->current_team_id == $team->id,
                                'text-gray-400 hover:text-white hover:bg-gray-800',
                                'group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold'
                           ])>
                            <span class="flex h-6 w-6 shrink-0 items-center justify-center rounded-lg border border-gray-700 bg-gray-800 text-[0.625rem] font-medium text-gray-400 group-hover:text-white">
                                {{ substr($team->name, 0, 1) }}
                            </span>
                            <span class="truncate">{{ $team->name }}</span>
                        </a>
                    </li>
                    @endforeach
                </ul>
            </li>
            @endif
        </ul>
    </nav>

    <div class="px-2 py-4">
        <a href="{{ route('profile.show') }}" class="group -mx-2 flex gap-x-3 rounded-md p-2 text-sm font-semibold leading-6 text-white hover:bg-gray-800">
            <img class="h-8 w-8 rounded-full bg-gray-800" src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}">
            <span class="sr-only">Your profile</span>
            <span aria-hidden="true">{{ Auth::user()->name }}</span>
        </a>
    </div>
</div>
