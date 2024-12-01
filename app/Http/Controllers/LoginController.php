<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
//    protected function login(Request $request, $user)
//    {
//        return redirect()->route('tasks.index');
//    }
    public function login(Request $request)
    {
        if (Auth::check()){
            return redirect()->intended(route('/'));
        }

        $formFields = $request->only(['email', 'password']);

        if(Auth::attempt($formFields)){
            return redirect()->intended('/');
        }

        return redirect(route('user.login'))->withErrors([
            'email' => 'Failed to login, please try again.',
        ]);
    }
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }

}

