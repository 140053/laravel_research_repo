<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-black dark:text-gray-300 leading-tight">
            Pending Research Papers
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

            <x-filter-form link="{{ route('admin.research.index') }}" />

            {{-- ✅ Action Buttons --}}
            <div class="flex flex-wrap gap-4 ">
                <a href="{{ route('admin.research.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">+ Add New Research</a>
                <a href="{{ route('admin.csv-import.form') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Import CSV</a>
            </div>

            {{-- ✅ Bulk Actions --}}
            <form action="{{ route('admin.research.bulkAction') }}" method="POST">
                @csrf
                <div class="my-4 flex gap-3">
                    <button type="submit" name="action" value="approve" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">✔ Approve</button>
                    <button type="submit" name="action" value="reject" class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600">⚠ Reject</button>
                    <button type="submit" name="action" value="delete" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700" onclick="return confirm('Delete selected research papers?')">🗑 Delete</button>
                </div>

                {{-- ✅ Table --}}
                <div class="bg-white dark:bg-gray-800 rounded shadow overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-200">
                                <th class="p-4 text-sm font-semibold">
                                    <input type="checkbox" id="select-all" class="form-checkbox" />
                                </th>
                                <th class="p-4 text-sm font-semibold">Research Details</th>
                                <th class="p-4 text-sm font-semibold text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($papers as $paper)
                                <tr class="border-b dark:border-gray-700">
                                    <td class="p-4 align-top">
                                        <input type="checkbox" name="selected[]" value="{{ $paper->id }}" class="form-checkbox select-item">
                                    </td>

                                    {{-- ✅ Research Card --}}
                                    <td class="p-4 align-top w-full">
                                        <x-research-card :paper="$paper" />
                                    </td>

                                    {{-- ✅ Per-Item Actions --}}
                                    <td class="p-4 align-top text-center w-[220px]">
                                        <div class="flex flex-col gap-2 items-center justify-center">

                                            

                                            {{-- Edit --}}
                                            <a href="{{ route('admin.research.edit', $paper->id) }}" class="inline-flex items-center gap-2 px-3 py-1.5 bg-yellow-500 text-white rounded-md hover:bg-yellow-600 text-sm w-full justify-center">
                                                ✏ Edit
                                            </a>

                                            
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center text-gray-500 py-6">No research papers found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- ✅ Pagination --}}
                <div class="mt-6">
                    {{ $papers->withQueryString()->links() }}
                </div>
            </form>
        </div>
    </div>

    {{-- ✅ Select All Script --}}
    <script>
        document.getElementById('select-all').addEventListener('change', function () {
            const checked = this.checked;
            document.querySelectorAll('.select-item').forEach(cb => cb.checked = checked);
        });
    </script>
</x-app-layout>
