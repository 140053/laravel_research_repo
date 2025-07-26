<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-black dark:text-gray-300 leading-tight">
            Admin Dashboard - Feature Materials
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="flex justify-end mb-4">
                <a href="{{ route('admin.feature.create') }}"
                   class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                    + Create New Feature Material
                </a>
            </div>

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-semibold mb-4">Feature Materials</h3>

                    <ul class="space-y-4">
                        @forelse ($materials as $material)
                            <li class="p-4 bg-gray-100 dark:bg-gray-700 rounded shadow-sm flex justify-between items-center">
                                <div>
                                    <p class="font-bold">{{ $material->name }}</p>
                                    <p class="text-sm text-gray-600 dark:text-gray-300 truncate max-w-xs">{{ $material->description }}</p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">Type: {{ ucfirst($material->type) }} | Hidden: {{ $material->hidden ? 'Yes' : 'No' }}</p>
                                </div>
                                <div class="flex space-x-2">
                                    <!-- View -->
                                    <a href="{{ route('admin.feature.show', $material) }}"
                                       class="text-blue-600 hover:underline">View</a>
                                    <!-- Edit -->
                                    <a href="{{ route('admin.feature.edit', $material) }}"
                                       class="text-yellow-500 hover:underline">Edit</a>
                                    <!-- Delete -->
                                    <form action="{{ route('admin.feature.destroy', $material) }}" method="POST"
                                          onsubmit="return confirm('Are you sure?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:underline">Delete</button>
                                    </form>
                                </div>
                            </li>
                        @empty
                            <li class="text-gray-600">No feature materials found.</li>
                        @endforelse
                    </ul>
                    <div class="mt-6">
                        {{ $materials->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
