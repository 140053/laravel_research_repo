<div class="bg-white p-6 rounded-xl shadow-lg border border-gray-100 dark:bg-gray-800 mb-8">
    <h2 class="text-xl font-semibold text-gray-900 mb-4 dark:text-gray-200">New Discoveries This Week</h2>
    <ul class="space-y-3">

        @php
            $isAdmin = auth()->check() && auth()->user()->hasRole('admin');
            $isGuest = auth()->guest();
            $dash = $isAdmin ? route('admin.index') : ($isGuest ? route('login') : route('dashboard'));
        @endphp
        @foreach ($papers as $paper)
            @php
               

                $titleLink = $isAdmin
                    ? route('admin.research.show', $paper->id)
                    : ($isGuest
                        ? route('login')
                        : route('dashboard.research.show', $paper->id));

                
            @endphp

            <li>
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
