<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Task;
use App\Models\Category;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\CategoryController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application.
| These routes are loaded by the RouteServiceProvider within a group
| which contains the "web" middleware group. Now create something great!
|
*/

// ------------------- DEFAULT ROUTE ------------------- //
Route::get('/', function () {
    return redirect()->route('dashboard');
});


// ------------------- AUTH ROUTES ------------------- //
require __DIR__.'/auth.php';


// ------------------- DASHBOARD ROUTE ------------------- //
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        $user = Auth::user();

        // If admin logs in → show Admin Dashboard
        if ($user->role === 'admin') {
            return view('admin-dashboard', [
                'totalUsers' => User::count(),
                'totalTasks' => Task::count(),
                'totalCategories' => Category::count(),
            ]);
        }

        // If normal user logs in → show User Dashboard
        return view('user-dashboard');
    })->name('dashboard');


    // ------------------- TASK ROUTES ------------------- //
    Route::resource('tasks', TaskController::class);

    // ------------------- CATEGORY ROUTES ------------------- //
    Route::resource('categories', CategoryController::class);
});
