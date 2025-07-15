<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-black dark:text-gray-300 leading-tight">
            Import Research Papers
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-2xl mx-auto bg-white dark:bg-gray-800 rounded shadow p-6">
            @if (session('success'))
                <div class="bg-green-100 text-green-800 p-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('admin.research.import.process') }}" method="POST" enctype="multipart/form-data">

                @csrf

                <div class="mb-4">
                    <label class="block font-medium">Upload CSV File</label>
                    <input type="file" name="csv_file" required class="w-full p-2 border rounded" accept=".csv,.xlsx">
                </div>

                <button class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                    Import
                </button>
            </form>
        </div>
    </div>
</x-app-layout>
