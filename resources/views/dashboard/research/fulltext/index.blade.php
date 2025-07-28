<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-black dark:text-gray-300 leading-tight">
            {{ $paper->title }} - Full Text View
            <br>
            <span class="text-sm text-gray-500 dark:text-gray-400">{{ $paper->authors }} * {{ $paper->year }} </span>
            <span class="text-sm text-gray-500 dark:text-gray-400">({{ $paper->type }})</span>
            <br>
            <a href="/dashboard/research" class="text-blue-500 hover:underline">Back to Details</a>

        </h2>
    </x-slot>


    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8 flex justify-center items-center w-full  min-h-[calc(100vh-14rem)] ">
       
        @if($paper->type == 'Book')
            @if($device == 'desktop')
                    <x-pdf-viewer-turn src="{{ asset($paper->pdf_path) }}" :paper="$paper" />
            @endif
        @endif
       
        @if($paper->type != 'Book')
            @if($device == 'mobile' or $device == 'tablet')
                <x-mobile-pdf-viewer :src="asset($paper->pdf_path)" :paper="$paper" />
            @endif
            @if($device == 'desktop')
                <x-mobile-pdf-viewer :src="asset($paper->pdf_path)" :paper="$paper" />
            @endif
        @endif

    </div>

</x-app-layout>
