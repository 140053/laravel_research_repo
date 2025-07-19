<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-black dark:text-gray-300 leading-tight">
            Admin Dashboard
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg dark:bg-gray-800">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    You're logged in as <strong>Admin</strong>!
                </div>
            </div>

            <div>
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mt-6">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <h3 class="text-lg font-semibold">Research Management</h3>
                        <ul class="mt-4 ">
                            <li class="p-4 shadow mb-2">
                                <a href="{{ route('admin.research.index') }}" class="text-blue-600 hover:underline flex justify-between">
                                    Manage Research
                                    <span class=" ml-3 inline-flex items-center rounded-md bg-green-50 px-2 py-1 text-xs font-medium text-green-700 ring-1 ring-green-600/20 ring-inset">{{ $approvedCount}}</span>
                                </a>
                            </li> 
                            <li class="p-4 shadow mb-2">
                                <a href="{{ route('admin.research.pending.index') }}" class="text-blue-600 hover:underline flex justify-between">
                                    Pending Research
                                    <span class=" ml-3 inline-flex items-center  rounded-md bg-red-50 px-2 py-1 text-xs font-medium text-red-700 ring-1 ring-red-600/10 ring-inset">{{ $pendingCount}}</span>
                                </a>
                            </li>   
                                                      
                            

                        </ul>
                    </div>

                    <div class="p-6 text-gray-900 dark:text-gray-100 hidden">
                        <h3 class="text-lg font-semibold">Article Management</h3>
                        <ul class="mt-4 ">
                            <li class="p-4 shadow mb-2">
                                <a href="{{ route('admin.articles.index') }}" class="text-blue-600 hover:underline flex justify-between">
                                    Manage Article
                                    <span class=" ml-3 inline-flex items-center rounded-md bg-green-50 px-2 py-1 text-xs font-medium text-green-700 ring-1 ring-green-600/20 ring-inset">0</span>
                                </a>
                            </li> 
                        </ul>
                    </div>

                    <div class="p-6 text-gray-900 dark:text-gray-100 ">
                        <h3 class="text-lg font-semibold">Gallery Management</h3>
                        <ul class="mt-4 ">
                            <li class="p-4 shadow mb-2">
                                <a href="{{ route('admin.gallery.index') }}" class="text-blue-600 hover:underline flex justify-between">
                                    Manage Album
                                    <span class=" ml-3 inline-flex items-center rounded-md bg-green-50 px-2 py-1 text-xs font-medium text-green-700 ring-1 ring-green-600/20 ring-inset">0</span>
                                </a>
                            </li> 
                        </ul>
                    </div>

                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <h3 class="text-lg font-semibold">User Management</h3>
                        <ul class="mt-4 ">
                            <li class="p-4 shadow mb-2">
                                <a href="{{ route('admin.users.index') }}" class="text-blue-600 hover:underline flex justify-between">
                                    Users
                                    <span class=" ml-3 inline-flex items-center rounded-md bg-green-50 px-2 py-1 text-xs font-medium text-green-700 ring-1 ring-green-600/20 ring-inset">{{ $users}}</span>
                                </a>
                            </li> 
                        </ul>
                    </div>
                </div>
            </div>

          
        </div>
    </div>
</x-app-layout>
