<!-- navbar.php -->
<nav class="bg-white shadow-md fixed top-0 left-0 w-full z-50">
  <div class="container mx-auto flex justify-between items-center py-3 px-4">
    
    <!-- Logo -->
    <a href="/" class="flex items-center gap-2">
      <img src="/assets/logos/logo.png" alt="Blink logo" class="w-10 h-10">
      <span class="font-bold text-xl text-[#7E3FBC]">Blink</span>
    </a>

    <ul class="hidden md:flex mx-auto justify-center items-center space-x-8 text-gray-700 font-medium">
        <li><a href="/" class="hover:text-[#7E3FBC] transition-colors">Home</a></li>
        <li><a href="/#features" class="hover:text-[#7E3FBC] transition-colors">How it Works</a></li>
        <li><a href="/#pricing" class="hover:text-[#7E3FBC] transition-colors">Pricing</a></li>
        <li><a href="/#contact" class="hover:text-[#7E3FBC] transition-colors">Reviews</a></li>
        <li><a href="/#FAQs" class="hover:text-[#7E3FBC] transition-colors">FAQs</a></li>
    </ul>


    <!-- Mobile menu button -->
    <button id="mobile-menu-btn" class="md:hidden text-gray-700 focus:outline-none">
      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
        stroke-width="1.5" stroke="currentColor" class="w-7 h-7">
        <path stroke-linecap="round" stroke-linejoin="round"
          d="M4 6h16M4 12h16M4 18h16" />
      </svg>
    </button>
  </div>

  <!-- Mobile menu -->
  <div id="mobile-menu" class="hidden bg-white border-t border-gray-100 md:hidden">
    <ul class="flex flex-col items-center py-4 space-y-2">
      <li><a href="/" class="hover:text-[#7E3FBC] transition-colors">Home</a></li>
      <li><a href="/#features" class="hover:text-[#7E3FBC] transition-colors">How it Works</a></li>
      <li><a href="/#pricing" class="hover:text-[#7E3FBC] transition-colors">Pricing</a></li>
      <li><a href="/#contact" class="hover:text-[#7E3FBC] transition-colors">Reviews</a></li>
      <li><a href="/#FAQs" class="hover:text-[#7E3FBC] transition-colors">FAQs</a></li>
    </ul>
  </div>
</nav>

<script>
  const btn = document.getElementById('mobile-menu-btn');
  const menu = document.getElementById('mobile-menu');
  btn.addEventListener('click', () => menu.classList.toggle('hidden'));
</script>
