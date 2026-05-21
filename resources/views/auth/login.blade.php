@extends('layouts.app')

@section('content')
<main class="container-fluid section-py">
  <div class="mx-auto max-w-md">
    <div class="card">
      <h1 class="mb-6 text-center text-2xl font-bold">Login</h1>

      @if ($errors->any())
      <div class="mb-4 rounded-lg bg-red-50 p-4 text-red-600">
        <ul>
          @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
      @endif

      <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="mb-4">
          <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
          <input type="email" id="email" name="email" value="{{ old('email') }}" required
            class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2 focus:border-blue-500 focus:outline-none">
          @error('email')
          <span class="mt-1 text-sm text-red-600">{{ $message }}</span>
          @enderror
        </div>

        <div class="mb-6">
          <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
          <input type="password" id="password" name="password" required
            class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2 focus:border-blue-500 focus:outline-none">
          @error('password')
          <span class="mt-1 text-sm text-red-600">{{ $message }}</span>
          @enderror
        </div>

        <div class="mb-4 flex items-center">
          <input type="checkbox" id="remember" name="remember"
            class="h-4 w-4 rounded border-gray-300">
          <label for="remember" class="ml-2 text-sm text-gray-700">Remember me</label>
        </div>

        <button type="submit" class="btn-primary w-full">
          Login
        </button>
      </form>

      <p class="mt-4 text-center text-sm text-gray-600">
        Don't have an account?
        <a href="{{ route('register') }}" class="font-semibold text-blue-600 hover:text-blue-700">Register</a>
      </p>
    </div>
  </div>
</main>
@endsection
