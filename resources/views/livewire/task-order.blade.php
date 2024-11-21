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
                <ul id="task-list" wire:sortable="updateTaskOrder">
                    @foreach($tasks as $task)
                        <li wire:sortable.item="{{ $task->id }}" wire:key="task-{{ $task->id }}">
                            <div wire:sortable.handle style="cursor: move;">
                                {{ $task->name }}
                            </div>
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
