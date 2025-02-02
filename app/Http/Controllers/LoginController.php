<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class LoginController extends Controller
{
    public function hi(Request $request)
    {
        $userId = Auth::id();
        Log::channel('visits')->info($userId, [
            'ip' => $request->ip(),
            'user-agent' => $request->header('user-agent'),
            'sec-ch-ua-platform' => $request->header('sec-ch-ua-platform'),
            'sec-ch-ua' => $request->header('sec-ch-ua'),
        ]);
        return ['authenticated' => $userId];
    }

    /**
     * Handle an authentication attempt.
     */
    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials, true)) {
            $request->session()->regenerate();

            return ["message" => "Success", "new_token" => csrf_token()];
        }

        abort(422, "Authentication failed");
    }

    /**
     * Log the user out of the application.
     */
    public function logout(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return ["message" => "Success", "new_token" => csrf_token()];
    }
}
