<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SessionsController extends Controller
{
    public function create()
    {
        return view('auth.login');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'email' => ['string', 'required', 'email', 'max:255'],
            'password' => ['string', 'required', 'min:8', 'max:255'],
        ]);

        if (! Auth::attempt($validated)) {
            // failed
            return back()
                ->withErrors([
                    'password' => 'Unable to authenticate using the provided credentials',
                ])
                ->withInput($request->only('email'));
        }

        $request->session()->regenerate();

        return redirect()->intended('/')->with('success', 'You are now logged in!');
    }

    public function destroy(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('success', 'You have been logged out');
    }
}
