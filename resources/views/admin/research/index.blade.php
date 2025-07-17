<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-black dark:text-gray-300 leading-tight">
            Research Papers
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- ✅ Success Message --}}
            @if (session('success'))
                <div class="bg-green-100 text-green-800 p-4 rounded">
                    {{ session('success') }}
                </div>
            @endif


            @if($keyword)
                <div class="bg-green-100 text-green-800 p-4 rounded ">
                    Filter by : <span class=" font-extrabold">{{ $keyword }} !</span>
                </div>
            @endif

          
            <x-filter-form link="{{ route('admin.research.index') }}" />

            {{-- ✅ Add New Button --}}
            <div class="">
                <a href="{{ route('admin.research.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 m-5 ">
                    + Add New Research
                </a>
                <a href="{{ route('admin.research.import.index') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Import CSV</a>
            </div>

            {{-- ✅ Table with Card and Actions --}}
            {{-- ✅ Table with Card and Actions --}}
<div class="bg-white dark:bg-gray-800 rounded shadow overflow-x-auto">
    <table class="w-full text-left border-collapse">
        <thead>
            <tr class="bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-200">
                <th class="p-4 text-sm font-semibold">Research Details</th>
                <th class="p-4 text-sm font-semibold text-center">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($papers as $paper)
                <tr class="border-b dark:border-gray-700">
                    {{-- ✅ Research Card Column --}}
                    <td class="p-4 align-top w-full">
                        <x-research-card :paper="$paper" />
                    </td>

                    {{-- ✅ Actions Column --}}
                    <td class="p-4 align-top text-center w-[220px]">
                        <div class="flex flex-col gap-2 items-center justify-center">
                    
                            {{-- View --}}
                            <a href="{{ route('admin.research.show', $paper->id) }} "
                               class="hidden inline-flex items-center gap-2 px-3 py-1.5 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition text-sm w-full justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                                     stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12H9m12 0c0 4.418-4.03 8-9 8S3 16.418 3 12s4.03-8 9-8 9 3.582 9 8z" />
                                </svg>
                                View
                            </a>
                    
                            {{-- Edit --}}
                            <a href="{{ route('admin.research.edit', $paper->id) }}"
                               class="inline-flex items-center gap-2 px-3 py-1.5 bg-yellow-500 text-white rounded-md hover:bg-yellow-600 transition text-sm w-full justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                                     stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="M11 5h2m2 0h.01M12 7v14m0 0H5.4A1.4 1.4 0 014 19.6V7.4A1.4 1.4 0 015.4 6H12" />
                                </svg>
                                Edit
                            </a>
                    
                            {{-- Delete --}}
                            <form action="{{ route('admin.research.destroy', $paper->id) }}"
                                  method="POST"
                                  onsubmit="return confirm('Delete this research paper?')"
                                  class="w-full">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="inline-flex items-center gap-2 px-3 py-1.5 bg-red-600 text-white rounded-md hover:bg-red-700 transition text-sm w-full justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                                         stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                              d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                    Delete
                                </button>
                            </form>
                        </div>
                    </td>
                    
                </tr>
            @empty
                <tr>
                    <td colspan="2" class="text-center text-gray-500 py-6">
                        No research papers found.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>


            {{-- ✅ Pagination --}}
            <div class="mt-6">
                {{ $papers->withQueryString()->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
