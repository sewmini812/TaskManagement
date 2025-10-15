@extends('layouts.app')

@section('content')
<div class="flex justify-between items-center mb-4">
  <h1 class="text-2xl font-semibold">Categories</h1>

  @if(auth()->user()->role === 'admin')
    <a href="{{ route('categories.create') }}" class="px-3 py-2 bg-indigo-600 text-white rounded">
      + New Category
    </a>
  @endif
</div>

<div class="bg-white shadow rounded overflow-hidden">
  <table class="min-w-full">
    <thead class="bg-gray-50">
      <tr>
        <th class="p-3 text-left">#</th>
        <th class="p-3 text-left">Name</th>
        <th class="p-3 text-left">Description</th>
        <th class="p-3 text-left">Status</th>
        @if(auth()->user()->role === 'admin')
          <th class="p-3 text-left">Actions</th>
        @endif
      </tr>
    </thead>
    <tbody>
      @foreach($categories as $cat)
      <tr class="border-t">
        <td class="p-3">{{ $cat->id }}</td>
        <td class="p-3 font-medium">{{ $cat->name }}</td>
        <td class="p-3">{{ $cat->description }}</td>
        <td class="p-3">{{ $cat->status }}</td>

        @if(auth()->user()->role === 'admin')
        <td class="p-3">
          <a href="{{ route('categories.edit',$cat->id) }}" class="text-sm px-2 py-1 border rounded">Edit</a>
          <form action="{{ route('categories.destroy',$cat->id) }}" method="POST" class="inline"
                onsubmit="return confirm('Delete this category?')">
            @csrf
            @method('DELETE')
            <button class="text-sm px-2 py-1 bg-red-500 text-white rounded">Delete</button>
          </form>
        </td>
        @endif
      </tr>
      @endforeach
    </tbody>
  </table>
</div>

<div class="mt-3">
  {{ $categories->links() }}
</div>
@endsection
