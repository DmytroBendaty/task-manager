@extends('layout')
@section('main-content')
    <div class="container">
        <h1>Welcome, {{ $user->email }}</h1>
        <br>
        <br>
        <div>
            <h2>Update your e-mail</h2>
            <form action="{{ route('user.update') }}" method="POST">
                @csrf
                <div>
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" value="{{ $user->email }}" required>
                </div>
                <br>
                <button type="submit" class="btn btn-info">Update</button>
            </form>
        </div>
        <br>
        <br>
        <div>
            <h2>Statistics</h2>
            <canvas id="taskChart"></canvas>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var ctx = document.getElementById('taskChart').getContext('2d');
            var taskChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: ['Done', 'Todo', 'In Progress'],
                    datasets: [{
                        label: 'Tasks',
                        data: [
                            {{ $completedTasks }},
                            {{ $pendingTasks }},
                            {{ $inProgressTasks }}
                        ],
                        backgroundColor: [
                            'rgba(75, 192, 192, 0.2)',
                            'rgba(255, 206, 86, 0.2)',
                            'rgba(153, 102, 255, 0.2)'
                        ],
                        borderColor: [
                            'rgba(75, 192, 192, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(153, 102, 255, 1)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        });
    </script>
        <div>
            <h2>Your Tasks</h2>
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
                @foreach($tasks as $task)
                    <div class="card mt-3">
                        <div class="card-header">
                            {{ $task->title }}
                            <span class="badge rounded-pill bg-warning text-dark">
                            {{ $task->created_at->diffForHumans() }}
                        </span>
                            <div class="float-end">
                                <a href="{{ route('tasks.estimate', $task->id) }}" class="btn btn-info">
                                    <i class="fa-solid fa-calculator"></i>
                                </a>
                                <a href="{{ route('task.edit', $task->id) }}" class="btn btn-success">
                                    <i class="fa fa-edit"></i>
                                </a>
                                <form action="{{ route('task.destroy', $task->id) }}" style="display: inline" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </form>
                            </div>
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
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
        <br>
        <br>
{{--        <div>--}}
{{--            <h2>Statistics</h2>--}}
{{--            <canvas id="taskChart"></canvas>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--    <script>--}}
{{--        document.addEventListener('DOMContentLoaded', function () {--}}
{{--            var ctx = document.getElementById('taskChart').getContext('2d');--}}
{{--            var taskChart = new Chart(ctx, {--}}
{{--                type: 'bar',--}}
{{--                data: {--}}
{{--                    labels: ['Done', 'Todo', 'In Progress'],--}}
{{--                    datasets: [{--}}
{{--                        label: 'Tasks',--}}
{{--                        data: [--}}
{{--                            {{ $completedTasks }},--}}
{{--                            {{ $pendingTasks }},--}}
{{--                            {{ $inProgressTasks }}--}}
{{--                        ],--}}
{{--                        backgroundColor: [--}}
{{--                            'rgba(75, 192, 192, 0.2)',--}}
{{--                            'rgba(255, 206, 86, 0.2)',--}}
{{--                            'rgba(153, 102, 255, 0.2)'--}}
{{--                        ],--}}
{{--                        borderColor: [--}}
{{--                            'rgba(75, 192, 192, 1)',--}}
{{--                            'rgba(255, 206, 86, 1)',--}}
{{--                            'rgba(153, 102, 255, 1)'--}}
{{--                        ],--}}
{{--                        borderWidth: 1--}}
{{--                    }]--}}
{{--                },--}}
{{--                options: {--}}
{{--                    scales: {--}}
{{--                        y: {--}}
{{--                            beginAtZero: true--}}
{{--                        }--}}
{{--                    }--}}
{{--                }--}}
{{--            });--}}
{{--        });--}}
{{--    </script>--}}
@endsection
