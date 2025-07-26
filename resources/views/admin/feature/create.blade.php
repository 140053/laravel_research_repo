<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-black dark:text-gray-300 leading-tight">
            Create Feature Material
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form method="POST" action="{{ route('admin.feature.store') }}" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-4">
                        <label class="block font-bold mb-1" for="name">Name</label>
                        <input type="text" name="name" id="name" value="{{ old('name') }}" class="w-full rounded border-gray-300 dark:bg-gray-700 dark:text-gray-100">
                        @error('name') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block font-bold mb-1" for="description">Description</label>
                        <textarea name="description" id="description" class="w-full rounded border-gray-300 dark:bg-gray-700 dark:text-gray-100">{{ old('description') }}</textarea>
                        @error('description') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block font-bold mb-1" for="url">URL</label>
                        <input type="text" name="url" id="url" value="{{ old('url') }}" class="w-full rounded border-gray-300 dark:bg-gray-700 dark:text-gray-100">
                        @error('url') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block font-bold mb-1" for="file">File Upload</label>
                        <input type="file" name="file" id="file" class="w-full rounded border-gray-300 dark:bg-gray-700 dark:text-gray-100">
                        @error('file') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block font-bold mb-1" for="type">Type</label>
                        <select name="type" id="type" class="w-full rounded border-gray-300 dark:bg-gray-700 dark:text-gray-100">
                            <option value="text" {{ old('type') == 'text' ? 'selected' : '' }}>Text</option>
                            <option value="link" {{ old('type') == 'link' ? 'selected' : '' }}>Link</option>
                            <option value="pdf" {{ old('type') == 'pdf' ? 'selected' : '' }}>PDF</option>
                            <option value="image" {{ old('type') == 'image' ? 'selected' : '' }}>Image</option>
                        </select>
                        @error('type') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block font-bold mb-1" for="location">Location</label>
                        <select name="location" id="location" class="w-full rounded border-gray-300 dark:bg-gray-700 dark:text-gray-100">
                            <option value="text" {{ old('location') == 'text' ? 'selected' : '' }}>Text</option>
                            <option value="brochure" {{ old('location') == 'brochure' ? 'selected' : '' }}>Brochure</option>
                            <option value="vedio" {{ old('location') == 'vedio' ? 'selected' : '' }}>Vedio</option>
                        </select>
                        @error('location') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-4 flex items-center hidden">
                        <input type="checkbox" name="hidden" id="hidden" value="1" {{ old('hidden', true) ? 'checked' : '' }} class="mr-2">
                        <label for="hidden" class="font-bold">Hidden</label>
                        @error('hidden') <span class="text-red-600 text-sm ml-2">{{ $message }}</span> @enderror
                    </div>

                    <div class="flex justify-end">
                        <a href="{{ route('admin.feature.index') }}" class="bg-gray-400 text-white px-4 py-2 rounded mr-2 hover:bg-gray-500">Cancel</a>
                        <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">Create</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout> 