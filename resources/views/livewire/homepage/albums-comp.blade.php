<section class="lg:col-span-2">
    <h2 class="text-2xl font-bold text-gray-900 mb-6 dark:text-gray-200">Captured in Action </h2>
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
        @foreach ($albums as $album)
            

            <div class="relative group rounded-lg overflow-hidden shadow-md hover:shadow-xl transition-shadow duration-300">
                @if ($album->images->first())
                    <img src="{{ Storage::disk('public')->url($album->images->first()->image_path) }}" alt="Album Image"
                         class="w-full h-48 object-cover" loading="lazy">
                @else
                    <div class="w-full h-48 bg-gray-200 flex items-center justify-center text-gray-500">
                        No Image
                    </div>
                @endif

                <div
                    class="absolute inset-0 from-green-800 to-blue-800 bg-gradient-to-br bg-opacity-80 flex flex-col items-center justify-center text-center px-4 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                    <a href="{{ route('gallery.view', $album) }}">
                        <span class="text-white text-xl font-bold mb-2">{{ $album->name }}</span><br>
                        <span class="text-white text-sm">
                            {{ \Illuminate\Support\Str::limit($album->description, 50, '...') }}
                        </span>
                    </a>
                </div>
            </div>
        @endforeach
    </div>
</section>
