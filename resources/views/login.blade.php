@extends('layout')

@section('main-content')
    <div>
        <div class="float-start">
            <h4 class="pb-3">Login</h4>
        </div>
    </div>
        <form class="col-4 offset-4 border rounded" method="POST" action="{{ route('user.login') }}">
            @csrf
            <div class="form-group mb-3">
                <label for="email" class="col-form-label-lg">Your e-mail</label>
                <input class="form-control" id="email" name="email" type="text" value="" placeholder="Email">
                @error('email')
                <div class="alert alert-danger">
                    {{ $message }}
                </div>
                @enderror
            </div>
            <div class="form-group mb-3">
                <label for="password" class="col-form-label-lg">Password</label>
                <input class="form-control" id="password" name="password" type="password" value="" placeholder="Password">
                @error('password')
                <div class="alert alert-danger">
                    {{ $message }}
                </div>
                @enderror
            </div>
            <div class="form-group" align="center">
                <button class="btn btn-lg btn-primary" type="submit"  name="sendMe" value="1">Login</button>
            </div>
        </form>

@endsection
