<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-black dark:text-gray-300 leading-tight">
            Research Paper Details
        </h2>
    </x-slot>

         
     <x-pdf-viewer-turn src={{ Storage::url($paper->pdf_path)  }} />

    

</x-app-layout>
