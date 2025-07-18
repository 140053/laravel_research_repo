<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-black dark:text-gray-300 leading-tight">
            Create New User
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg p-6">

                <form action="{{ route('admin.users.store') }}" method="POST">
                    @csrf

                    <div class="mb-4">
                        <label for="name" class="block font-semibold text-sm mb-1">Name</label>
                        <input type="text" name="name" id="name" required
                               value="{{ old('name') }}"
                               class="w-full border-gray-300 rounded px-3 py-2">
                        @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-4">
                        <label for="email" class="block font-semibold text-sm mb-1">Email</label>
                        <input type="email" name="email" id="email" required
                               value="{{ old('email') }}"
                               class="w-full border-gray-300 rounded px-3 py-2">
                        @error('email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-6">
                        <label for="password" class="block font-semibold text-sm mb-1">Password</label>
                        <input type="password" name="password" id="password" required
                               class="w-full border-gray-300 rounded px-3 py-2">
                        @error('password') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div class="flex justify-end space-x-2">
                        <a href="{{ route('admin.users.index') }}"
                           class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300 text-gray-700">Cancel</a>
                        <button type="submit"
                                class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">Create</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
