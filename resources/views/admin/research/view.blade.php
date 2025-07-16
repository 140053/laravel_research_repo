<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-black dark:text-gray-300 leading-tight">
            Research Paper Details
        </h2>
    </x-slot>

    {{--<x-research-paper-view :paper="$paper" /> --}}

    <div>
        
        <x-pdf-flipbook :src="Storage::url($paper->pdf_path)" />

    </div>
</x-app-layout>
