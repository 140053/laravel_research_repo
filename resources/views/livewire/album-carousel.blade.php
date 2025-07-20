<div class="container mx-auto px-5 sm:px-6 lg:px-8 py-12 mb-5">
    <h2 class="text-2xl font-bold mb-4">Album: {{ $album->name }}</h2>

    <div class="relative w-full overflow-hidden rounded-lg border shadow-lg h-[300px] md:h-[450px] lg:h-[650px]">
        @foreach ($album->Images as $index => $image)
            @if ($current === $index)
                <div class="absolute inset-0 w-full h-full flex items-center justify-center transition-opacity duration-700">
                    <img src="{{ asset($image->image_path) }}" alt="" class="object-contain w-full h-full rounded-lg" />
                    <div class="absolute bottom-0 left-0 w-full bg-black bg-opacity-50 text-white text-lg p-4">
                        {{ $image->caption }}
                    </div>
                </div>
            @endif
        @endforeach

        <!-- Controls -->
        <button wire:click="prev" class="absolute top-0 left-0 z-30 h-full px-4 flex items-center">
            <span class="w-10 h-10 bg-gray-500/30 hover:bg-green-500/50 rounded-full flex items-center justify-center">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                </svg>
            </span>
        </button>
        <button wire:click="next" class="absolute top-0 right-0 z-30 h-full px-4 flex items-center">
            <span class="w-10 h-10 bg-gray-500/30 hover:bg-green-500/50 rounded-full flex items-center justify-center">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                </svg>
            </span>
        </button>
    </div>

    <!-- Indicators -->
    <div class="mt-4 flex justify-center space-x-2">
        @foreach ($album->Images as $index => $image)
            <button wire:click="goTo({{ $index }})"
                class="w-3 h-3 rounded-full {{ $current === $index ? 'bg-white' : 'bg-gray-400' }}"></button>
        @endforeach
    </div>

    <div class="mt-5 font-medium">
        {{ $album->description }}
    </div>


    @push('scripts')
    <script>
        document.addEventListener('livewire:load', function () {
            setInterval(() => {
                Livewire.emit('autoSlide');
            }, 2000); // Slide every 5 seconds
        });
    </script>
    @endpush
</div>
