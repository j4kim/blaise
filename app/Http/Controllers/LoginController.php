<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class LoginController extends Controller
{
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

    public function updatePassword(Request $request)
    {
        $request->validate([
            'password' => ['required', 'string', 'current_password:web'],
            'newPassword' => ['required', 'confirmed', Password::min(8)],
        ], [
            'password.current_password' => 'The provided password does not match your current password.',
        ]);

        $request->user()->forceFill([
            'password' => Hash::make($request->newPassword),
        ])->save();

        return ["message" => "Success"];
    }
}
