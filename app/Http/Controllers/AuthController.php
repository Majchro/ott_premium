<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use Auth;

class AuthController extends Controller
{
    public function authentication(LoginRequest $request)
    {
        $credentials = $request->validated();
        if (Auth::attempt($credentials, true)) {
            $request->session()->regenerate();
            return redirect()->intended('dashboard');
        }

        return back()->withErrors([
            'password' => 'Wrong password'
        ]);
    }
}
