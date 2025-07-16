<div class="bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-700 p-4 rounded mb-4 shadow">
    <div class="flex flex-wrap items-center gap-2 text-xs mb-2">
        <span class="bg-green-200 text-green-800 px-2 py-0.5 rounded dark:bg-green-800 dark:text-green-200">Publisher: {{ $paper->publisher }}</span>
        <span class="bg-blue-200 text-blue-800 px-2 py-0.5 rounded hidden">Date Uploaded: {{ $paper->created_at->format('F j, Y') }}</span>
        <span class="bg-gray-300 text-gray-800 px-2 py-0.5 rounded dark:bg-gray-800 dark:text-gray-300">Copyright: {{ $paper->year }}</span>
    </div>

   
    <div class="border rounded shadow  p-2">
        <h2 class=" text-2xl font-bold text-blue-700 mb-1">
            <a href="{{ auth()->user()->hasRole('admin') ? route('admin.research.show', $paper->id) : route('dashboard.research.show', $paper->id) }}" class="hover:underline">
                {{ strtoupper($paper->title) }}
            </a>            
        </h2>
    
        <p class="text-gray-700 dark:text-gray-300 font-bold ">
            {{ $paper->authors }} ({{ $paper->department }})
        </p>
    
        <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
            {{ \Illuminate\Support\Str::limit($paper->abstract, 250, '...') }}
            <a href="{{ auth()->user()->hasRole('admin') ? route('admin.research.show', $paper->id) : route('dashboard.research.show', $paper->id) }}" class="text-blue-600 hover:underline">Read more..</a>
        </p>

    </div>
    <div class="flex flex-wrap items-center gap-2 text-xs m-2">
        <span class="bg-blue-200 text-blue-800 px-2 py-0.5 rounded"> {{ $paper->external_link ? 'Has Link' : 'No Link' }}</span>
        <span class="bg-blue-200 text-blue-800 px-2 py-0.5 rounded "> {{ $paper->pdf_path ? "With PDf" : " No PDF" }}</span>
        
    </div>


    <x-accordion-basic label="Citation" content="{{ $paper->citation }}" />

</div>
