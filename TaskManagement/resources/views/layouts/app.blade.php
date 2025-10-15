<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>{{ config('app.name', 'TaskApp') }}</title>
  @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100 min-h-screen">
  <!-- NAVBAR -->
  <nav class="bg-white shadow">
    <div class="max-w-7xl mx-auto px-4 py-3 flex justify-between items-center">
      <!-- Left side: Logo -->
      <div class="flex items-center space-x-4">
        <a href="{{ route('dashboard') }}" class="text-xl font-semibold text-indigo-600">
          TaskManager
        </a>
      </div>

      <!-- Right side: Links -->
      <div class="flex items-center space-x-4">
        @auth
          <!-- Authenticated User Links -->
          <a href="{{ route('tasks.index') }}" class="text-gray-700 hover:text-indigo-600">Tasks</a>
          <a href="{{ route('categories.index') }}" class="text-gray-700 hover:text-indigo-600">Categories</a>
          <a href="{{ route('dashboard') }}" class="text-gray-800 font-semibold">Dashboard</a>

          <span class="text-sm text-gray-600 ml-4">Hi, {{ auth()->user()->name }}</span>
          <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="ml-3 px-3 py-1 bg-red-500 text-white rounded hover:bg-red-600">
              Logout
            </button>
          </form>
        @endauth

        @guest
          <!-- Guest Links -->
          <a href="{{ route('login') }}" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">
            Login
          </a>
          <a href="{{ route('register') }}" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
            Register
          </a>
        @endguest
      </div>
    </div>
  </nav>

  <!-- MAIN CONTENT -->
  <main class="max-w-7xl mx-auto p-4">
    @if(session('success'))
      <div class="mb-4 p-3 bg-green-100 border border-green-200 text-green-700 rounded">
        {{ session('success') }}
      </div>
    @endif

    @yield('content')
  </main>
</body>
</html>
