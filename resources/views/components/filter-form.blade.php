{{-- resources/views/components/filter-form.blade.php --}}
<div class="bg-white dark:bg-gray-800 p-4 rounded-md shadow-md">
    <h3 class="text-lg font-semibold mb-4 text-center md:text-left">Filter Research Papers</h3>

    <form method="GET" action="{{ $link }}"
        class="flex flex-col md:flex-row md:items-end md:justify-between gap-4 w-full">
        
        
        {{-- Input --}}
        <div class="flex-1">
            <label class="block text-sm font-medium mb-1 text-gray-700 dark:text-gray-300">Keyword</label>
            <input type="text" name="search" value="{{ request('search') }}"
                class="border rounded px-3 py-2 w-full focus:ring-2 focus:ring-blue-500 focus:outline-none">
        </div>

        {{-- Buttons --}}
        <div class="flex flex-col md:flex-row items-center gap-2 md:gap-3">
            <button type="submit"
                    class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 w-full md:w-auto">
                Search
            </button>
            <a href="{{ $link }}"
               class="text-gray-600 dark:text-gray-300 underline text-sm w-full text-center md:w-auto">
                Reset
            </a>
        </div>
    </form>
</div>
