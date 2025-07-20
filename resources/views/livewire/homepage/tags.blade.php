<div class="bg-white p-6 rounded-xl shadow-lg border border-gray-100 dark:bg-gray-800">
    <h2 class="text-xl font-semibold text-gray-900 mb-4 dark:text-gray-200">Research Categories</h2>
    <div class="flex flex-wrap gap-2">
        @php
            $isAdmin = auth()->check() && auth()->user()->hasRole('admin');
            $isGuest = auth()->guest();
        @endphp

        @foreach ($tags as $t)
            @php
                $tag_link = $isAdmin
                    ? route('admin.research.index', ['category' => $t->name])
                    : ($isGuest
                        ? route('login')
                        : route('dashboard.research.index', ['category' => $t->name]));
            @endphp
            <a href="{{ $tag_link }}"
               class="bg-indigo-100 text-indigo-700 px-3 py-1 rounded-full text-sm font-medium hover:bg-indigo-200 transition-colors duration-200">
                #{{ $t->name }}
            </a>
        @endforeach
    </div>
</div>
