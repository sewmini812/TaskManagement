@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto p-6 bg-white shadow rounded">
    <h1 class="text-3xl font-bold text-center text-indigo-600 mb-6">Admin Dashboard</h1>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div class="p-4 bg-indigo-100 rounded shadow">
            <h2 class="text-lg font-semibold">Total Users</h2>
            <p class="text-2xl font-bold text-indigo-700 mt-2">{{ $totalUsers }}</p>
        </div>
        <div class="p-4 bg-green-100 rounded shadow">
            <h2 class="text-lg font-semibold">Total Tasks</h2>
            <p class="text-2xl font-bold text-green-700 mt-2">{{ $totalTasks }}</p>
        </div>
        <div class="p-4 bg-pink-100 rounded shadow">
            <h2 class="text-lg font-semibold">Categories</h2>
            <p class="text-2xl font-bold text-pink-700 mt-2">{{ $totalCategories }}</p>
        </div>
    </div>

    <div class="mt-8 text-center">
        <a href="{{ route('tasks.index') }}" class="bg-indigo-600 text-white px-6 py-2 rounded hover:bg-indigo-700 transition">
            Manage Tasks
        </a>
    </div>
</div>
@endsection
