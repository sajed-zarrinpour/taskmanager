<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthenticationService
{
    public function register(string $name, string $email, string $password)  {

        $user = User::create([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($password),
        ]);

        return $user;
    }

    public function login(array $credentials)
    {

        if (!auth()->attempt($credentials)) {
            return null;
        }

        $token = auth()->user()->createToken('token_name');

        return $token;
    }

    public function logout(User $user){
        // revoke the token which used to authenticate current request
        $user->currentAccessToken()->delete();
    }
}
