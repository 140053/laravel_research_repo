<x-home-layout>
    <div class="">
        <!-- Hero Section -->
        <section class="bg-gradient-to-r from-green-950 to-blue-900 py-8 sm:py-12 px-4 sm:px-6 lg:px-8 text-center rounded-b-lg shadow-md lg:ml-60 lg:mr-60">
            <div class="max-w-3xl mx-auto">
                <div class="flex items-center justify-center mb-4">
                    <a href="{{ route('gallery') }}" 
                       class="text-white hover:text-indigo-200 transition-colors duration-200 mr-4 p-2 rounded-full hover:bg-white/10">
                        <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                        </svg>
                    </a>
                    <h1 class="text-2xl sm:text-3xl md:text-4xl lg:text-5xl font-extrabold text-white leading-tight">
                        {{ $album->name }}
                    </h1>
                </div>
                @if($album->description)
                    <p class="text-sm sm:text-base lg:text-lg text-indigo-100 px-4">
                        {{ $album->description }}
                    </p>
                @endif
            </div>
        </section>

        <!-- Album Content -->
        <section class="py-8 sm:py-12 px-4 sm:px-6 lg:px-8">
            <div class="max-w-7xl mx-auto">
                @if($album->images && $album->images->count() > 0)
                    <!-- Album Stats -->
                    <div class="mb-8 text-center">
                        <div class="inline-flex items-center space-x-4 bg-white dark:bg-gray-800 rounded-full px-6 py-3 shadow-lg">
                            <div class="flex items-center space-x-2">
                                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <span class="text-sm font-medium text-gray-700 dark:text-gray-300">
                                    {{ $album->images->count() }} {{ Str::plural('image', $album->images->count()) }}
                                </span>
                            </div>
                            <div class="w-px h-4 bg-gray-300 dark:bg-gray-600"></div>
                            <div class="flex items-center space-x-2">
                                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <span class="text-sm font-medium text-gray-700 dark:text-gray-300">
                                    {{ $album->created_at->diffForHumans() }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Image Grid -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4 sm:gap-6">
                        @foreach($album->images as $index => $image)
                            <div class="group relative bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-1"
                                 style="animation-delay: {{ $index * 0.1 }}s">
                                <!-- Image Container -->
                                <div class="aspect-square overflow-hidden relative">
                                    <img src="{{ asset('storage/' . $image->image_path) }}" 
                                         alt="{{ $image->caption ?? $album->name }}" 
                                         class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110"
                                         loading="lazy">
                                    
                                    <!-- Gradient Overlay -->
                                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                                    
                                    <!-- Caption Overlay -->
                                    @if($image->caption)
                                        <div class="absolute bottom-0 left-0 right-0 p-4 transform translate-y-full group-hover:translate-y-0 transition-transform duration-300">
                                            <p class="text-white text-sm font-medium leading-relaxed">
                                                {{ $image->caption }}
                                            </p>
                                        </div>
                                    @endif
                                    
                                    <!-- Action Buttons -->
                                    <div class="absolute top-3 right-3 flex space-x-2 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                        <!-- Full Screen Button -->
                                        <button onclick="openLightbox('{{ asset('storage/' . $image->image_path) }}', '{{ $image->caption ?? '' }}', {{ $loop->index }})"
                                                class="bg-black/70 hover:bg-black/90 text-white p-2 rounded-full transition-all duration-200 transform hover:scale-110">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4" />
                                            </svg>
                                        </button>
                                    </div>
                                    
                                    <!-- Image Number Badge -->
                                    <div class="absolute top-3 left-3 bg-black/70 text-white text-xs font-medium px-2 py-1 rounded-full">
                                        {{ $index + 1 }}
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Album Info Card -->
                    <div class="mt-12 hidden">
                        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl p-6 sm:p-8 max-w-3xl mx-auto">
                            <div class="text-center">
                                <h3 class="text-xl sm:text-2xl font-bold text-gray-900 dark:text-white mb-4">
                                    {{ $album->name }}
                                </h3>
                                @if($album->description)
                                    <p class="text-gray-600 dark:text-gray-300 leading-relaxed text-sm sm:text-base">
                                        {{ $album->description }}
                                    </p>
                                @endif
                                <div class="mt-6 flex flex-wrap justify-center gap-4 text-sm text-gray-500 dark:text-gray-400">
                                    <div class="flex items-center space-x-2">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        <span>{{ $album->images->count() }} {{ Str::plural('image', $album->images->count()) }}</span>
                                    </div>
                                    <div class="flex items-center space-x-2">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        <span>{{ $album->created_at->format('M d, Y') }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <!-- Empty State -->
                    <div class="text-center py-16">
                        <div class="bg-gray-100 dark:bg-gray-800 rounded-2xl p-8 sm:p-12 max-w-md mx-auto">
                            <div class="w-20 h-20 mx-auto mb-6 bg-gray-200 dark:bg-gray-700 rounded-full flex items-center justify-center">
                                <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">No Images Available</h3>
                            <p class="text-gray-500 dark:text-gray-400 text-sm">
                                This album doesn't contain any images yet.
                            </p>
                        </div>
                    </div>
                @endif
            </div>
        </section>
    </div>

    <!-- Enhanced Lightbox Modal -->
    <div id="lightbox" class="fixed inset-0 bg-black bg-opacity-95 z-50 hidden flex items-center justify-center p-4">
        <div class="relative max-w-5xl max-h-full w-full">
            <img id="lightbox-image" src="" alt="" class="max-w-full max-h-full object-contain mx-auto">
            <div id="lightbox-caption" class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/80 to-transparent p-6 text-center">
                <p class="text-white text-lg font-medium"></p>
            </div>
            
            <!-- Navigation Buttons -->
            <button id="lightbox-prev" onclick="navigateLightbox(-1)" 
                    class="absolute left-4 top-1/2 transform -translate-y-1/2 bg-black/50 hover:bg-black/70 text-white p-3 rounded-full transition-all duration-200 opacity-0 hover:opacity-100">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </button>
            
            <button id="lightbox-next" onclick="navigateLightbox(1)" 
                    class="absolute right-4 top-1/2 transform -translate-y-1/2 bg-black/50 hover:bg-black/70 text-white p-3 rounded-full transition-all duration-200 opacity-0 hover:opacity-100">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </button>
            
            <!-- Close Button -->
            <button onclick="closeLightbox()" 
                    class="absolute top-4 right-4 text-white hover:text-gray-300 transition-colors duration-200 bg-black/50 hover:bg-black/70 p-2 rounded-full">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
            
            <!-- Image Counter -->
            <div class="absolute top-4 left-4 bg-black/50 text-white px-3 py-1 rounded-full text-sm font-medium">
                <span id="lightbox-counter"></span>
            </div>
        </div>
    </div>

    <script>
        let currentImageIndex = 0;
        const images = @json($album->images);
        
        function openLightbox(imageSrc, caption, index = 0) {
            currentImageIndex = index;
            updateLightboxImage(imageSrc, caption);
            document.getElementById('lightbox').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
            updateLightboxCounter();
        }

        function updateLightboxImage(imageSrc, caption) {
            document.getElementById('lightbox-image').src = imageSrc;
            document.getElementById('lightbox-caption').querySelector('p').textContent = caption;
        }

        function updateLightboxCounter() {
            document.getElementById('lightbox-counter').textContent = `${currentImageIndex + 1} / ${images.length}`;
        }

        function navigateLightbox(direction) {
            const newIndex = (currentImageIndex + direction + images.length) % images.length;
            currentImageIndex = newIndex;
            
            const image = images[currentImageIndex];
            const imageSrc = `{{ asset('storage/') }}/${image.image_path}`;
            const caption = image.caption || '';
            
            updateLightboxImage(imageSrc, caption);
            updateLightboxCounter();
        }

        function closeLightbox() {
            document.getElementById('lightbox').classList.add('hidden');
            document.body.style.overflow = 'auto';
        }

        // Close lightbox when clicking outside the image
        document.getElementById('lightbox').addEventListener('click', function(e) {
            if (e.target === this) {
                closeLightbox();
            }
        });

        // Keyboard navigation
        document.addEventListener('keydown', function(e) {
            if (document.getElementById('lightbox').classList.contains('hidden')) return;
            
            switch(e.key) {
                case 'Escape':
                    closeLightbox();
                    break;
                case 'ArrowLeft':
                    navigateLightbox(-1);
                    break;
                case 'ArrowRight':
                    navigateLightbox(1);
                    break;
            }
        });

        // Touch/swipe support for mobile
        let touchStartX = 0;
        let touchEndX = 0;

        document.getElementById('lightbox').addEventListener('touchstart', function(e) {
            touchStartX = e.changedTouches[0].screenX;
        });

        document.getElementById('lightbox').addEventListener('touchend', function(e) {
            touchEndX = e.changedTouches[0].screenX;
            handleSwipe();
        });

        function handleSwipe() {
            const swipeThreshold = 50;
            const diff = touchStartX - touchEndX;
            
            if (Math.abs(diff) > swipeThreshold) {
                if (diff > 0) {
                    navigateLightbox(1); // Swipe left - next
                } else {
                    navigateLightbox(-1); // Swipe right - previous
                }
            }
        }

        // Add animation classes to grid items
        document.addEventListener('DOMContentLoaded', function() {
            const gridItems = document.querySelectorAll('.group');
            gridItems.forEach((item, index) => {
                item.style.animationDelay = `${index * 0.1}s`;
                item.classList.add('animate-fade-in-up');
            });
        });
    </script>

    <style>
        @keyframes fade-in-up {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .animate-fade-in-up {
            animation: fade-in-up 0.6s ease-out forwards;
        }
    </style>
</x-home-layout> 