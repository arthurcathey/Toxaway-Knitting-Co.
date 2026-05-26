<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Server Error | Toxaway Knitting Co.</title>
  @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-stone-50 text-stone-900">
  <div class="min-h-screen flex flex-col items-center justify-center px-4">
    <div class="text-center max-w-md">
      <!-- Error Code -->
      <h1 class="text-6xl font-bold text-red-300 mb-4">500</h1>

      <!-- Error Title -->
      <h2 class="text-3xl font-bold text-stone-900 mb-2">Server Error</h2>

      <!-- Error Description -->
      <p class="text-stone-600 mb-8">
        Something went wrong on our end. Our team has been notified and is working on a fix.
      </p>

      <!-- Actions -->
      <div class="space-y-3">
        <a href="{{ route('home') }}" class="block w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-6 rounded transition">
          Return to Home
        </a>
        <a href="{{ route('shop') }}" class="block w-full border-2 border-stone-300 hover:border-stone-400 text-stone-900 font-semibold py-3 px-6 rounded transition">
          Browse Shop
        </a>
      </div>

      <!-- Help Text -->
      <p class="text-stone-500 text-sm mt-8">
        If the problem persists, please <a href="{{ route('contact') }}" class="text-blue-600 hover:underline">contact us</a>
      </p>
    </div>
  </div>
</body>

</html>
