<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/', [\App\Http\Controllers\TaskController::class, 'index'])->name('index');
Route::resource('task', \App\Http\Controllers\TaskController::class);
Route::get('/tasks', [TaskController::class, 'index'])->name('tasks.index')->middleware('auth');
//Route::get('/tasks', [\App\Http\Controllers\TaskController::class, 'index'])->middleware('auth');

//Auth::routes();
/*
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');
*/
Route::name('user.')->group(function () {
    Route::view('/private', 'private')->middleware(['auth'])->name('private');

    Route::get('/login', function () {
        if(\Illuminate\Support\Facades\Auth::check()){
            return redirect(route('user.private'));
        }
        return view('login');
    })->name('login');

    Route::post('/login', [\App\Http\Controllers\LoginController::class, 'login']);

    Route::get('/logout', function() {
        Auth::logout();
        return redirect(route('index'));
    })->name('logout');

    Route::get('/register', function () {
        if(\Illuminate\Support\Facades\Auth::check()){
            return redirect(route('index'));
        }
        return view('register');
    })->name('register');

    Route::post('/register', [\App\Http\Controllers\RegisterController::class, 'save']);
});

/*
require __DIR__.'/auth.php';
*/
