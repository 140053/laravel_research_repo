<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-bold text-gray-800">Article Details</h2>
    </x-slot>

    <div class="py-6 max-w-4xl mx-auto px-4 space-y-4 bg-white p-6 rounded shadow">
        <h1 class="text-2xl font-bold text-indigo-700">{{ $article->title }}</h1>
        <p class="text-gray-600">By {{ $article->author }}</p>
        <p class="text-sm text-gray-400">
            Published: 
            {{ $article->published && $article->published_at ? \Carbon\Carbon::parse($article->published_at)->format('F j, Y') : 'No' }}
        </p>
        

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
        

        <div class="mt-6 text-gray-800 prose">
            {!! nl2br(e($article->body)) !!}
        </div>

        <div class="mt-6">
            <a href="{{ route('admin.articles.edit', $article) }}" class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600">Edit</a>
            <a href="{{ route('admin.articles.index') }}" class="ml-2 text-gray-600 hover:underline">Back to Articles</a>
        </div>
    </div>
</x-app-layout>
