@extends('layouts.app')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-3 gap-4">
  <div class="col-span-2">
    <div class="bg-white p-4 rounded shadow">
      <h2 class="text-lg font-semibold mb-2">Overview</h2>
      <div class="grid grid-cols-2 gap-4">
        <div class="p-4 border rounded">
          <div class="text-sm text-gray-500">Total Tasks</div>
          <div class="text-2xl font-bold">{{ $totalTasks ?? 0 }}</div>
        </div>
        <div class="p-4 border rounded">
          <div class="text-sm text-gray-500">Pending</div>
          <div class="text-2xl font-bold">{{ $pending ?? 0 }}</div>
        </div>
        <div class="p-4 border rounded">
          <div class="text-sm text-gray-500">In Progress</div>
          <div class="text-2xl font-bold">{{ $inProgress ?? 0 }}</div>
        </div>
        <div class="p-4 border rounded">
          <div class="text-sm text-gray-500">Completed</div>
          <div class="text-2xl font-bold">{{ $completed ?? 0 }}</div>
        </div>
      </div>

      <div class="mt-4">
        <h3 class="font-semibold mb-2">Recent Tasks</h3>
        <ul>
          @forelse($recentTasks as $t)
            <li class="border-b py-2">
              <a href="{{ route('tasks.show',$t->id) }}" class="text-indigo-600 font-medium">{{ $t->name }}</a>
              <div class="text-sm text-gray-600">Category: {{ $t->category->name ?? '-' }} | Assigned to: {{ $t->user->name ?? '-' }} | Status: {{ $t->status }}</div>
            </li>
          @empty
            <li class="text-gray-500">No recent tasks</li>
          @endforelse
        </ul>
      </div>
    </div>
  </div>

  <div>
    <div class="bg-white p-4 rounded shadow">
      <h3 class="font-semibold">Quick Actions</h3>
      <div class="mt-3 flex flex-col gap-2">
        <a href="{{ route('tasks.create') }}" class="block text-center px-3 py-2 bg-indigo-600 text-white rounded">Create Task</a>
        @if(auth()->user()->role === 'admin')
          <a href="{{ route('categories.create') }}" class="block text-center px-3 py-2 bg-gray-600 text-white rounded">Create Category</a>
        @endif
        <a href="{{ route('tasks.index') }}" class="block text-center px-3 py-2 border rounded">View Tasks</a>
      </div>
    </div>
  </div>
</div>
@endsection
