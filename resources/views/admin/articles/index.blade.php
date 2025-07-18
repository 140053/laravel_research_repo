<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-bold text-gray-800">Articles</h2>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <a href="{{ route('admin.articles.create') }}" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">Create New Article</a>

        <div class="mt-6">
            <table class="w-full bg-white shadow rounded">
                <thead class="bg-gray-100 text-left">
                    <tr>
                        <th class="p-4">Title</th>
                        <th class="p-4">Author</th>
                        <th class="p-4">Published</th>
                        <th class="p-4">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($articles as $article)
                        <tr class="border-b">
                            <td class="p-4 font-semibold">{{ $article->title }}</td>
                            <td class="p-4">{{ $article->author }}</td>
                            <td class="p-4">{{ $article->published ? 'Yes' : 'No' }}</td>
                            <td class="p-4 space-x-2">
                                <a href="{{ route('admin.articles.show', $article) }}" class="text-blue-500 hover:underline">View</a>
                                <a href="{{ route('admin.articles.edit', $article) }}" class="text-yellow-500 hover:underline">Edit</a>
                                <form action="{{ route('admin.articles.destroy', $article) }}" method="POST" class="inline" onsubmit="return confirm('Delete this article?')">
                                    @csrf @method('DELETE')
                                    <button class="text-red-500 hover:underline">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="mt-4">
                {{ $articles->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
