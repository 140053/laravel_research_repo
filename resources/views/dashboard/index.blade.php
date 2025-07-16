<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

           

            {{-- ✅ Filter Form --}}
            <div class="bg-white dark:bg-gray-800 p-4 rounded-md  shadow-md">
                <h3 class="text-lg font-semibold mb-4">Filter Research Papers</h3>
                <form method="GET" action="{{ route('dashboard.research.index') }}" class="flex flex-wrap gap-4 items-end justify-center">
                    <div>
                        <label class="block text-sm font-medium">Keyword</label>
                        <input type="text" name="search" value="{{ request('search') }}" class="border rounded px-3 py-2 lg:w-[550px] sm:w-3/4 md:w-auto ">
                    </div>
                    <div>
                        <label class="block text-sm font-medium">Year</label>
                        <input type="number" name="year" value="{{ request('year') }}" class="border rounded px-3 py-2 w-32">
                    </div>
                    <div>
                        <label class="block text-sm font-medium">Department</label>
                        <input type="text" name="department" value="{{ request('department') }}" class="border rounded px-3 py-2 w-64">
                    </div>
                    <div>
                        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                            Filter
                        </button>
                        <a href="{{ route('dashboard.research.index') }}" class="ml-2 text-gray-500 underline">Reset</a>
                    </div>
                </form>
            </div>

            

            {{-- ✅ Table with Card and Actions --}}
            <div class="bg-white dark:bg-gray-800 rounded shadow-md overflow-x-auto">
                <table class="w-full text-left border-collapse">
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
