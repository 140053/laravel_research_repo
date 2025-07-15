<div class="bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-700 p-4 rounded mb-4 shadow">
    <div class="flex flex-wrap items-center gap-2 text-xs mb-2">
        <span class="bg-green-200 text-green-800 px-2 py-0.5 rounded">Library {{ $paper->department }}</span>
        <span class="bg-blue-200 text-blue-800 px-2 py-0.5 rounded">Date Uploaded: {{ $paper->created_at->format('F j, Y') }}</span>
        <span class="bg-gray-300 text-gray-800 px-2 py-0.5 rounded">Embargo [{{ $paper->tm === 'P' ? 'false' : 'true' }}]</span>
    </div>

    <h3 class="text-lg font-bold text-blue-700 mb-1">
        <a href="{{ route('admin.research.show', $paper->id) }}" class="hover:underline">
            {{ strtoupper($paper->title) }}
        </a>
    </h3>

    <p class="text-gray-700 dark:text-gray-300 font-medium">
        {{ $paper->authors }} ({{ $paper->department }})
    </p>

    <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
        {{ \Illuminate\Support\Str::limit($paper->abstract, 150, '...') }}
        <a href="{{ route('admin.research.show', $paper->id) }}" class="text-blue-600 hover:underline">Read more..</a>
    </p>
</div>
