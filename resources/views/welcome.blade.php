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
                <img src="{{ asset('img/cbsua-logo.png') }}" class="max-w-[155px] hidden sm:block " alt="cbsua" />
            </div>
            <h2 class="pt-5 text-white text-5xl font-bold mb-5 dark:text-gray-300">
                Explore Scholarly Works from Our Institution
            </h2>
            <p class="text-white text-2xl mb-6 dark:text-gray-300">
                Access theses, dissertations, and research projects from students and faculty.
            </p>

            <div class="relative max-w-2xl mx-auto">
                @auth
                    <form
                        action="{{ auth()->user()->hasRole('admin') ? route('admin.research.index') : route('dashboard.research.index') }}"
                        method="GET">
                        <input type="text" name="search"
                            placeholder="Search for insights, studies, topics, or keywords..."
                            class="w-full py-3 pl-5 pr-12 rounded-full shadow-lg focus:outline-none focus:ring-2 focus:ring-indigo-300 text-gray-800 text-lg">
                        <button class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-500 hover:text-indigo-700">
                            <!-- Search Icon -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </button>
                    </form>
                @endauth

                @guest
                    <a href="{{ route('login') }}"
                        class="w-full px-4 py-2 border rounded-lg shadow-sm text-white dark:bg-gray-700 dark:text-gray-300">
                        Login to Search for Content
                    </a>
                @endguest
            </div>

            <p class="text-sm text-indigo-200 mt-4">
                Try 'user pain points onboarding' or 'feature X usability'.
            </p>

            <!-- Constrained Logo Placement -->
            <div class="absolute right-4 top-4 ">
                <img src="{{ asset('img/pcard-logo.png') }}" class="max-w-[150px] hidden sm:block " alt="pcard" />
            </div>
        </section>


        @php
            $isAdmin = auth()->check() && auth()->user()->hasRole('admin');
            $isGuest = auth()->guest();

            $dash = $isAdmin ? route('admin.index') : ($isGuest ? route('login') : route('dashboard'));
        @endphp





        <!-- Main Content Area -->
        <main class="container mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                <!-- Quick Access & Trending Section -->
                <section class="lg:col-span-1 space-y-8">
                    <!-- Latest Insights Card -->
                    <div class="bg-white p-6 rounded-xl shadow-lg border border-gray-100 dark:bg-gray-800">
                        <h2 class="text-xl font-semibold text-gray-900 mb-4 dark:text-gray-200">New Discoveries This
                            Week</h2>
                        <ul class="space-y-3">
                            @foreach ($randomPapers as $paper)
                                <!-- Card -->
                                <li>

                                    @php

                                        $titleLink = $isAdmin
                                            ? route('admin.research.show', $paper->id)
                                            : ($isGuest
                                                ? route('login')
                                                : route('dashboard.research.show', $paper->id));
                                        $detailsLink = $isAdmin
                                            ? route('admin.research.show', $paper->id)
                                            : ($isGuest
                                                ? route('login')
                                                : route('dashboard.research.index'));

                                        $detailsText = $isGuest ? 'Login to View Details' : 'View Details';

                                    @endphp

                                    <a href="{{ $titleLink }}"
                                        class="block text-indigo-600 hover:text-indigo-800 font-medium dark:text-indigo-500">
                                        {{ $paper->title }}
                                    </a>

                                    <p class="text-sm text-gray-600 dark:text-gray-400">
                                        Authored by: {{ $paper->authors }} • {{ $paper->year }}
                                    </p>


                                </li>
                            @endforeach
                        </ul>
                        <a href="{{ $dash }}"
                            class="mt-6 inline-block text-indigo-700 hover:text-indigo-900 font-semibold transition-colors duration-200">
                            View More &rarr;
                        </a>
                    </div>

                    <!-- Most Popular Topics Card -->
                    <div class="bg-white p-6 rounded-xl shadow-lg border border-gray-100 dark:bg-gray-800">
                        <h2 class="text-xl font-semibold text-gray-900 mb-4 dark:text-gray-200">Research Categories</h2>
                        <div class="flex flex-wrap gap-2">
                            @foreach ($tag as $t)
                                @php

                                    $tag_link = $isAdmin
                                        ? route('admin.research.index', ['category' => $t->name])
                                        : ($isGuest
                                            ? route('login')
                                            : route('dashboard.research.index', ['category' => $t->name]));

                                @endphp
                                <a href="{{ $tag_link }}"
                                    class="bg-indigo-100 text-indigo-700 px-3 py-1 rounded-full text-sm font-medium hover:bg-indigo-200 transition-colors duration-200">#{{ $t->name }}</a>
                            @endforeach

                        </div>
                    </div>
                </section>

                <!-- Curated Collections / Key Areas Section -->
                <section class="lg:col-span-2">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6 dark:text-gray-200">Captured in Action</h2>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">

                        @foreach ($albums as $album)
                            @php
                                $album_link = $isAdmin
                                    ? route('admin.gallery.view', $album)
                                    : ($isGuest
                                        ? route('login')
                                        : route('dashboard.gallery.view', $album));
                            @endphp
                            <div
                                class="relative group rounded-lg overflow-hidden shadow-md hover:shadow-xl transition-shadow duration-300">
                                @if ($album->images->first())
                                    <img src="{{ $album->images->first()->image_path }}" alt="Album Image"
                                        class="w-full h-48 object-cover">
                                @else
                                    <div class="w-full h-48 bg-gray-200 flex items-center justify-center text-gray-500">
                                        No Image
                                    </div>
                                @endif

                                <div
                                    class="absolute inset-0 from-green-800 to-blue-800 bg-gradient-to-br bg-opacity-80 flex flex-col items-center justify-center text-center px-4 opacity-0 group-hover:opacity-100 transition-opacity duration-300 ">
                                    <a href="{{ $album_link }}">
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
            </div>

            <!-- Recent Studies / Projects Section (Full Width below the grid) -->
            <section class="mt-12">
                <h2 class="text-2xl font-bold text-gray-900 mb-6 dark:text-gray-200">Recent Research Studies</h2>
                <div class="space-y-6">
                    <!-- Study Entry 1 -->
                    @foreach ($papers as $paper)
                        @php
                            $titleLink = $isAdmin
                                ? route('admin.research.show', $paper->id)
                                : ($isGuest
                                    ? route('login')
                                    : route('dashboard.research.show', $paper->id));
                        @endphp
                        <div class="bg-white p-6 rounded-xl shadow-lg border border-gray-100 dark:bg-gray-800 ">
                            <h3 class="text-xl font-semibold text-gray-900 mb-2">
                                <a href="{{ $titleLink }}"
                                    class="hover:text-indigo-700 hover:text-4xl  transition-colors duration-1000 dark:text-gray-200">{{ $paper->title }}</a>
                            </h3>
                            <p class="text-gray-600 text-sm mb-3 dark:text-gray-200">
                                Researcher: <span class="font-medium"> {{ $paper->authors }} </span> | Year:
                                {{ $paper->year }}
                            </p>
                            <p class="text-gray-700 mb-4 dark:text-gray-200">
                                {{ \Illuminate\Support\Str::limit($paper->abstract, 250, '...') }}

                            </p>

                            <div class="flex flex-wrap gap-2">
                                @if ($paper->tags->isNotEmpty())
                                    @foreach ($paper->tags as $tg)
                                        @php

                                            $tag_links = $isAdmin
                                                ? route('admin.research.index', ['category' => $tg->name])
                                                : ($isGuest
                                                    ? route('login')
                                                    : route('dashboard.research.index', ['category' => $tg->name]));

                                        @endphp

                                        <a href="{{ $tag_links }}">
                                            <span
                                                class="bg-blue-100 text-blue-700 px-2 py-0.5 rounded-full text-xs font-medium">
                                                #{{ $tg->name }}
                                            </span>
                                        </a>
                                    @endforeach
                                @else
                                    <p class="text-gray-400">No tags provided.</p>
                                @endif
                            </div>
                        </div>
                    @endforeach


                </div>
                <div class="text-center mt-8">
                    <a href="{{ $dash }}"
                        class="inline-block bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 px-6 rounded-full shadow-md transition-colors duration-200">
                        View All Studies
                    </a>
                </div>
            </section>
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
