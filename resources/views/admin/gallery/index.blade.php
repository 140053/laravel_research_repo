<x-app-layout>
    <x-slot name="header">
        <!-- Page Title Section -->
        <section class="bg-gradient-to-r from-green-900 to-blue-700 py-16 px-6 sm:px-8 lg:px-10 text-center rounded-b-lg shadow-lg">
            <div class="max-w-4xl mx-auto">
                <h1 class="text-3xl sm:text-4xl md:text-5xl font-extrabold text-white mb-4 leading-tight">
                    Image Gallery Management
                </h1>
                <p class="text-lg sm:text-xl text-indigo-100">
                    Manage your research photo albums and images.
                </p>
            </div>
        </section>
    </x-slot>

  <!-- Main Content Area -->
<main class="container mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="space-y-10">
        <!-- New Album Button -->
        <div class="text-right mb-6">
            <a href="{{ route('admin.gallery.albums.create') }}"
               class="bg-green-600 text-white px-6 py-3 rounded-md hover:bg-green-700 transition-all duration-300 shadow-lg transform hover:scale-105">
                + New Album
            </a>
        </div>

        <!-- Albums List -->
        <div class="space-y-10">
            @foreach ($albums as $album)
                <div class="border rounded-lg p-6 shadow-md hover:shadow-xl transition-shadow duration-300 overflow-hidden">
                    <div class="flex flex-col xl:flex-row justify-between gap-6 mb-6">
                        <!-- Album Info -->
                        <div class="flex-1">
                            <h3 class="text-2xl sm:text-3xl font-semibold mb-2 text-gray-900 break-words">
                                {{ $album->name }}
                            </h3>
                            <p class="text-gray-600 text-sm sm:text-base break-words">
                                {{ $album->description }}
                            </p>
                        </div>

                        <!-- Album Actions -->
                        <div class="flex-shrink-0 text-right space-y-2 xl:space-y-0 xl:space-x-2">
                            <a href="{{ route('admin.gallery.albums.images.create', $album) }}"
                               class="inline-block bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700 transition-all duration-300 shadow hover:scale-105">
                                + Add Images
                            </a>
                            <form action="{{ route('admin.gallery.albums.destroy', $album) }}" method="POST" class="inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="inline-block bg-red-600 text-white px-4 py-2 rounded-md hover:bg-red-700 transition-all duration-300 shadow hover:scale-105"
                                        onclick="return confirm('Are you sure you want to delete this album?')">
                                    - Delete Album
                                </button>
                            </form>
                        </div>
                    </div>

                    <!-- Images Grid -->
                    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-4">
                        @forelse ($album->images as $image)
                            <div class="aspect-square overflow-hidden rounded-lg border border-gray-300 relative group bg-white">
                                <img src="{{ asset('storage/' . $image->image_path) }}"
                                     alt="{{ $image->caption }}"
                                     class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-105">

                                <!-- Hover Overlay -->
                                <div class="absolute inset-0 bg-black bg-opacity-30 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-end justify-center p-2">
                                    <form action="{{ route('admin.gallery.images.destroy', $image->id) }}" method="POST" onsubmit="return confirm('Delete this image?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="bg-red-600 text-white px-2 py-1 text-xs rounded hover:bg-red-700">
                                            Delete
                                        </button>
                                    </form>
                                </div>

                                <!-- Caption -->
                                <p class="mt-2 text-xs sm:text-sm text-gray-700 text-center px-2 truncate">
                                    {{ $image->caption }}
                                </p>
                            </div>
                        @empty
                            <div class="col-span-full text-center text-gray-400">
                                <p>No images in this album.</p>
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12 mx-auto text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                </svg>
                            </div>
                        @endforelse
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</main>

</x-app-layout>
