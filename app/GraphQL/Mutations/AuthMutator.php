<?php

namespace App\GraphQL\Mutations;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Nuwave\Lighthouse\Exceptions\AuthenticationException;

class AuthMutator
{
    public function login($_, array $args)
    {
        if (!Auth::attempt([
            'email' => $args['email'],
            'password' => $args['password']
        ])) {
            throw new AuthenticationException('Invalid credentials');
        }

        $user = Auth::user();

        $token = $user->createToken('admin-token')->plainTextToken;

        return [
            'token' => $token,
            'user'  => $user
        ];
    }

    public function logout()
    {
        $user = Auth::user();
        $user->currentAccessToken()->delete();
        return 'Logged out successfully';
    }
}
