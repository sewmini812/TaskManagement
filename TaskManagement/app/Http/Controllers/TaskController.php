<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class TaskController extends Controller
{
    // Dashboard page
    public function dashboard()
    {
        $user = Auth::user();

        if ($user->role === 'admin') {
            $totalTasks = Task::count();
            $pending = Task::where('status','Pending')->count();
            $inProgress = Task::where('status','In Progress')->count();
            $completed = Task::where('status','Completed')->count();
            $recentTasks = Task::latest()->take(6)->with('user','category')->get();
        } else {
            $totalTasks = $user->tasks()->count();
            $pending = $user->tasks()->where('status','Pending')->count();
            $inProgress = $user->tasks()->where('status','In Progress')->count();
            $completed = $user->tasks()->where('status','Completed')->count();
            $recentTasks = $user->tasks()->latest()->take(6)->with('category')->get();
        }

        return view('dashboard', compact(
            'totalTasks','pending','inProgress','completed','recentTasks'
        ));
    }

    // List tasks
    public function index()
    {
        $user = Auth::user();

        if ($user->role === 'admin') {
            $tasks = Task::with('user','category')->latest()->paginate(10);
        } else {
            $tasks = $user->tasks()->with('category')->latest()->paginate(10);
        }

        return view('tasks.index', compact('tasks'));
    }

    public function create()
    {
        $this->authorizeCreateOrAdmin();

        $categories = Category::where('status','Active')->get();
        // assigned users - admin can assign to any user, intern only themselves
        $users = Auth::user()->role === 'admin' ? User::all() : collect([Auth::user()]);

        return view('tasks.create', compact('categories','users'));
    }

    public function store(Request $request)
    {
        $this->authorizeCreateOrAdmin();

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
            'deadline' => 'required|date|after:today',
            'assigned_user_id' => 'nullable|exists:users,id',
            'status' => 'required|in:Pending,In Progress,Completed',
        ]);

        $user = Auth::user();
        $assignedTo = $request->input('assigned_user_id') ?? $user->id;

        // Interns can only assign to themselves
        if ($user->role !== 'admin' && $assignedTo != $user->id) {
            abort(403);
        }

        $task = Task::create([
            'name' => $request->name,
            'description' => $request->description,
            'category_id' => $request->category_id,
            'user_id' => $assignedTo,
            'assignment_date' => Carbon::now()->toDateString(),
            'deadline' => $request->deadline,
            'status' => $request->status,
        ]);

        return redirect()->route('tasks.index')->with('success','Task created successfully.');
    }

    public function show(Task $task)
    {
        $this->authorizeView($task);
        $task->load('user','category');
        return view('tasks.show', compact('task'));
    }

    public function edit(Task $task)
    {
        $this->authorizeEdit($task);

        $categories = Category::where('status','Active')->get();
        $users = Auth::user()->role === 'admin' ? User::all() : collect([Auth::user()]);

        return view('tasks.edit', compact('task','categories','users'));
    }

    public function update(Request $request, Task $task)
    {
        $this->authorizeEdit($task);

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
            'deadline' => 'required|date|after:today',
            'assigned_user_id' => 'nullable|exists:users,id',
            'status' => 'required|in:Pending,In Progress,Completed',
        ]);

        $user = Auth::user();
        $assignedTo = $request->input('assigned_user_id') ?? $task->user_id;

        if ($user->role !== 'admin' && $assignedTo != $user->id) {
            abort(403);
        }

        $task->update([
            'name' => $request->name,
            'description' => $request->description,
            'category_id' => $request->category_id,
            'user_id' => $assignedTo,
            'deadline' => $request->deadline,
            'status' => $request->status,
        ]);

        return redirect()->route('tasks.index')->with('success','Task updated successfully.');
    }

    public function destroy(Task $task)
    {
        // Only admin can delete, or owner can delete? Assignment says Admin manages all tasks; interns manage only their own.
        $user = Auth::user();
        if ($user->role !== 'admin' && $task->user_id !== $user->id) {
            abort(403);
        }

        $task->delete();
        return redirect()->route('tasks.index')->with('success','Task deleted.');
    }

    /* ---------------- Helper authorization methods ---------------- */

    protected function authorizeCreateOrAdmin()
    {
        $user = Auth::user();
        // both admin and intern can create tasks (intern for themselves). If you want only admin, change here.
        if (!$user) abort(403);
    }

    protected function authorizeView(Task $task)
    {
        $user = Auth::user();
        if ($user->role !== 'admin' && $task->user_id !== $user->id) {
            abort(403);
        }
    }

    protected function authorizeEdit(Task $task)
    {
        $user = Auth::user();
        if ($user->role !== 'admin' && $task->user_id !== $user->id) {
            abort(403);
        }
    }
}
