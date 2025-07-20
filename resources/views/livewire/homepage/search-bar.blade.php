<div class="relative max-w-2xl mx-auto">
    @auth
    <form wire:submit.prevent="searchNow">
        <input type="text" wire:model.defer="search"
            placeholder="Search for insights, studies, topics, or keywords..."
            class="w-full py-3 pl-5 pr-12 rounded-full shadow-lg text-gray-800 text-lg">
        <button type="submit" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-500 hover:text-indigo-700">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" ...></svg>
        </button>
    </form>
    @else
        <a href="{{ route('login') }}"
            class="w-full px-4 py-2 border rounded-lg shadow-sm text-white dark:bg-gray-700 dark:text-gray-300">
            Login to Search for Content
        </a>
    @endauth
</div>
