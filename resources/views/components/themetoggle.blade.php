 <!-- Your existing theme toggle button component -->
    <button
        x-data="{
            // Initialize 'dark' state by checking if the 'dark' class is already on the html element.
            // This ensures Alpine's state matches the initial state set by the head script.
            dark: document.documentElement.classList.contains('dark')
        }"
        x-init="
            // Watch for changes in the 'dark' state (triggered by button click)
            $watch('dark', value => {
                localStorage.setItem('theme', value ? 'dark' : 'light');
                document.documentElement.classList.toggle('dark', value);
            });
            // Also, explicitly apply the class on initial Alpine init.
            // This is a safeguard, as the head script should have already done it.
            document.documentElement.classList.toggle('dark', dark);
        "
        @click="dark = !dark"
        class="p-2 rounded text-sm text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition"
        title="Toggle Theme"
    >
        <template x-if="dark">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v1m0 16v1m8-8h1M3 12H2m15.364-6.364l.707.707M6.343 17.657l-.707.707M17.657 17.657l.707-.707M6.343 6.343l-.707-.707M12 5a7 7 0 100 14 7 7 0 000-14z" />
            </svg>
        </template>
        <template x-if="!dark">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21 12.79A9 9 0 1111.21 3a7 7 0 009.79 9.79z" />
            </svg>
        </template>
    </button>