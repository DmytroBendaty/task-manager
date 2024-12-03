<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (auth()->check()) {
            $user = Auth::user();
            $sortBy = $request->get('sort_by', 'created_at'); // За замовчуванням сортування за датою створення
            $order = $request->get('order', 'asc');         // За замовчуванням порядок спадний
            $validSortBy = ['created_at', 'title'];
            if (!in_array($sortBy, $validSortBy)) {
                $sortBy = 'created_at';
            }
            $validOrder = ['asc', 'desc'];
            if (!in_array($order, $validOrder)) {
                $order = 'asc';
            }
            $tasks = Task::query()->where('user_id', auth()->id())
                ->orderBy($sortBy, $order)
                ->get();
            return view('index', ['tasks' => $tasks, 'message' => null], compact('tasks', 'sortBy', 'order'));
        } else {
            $message = ' You are not logged in, please log in to see and create tasks';
            return view('index', ['tasks' => collect(), 'message' => $message]);
        }
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
        $task = Task::query()->findOrFail($id);
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
        $task = Task::query()->findOrFail($id);
        $task->delete();
        return redirect()->route('index');
    }

    public function showEstimateForm($id)
    {
        $task = Task::query()->findOrFail($id);
        return view('estimate', compact('task'));
    }

    public function calculateEstimate(Request $request, $id)
    {
        $task = Task::query()->findOrFail($id);
        // Валідація вхідних даних
        $request->validate([
            'optimistic_time' => 'required|numeric|min:0',
            'pessimistic_time' => 'required|numeric|min:0',
            'likely_time' => 'required|numeric|min:0',
        ]);

        // Отримання даних із запиту
        $optimistic = $request->input('optimistic_time');
        $pessimistic = $request->input('pessimistic_time');
        $likely = $request->input('likely_time');

        // Розрахунок оцінки за формулою PERT
        $estimate = ($optimistic + 4 * $likely + $pessimistic) / 6;

        // Повернення результату на сторінку з результатами
        return view('estimate_result', compact('task', 'estimate'));
    }

    public function dragAndDrop()
    {
        $tasks = Task::query()->where('user_id', auth()->id())->orderBy('order', 'asc')->get(); // Приклад отримання завдань
        return view('\livewire\task-order', compact('tasks'));
    }
}

