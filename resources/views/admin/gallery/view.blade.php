<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-bold"> Album: {{ $album->name }}</h2>

    </x-slot>


    <livewire:album-carousel :album="$album" />


 {{-- 

    <div class="container mx-auto px-5 sm:px-6 lg:px-8 py-12 mb-5">
        <div x-data="carousel()" x-init="init()" class="relative w-full  overflow-hidden rounded-lg">
        <!-- Slides -->


        <div class=" relative  h-[300px] md:h-[450px] lg:h-[650px] border shadow-lg rounded-lg">
            <template x-for="(slide, index) in slides" :key="index">
                <div x-show="current === index" x-transition:enter="transition-opacity duration-700"
                    x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                    class="absolute inset-0 w-full h-full flex items-center justify-center">
                    <img :src="slide" class=" object-contain w-full h-full rounded-lg" alt="">
                
                    <div class="absolute bottom-0 left-0 w-full bg-black bg-opacity-50 text-white text-lg p-4">
                        <p x-text="captions[index]"></p>
                    </div>
                
                </div>
            </template>
        </div>

        <!-- Indicators -->
        <div class="absolute bottom-4 left-1/2 transform -translate-x-1/2 z-30 flex space-x-3">
            <template x-for="(slide, index) in slides" :key="'indicator-' + index">
                <button @click="goTo(index)" :class="{ 'bg-white': current === index, 'bg-gray-400': current !== index }"
                    class="w-3 h-3 rounded-full" aria-label="Slide indicator"></button>
            </template>
        </div>

        <!-- Controls -->
        <button @click="prev" class="absolute top-0 left-0 z-30 h-full px-4 flex items-center">
            <span class="w-10 h-10 bg-gray-500/30 hover:bg-green-500/50 rounded-full flex items-center justify-center">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="2"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                </svg>
            </span>
        </button>
        <button @click="next" class="absolute top-0 right-0 z-30 h-full px-4 flex items-center">
            <span class="w-10 h-10 bg-gray-500/30 hover:bg-green-500/50 rounded-full flex items-center justify-center">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="2"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                </svg>
            </span>
        </button>
    </div>

    <div class="mt-2 font-medium justify-around">
        {{ $album->description }}
    </div>

    </div>

    

    <script>
        function carousel() {
            return {
                current: 0,
                slides: [
                    @foreach ($album->Images as $al)
                        '{{ Storage::disk('public')->url($al->image_path) }}',
                    @endforeach                   
                ],
                captions: [
                     @foreach ($album->Images as $al)
                        '{{ $al->caption }}',
                     @endforeach 
                ],
                init() {
                    this.autoSlide();
                },
                next() {
                    this.current = (this.current + 1) % this.slides.length;
                },
                prev() {
                    this.current = (this.current - 1 + this.slides.length) % this.slides.length;
                },
                goTo(index) {
                    this.current = index;
                },
                autoSlide() {
                    setInterval(() => {
                        this.next();
                    }, 5000); // 5 seconds
                }
            }
        }
    </script>

    --}}

</x-app-layout>
