@extends('layout')

@section('main-content')
    <div class="container">
        <h2>Оцінка часу для завдання: {{ $task->title }}</h2>
        <p>Розрахована оцінка часу виконання: <strong>{{ number_format($estimate, 2) }}</strong> годин.</p>
        <a href="{{ route('index', $task->id) }}" class="btn btn-secondary"> <i class="fa-solid fa-circle-left"></i> Назад до завдання</a>
    </div>
@endsection
