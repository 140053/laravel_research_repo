{{-- resources/views/components/layouts/home.blade.php --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <title>{{ $title ?? 'Home' }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    @vite(['resources/css/app.css', 'resources/js/app.js']) {{-- Optional if you're using Vite --}}
</head>
<body class="bg-gray-100 font-sans antialiased">

    <!-- Header -->
    <header class="bg-white shadow">
        <div class="max-w-7xl mx-auto px-4 py-4 flex justify-between items-center">
          <h1 class="text-xl font-bold text-indigo-600">Research Repository</h1>
      
          <!-- Hamburger Button (Mobile) -->
          <button id="menu-toggle" class="md:hidden text-gray-700 focus:outline-none">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2"
                 viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
              <path stroke-linecap="round" stroke-linejoin="round"
                    d="M4 6h16M4 12h16M4 18h16"></path>
            </svg>
          </button>
      
          <!-- Desktop Menu -->
          <nav class="hidden md:flex space-x-4">
            <a href="/" class="text-gray-700 hover:text-indigo-600">Home</a>
            <a href="#" class="text-gray-700 hover:text-indigo-600">Browse</a>
            <a href="#" class="text-gray-700 hover:text-indigo-600">Authors</a>
            <a href="#" class="text-gray-700 hover:text-indigo-600">Categories</a>
            <a href="/about" class="text-gray-700 hover:text-indigo-600">About</a>
            <a href="/login" class="text-gray-700 hover:text-indigo-600">Login</a>
          </nav>
        </div>
      
        <!-- Mobile Menu -->
        <div id="mobile-menu" class="md:hidden px-4 pb-4 hidden">
          <nav class="flex flex-col space-y-2">
            <a href="/" class="text-gray-700 hover:text-indigo-600">Home</a>
            <a href="#" class="text-gray-700 hover:text-indigo-600">Browse</a>
            <a href="#" class="text-gray-700 hover:text-indigo-600">Authors</a>
            <a href="#" class="text-gray-700 hover:text-indigo-600">Categories</a>
            <a href="/about" class="text-gray-700 hover:text-indigo-600">About</a>
            <a href="/login" class="text-gray-700 hover:text-indigo-600">Login</a>
          </nav>
        </div>
      </header>
      
      <!-- Toggle Script -->
      <script>
        const toggleButton = document.getElementById('menu-toggle');
        const mobileMenu = document.getElementById('mobile-menu');
      
        toggleButton.addEventListener('click', () => {
          mobileMenu.classList.toggle('hidden');
        });
      </script>
      

    <main class="p-6 max-w-6xl mx-auto">
        {{ $slot }}
    </main>

    <!-- Footer -->
<footer class="bg-gray-800 text-white py-6">
    <div class="max-w-7xl mx-auto px-4 text-center">
      <p>&copy; 2025 eResearch Repository. All rights reserved.</p>
    </div>
  </footer>
</body>
</html>
