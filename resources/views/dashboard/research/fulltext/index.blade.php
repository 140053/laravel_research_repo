<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-black dark:text-gray-300 leading-tight">
            {{ $paper->title }} - Full Text View 
            <span class="text-sm text-gray-500 dark:text-gray-400">({{ $paper->type }})</span>
            <br>
            <a href="{{ auth()->user()->hasRole('admin') ? route('admin.research.show', $paper->id) : route('dashboard.research.show', $paper->id ) }}" class="text-blue-500 hover:underline">Back to Details</a>
        </h2>
    </x-slot>
     

    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8 flex justify-center items-center w-full">

         <x-pdf-viewer-turn src="{{ Storage::url($paper->pdf_path) }}" :paper="$paper" />
    </div>

</x-app-layout>
