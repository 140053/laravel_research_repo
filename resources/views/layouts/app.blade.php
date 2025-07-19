<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />



    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

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

</head>

<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
        @include('layouts.navigation')

        <!-- Page Heading -->
        @isset($header)
            <header class="bg-white dark:bg-gray-800 shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endisset

        <!-- Page Content -->
        <main>
            {{ $slot }}
        </main>
        <footer class="bg-gray-800 text-white py-6">
            <div class="max-w-7xl mx-auto px-4 text-center">
                <p>&copy; 2025 {{ config('app.name') }}. All rights reserved.</p>
            </div>
        </footer>

    </div>
    <!-- Footer -->

</body>

</html>
