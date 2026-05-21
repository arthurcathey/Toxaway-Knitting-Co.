<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title') | Toxaway Knitting Co.</title>
  <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
  @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>
  <nav class="sticky top-0 bg-stone-50 border-b border-stone-300 z-50">
    <div class="container-fluid py-3 sm:py-4 flex justify-between items-center">
      <a href="/" class="font-bold text-sm sm:text-base tracking-widest text-stone-900 hover:text-stone-700 transition">Toxaway Knitting Co.</a>
      <ul class="hidden md:flex gap-4 lg:gap-6 list-none items-center">
        <li><a href="/shop" class="text-xs tracking-widest hover:text-stone-700 transition {{ request()->routeIs('shop.*') ? 'font-bold text-stone-900' : '' }}">SHOP</a></li>
        <li><a href="/heritage" class="text-xs tracking-widest hover:text-stone-700 transition {{ request()->routeIs('heritage') ? 'font-bold text-stone-900' : '' }}">HERITAGE</a></li>
        <li><a href="/craftsmanship" class="text-xs tracking-widest hover:text-stone-700 transition {{ request()->routeIs('craftsmanship') ? 'font-bold text-stone-900' : '' }}">CRAFT</a></li>
        <li><a href="/contact" class="text-xs tracking-widest hover:text-stone-700 transition {{ request()->routeIs('contact') ? 'font-bold text-stone-900' : '' }}">CONTACT</a></li>
        <li><a href="/cart" class="text-xs tracking-widest hover:text-stone-700 transition border-l border-stone-300 pl-4 {{ request()->routeIs('cart.index') ? 'font-bold text-stone-900' : '' }}">CART</a></li>
        @auth
        <li class="border-l border-stone-300 pl-4">
          <span class="text-xs tracking-widest text-stone-600">{{ Auth::user()->name }}</span>
        </li>
        <li>
          <a href="{{ route('dashboard') }}" class="text-xs tracking-widest hover:text-stone-700 transition {{ request()->routeIs('dashboard') ? 'font-bold text-stone-900' : '' }}">DASHBOARD</a>
        </li>
        @if (Auth::user()->is_admin)
        <li>
          <a href="{{ route('admin.dashboard') }}" class="text-xs tracking-widest hover:text-stone-700 transition text-stone-900 {{ request()->routeIs('admin.*') ? 'font-bold' : '' }}">ADMIN</a>
        </li>
        @endif
        <li>
          <form method="POST" action="{{ route('logout') }}" class="inline">
            @csrf
            <button type="submit" class="text-xs tracking-widest hover:text-stone-700 transition">LOGOUT</button>
          </form>
        </li>
        @else
        <li class="border-l border-stone-300 pl-4">
          <a href="{{ route('login') }}" class="text-xs tracking-widest hover:text-stone-700 transition">LOGIN</a>
        </li>
        <li>
          <a href="{{ route('register') }}" class="text-xs tracking-widest hover:text-stone-700 transition">REGISTER</a>
        </li>
        @endauth
      </ul>
      <button id="mobile-menu-btn" class="md:hidden text-stone-900 hover:text-stone-700 transition">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
        </svg>
      </button>
    </div>
    <div id="mobile-menu" class="hidden md:hidden border-t border-stone-300">
      <ul class="flex flex-col list-none divide-y divide-stone-300">
        <li><a href="/shop" class="block px-4 sm:px-6 py-3 text-xs tracking-widest hover:bg-stone-100 transition {{ request()->routeIs('shop.*') ? 'font-bold text-stone-900' : '' }}">SHOP</a></li>
        <li><a href="/heritage" class="block px-4 sm:px-6 py-3 text-xs tracking-widest hover:bg-stone-100 transition {{ request()->routeIs('heritage') ? 'font-bold text-stone-900' : '' }}">HERITAGE</a></li>
        <li><a href="/craftsmanship" class="block px-4 sm:px-6 py-3 text-xs tracking-widest hover:bg-stone-100 transition {{ request()->routeIs('craftsmanship') ? 'font-bold text-stone-900' : '' }}">CRAFT</a></li>
        <li><a href="/contact" class="block px-4 sm:px-6 py-3 text-xs tracking-widest hover:bg-stone-100 transition {{ request()->routeIs('contact') ? 'font-bold text-stone-900' : '' }}">CONTACT</a></li>
        <li><a href="/cart" class="block px-4 sm:px-6 py-3 text-xs tracking-widest hover:bg-stone-100 transition {{ request()->routeIs('cart.index') ? 'font-bold text-stone-900' : '' }}">CART</a></li>
        @auth
        <li><a href="{{ route('dashboard') }}" class="block px-4 sm:px-6 py-3 text-xs tracking-widest hover:bg-stone-100 transition {{ request()->routeIs('dashboard') ? 'font-bold text-stone-900' : '' }}">DASHBOARD</a></li>
        @if (Auth::user()->is_admin)
        <li><a href="{{ route('admin.dashboard') }}" class="block px-4 sm:px-6 py-3 text-xs tracking-widest hover:bg-stone-100 transition text-stone-900 {{ request()->routeIs('admin.*') ? 'font-bold' : '' }}">ADMIN</a></li>
        @endif
        <li>
          <form method="POST" action="{{ route('logout') }}" class="block">
            @csrf
            <button type="submit" class="w-full text-left px-4 sm:px-6 py-3 text-xs tracking-widest hover:bg-stone-100 transition">LOGOUT</button>
          </form>
        </li>
        @else
        <li><a href="{{ route('login') }}" class="block px-4 sm:px-6 py-3 text-xs tracking-widest hover:bg-stone-100 transition">LOGIN</a></li>
        <li><a href="{{ route('register') }}" class="block px-4 sm:px-6 py-3 text-xs tracking-widest hover:bg-stone-100 transition">REGISTER</a></li>
        @endauth
      </ul>
    </div>
  </nav>

  @yield('content')

  <footer class="border-t border-stone-300 section-py mt-12 sm:mt-16 md:mt-20">
    <div class="container-fluid">
      <div class="grid-3col gap-6 sm:gap-8 mb-6 sm:mb-8">
        <div>
          <h4 class="text-stone-600 mb-2 sm:mb-3">ABOUT</h4>
          <p class="text-stone-600 leading-relaxed text-xs sm:text-sm">Toxaway Knitting Company creates heavyweight, American-made apparel with meticulous attention to craft.</p>
        </div>
        <div>
          <h4 class="text-stone-600 mb-2 sm:mb-3">NAVIGATION</h4>
          <ul class="text-stone-600 space-y-1 text-xs sm:text-sm">
            <li><a href="/shop" class="hover:text-stone-900 transition">Shop</a></li>
            <li><a href="/heritage" class="hover:text-stone-900 transition">Our Heritage</a></li>
            <li><a href="/craftsmanship" class="hover:text-stone-900 transition">Craftsmanship</a></li>
            <li><a href="/contact" class="hover:text-stone-900 transition">Contact</a></li>
          </ul>
        </div>
        <div>
          <h4 class="text-stone-600 mb-2 sm:mb-3">CONTACT</h4>
          <p class="text-stone-600 text-xs sm:text-sm">Email: hello@toxaway.test</p>
          <p class="text-stone-600 text-xs sm:text-sm">Phone: (828) 555-0123</p>
        </div>
      </div>
      <div class="border-t border-stone-300 pt-6 sm:pt-8 text-center">
        <p class="text-xs text-stone-600">&copy; 2024 Toxaway Knitting Co. All rights reserved.</p>
      </div>
    </div>
  </footer>

  <button id="scroll-to-top-btn" class="hidden fixed bottom-8 right-8 bg-stone-600 text-stone-50 p-3 rounded-full hover:bg-stone-700 transition shadow-lg z-50" title="Scroll to top">
    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
      <path fill-rule="evenodd" d="M3.293 14.707a1 1 0 010-1.414l6-6a1 1 0 011.414 0l6 6a1 1 0 01-1.414 1.414L10 9.414l-5.293 5.293a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
    </svg>
  </button>
</body>

</html>
