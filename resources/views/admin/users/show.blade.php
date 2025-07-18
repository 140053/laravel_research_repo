<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-black dark:text-gray-300 leading-tight">
            User Details: {{ $user->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg p-6 text-gray-800 dark:text-gray-100">

                <div class="mb-6">
                    <h3 class="text-lg font-semibold mb-2">Name:</h3>
                    <p>{{ $user->name }}</p>
                </div>

                <div class="mb-6">
                    <h3 class="text-lg font-semibold mb-2">Email:</h3>
                    <p>{{ $user->email }}</p>
                </div>

                <div class="mb-6">
                    <h3 class="text-lg font-semibold mb-2">Roles:</h3>
                    @forelse ($user->getRoleNames() as $role)
                        <span class="inline-block bg-indigo-100 text-indigo-800 text-xs px-2 py-1 rounded-full mr-2">
                            {{ $role }}
                        </span>
                    @empty
                        <span class="text-sm text-gray-500">No roles assigned</span>
                    @endforelse
                </div>

                <div class="mb-6">
                    <h3 class="text-lg font-semibold mb-2">Registered At:</h3>
                    <p>{{ $user->created_at->format('F j, Y, g:i a') }}</p>
                </div>

                <div class="flex justify-end space-x-2">
                    <a href="{{ route('admin.users.index') }}"
                       class="px-4 py-2 bg-gray-200 text-gray-700 rounded hover:bg-gray-300">Back</a>
                    <a href="{{ route('admin.users.edit', $user) }}"
                       class="px-4 py-2 bg-yellow-500 text-white rounded hover:bg-yellow-600">Edit</a>
                    <form action="{{ route('admin.users.destroy', $user) }}" method="POST"
                          onsubmit="return confirm('Are you sure you want to delete this user?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">
                            Delete
                        </button>
                    </form>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
