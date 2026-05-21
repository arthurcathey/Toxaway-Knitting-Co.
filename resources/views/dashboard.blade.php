@extends('layouts.app')

@section('content')
<main class="container-fluid section-py">
  <div class="max-w-4xl mx-auto">
    <div class="card mb-6">
      <h1 class="text-3xl font-bold mb-2">Welcome, {{ Auth::user()->name }}!</h1>
      <p class="text-gray-600">You are logged in to your Toxaway Knitting Co. account.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
      <!-- Account Info -->
      <div class="card">
        <h2 class="text-xl font-bold mb-4">Account Information</h2>
        <div class="space-y-3">
          <div>
            <p class="text-sm text-gray-600">Name</p>
            <p class="font-semibold">{{ Auth::user()->name }}</p>
          </div>
          <div>
            <p class="text-sm text-gray-600">Email</p>
            <p class="font-semibold">{{ Auth::user()->email }}</p>
          </div>
          <div>
            <p class="text-sm text-gray-600">Member Since</p>
            <p class="font-semibold">{{ Auth::user()->created_at->format('F d, Y') }}</p>
          </div>
        </div>
      </div>

      <!-- Quick Links -->
      <div class="card">
        <h2 class="text-xl font-bold mb-4">Quick Links</h2>
        <div class="space-y-2">
          <a href="{{ route('shop') }}" class="btn-secondary block text-center">
            Browse Products
          </a>
          <a href="{{ route('cart.index') }}" class="btn-secondary block text-center">
            View Cart
          </a>
          <form method="POST" action="{{ route('logout') }}" class="w-full">
            @csrf
            <button type="submit" class="btn-secondary w-full">
              Logout
            </button>
          </form>
        </div>
      </div>
    </div>
  </div>
</main>
@endsection
