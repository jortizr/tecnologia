<div x-data="{
    darkMode: localStorage.getItem('darkMode') === 'true',
    init() {
        this.updateTheme();
    },
    toggle() {
        this.darkMode = !this.darkMode;
        localStorage.setItem('darkMode', this.darkMode);
        this.updateTheme();
    },
    updateTheme() {
        if (this.darkMode) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    }
}">
    <button
        type="button"
        x-on:click="toggle"
        class="text-brand-primary hover:bg-brand-red/10 focus:ring-brand-primary"
    >
        <div class="shrink-0">
            <svg x-show="!darkMode" class="w-5 h-5" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                <path d="M12 3V5.25M18.364 5.63604L16.773 7.22703M21 12H18.75M18.364 18.364L16.773 16.773M12 18.75V21M7.22703 16.773L5.63604 18.364M5.25 12H3M7.22703 7.22703L5.63604 5.63604M15.75 12C15.75 14.0711 14.0711 15.75 12 15.75C9.92893 15.75 8.25 14.0711 8.25 12C8.25 9.92893 9.92893 8.25 12 8.25C14.0711 8.25 15.75 12Z" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
            </svg>

            <svg x-show="darkMode" x-cloak class="w-5 h-5" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path>
            </svg>
        </div>
    </button>
</div>
