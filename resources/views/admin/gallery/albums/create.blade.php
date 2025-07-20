<x-app-layout>
    <x-slot name="header">
        <h2 class="text-3xl font-extrabold text-gray-900 dark:text-gray-100">📁 Create New Album</h2>
    </x-slot>

    <div class="max-w-2xl mx-auto mt-8 p-8 bg-white dark:bg-gray-800 shadow-xl rounded-2xl">
        <form method="POST" action="{{ route('admin.gallery.albums.store') }}" class="space-y-6">
            @csrf

            <!-- Album Name -->
            <div>
                <label for="name" class="block text-sm font-semibold text-gray-700 dark:text-gray-300">Album Name</label>
                <input
                    type="text"
                    name="name"
                    id="name"
                    class="mt-2 block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:ring-green-500 focus:border-green-500"
                    required
                >
                @error('name')
                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Description -->
            <div>
                <label for="description" class="block text-sm font-semibold text-gray-700 dark:text-gray-300">Description</label>
                <textarea
                    name="description"
                    id="description"
                    rows="4"
                    class="mt-2 block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:ring-green-500 focus:border-green-500"
                ></textarea>
            </div>

            <!-- Submit Button -->
            <div class="pt-4">
                <button
                    type="submit"
                    class="w-full flex justify-center items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white font-semibold rounded-lg transition duration-150 ease-in-out"
                >
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Create Album
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
