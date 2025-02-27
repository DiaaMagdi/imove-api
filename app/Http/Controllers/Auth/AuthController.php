<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function login(): View
    {
        return view('auth.login');
    }
    public function checkCredentials(Request $request): RedirectResponse
    {
        try {
            $credentials = $request->only('email', 'password');

            $validator = Validator::make($credentials, [
                'email' => 'required|email',
                'password' => 'required|string',
            ]);

            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            }

            if (Auth::attempt($credentials)) {
                if (! auth()->user()->is_active || auth()->user()->patient || auth()->user()->doctor) {
                    Session::flush();
                    Auth::logout();
                    return back()->with(['error' => __('messages.errors.cannot_login')]);
                }
                return redirect()->route('dashboard');
            }

            return back()->with(['error' => __('messages.errors.check_credentials')]);
        } catch (Exception $e) {
            return back()->with(['error' => $e->getMessage()]);
        }
    }

    public function logout(): RedirectResponse
    {
        Session::flush();
        Auth::logout();
        return redirect()->route('login');
    }
}
