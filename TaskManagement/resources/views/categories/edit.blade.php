@extends('layouts.app')

@section('content')
<h1 class="text-2xl font-semibold mb-4">Edit Category</h1>

<form action="{{ route('categories.update',$category->id) }}" method="POST" class="bg-white p-4 rounded shadow max-w-lg">
  @csrf
  @method('PUT')

  <div class="mb-3">
    <label class="block text-sm font-medium">Category Name</label>
    <input type="text" name="name" value="{{ old('name',$category->name) }}" class="w-full border p-2 rounded" required>
    @error('name') <div class="text-red-600 text-sm">{{ $message }}</div> @enderror
  </div>

  <div class="mb-3">
    <label class="block text-sm font-medium">Description</label>
    <textarea name="description" class="w-full border p-2 rounded">{{ old('description',$category->description) }}</textarea>
  </div>

  <div class="mb-3">
    <label class="block text-sm font-medium">Status</label>
    <select name="status" class="w-full border p-2 rounded">
      <option value="Active" @if($category->status==='Active') selected @endif>Active</option>
      <option value="Inactive" @if($category->status==='Inactive') selected @endif>Inactive</option>
    </select>
  </div>

  <div class="mt-4">
    <button class="px-4 py-2 bg-indigo-600 text-white rounded">Update</button>
    <a href="{{ route('categories.index') }}" class="ml-2 text-gray-600">Cancel</a>
  </div>
</form>
@endsection
