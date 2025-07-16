<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

           

            <x-filter-form link="{{ route('dashboard.research.index') }}" />
            

            {{-- ✅ Table with Card and Actions --}}
            <div class="bg-white dark:bg-gray-800 rounded border shadow-md overflow-x-auto">
                <table class="w-full text-left border-collapse ">
                    <thead>
                        <tr class="bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-200">
                            <th class="p-4 text-sm font-semibold">Research Details</th>
                           
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($papers as $paper)
                            <tr class="">
                                <td class="p-4 align-top w-full">
                                    <x-research-card :paper="$paper" />
                                </td>
                                
                            </tr>
                        @empty
                            <tr>
                                <td colspan="2" class="text-center text-gray-500 py-6">
                                    No research papers found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- ✅ Pagination --}}
            <div class="mt-6">
                {{ $papers->withQueryString()->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
