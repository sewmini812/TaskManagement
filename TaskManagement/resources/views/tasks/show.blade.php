@extends('layouts.app')

@section('content')
<div class="bg-white p-4 rounded shadow">
  <h2 class="text-xl font-semibold mb-2">{{ $task->name }}</h2>
  <div class="text-gray-600 mb-3">Category: {{ $task->category->name ?? '-' }}</div>
  <div class="mb-3"><strong>Assigned to:</strong> {{ $task->user->name ?? '-' }} </div>
  <div class="mb-3"><strong>Deadline:</strong> {{ $task->deadline }}</div>
  <div class="mb-3"><strong>Status:</strong> {{ $task->status }}</div>
  <div class="mb-3"><strong>Description:</strong><div class="mt-1">{{ $task->description }}</div></div>

  <a href="{{ route('tasks.index') }}" class="px-3 py-2 bg-gray-200 rounded">Back</a>
</div>
@endsection
