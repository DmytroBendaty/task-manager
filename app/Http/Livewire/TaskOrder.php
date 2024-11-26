<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Task;

class TaskOrder extends Component
{
    public $tasks;

    public function mount()
    {
        $this->tasks = Task::orderBy('order')->get();
    }

    public function updateOrder($orderedIds)
    {
        foreach ($orderedIds as $index => $id) {
            Task::where('id', $id)->update(['order' => $index]);
        }

        $this->tasks = Task::orderBy('order')->get();
    }

    public function render()
    {
        return view('livewire.task-order');
    }
}

//class TaskOrder extends Component
//{
//    public $tasks;
//
//    public function mount()
//    {
//        $this->tasks = Task::orderBy('order', 'asc')->get();
//    }
//
//    public function updateTaskOrder($orderedIds)
//    {
//        foreach ($orderedIds as $index => $id) {
//            Task::where('id', $id)->update(['order' => $index]);
//        }
//
//        $this->tasks = Task::orderBy('order', 'asc')->get();
//    }
//
//    public function render()
//    {
//        return view('livewire.task-order');
//    }
//}
