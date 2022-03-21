<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Auth;
use Laravel\Passport\RefreshToken;
use Laravel\Passport\Token;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $data = $request->validate([
            'email' => 'email|required',
            'password' => 'required',
        ]);

        if (!auth()->attempt($data)) {
            return response([
                'error_message' => 'Incorrect Details. 
            Please try again',
            ]);
        }

        $token = auth()
            ->user()
            ->createToken('API Token')->accessToken;

        return response(['user' => auth()->user(), 'token' => $token]);
    }
    public function logout(Request $request)
    {
        $tokenRepository = app('Laravel\Passport\TokenRepository');

        $user = auth('api')->user();

        if ($user) {
            $tokenRepository->revokeAccessToken($user->token()->id);
            return 'logged out';
        } else {
            return 'already logged out';
        }
    }
}
