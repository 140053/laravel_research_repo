<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-bold">Image Gallery by Album</h2>
    </x-slot>

    <div class="p-6 space-y-10">
        <div class="text-right mb-6">
            <a href="{{ route('admin.gallery.albums.create') }}" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                + New Album
            </a>
        </div>
        
        @foreach ($albums as $album)
            <div class="border rounded-lg p-4 shadow-md">
                <a href="{{ route('admin.gallery.albums.images.create', $album) }}" class="text-sm text-blue-600 underline">
                    + Add Images
                </a>
                <h3 class="text-xl font-semibold mb-2">{{ $album->name }}</h3>
                <p class="mb-4 text-gray-500">{{ $album->description }}</p>

                <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4">
                    @forelse ($album->images as $image)
                       
                        <div class="aspect-square overflow-hidden rounded-lg border">
                            <img src="{{ asset('storage/' . $image->image_path) }}" alt="" class="w-full h-full object-cover">
                        </div>
                    @empty
                        <p class="col-span-full text-gray-400">No images in this album.</p>
                    @endforelse
                </div>
            </div>
        @endforeach
    </div>
</x-app-layout>
