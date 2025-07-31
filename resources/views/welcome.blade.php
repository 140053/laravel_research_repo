<x-home-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">

        </h2>
    </x-slot>

    <div class="">
        <!-- Hero Section -->
        <section
            class="relative bg-gradient-to-r from-green-950 to-blue-900 py-16 px-5 sm:px-6 lg:px-8 rounded-b-lg shadow-md dark:bg-gray-800 text-center rounded-md overflow-hidden">
            <div class="absolute left-4 top-4 ">
                <img src="{{ asset('img/cbsua-logo.webp') }}" width="155" height="auto" loading="lazy" class="max-w-[155px] hidden sm:block" alt="CBSUA Logo" />
            </div>
            <h2 class="pt-5 text-white text-5xl font-bold mb-5 dark:text-gray-300">
                Explore Scholarly Works from Our Institution
            </h2>
            <p class="text-white text-2xl mb-6 dark:text-gray-300">
                Access theses, dissertations, and research projects from students and faculty.
            </p>

           <!-- 🔍 Search Section -->
            <livewire:homepage.search-bar />

            <p class="text-sm text-indigo-200 mt-4">
                Try 'taro' or 'crops'.
            </p>

            <!-- Constrained Logo Placement -->
            <div class="absolute right-4 top-4 ">
                <img src="{{ asset('img/pcard-logo.webp') }}" width="150" height="auto" loading="lazy" class="max-w-[150px] hidden sm:block" alt="PCAARRD Logo" />
            </div>
        </section>

        @php
            $isAdmin = auth()->check() && auth()->user()->hasRole('admin');
            $isGuest = auth()->guest();

        @endphp


        <!-- Main Content Area -->
        <main class="container mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                <!-- Quick Access & Trending Section -->
                <section class="lg:col-span-1 space-y-8">
                  
                    <!-- 🧠 New Discoveries -->
                    <div wire:loading><div class="animate-pulse h-24 bg-gray-200 rounded mb-4"></div></div>
                    <livewire:homepage.random-papers lazy />

                    <!-- Most Popular Topics Card -->
                    <div wire:loading><div class="animate-pulse h-12 bg-gray-200 rounded mb-4"></div></div>
                   <!-- 🏷️ Tags -->
                    <livewire:homepage.tags lazy />
                </section>

                <!-- Curated Collections / Key Areas Section -->
                <div wire:loading><div class="animate-pulse h-24 bg-gray-200 rounded mb-4"></div></div>
                 <livewire:homepage.albums-comp lazy />
            </div>

            <!-- Recent Studies / Projects Section (Full Width below the grid) -->
            <div wire:loading><div class="animate-pulse h-24 bg-gray-200 rounded mb-4"></div></div>
           <!-- 📚 Recent Research Papers -->
            <livewire:homepage.recent-papers lazy />
        </main>





        <!-- About -->
        <section class="py-12 text-center">
            <div class="max-w-4xl mx-auto px-4">
                <h3 class="text-2xl font-semibold mb-4 dark:text-gray-200">About the {{ config('app.name') }}</h3>
                <p class="text-gray-700 text-lg dark:text-gray-200">This system provides a platform for storing,
                    archiving, and accessing research outputs from the university community. It encourages knowledge
                    sharing and research visibility.</p>
            </div>
        </section>
    </div>
</x-home-layout>
