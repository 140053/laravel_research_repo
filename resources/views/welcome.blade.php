<x-home-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
           
        </h2>
    </x-slot>

    <div class="py-10">
        <!-- Hero Section -->
    <section class="bg-gray-100 py-16 text-center">
        <h2 class="text-4xl font-bold mb-4">Explore Scholarly Works from Our Institution</h2>
        <p class="text-lg mb-6 text-gray-700">Access theses, dissertations, and research projects from students and faculty.</p>
        <div class="max-w-xl mx-auto">
        <input type="text" placeholder="Search research..." class="w-full px-4 py-2 border rounded shadow-sm" />
        </div>
    </section>

    <!-- Latest Research -->
<section class="py-12">
    <div class="max-w-7xl mx-auto px-4">
      <h3 class="text-2xl font-semibold mb-6">Latest Research</h3>
      <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Card -->
        <div class="bg-white p-4 rounded shadow">
          <h4 class="font-bold text-lg mb-2">AI in Education</h4>
          <p class="text-sm text-gray-600">By Jane Doe • 2025</p>
          <a href="#" class="text-indigo-600 text-sm mt-2 inline-block">View Details</a>
        </div>
        <!-- More cards -->
      </div>
    </div>
  </section>

  @foreach ($papers as $paper)
  <p>{{ $paper }}</p>
      
  @endforeach


  <!-- Categories -->
<section class="bg-gray-50 py-12">
    <div class="max-w-7xl mx-auto px-4">
      <h3 class="text-2xl font-semibold mb-6">Research Categories</h3>
      <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <span class="bg-white shadow px-4 py-2 rounded text-center">Science</span>
        <span class="bg-white shadow px-4 py-2 rounded text-center">IT/CS</span>
        <span class="bg-white shadow px-4 py-2 rounded text-center">Business</span>
        <span class="bg-white shadow px-4 py-2 rounded text-center">Education</span>
      </div>
    </div>
  </section>
  
        


            
        
            <!-- About -->
<section class="py-12 text-center">
    <div class="max-w-4xl mx-auto px-4">
      <h3 class="text-2xl font-semibold mb-4">About the Repository</h3>
      <p class="text-gray-700 text-lg">This system provides a platform for storing, archiving, and accessing research outputs from the university community. It encourages knowledge sharing and research visibility.</p>
    </div>
  </section>
    </div>
</x-home-layout>
