<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-black dark:text-gray-300 leading-tight">
            Feature Material Details
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class="mb-6">
                    <h3 class="text-2xl font-bold mb-2">{{ $featureMaterial->name }}</h3>
                    <p class="mb-2 text-gray-700 dark:text-gray-200">{{ $featureMaterial->description }}</p>
                    <p class="mb-2 text-sm text-gray-600 dark:text-gray-300"><b>Type:</b> {{ ucfirst($featureMaterial->type) }}</p>
                    <p class="mb-2 text-sm text-gray-600 dark:text-gray-300"><b>URL:</b> {{ $featureMaterial->url }}</p>
                    @if($featureMaterial->file)
                        <div class="mb-2">
                            <b>File:</b>
                            @if($featureMaterial->type === 'image')
                                <img src="{{ asset('storage/' . $featureMaterial->file) }}" alt="Image" class="max-w-xs mt-2 rounded shadow">
                            @elseif($featureMaterial->type === 'pdf')
                                <a href="{{ asset('storage/' . $featureMaterial->file) }}" target="_blank" class="underline text-blue-600">View PDF</a>
                            @else
                                <a href="{{ asset('storage/' . $featureMaterial->file) }}" download class="underline text-blue-600">Download File</a>
                            @endif
                        </div>
                    @endif
                    <p class="mb-2 text-sm text-gray-600 dark:text-gray-300"><b>Hidden:</b> {{ $featureMaterial->hidden ? 'Yes' : 'No' }}</p>
                </div>
                <div class="flex justify-end space-x-2">
                    <a href="{{ route('admin.feature.index') }}" class="bg-gray-400 text-white px-4 py-2 rounded hover:bg-gray-500">Back</a>
                    <a href="{{ route('admin.feature.edit', $featureMaterial) }}" class="bg-yellow-600 text-white px-4 py-2 rounded hover:bg-yellow-700">Edit</a>
                    <form action="{{ route('admin.feature.destroy', $featureMaterial) }}" method="POST" onsubmit="return confirm('Are you sure?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 