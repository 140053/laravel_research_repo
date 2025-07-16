<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-black dark:text-gray-300 leading-tight">
            Edit Research Paper
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                @if ($errors->any())
                    <div class="bg-red-100 text-red-600 p-4 rounded mb-4">
                        <ul class="list-disc pl-5">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('admin.research.update', $paper->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    @method('PUT')

                    @include('admin.research.form', ['paper' => $paper])

                   
                    <div class="grid grid-cols-2 gap-5">
                        <button onclick="window.history.back()" class=" bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600 text-center w-full">
                            Cancel
                        </button>
                         <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 w-full">
                             Update
                         </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
