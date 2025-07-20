<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-black dark:text-gray-300 leading-tight">
            {{ $paper->title }} - Full Text View
            <span class="text-sm text-gray-500 dark:text-gray-400">({{ $paper->type }})</span>
            <br>
            <a href="{{ route('admin.research.show', $paper->id) }}" class="text-blue-500 hover:underline">Back to Details</a>

        </h2>
    </x-slot>


    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8 flex justify-center items-center w-full  min-h-[calc(100vh-14rem)] ">

        {{$device }}
        @if($device == 'desktop')
                <x-pdf-viewer-turn src="{{ asset($paper->pdf_path) }}" :paper="$paper" />
        @endif

        @if($device == 'mobile' or $device == 'tablet')
                <x-mobile-pdf-viewer :src="asset($paper->pdf_path)" :paper="$paper" />
        @endif



    </div>

</x-app-layout>
