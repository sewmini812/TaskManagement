@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto p-6 bg-white shadow rounded">
    <h1 class="text-3xl font-bold text-center text-green-600 mb-6">User Dashboard</h1>

    <div class="text-center">
        <p class="text-lg text-gray-600 mb-4">Welcome back, {{ Auth::user()->name }}!</p>
        <a href="{{ route('tasks.index') }}" class="bg-green-600 text-white px-6 py-2 rounded hover:bg-green-700 transition">
            View My Tasks
        </a>
    </div>
</div>
@endsection
