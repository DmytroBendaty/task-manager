<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (auth()->check()) {
            $tasks = auth()->user()->tasks()->orderBy('id', 'desc')->get();
            return view('index', ['tasks' => $tasks, 'message' => null]);
        } else {
            $message = ' You are not logged in, please log in to see and create tasks';
            return view('index', ['tasks' => collect(), 'message' => $message]);
        }
//        $tasks = auth()->user()->tasks()->orderBy('id', 'desc')->get();
//        return view('index', compact('tasks'));
//        $tasks = Task::orderBy('id','desc')->get();
//        return view('index', compact('tasks'));
    }

    /**
     * Show the form for creating a new resource.s
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $statuses = [
            [
                'label' => 'Todo',
                'value' => "Todo",
            ],
            [
                'label' => 'In progress',
                'value' => "In progress",
            ],
            [
                'label' => 'Done',
                'value' => "Done",
            ]
        ];
        return view('create', compact('statuses'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
//        $request->validate([
//            'title' => 'required',
//        ]);
//
//        $task = new Task();
//        $task->title = $request->title;
//        $task->description = $request->description;
//        $task->status = $request->status;
//        $task->email = $request->user()->email;
//        $task->save();
//        $user = User();
//        return redirect()->route('index');

        $validated = $request->validate([
            'title' => 'required|max:255',
            'description' => 'required',
        ]);

        $task = new Task;
        $task->title = $request->title;
        $task->description = $request->description;
        $task->user_id = auth()->id(); // Зберігаємо user_id
        $task->save();

        return redirect()->route('index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $task = Task::findOrFail($id);
        $statuses = [
            [
                'label' => 'Todo',
                'value' => "Todo",
            ],
            [
                'label' => 'In progress',
                'value' => "In progress",
            ],
            [
                'label' => 'Done',
                'value' => "Done",
            ]
        ];
        return view('edit', compact('statuses', 'task'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $task = Task::findOrFail($id);
        $request->validate([
            'title' => 'required',
        ]);

        $task->title = $request->title;
        $task->description = $request->description;
        $task->status = $request->status;
        $task->save();
        return redirect()->route('index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $task = Task::findOrFail($id);
        $task->delete();
        return redirect()->route('index');
    }
}
