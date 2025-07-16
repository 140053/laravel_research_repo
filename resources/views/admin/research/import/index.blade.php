<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-black dark:text-gray-300 leading-tight">
            Import Research Papers
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-6xl mx-auto bg-white dark:bg-gray-800 rounded shadow p-6">
            @if (session('success'))
                <div class="bg-green-100 text-green-800 p-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            {{-- <form action="{{ route('admin.research.import.process') }}" method="POST" enctype="multipart/form-data"> --}}
            <form action="{{ route('admin.research.import.preview') }}" method="POST" enctype="multipart/form-data">

                @csrf
                <h1>
                    <span class="text-2xl font-bold">Import Research Papers</span>
                    
                </h1>
                <p class="text-gray-600 mb-4">
                    Upload a CSV or Excel file containing research papers to import them into the system.   
                </p>

                <div class="mb-4">
                    <label class="block font-medium">Upload CSV File</label>
                    <input type="file" name="csv_file" required class="w-full p-2 border rounded" accept=".csv,.xlsx">
                </div>

                <div class="flex justify-end gap-4">
                    <button type="reset" class="bg-gray-300 text-gray-800 px-4 py-2 rounded hover:bg-gray-400 transition">
                        Reset
                    </button>
            
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
                        Preview
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
