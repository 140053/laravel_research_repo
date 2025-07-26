<x-home-layout>
    

    <div class="">
        <!-- Hero Section -->
          <!-- Page Title Section -->
        <section class="bg-gradient-to-r from-green-950 to-blue-900 py-12 px-4 sm:px-6 lg:px-8 text-center rounded-b-lg shadow-md lg:ml-60 lg:mr-60 ">
            <div class="max-w-3xl mx-auto">
                <h1 class="text-4xl sm:text-5xl font-extrabold text-white mb-4 leading-tight">
                    Feature Materials
                </h1>
                <p class="text-lg text-indigo-100">
                    Discover the feature materials of the university.
                </p>
            </div>
        </section>

        


        <section class="py-12">
            <livewire:brochure />
        </section>



        <section class="py-12">
            <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
                <h2 class="text-2xl font-bold mb-4">Documentation in Action </h2>
                <p class="text-gray-700 text-lg">
                    Watch the documentation in action.
                </p>
            </div>
        </section>



        <section >
            <x-feature-vedio :vedio="$vedio" />
        </section>




       


     





        
    </div>
</x-home-layout>
