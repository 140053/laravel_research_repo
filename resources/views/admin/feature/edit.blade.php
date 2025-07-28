<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-black dark:text-gray-300 leading-tight">
            Edit Feature Material
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form method="POST" action="{{ route('admin.feature.update', $featureMaterial) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label class="block font-bold mb-1" for="name">Name</label>
                        <input type="text" name="name" id="name" value="{{ old('name', $featureMaterial->name) }}" class="w-full rounded border-gray-300 dark:bg-gray-700 dark:text-gray-100">
                        @error('name') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block font-bold mb-1" for="description">Description</label>
                        <textarea name="description" id="description" class="w-full rounded border-gray-300 dark:bg-gray-700 dark:text-gray-100">{{ old('description', $featureMaterial->description) }}</textarea>
                        @error('description') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block font-bold mb-1" for="url">URL</label>
                        <input type="text" name="url" id="url" value="{{ old('url', $featureMaterial->url) }}" class="w-full rounded border-gray-300 dark:bg-gray-700 dark:text-gray-100">
                        @error('url') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block font-bold mb-1" for="file">File Upload</label>
                        <input type="file" name="file" id="file" class="w-full rounded border-gray-300 dark:bg-gray-700 dark:text-gray-100">
                        @if($featureMaterial->file)
                            <div class="mt-2 text-xs text-gray-500 dark:text-gray-300">
                                Current file: <a href="{{ asset('storage/' . $featureMaterial->file) }}" target="_blank" class="underline">View/Download</a>
                            </div>
                        @endif
                        @error('file') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block font-bold mb-1" for="type">Type</label>
                        <select name="type" id="type" class="w-full rounded border-gray-300 dark:bg-gray-700 dark:text-gray-100">
                            <option value="text" {{ old('type', $featureMaterial->type) == 'text' ? 'selected' : '' }}>Text</option>
                            <option value="link" {{ old('type', $featureMaterial->type) == 'link' ? 'selected' : '' }}>Link</option>
                            <option value="pdf" {{ old('type', $featureMaterial->type) == 'pdf' ? 'selected' : '' }}>PDF</option>
                            <option value="image" {{ old('type', $featureMaterial->type) == 'image' ? 'selected' : '' }}>Image</option>
                        </select>
                        @error('type') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block font-bold mb-1" for="location">Location</label>
                        <select name="location" id="location" class="w-full rounded border-gray-300 dark:bg-gray-700 dark:text-gray-100">
                            <option value="text" {{ old('location', $featureMaterial->location) == 'text' ? 'selected' : '' }}>Text</option>
                            <option value="brochure" {{ old('location', $featureMaterial->location) == 'brochure' ? 'selected' : '' }}>Brochure</option>
                            <option value="vedio" {{ old('location', $featureMaterial->location) == 'vedio' ? 'selected' : '' }}>Vedio</option>
                        </select>
                        @error('location') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-4 flex items-center hiddee ">
                        <input type="checkbox" name="hidden" id="hidden" value="0"  class="mr-2">
                        <label for="hidden" class="font-bold">Hidden</label>
                        @error('hidden') <span class="text-red-600 text-sm ml-2">{{ $message }}</span> @enderror
                    </div>

                    <div class="flex justify-end">
                        <a href="{{ route('admin.feature.index') }}" class="bg-gray-400 text-white px-4 py-2 rounded mr-2 hover:bg-gray-500">Cancel</a>
                        <button type="submit" class="bg-yellow-600 text-white px-4 py-2 rounded hover:bg-yellow-700">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout> 