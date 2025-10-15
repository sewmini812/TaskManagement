@extends('layouts.app')

@section('content')
<div class="flex justify-between items-center mb-4">
  <h1 class="text-2xl font-semibold">Tasks</h1>
  <a href="{{ route('tasks.create') }}" class="px-3 py-2 bg-indigo-600 text-white rounded">New Task</a>
</div>

<div class="bg-white rounded shadow overflow-hidden">
  <table class="min-w-full">
    <thead class="bg-gray-50">
      <tr>
        <th class="p-3 text-left">#</th>
        <th class="p-3 text-left">Name</th>
        <th class="p-3 text-left">Category</th>
        <th class="p-3 text-left">Assigned To</th>
        <th class="p-3 text-left">Deadline</th>
        <th class="p-3 text-left">Status</th>
        <th class="p-3 text-left">Actions</th>
      </tr>
    </thead>
    <tbody>
      @foreach($tasks as $task)
      <tr class="border-t">
        <td class="p-3">{{ $task->id }}</td>
        <td class="p-3"><a href="{{ route('tasks.show',$task->id) }}" class="text-indigo-600">{{ $task->name }}</a></td>
        <td class="p-3">{{ $task->category->name ?? '-' }}</td>
        <td class="p-3">{{ $task->user->name ?? '-' }}</td>
        <td class="p-3">{{ $task->deadline }}</td>
        <td class="p-3">{{ $task->status }}</td>
        <td class="p-3">
          <a href="{{ route('tasks.edit',$task->id) }}" class="text-sm px-2 py-1 border rounded">Edit</a>
          <form action="{{ route('tasks.destroy',$task->id) }}" method="POST" class="inline" onsubmit="return confirm('Delete?')">
            @csrf
            @method('DELETE')
            <button class="text-sm px-2 py-1 bg-red-500 text-white rounded">Delete</button>
          </form>
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>
</div>

<div class="mt-3">
  {{ $tasks->links() }}
</div>
@endsection
