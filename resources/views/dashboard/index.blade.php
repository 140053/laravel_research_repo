<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

           

            {{-- ✅ Filter Form --}}
            <div class="bg-white dark:bg-gray-800 p-4 rounded-md shadow-md">
                <h3 class="text-lg font-semibold mb-4 text-center md:text-left">Filter Research Papers</h3>

                <form method="GET" action="{{ route('dashboard.research.index') }}"
                    class="flex flex-col md:flex-row md:items-end md:justify-between gap-4 w-full">
                    
                    {{-- Input --}}
                    <div class="flex-1">
                        <label class="block text-sm font-medium mb-1 text-gray-700 dark:text-gray-300">Keyword</label>
                        <input type="text" name="search" value="{{ request('search') }}"
                            class="border rounded px-3 py-2 w-full focus:ring-2 focus:ring-blue-500 focus:outline-none">
                    </div>

                    {{-- Buttons --}}
                    <div class="flex flex-col md:flex-row items-center gap-2 md:gap-3">
                        <button type="submit"
                                class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 w-full md:w-auto">
                            Filter
                        </button>
                        <a href="{{ route('dashboard.research.index') }}"
                        class="text-gray-600 dark:text-gray-300 underline text-sm w-full text-center md:w-auto">
                            Reset
                        </a>
                    </div>
                </form>
            </div>


            

            {{-- ✅ Table with Card and Actions --}}
            <div class="bg-white dark:bg-gray-800 rounded border shadow-md overflow-x-auto">
                <table class="w-full text-left border-collapse ">
                    <thead>
                        <tr class="bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-200">
                            <th class="p-4 text-sm font-semibold">Research Details</th>
                           
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($papers as $paper)
                            <tr class="">
                                <td class="p-4 align-top w-full">
                                    <x-research-card :paper="$paper" />
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
