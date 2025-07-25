{{-- In resources/views/components/research-paper-view.blade.php --}}
<div class="py-10">

    <div class="max-w-6xl mx-auto bg-white dark:bg-gray-800 rounded-xl shadow-md p-8 space-y-6">
        <div class="">

            <a href="{{ auth()->user()->hasRole('admin') ? route('admin.research.index') : route('dashboard.research.index') }}"
                class="inline-flex items-center text-blue-600 hover:underline text-sm">
                ← Back to list
            </a>
        </div>

        <div class="flex  flex-col gap-2">
            <div class=" p-2">
                <div class="flex flex-row justify-between ">
                    <div>
                        <x-detail label="Title" lclass="text-3xl sm:text-md dark:text-gray-300" :value="$paper->title" />
                        <x-detail label="Authors" lclass="text-2xl sm:text-md dark:text-gray-300" :value="$paper->authors" />

                        @if ($paper->editors)
                            <x-detail label="Editors" lclass="dark:text-gray-300" :value="$paper->editors" />
                        @endif

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-5 ">
                            <x-detail label="Material Type" lclass="dark:text-gray-300" :value="$paper->tm" />

                            <x-detail label="Type" lclass="dark:text-gray-300" :value="$paper->type" />

                            @if ($paper->publisher)
                                <x-detail label="Publisher" lclass="dark:text-gray-300" :value="$paper->publisher" />
                            @endif

                            @if ($paper->isbn)
                                <x-detail label="ISBN" lclass="dark:text-gray-300" :value="$paper->isbn" />
                            @endif

                            <x-detail label="Year" lclass="dark:text-gray-300" :value="$paper->year" />

                        </div>
                    </div>



                    @if ($paper->pdf_path)
                        <div class=" w-[350px]  max-w-sm mx-auto flex flex-col justify-center">
                           
                            <x-pdf-thumbnail src="{{ asset($paper->pdf_path) }}" id="thumbnail-{{ $paper->id }}" />
                            <a href="{{ auth()->user()->hasRole('admin') ? route('admin.research.fulltext.index', $paper->id) : route('dashboard.research.fulltext.index', $paper->id) }}" class="bg-green-600 text-white text-center px-4 py-2 rounded hover:bg-green-700 w-full">View Full text</a>
                        </div>

                    @endif




                </div>

            </div>

            @if ($paper->keyword)
                <x-detail label="Keywords" lclass="italic dark:text-gray-300" :value="$paper->keyword" />
            @endif

            <div>
                <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 uppercase ">Abstract</h3>
                <p class="text-gray-800 dark:text-gray-300 whitespace-pre-line mt-1 justify-normal">
                    {{ $paper->abstract }}</p>
            </div>



            <div class="md:col-span-2 ">
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
                <x-accordion-basic label="Citation" content="{{ $paper->citation }}" />
            @endif

            @if ($paper->external_link)
                <x-accordion-with-link label="External Link" content='Click here to view ' link="{{ $paper->external_link }}" />
            @endif

            @if ($paper->pdf_path)
                <div class="md:col-span-2 hidden">
                    <x-detail label="PDF File">
                        <a href="{{ Storage::url($paper->pdf_path) }}" target="_blank"
                            class="text-blue-600 hover:underline">
                            View PDF
                        </a>
                    </x-detail>
                </div>
            @endif
        </div>




    </div>
</div>
