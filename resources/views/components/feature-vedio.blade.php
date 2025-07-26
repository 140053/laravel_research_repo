<div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        @if($vedio && $vedio->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 lg:gap-8">
                @foreach ($vedio as $item)
                    @php
                        // Extract YouTube URL from iframe HTML if it exists
                        $url = $item->url;
                        
                        // Remove quotes from the beginning and end
                        $url = trim($url, '"\'');
                        
                        // Remove @ symbol if it exists at the beginning of the cleaned URL
                        $url = ltrim($url, '@');
                        
                        if (str_contains($url, 'youtube.com/embed/')) {
                            // Extract the embed URL from iframe
                            preg_match('/src="([^"]+)"/', $url, $matches);
                            if (isset($matches[1])) {
                                $url = $matches[1];
                            }
                        }
                        
                        // Clean up any extra whitespace
                        $url = trim($url);
                    @endphp
                    
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg overflow-hidden">
                        <!-- Video Title -->
                        @if($item->name)
                            <div class="px-4 py-3 border-b border-gray-200 dark:border-gray-700">
                                <h3 class="text-lg font-bold text-gray-900 dark:text-white truncate">
                                    {{ $item->name }}
                                </h3>
                            </div>
                        @endif
                        
                        <!-- Video Container -->
                        <div class="relative">
                            <div class="aspect-video">
                                <iframe 
                                    src="{{ $url }}" 
                                    frameborder="0" 
                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                                    allowfullscreen
                                    class="w-full h-full">
                                </iframe>
                            </div>
                        </div>
                        
                        <!-- Video Description -->
                        @if($item->description)
                            <div class="px-4 py-3 bg-gray-50 dark:bg-gray-700">
                                <p class="text-sm text-gray-700 dark:text-gray-300 leading-relaxed line-clamp-3">
                                    {{ $item->description }}
                                </p>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-12">
                <div class="bg-gray-100 dark:bg-gray-800 rounded-lg p-8">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-white">No videos available</h3>
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                        No video content has been added yet.
                    </p>
                </div>
            </div>
        @endif
    </div>
</div>
