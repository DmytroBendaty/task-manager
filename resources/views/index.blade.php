@extends('layout')

@section('main-content')
    <div>
        <div class="float-start">
            <h4 class="pb-3">My Tasks</h4>
        </div>
    </div>
    <br>
    <br>
    @auth()
        <div class="container">
            <h1>Drag and Drop Tasks</h1>
{{--            <livewire:task-order />--}}
        </div>
   <div>
       <div class="float-end">
           <a href="{{ route('task.create') }}" class="btn btn-info">
               <i class="fa fa-plus-circle"></i> Create Task
           </a>
       </div>
       <div class="clearfix"></div>
   </div>
    @endauth
    @if ($message)
        <p>{{ $message }}</p>
    @else
        @if ($tasks->isEmpty())
            <div class="alert alert-danger p-2">
                No Task Found. Please Create New Task
                <br>
                <br>
                <a href="{{ route('task.create') }}" class="btn btn-info">
                    <i class="fa fa-plus-circle"></i> Create Task
                </a>
            </div>
        @else
            <form method="GET" action="{{ route('index') }}" class="d-flex align-items-center mb-4 gap-2">
                <label for="sort_by" class="form-label fw-bold">Sort by:</label>
                <select name="sort_by" id="sort_by" class="form-select w-25" onchange="this.form.submit()">
                    <option value="created_at" {{ request('sort_by') === 'created_at' ? 'selected' : '' }}>За датою створення</option>
                    <option value="title" {{ request('sort_by') === 'title' ? 'selected' : '' }}>За назвою</option>
                </select>

                <select name="order" id="order" class="form-select w-25" onchange="this.form.submit()">
                    <option value="asc" {{ request('order') === 'asc' ? 'selected' : '' }}>За зростанням</option>
                    <option value="desc" {{ request('order') === 'desc' ? 'selected' : '' }}>За спаданням</option>
                </select>
            </form>
            @foreach($tasks as $task)
                <div class="card mt-3">
                    <div class="card-header">
                        {{ $task->title }}
                        <span class="badge rounded-pill bg-warning text-dark">
                            {{ $task->created_at->diffForHumans() }}
                        </span>
                        {{ $task->author }}
                    </div>
                    <div class="card-body">
                        <div class="card-text">
                            <div class="float-start">
                                {{ $task->description }}
                                <br>
                                @if($task->status === "Todo")
                                    <span class="badge rounded-pill bg-info text-dark">Todo</span>
                                @elseif($task->status === "In progress")
                                    <span class="badge rounded-pill bg-info text-dark">In progress</span>
                                @else
                                    <span class="badge rounded-pill bg-success text-white">Done</span>
                                @endif
                                <small>Last Updated - {{ $task->updated_at->diffForHumans() }} </small>
                            </div>
                            <div class="float-end">
                                <a href="{{ route('tasks.estimate', $task->id) }}" class="btn btn-info">
                                    <i class="fa-solid fa-calculator"></i> Estimate
                                </a>
                                <a href="{{ route('task.edit', $task->id) }}" class="btn btn-success">
                                    <i class="fa fa-edit"></i> Edit
                                </a>
                                <form action="{{ route('task.destroy', $task->id) }}" style="display: inline" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">
                                        <i class="fa fa-trash"></i> Delete
                                    </button>
                                </form>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                </div>
            @endforeach
        @endif
    @endif
    {{-- @auth()
    @if(count($tasks) === 0)
        <div class="alert alert-danger p-2">
            No Task Found. Please Create New Task
            <br>
            <br>
            <a href="{{ route('task.create') }}" class="btn btn-info">
                <i class="fa fa-plus-circle"></i> Create Task
            </a>
        </div>
    @endif
    @endauth --}}
@endsection
