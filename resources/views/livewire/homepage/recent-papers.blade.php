<section class="mt-12">
    <h2 class="text-2xl font-bold text-gray-900 mb-6 dark:text-gray-200">Recent Research Studies</h2>
    <div class="space-y-6">
        @php
            $isAdmin = auth()->check() && auth()->user()->hasRole('admin');
            $isGuest = auth()->guest();
        @endphp

        @foreach ($papers as $paper)
            @php
                $titleLink = $isAdmin
                    ? route('admin.research.show', $paper->id)
                    : ($isGuest
                        ? route('login')
                        : route('dashboard.research.show', $paper->id));
            @endphp

            <div class="bg-white p-6 rounded-xl shadow-lg border border-gray-100 dark:bg-gray-800">
                <h3 class="text-xl font-semibold text-gray-900 mb-2">
                    <a href="{{ $titleLink }}"
                       class="hover:text-indigo-700 hover:text-4xl transition-colors duration-1000 dark:text-gray-200">
                        {{ $paper->title }}
                    </a>
                </h3>
                <p class="text-gray-600 text-sm mb-3 dark:text-gray-200">
                    Researcher: <span class="font-medium">{{ $paper->authors }}</span> | Year: {{ $paper->year }}
                </p>
                <p class="text-gray-700 mb-4 dark:text-gray-200">
                    {{ \Illuminate\Support\Str::limit($paper->abstract, 250, '...') }}
                </p>

                <div class="flex flex-wrap gap-2">
                    @if ($paper->tags->isNotEmpty())
                        @foreach ($paper->tags as $tg)
                            @php
                                $tag_link = $isAdmin
                                    ? route('admin.research.index', ['category' => $tg->name])
                                    : ($isGuest
                                        ? route('login')
                                        : route('dashboard.research.index', ['category' => $tg->name]));
                            @endphp
                            <a href="{{ $tag_link }}">
                                <span class="bg-blue-100 text-blue-700 px-2 py-0.5 rounded-full text-xs font-medium">
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
        <a href="{{ $isAdmin ? route('admin.index') : ($isGuest ? route('login') : route('dashboard')) }}"
           class="inline-block bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 px-6 rounded-full shadow-md transition-colors duration-200">
            View All Studies
        </a>
    </div>

    <div class="mt-6 hidden ">
        {{ $papers->links() }}
    </div>
</section>
