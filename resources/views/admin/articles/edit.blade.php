<!-- resources/views/admin/articles/edit.blade.php -->

<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200">
            Edit Article
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 bg-white shadow p-6 rounded">
            <form method="POST" action="{{ route('admin.articles.update', $article->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label for="title" class="block font-medium text-sm text-gray-700">Title</label>
                    <input type="text" name="title" id="title" class="mt-1 block w-full" value="{{ old('title', $article->title) }}" required>
                </div>

                <div class="mb-4">
                    <label for="author" class="block font-medium text-sm text-gray-700">Author</label>
                    <input type="text" name="author" id="author" class="mt-1 block w-full" value="{{ old('author', $article->author) }}" required>
                </div>

                <div class="mb-4">
                    <label for="body" class="block font-medium text-sm text-gray-700">Body</label>
                    <textarea name="body" id="body" class="mt-1 block w-full" rows="5" required>{{ old('body', $article->body) }}</textarea>
                </div>

                <div class="mb-4">
                    <label for="images" class="block font-medium text-sm text-gray-700">Upload Images</label>
                    <input type="file" name="images[]" id="images" class="mt-1 block w-full" multiple>
                </div>

                <div class="mb-6">
                    <label class="block font-medium text-sm text-gray-700 mb-2">Existing Images</label>
                    <div class="flex flex-wrap gap-4">
                        @forelse ($article->images as $image)
                            <div class="relative w-32 h-32">
                                <img src="{{ asset('storage/' . $image->path) }}" class="object-cover w-full h-full rounded shadow" alt="Article Image">
                            </div>
                        @empty
                            <p class="text-gray-500">No images uploaded.</p>
                        @endforelse
                    </div>
                </div>

                <div class="mb-4 flex items-center">
                    <label for="published" class="mr-2 font-medium text-sm text-gray-700">Published?</label>
                    <input type="checkbox" name="published" id="published" {{ old('published', $article->published) ? 'checked' : '' }}>
                </div>

                <div class="flex justify-end">
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                        Update Article
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
