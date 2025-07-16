<div x-data="{ open: false }" class="border rounded shadow ">
    <button
        @click="open = !open"
        class="flex items-center justify-between w-full px-4 py-3 text-left  text-gray-700 bg-gray-100 hover:bg-gray-200"
    >
        <span>📂 {{ $label }}</span>
        <svg :class="{'rotate-180': open}" class="w-4 h-4 transform transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
        </svg>
    </button>

    <div x-show="open" x-transition class="text-gray-800 dark:text-gray-300 whitespace-pre-line italic font-thin text-sm p-3">
        {{$content}}
    </div>
</div>