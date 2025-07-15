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

            {{-- ✅ Filter Form --}}
            <div class="bg-white dark:bg-gray-800 p-4 rounded shadow">
                <form method="GET" action="{{ route('admin.research.index') }}" class="flex flex-wrap gap-4 items-end">
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
                        <a href="{{ route('admin.research.index') }}" class="ml-2 text-gray-500 underline">Reset</a>
                    </div>
                </form>
            </div>

            {{-- ✅ Add New Button --}}
            <div>
                <a href="{{ route('admin.research.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                    + Add New Research
                </a>
            </div>

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
                                <td class="p-4 align-top w-full">
                                    <x-research-card :paper="$paper" />
                                </td>
                                <td class="p-4 align-center text-center whitespace-nowrap  ">
                                    <div class="bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-700 p-4 rounded mb-4 shadow">
                                        <a href="{{ route('admin.research.show', $paper->id) }}" class="text-blue-600 hover:underline block mb-1">View</a>
                                        <a href="{{ route('admin.research.edit', $paper->id) }}" class="text-yellow-600 hover:underline block mb-1">Edit</a>
                                        <form action="{{ route('admin.research.destroy', $paper->id) }}" method="POST" onsubmit="return confirm('Delete this research paper?')" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:underline block">Delete</button>
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
