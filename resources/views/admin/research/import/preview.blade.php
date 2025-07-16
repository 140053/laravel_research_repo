<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-black dark:text-gray-300">Preview Import</h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto bg-white dark:bg-gray-800 rounded shadow p-6 space-y-6">
            <h3 class="font-semibold text-lg">Review the data before importing</h3>

            <div class="overflow-auto max-h-[600px]">
                <table class="table-auto w-full border-collapse border text-sm">
                    <thead>
                        <tr class="bg-gray-100 text-left sticky top-0">
                            @foreach($rows->first() as $key => $value)
                                <th class="border px-4 py-2 font-semibold uppercase text-xs tracking-wider">
                                    {{ $key }}
                                </th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($rows as $row)
                            <tr class="border-t hover:bg-gray-50 dark:hover:bg-gray-700">
                                @foreach($row as $columnKey => $cell)
                                    <td class="px-4 py-2 border text-wrap max-w-xs truncate" title="{{ $cell }}">
                                        @if (strtolower($columnKey) === 'abstract')
                                            {{ \Illuminate\Support\Str::limit($cell, 100) }}
                                        @else
                                            {{ $cell }}
                                        @endif
                                    </td>
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <form action="{{ route('admin.research.import.process') }}" method="POST">
                @csrf
                <input type="hidden" name="file" value="{{ $file }}">

                <div class="flex justify-end gap-4 mt-4">
                    <a href="{{ route('admin.research.import.index') }}" class="text-gray-600 underline">Cancel</a>
                    <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                        Confirm & Import
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
