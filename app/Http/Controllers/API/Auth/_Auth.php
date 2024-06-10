<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class _Auth extends Controller
{
    public function login(Request $request)
    {
        try {
            $request->validate([
                'email' => 'required|email',
                'password' => 'required',
            ]);

            $user = User::where('email', $request->email)->first();

            if (! $user || ! Hash::check($request->password, $user->password)) {
                // throw ValidationException::withMessages([
                //     'email' => ['The provided credentials are incorrect.'],
                // ]);
                return response()->json([
                    'code'=> 201,
                    'type' => 'error',
                    'title' => 'Feedback 👋',
                    'message' => '❌ The provided credentials are incorrect'
                ]);
            }

            return [
                'user' => $user,
                'token' => $user->createToken('login-token')->plainTextToken
            ];
        } catch (\Throwable $th) {
            return response()->json([
                'code'=> 500,
                'type' => 'error',
                'title' => 'Feedback 👋',
                'message' => '❌ Internal server error'
            ]);
        }
    }
}
