<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-bold">Upload Images to Album: {{ $album->name }}</h2>
    </x-slot>

    <div class="p-6 max-w-4xl mx-auto">
        <form action="{{ route('admin.albums.images.store', $album) }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-4">
                <label class="block mb-2 text-sm font-medium text-gray-700">Select Images</label>
                <input type="file" name="images[]" multiple class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer focus:outline-none">
                @error('images.*')
                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                Upload
            </button>
        </form>
    </div>
</x-app-layout>
