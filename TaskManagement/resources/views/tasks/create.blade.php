@extends('layouts.app')

@section('content')
<h1 class="text-2xl font-semibold mb-4">Create Task</h1>

<form action="{{ route('tasks.store') }}" method="POST" class="bg-white p-4 rounded shadow">
  @csrf

  <div class="mb-3">
    <label class="block text-sm">Task Name</label>
    <input name="name" value="{{ old('name') }}" class="w-full border p-2 rounded" />
    @error('name') <div class="text-red-600 text-sm">{{ $message }}</div> @enderror
  </div>

  <div class="mb-3">
    <label class="block text-sm">Description</label>
    <textarea name="description" class="w-full border p-2 rounded">{{ old('description') }}</textarea>
  </div>

  <div class="mb-3">
    <label class="block text-sm">Category</label>
    <select name="category_id" class="w-full border p-2 rounded">
      @foreach($categories as $c)
        <option value="{{ $c->id }}">{{ $c->name }}</option>
      @endforeach
    </select>
  </div>

  <div class="mb-3">
    <label class="block text-sm">Assign To</label>
    <select name="assigned_user_id" class="w-full border p-2 rounded">
      @foreach($users as $u)
        <option value="{{ $u->id }}" @if($u->id == auth()->id()) selected @endif>{{ $u->name }} ({{ $u->email }})</option>
      @endforeach
    </select>
  </div>

  <div class="mb-3">
    <label class="block text-sm">Deadline</label>
    <input type="date" name="deadline" value="{{ old('deadline') }}" class="w-full border p-2 rounded" />
    @error('deadline') <div class="text-red-600 text-sm">{{ $message }}</div> @enderror
  </div>

  <div class="mb-3">
    <label class="block text-sm">Status</label>
    <select name="status" class="w-full border p-2 rounded">
      <option>Pending</option>
      <option>In Progress</option>
      <option>Completed</option>
    </select>
  </div>

  <div class="mt-4">
    <button class="px-4 py-2 bg-indigo-600 text-white rounded">Create Task</button>
    <a href="{{ route('tasks.index') }}" class="ml-2 text-gray-600">Cancel</a>
  </div>
</form>
@endsection
