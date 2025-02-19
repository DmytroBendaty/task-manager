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
        <div>
            <div class="float-end">
                <a href="{{ route('task.create') }}" class="btn btn-info">
                    <i class="fa fa-plus-circle"></i> Create Task
                </a>
            </div>
            <div class="clearfix"></div>
        </div>
    @endauth

{{--    @if ($message)--}}
{{--        <p>{{ $message }}</p>--}}
{{--    @else--}}
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
            <div>
{{--                <livewire:task-order />--}}
                <br>
                <ul id="task-list" class="list-group">
                    @foreach($tasks as $task)
                        <li class="list-group-item" data-id="{{ $task->id }}">
                            {{ $task->name }}
                        </li>
                    @endforeach
                </ul>
            </div>
        @endif
{{--    @endif--}}
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
