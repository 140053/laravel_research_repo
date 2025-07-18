<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-bold text-gray-800">Create Article</h2>
    </x-slot>

    <div class="py-6 max-w-4xl mx-auto px-4">
        <form action="{{ route('admin.articles.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6 bg-white p-6 shadow rounded">
            @csrf

            <div>
                <label class="block text-gray-700">Title</label>
                <input name="title" type="text" class="w-full border rounded p-2" value="{{ old('title') }}" required>
            </div>

            <div>
                <label class="block text-gray-700">Author</label>
                <input name="author" type="text" class="w-full border rounded p-2" value="{{ old('author') }}" required>
            </div>

            <div>
                <label class="block text-gray-700">Body</label>
                <textarea name="body" class="w-full border rounded p-2" rows="6" required>{{ old('body') }}</textarea>
            </div>

            <!-- Add in create.blade.php and edit.blade.php -->
            <div>
                <label for="images" class="block mb-2 font-medium">Upload Images</label>
                <input type="file" name="images[]" id="images" multiple class="border border-gray-300 rounded p-2">
            </div>


            <div class="flex items-center space-x-2">
                <input type="checkbox" name="published" id="published" class="rounded" value="1">
                <label for="published" class="text-gray-700">Publish now</label>
            </div>

            <button class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">Save Article</button>
        </form>
    </div>
</x-app-layout>
