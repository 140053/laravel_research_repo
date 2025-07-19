<x-home-layout>


    <!-- Page Title Section -->
    <section class="bg-gradient-to-r from-green-950 to-blue-900 py-12 px-4 sm:px-6 lg:px-8 text-center rounded-b-lg shadow-md lg:ml-60 lg:mr-60 ">
        <div class="max-w-3xl mx-auto">
            <h1 class="text-4xl sm:text-5xl font-extrabold text-white mb-4 leading-tight">
                Our Esteemed Authors
            </h1>
            <p class="text-lg text-indigo-100">
                Discover the brilliant minds contributing to our research repository.
            </p>
        </div>
    </section>


     <div class="container mx-auto px-4 py-8 max-w-4xl">
        <div class="shadow p-5 rounded-md bg-white dark:bg-gray-700">
            <div class="mb-6">
                <h1 class="text-2xl font-medium italic border-b-2 border-gray-900 dark:border-white dark:text-white pb-2 mb-4">
                    List of Authors
                </h1>

               <!-- Search Form -->
                    @auth
                        {{-- If user is logged in --}}
                        <form action="{{ auth()->user()->hasRole('admin') ? route('admin.research.index') : route('dashboard.research.index')}}" method="GET">
                            <div class="relative">
                                <input
                                    type="text"
                                    name="search"
                                    placeholder="Search authors..."
                                    class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-800 dark:border-gray-600 dark:text-white dark:placeholder-gray-400"
                                    value="{{ request('search') }}"
                                />
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                                </div>

                            </div>
                        </form>
                    @else
                        {{-- If user is NOT logged in (guest) --}}
                        <form action="{{ route('login') }}" method="GET"> {{-- Assuming 'research.index' is your public research page --}}
                            <div class="relative">
                                <input
                                    type="text"
                                    name="search"
                                    placeholder="Search authors..."
                                    class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-800 dark:border-gray-600 dark:text-white dark:placeholder-gray-400"
                                    value="{{ request('search') }}"
                                />
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                                </div>
                            </div>
                        </form>
                    @endauth
                    <!-- End Search Form -->
            </div>

           <ul role="list" class="divide-y divide-gray-100 dark:divide-gray-600" id="authorList">
                {{-- Loop through the prepared unique authors array --}}
                @forelse ($uniqueAuthors as $authorName)
                    <li class="flex justify-between gap-x-6 py-5">
                        <div class="flex min-w-0 gap-x-4 items-center">
                            {{-- Placeholder image: uses first letter of author's name --}}
                            @auth
                            <a href="{{  auth()->user()->hasRole('admin') ?  route('admin.research.index', ['search' => $authorName]) :  route('dashboard.research.index', ['search' => $authorName]) }}">
                                <div class="min-w-0 flex-auto">
                                    <p class="text-lg font-semibold text-gray-900 dark:text-white">{{ $authorName }}</p>

                                </div>
                            </a>
                            @endauth
                            @guest
                                <a href="{{ route('login') }}">
                                    <div class="min-w-0 flex-auto">
                                        <p class="text-lg font-semibold text-gray-900 dark:text-white">{{ $authorName }}</p>

                                    </div>
                                </a>
                            @endguest
                        </div>

                    </li>
                @empty
                    {{-- Message if no authors are found --}}
                    <li class="py-5 text-center text-gray-500 dark:text-gray-400">No authors found in the repository.</li>
                @endforelse
            </ul>
        </div>
    </div>

</x-home-layout>
