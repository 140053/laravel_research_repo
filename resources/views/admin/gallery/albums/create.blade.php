<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-bold">Create New Album</h2>
    </x-slot>

    <div class="max-w-xl mx-auto p-6">
        <form method="POST" action="{{ route('admin.gallery.albums.store') }}">
            @csrf

            <div class="mb-4">
                <label class="block font-medium text-sm text-gray-700">Album Name</label>
                <input type="text" name="name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                @error('name')
                    <div class="text-red-500 text-sm">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block font-medium text-sm text-gray-700">Description</label>
                <textarea name="description" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"></textarea>
            </div>

            <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                Create Album
            </button>
        </form>
    </div>
</x-app-layout>
