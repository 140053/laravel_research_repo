<div x-data="{ opens: false }" class="border rounded shadow ">
    <button
        @click="opens = !opens"
        class="flex items-center justify-between w-full px-4 py-3 text-left  text-gray-700 bg-gray-100 hover:bg-gray-200 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700 font-semibold focus:outline-none focus:ring-2 focus:ring-blue-500 transition-colors"
    >
        <span>📂 {{ $label }}</span>
        <svg :class="{'rotate-180': open}" class="w-4 h-4 transform transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
        </svg>
    </button>

    <div x-show="opens" x-transition class="text-gray-800 dark:text-gray-300  italic font-thin text-sm p-3">
       
        <a href="{{ $link }}" target="_blank" class="text-blue-600 hover:underline break-all dark:text-blue-400">
            {{$content}}
        </a>
    </div>
</div>