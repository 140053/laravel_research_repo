<x-home-layout>
    <div class="">
        <!-- Hero Section -->
        <section class="bg-gradient-to-r from-green-950 to-blue-900 py-12 px-4 sm:px-6 lg:px-8 text-center rounded-b-lg shadow-md lg:ml-60 lg:mr-60">
            <div class="max-w-3xl mx-auto">
                <h1 class="text-4xl sm:text-5xl font-extrabold text-white mb-4 leading-tight">
                    Gallery
                </h1>
                <p class="text-lg text-indigo-100">
                    Discover the documentation of the project.
                </p>
            </div>
        </section>

        <!-- Gallery Content -->
        <section class="py-12 px-4 sm:px-6 lg:px-8">
            <div class="max-w-7xl mx-auto">
                @if($albums && $albums->count() > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                        @foreach($albums as $album)
                            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition-shadow duration-300">
                                <!-- Album Cover Image -->
                                <div class="relative h-64 overflow-hidden">
                                    @if($album->images->count() > 0)
                                        <img src="{{ asset('storage/' . $album->images->first()->image_path) }}" 
                                             alt="{{ $album->name }}" 
                                             class="w-full h-full object-cover transition-transform duration-300 hover:scale-105">
                                        
                                        <!-- Image Count Badge -->
                                        <div class="absolute top-4 right-4 bg-black bg-opacity-75 text-white px-3 py-1 rounded-full text-sm font-medium">
                                            {{ $album->images->count() }} {{ Str::plural('image', $album->images->count()) }}
                                        </div>
                                    @else
                                        <div class="w-full h-full bg-gray-200 dark:bg-gray-700 flex items-center justify-center">
                                            <div class="text-center text-gray-500 dark:text-gray-400">
                                                <svg class="w-16 h-16 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                </svg>
                                                <p class="text-sm">No images</p>
                                            </div>
                                        </div>
                                    @endif
                                </div>

                                <!-- Album Info -->
                                <div class="p-6">
                                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">
                                        {{ $album->name }}
                                    </h3>
                                    
                                    @if($album->description)
                                        <p class="text-gray-600 dark:text-gray-300 text-sm mb-4 line-clamp-3">
                                            {{ $album->description }}
                                        </p>
                                    @endif

                                    <!-- Action Buttons -->
                                    <div class="flex justify-between items-center">
                                        @if($album->images->count() > 0)
                                           
                                            <a href="{{ route('gallery.view', $album) }}" 
                                               class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-md hover:bg-blue-700 transition-colors duration-200">
                                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                </svg>
                                                View Album
                                            </a>
                                        @else
                                            <span class="text-gray-500 dark:text-gray-400 text-sm">
                                                No images to view
                                            </span>
                                        @endif

                                        <span class="text-xs text-gray-500 dark:text-gray-400">
                                            {{ $album->created_at->diffForHumans() }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <!-- Empty State -->
                    <div class="text-center py-16">
                        <div class="bg-gray-100 dark:bg-gray-800 rounded-lg p-12 max-w-md mx-auto">
                            <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">No Albums Available</h3>
                            <p class="text-gray-500 dark:text-gray-400 text-sm">
                                No gallery albums have been created yet. Check back later for updates.
                            </p>
                        </div>
                    </div>
                @endif
            </div>
        </section>
    </div>
</x-home-layout>
