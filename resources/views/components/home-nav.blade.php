<header class="bg-white">
  <nav class="mx-auto flex max-w-7xl items-center justify-between p-6 lg:px-8" aria-label="Global">
    <div class="flex lg:flex-1">
      <a href="/" class="-m-1.5 p-1.5">
        <span class="sr-only">{{ config('app.name', 'Laravel') }}</span>
        <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
      </a>
    </div>

    <!-- Mobile Menu Button -->
    <div class="flex lg:hidden">
      <button type="button" class="-m-2.5 inline-flex items-center justify-center rounded-md p-2.5 text-gray-700" id="menu-toggle">
        <span class="sr-only">Open main menu</span>
        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
          <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
        </svg>
      </button>
    </div>

    <!-- Desktop Menu (hidden on mobile) -->
    <div class="hidden lg:flex lg:gap-x-12">
      <div class="relative">
        <a  class="flex items-center gap-x-1 text-sm font-semibold text-gray-900">
          Home
        </a>
      </div>
      
      <a href="#" class="text-sm font-semibold text-gray-900">Collection</a>
     
      <a href="#" class="text-sm font-semibold text-gray-900">About</a>
       {{--
      <a href="#" class="text-sm font-semibold text-gray-900">Company</a>
      --}}
    </div>

    <!-- Log in Button (hidden on mobile) -->
    <div class="hidden lg:flex lg:flex-1 lg:justify-end">
      <a href="{{ route('login') }}" class="text-sm font-semibold text-gray-900">Log in <span aria-hidden="true">&rarr;</span></a>
    </div>
  </nav>

  <!-- Mobile Menu (Initially Hidden) -->
  <div class="lg:hidden" id="mobile-menu" style="display: none;">
    <div class="fixed inset-0 z-50 bg-white p-6">
      <div class="flex items-center justify-between">
        <a href="/" class="-m-1.5 p-1.5">
          <span class="sr-only">Your Company</span>
          <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
        </a>
        <button type="button" class="-m-2.5 rounded-md p-2.5 text-gray-700" id="close-menu">
          <span class="sr-only">Close menu</span>
          <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
          </svg>
        </button>
      </div>

      <!-- Mobile Menu Links -->
      <div class="mt-6">
        <a href="#" class="block py-2 text-base font-semibold text-gray-900 hover:bg-gray-50">Product</a>
        <a href="#" class="block py-2 text-base font-semibold text-gray-900 hover:bg-gray-50">Features</a>
        <a href="#" class="block py-2 text-base font-semibold text-gray-900 hover:bg-gray-50">Marketplace</a>
        <a href="#" class="block py-2 text-base font-semibold text-gray-900 hover:bg-gray-50">Company</a>
        <a href="#" class="block py-2 text-base font-semibold text-gray-900 hover:bg-gray-50">Log in</a>
      </div>
    </div>
  </div>
</header>

<script>
  // Toggle mobile menu visibility
  const menuToggle = document.getElementById("menu-toggle");
  const mobileMenu = document.getElementById("mobile-menu");
  const closeMenu = document.getElementById("close-menu");

  menuToggle.addEventListener("click", () => {
    mobileMenu.style.display = "block";
  });

  closeMenu.addEventListener("click", () => {
    mobileMenu.style.display = "none";
  });
</script>
