<?php
namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::paginate(10);
        return view('categories.index', compact('categories'));
    }

    public function create()
    {
        if (Auth::user()->role !== 'admin') abort(403);
        return view('categories.create');
    }

    public function store(Request $request)
    {
        if (Auth::user()->role !== 'admin') abort(403);

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:Active,Inactive',
        ]);

        Category::create($request->only('name','description','status'));

        return redirect()->route('categories.index')->with('success','Category created.');
    }

    public function edit(Category $category)
    {
        if (Auth::user()->role !== 'admin') abort(403);
        return view('categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        if (Auth::user()->role !== 'admin') abort(403);

        $request->validate([
            'name' => 'required|string|max:255',
            'status' => 'required|in:Active,Inactive',
        ]);

        $category->update($request->only('name','description','status'));
        return redirect()->route('categories.index')->with('success','Category updated.');
    }

    public function destroy(Category $category)
    {
        if (Auth::user()->role !== 'admin') abort(403);
        $category->delete();
        return redirect()->route('categories.index')->with('success','Category deleted.');
    }
}
