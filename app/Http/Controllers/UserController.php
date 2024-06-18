<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();
        $tasks = $user->tasks;

        // Підрахунок задач за статусами
        $completedTasks = $tasks->where('status', 'Done')->count();
        $pendingTasks = $tasks->where('status', 'Todo')->count();
        $inProgressTasks = $tasks->where('status', 'In progress')->count();

        return view('user_dashboard', compact('user', 'tasks', 'completedTasks', 'pendingTasks', 'inProgressTasks'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        $user->update($request->all());
        return redirect()->route('user.dashboard')->with('success', 'Profile updated successfully');
    }
}
