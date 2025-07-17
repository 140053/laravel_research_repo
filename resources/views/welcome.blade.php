<x-home-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
           
        </h2>
    </x-slot>

    <div class="py-10">
        <!-- Hero Section -->
    <section class="bg-gray-100 dark:bg-gray-800 py-16 text-center rounded-md">
        <h2 class="text-4xl font-bold mb-4 dark:text-gray-300">Explore Scholarly Works from Our Institution</h2>
        <p class="text-lg mb-6 text-gray-700 dark:text-gray-300">Access theses, dissertations, and research projects from students and faculty.</p>
        <div class="max-w-xl mx-auto">
          @auth
            <form action="{{ auth()->user()->hasRole('admin') ? route('admin.research.index') : route('dashboard.research.index')}}" method="GEt"> 
                <input type="text" placeholder="Search research..." class="w-full px-4 py-2 border rounded shadow-sm dark:bg-gray-700 dark:text-gray-300" />
            </form>
          @endauth

          @guest
            <a href="{{ route('login') }}" class="w-full px-4 py-2 border rounded shadow-sm dark:bg-gray-700 dark:text-gray-300">Login to Search for Content</a>
          @endguest
       
        </div>
    </section>


  <section class="py-12">
    <div class="max-w-7xl mx-auto px-4">
      <h3 class="text-2xl font-semibold mb-6 dark:text-gray-200">Latest Research</h3>
      <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
      @foreach ($papers as $paper)
     
     
          <!-- Card -->
          <div class="bg-white dark:bg-gray-700 p-4 rounded shadow">
            @auth
             @if(auth()->user()->hasRole('admin'))
                <a href="{{ route('admin.research.show', $paper->id) }}" class="text-indigo-600 text-sm mt-2 inline-block dark:text-gray-200 dark:underline">
                          <h4 class="font-bold text-lg mb-2 dark:text-gray-200">{{ $paper->title }}</h4>
                </a>
             @else
              <a href="{{ route('dashboard.research.show', $paper->id) }}" class="text-indigo-600 text-sm mt-2 inline-block dark:text-gray-200 dark:underline">
                          <h4 class="font-bold text-lg mb-2 dark:text-gray-200">{{ $paper->title }}</h4>
                </a>
             @endif              
            
            @else
              <a href="{{ route('login') }}" class="text-indigo-600 text-sm mt-2 inline-block dark:text-gray-200 dark:underline">
                  <h4 class="font-bold text-lg mb-2 dark:text-gray-200">{{ $paper->title }}</h4>
              </a>
            @endauth

           
            <p class="text-sm text-gray-600 dark:text-gray-200">{{ $paper->authors }} • {{ $paper->year }} </p>
            @auth
                @if(auth()->user()->hasRole('admin'))
                    <a href="{{ route('admin.research.show', $paper->id) }}" class="text-indigo-600 text-sm mt-2 inline-block dark:text-gray-200 dark:underline">
                        View Details
                    </a>
                @else
                    <a href="{{ route('dashboard.research.index') }}" class="text-indigo-600 text-sm mt-2 inline-block dark:text-gray-200 dark:underline">
                        View Details
                    </a>
                @endif
            @else
                <a href="{{ route('login') }}" class="text-indigo-600 text-sm mt-2 inline-block dark:text-gray-200 dark:underline">
                    Login to View Details
                </a>
            @endauth
        
          </div>
          <!-- More cards -->
        
          
      @endforeach
    </div>
  </div>
  </section>


  <!-- Categories -->
<section class="bg-gray-50 dark:bg-gray-700 py-12 rounded-lg">
    <div class="max-w-7xl mx-auto px-4">
      <h3 class="text-2xl font-semibold mb-6 dark:text-gray-200">Research Categories</h3>
      <div class="grid grid-cols-2 md:grid-cols-4 gap-4">

        @foreach($tag as $t)
          @auth
            @if ( auth()->user()->hasRole('admin'))
                <a href="{{ route('admin.research.index', ['category' => $t->name]) }}" class="bg-white  shadow px-4 py-2 rounded text-center dark:bg-gray-500" >
                    <span class="dark:text-gray-200" >{{ $t->name }}</span>
                </a>
            @else
                <a href="{{ route('dashboard.research.index', ['category' => $t->name]) }}" class="bg-white  shadow px-4 py-2 rounded text-center dark:bg-gray-500" >
                    <span class="dark:text-gray-200" >{{ $t->name }}</span>
                </a>
              
            @endif
          @else
           <a href="{{ route('login') }}" class="bg-white  shadow px-4 py-2 rounded text-center dark:bg-gray-500" >
                    <span class="dark:text-gray-200" >{{ $t->name }}</span>
             </a>
          @endauth
          
        @endforeach

       
      </div>
    </div>
  </section>
  
        


            
        
            <!-- About -->
  <section class="py-12 text-center">
    <div class="max-w-4xl mx-auto px-4">
      <h3 class="text-2xl font-semibold mb-4 dark:text-gray-200">About the Repository</h3>
      <p class="text-gray-700 text-lg dark:text-gray-200">This system provides a platform for storing, archiving, and accessing research outputs from the university community. It encourages knowledge sharing and research visibility.</p>
    </div>
  </section>
    </div>
</x-home-layout>
