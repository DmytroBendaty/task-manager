@extends('layout')

@section('main-content')
    <div>
        <div class="float-start">
            <h4 class="pb-3">Розрахунок оцінки часу для завдання: <span class="badge bg-info">{{ $task->title }}</span></h4>
        </div>
    </div>
    <div>
        <div class="float-end">
            <a href="{{ route('index') }}" class="btn btn-info">
                <i class="fa fa-arrow-left"></i> Back
            </a>
        </div>
        <div class="clearfix"></div>
    </div>

    <div class="container">
        {{--<h2>Розрахунок оцінки часу для завдання: {{ $task->title }}</h2>--}}
        <div class="card card-body bg-light p-4">
            <form action="{{ route('tasks.calculateEstimate', $task->id) }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="optimistic_time">Оптимістичний час (O):</label>
                    <input type="number" step="0.01" class="form-control" id="optimistic_time" name="optimistic_time" required>
                </div>
                <div class="form-group">
                    <label for="likely_time">Ймовірний час (M):</label>
                    <input type="number" step="0.01" class="form-control" id="likely_time" name="likely_time" required>
                </div>
                <div class="form-group">
                    <label for="pessimistic_time">Песимістичний час (P):</label>
                    <input type="number" step="0.01" class="form-control" id="pessimistic_time" name="pessimistic_time" required>
                </div>
                <button type="submit" class="btn btn-primary mt-3"> <i class="fa-solid fa-calculator"></i> Розрахувати оцінку часу</button>
            </form>
        </div>
    </div>
@endsection
