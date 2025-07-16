<div class="bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-700 p-4 rounded mb-4 shadow">
    <div class="flex flex-wrap items-center gap-2 text-xs mb-2">
        <span class="bg-green-200 text-green-800 px-2 py-0.5 rounded">Publisher: {{ $paper->publisher }}</span>
        <span class="bg-blue-200 text-blue-800 px-2 py-0.5 rounded hidden">Date Uploaded: {{ $paper->created_at->format('F j, Y') }}</span>
        <span class="bg-gray-300 text-gray-800 px-2 py-0.5 rounded">Copyright: {{ $paper->year }}</span>
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

   
    
    <div x-data="{ open: false }" class="border rounded shadow mb-4">
        <button
            @click="open = !open"
            class="flex items-center justify-between w-full px-4 py-3 text-left  text-gray-700 bg-gray-100 hover:bg-gray-200"
        >
            <span>📂 Citation</span>
            <svg :class="{'rotate-180': open}" class="w-4 h-4 transform transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
            </svg>
        </button>
    
        <div x-show="open" x-transition class="px-4 py-3 text-gray-700 bg-white font-thin italic">
            {{$paper->citation}}
        </div>
    </div>
    
  
</div>
