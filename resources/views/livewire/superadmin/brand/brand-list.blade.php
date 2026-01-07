{{-- En tu archivo de rutas o vista principal --}}
<livewire:superadmin.generic-catalog
    :model="'Brand'"
    :with="['creator:id,name', 'updater:id,name']"
/>
