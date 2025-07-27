<div>
    @if($vedio)
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6">
                <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-4">{{ $vedio->name }}</h3>
                
                @if($vedio->description)
                    <p class="text-gray-600 dark:text-gray-300 mb-4">{{ $vedio->description }}</p>
                @endif
                
                @if($vedio->url)
                    <div class="aspect-video rounded-lg overflow-hidden">
                        <iframe 
                            src="{{ $vedio->url }}" 
                            class="w-full h-full"
                            frameborder="0" 
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                            allowfullscreen>
                        </iframe>
                    </div>
                @else
                    <div class="text-center py-8">
                        <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                        </svg>
                        <p class="text-gray-500 dark:text-gray-400">No video content available at the moment.</p>
                    </div>
                @endif
            </div>
        </div>
    @else
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 text-center">
                <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                </svg>
                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">No Video Content Available</h3>
                <p class="text-gray-500 dark:text-gray-400">There are currently no video materials to display.</p>
            </div>
        </div>
    @endif
</div>
