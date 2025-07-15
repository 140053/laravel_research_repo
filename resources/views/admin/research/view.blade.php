<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-black dark:text-gray-300 leading-tight">
            Research Paper Details
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-4xl mx-auto bg-white dark:bg-gray-800 rounded-xl shadow-md p-8 space-y-6">

            {{-- Paper Details Grid --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-5">
                <div>
                    <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 uppercase">Title</h3>
                    <p class="text-lg font-semibold text-gray-800 dark:text-gray-200">{{ $paper->title }}</p>
                </div>

                <div>
                    <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 uppercase">Authors</h3>
                    <p class="text-gray-800 dark:text-gray-300">{{ $paper->authors }}</p>
                </div>

                @if ($paper->editors)
                    <div>
                        <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 uppercase">Editors</h3>
                        <p class="text-gray-800 dark:text-gray-300">{{ $paper->editors }}</p>
                    </div>
                @endif

                <div>
                    <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 uppercase">Thesis Mode</h3>
                    <p class="text-gray-800 dark:text-gray-300">{{ $paper->tm }}</p>
                </div>

                <div>
                    <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 uppercase">Type</h3>
                    <p class="text-gray-800 dark:text-gray-300">{{ $paper->type }}</p>
                </div>

                @if ($paper->publisher)
                    <div>
                        <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 uppercase">Publisher</h3>
                        <p class="text-gray-800 dark:text-gray-300">{{ $paper->publisher }}</p>
                    </div>
                @endif

                @if ($paper->isbn)
                    <div>
                        <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 uppercase">ISBN</h3>
                        <p class="text-gray-800 dark:text-gray-300">{{ $paper->isbn }}</p>
                    </div>
                @endif

                <div>
                    <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 uppercase">Year</h3>
                    <p class="text-gray-800 dark:text-gray-300">{{ $paper->year }}</p>
                </div>

                <div>
                    <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 uppercase">Department</h3>
                    <p class="text-gray-800 dark:text-gray-300">{{ $paper->department }}</p>
                </div>

                {{-- Keyword --}}
                @if ($paper->keyword)
                <div>
                    <h3 class="text-lg font-bold">Keywords</h3>
                    <p class="text-gray-800 dark:text-gray-300">{{ $paper->keyword }}</p>
                </div>
                @endif


                {{-- Tags --}}
                <div class="md:col-span-2">
                    <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 uppercase">Tags</h3>
                    @if ($paper->tags->isNotEmpty())
                        <div class="flex flex-wrap gap-2 mt-2">
                            @foreach ($paper->tags as $tag)
                                <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-sm">
                                    {{ $tag->name }}
                                </span>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-400">No tags provided.</p>
                    @endif
                </div>

                @if ($paper->citation)
                    <div>
                        <h3 class="text-lg font-bold">Citation</h3>
                        <p class="text-gray-800 dark:text-gray-300 whitespace-pre-line">{{ $paper->citation }}</p>
                    </div>
                @endif

                {{-- External Link --}}
                @if ($paper->external_link)
                    <div class="md:col-span-2">
                        <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 uppercase">External Link</h3>
                        <a href="{{ $paper->external_link }}" target="_blank" class="text-blue-600 hover:underline break-all">
                            {{ $paper->external_link }}
                        </a>
                    </div>
                @endif

                {{-- PDF Link --}}
                @if ($paper->pdf_path)
                    <div class="md:col-span-2">
                        <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 uppercase">PDF File</h3>
                        <a href="{{ Storage::url($paper->pdf_path) }}" target="_blank" class="text-blue-600 hover:underline">
                            View PDF
                        </a>
                    </div>
                @endif
            </div>

            {{-- Abstract Full Width --}}
            <div>
                <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 uppercase">Abstract</h3>
                <p class="text-gray-800 dark:text-gray-300 whitespace-pre-line mt-1">{{ $paper->abstract }}</p>
            </div>

            {{-- Back Button --}}
            <div class="pt-4">
                <a href="{{ route('admin.research.index') }}" class="inline-flex items-center text-blue-600 hover:underline text-sm">
                    ← Back to list
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
