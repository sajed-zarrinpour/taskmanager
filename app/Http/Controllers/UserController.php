<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;

use App\Http\Resources\UserResource;
use App\Services\AuthenticationService;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function __construct(private AuthenticationService $authService){}

    public function register(RegisterRequest $request)  {
        $validated = $request->validated();

        $user = $this->authService->register(
            $validated['name'],
            $validated['email'],
            $validated['password']
        );

        return response()->json(new UserResource($user), 201);
    }

    public function login(LoginRequest $request)
    {
        $validated = $request->validated();

        $token = $this->authService->login($validated);

        if (empty($token)) {
            return response()->json(['error' => 'wrong credentials'], 401);
        }
       
        return response()->json(['token' => $token->plainTextToken]);
    }

    public function me(Request $request)
    {
        return response()->json(new UserResource($request->user()), 200);
    }

    public function logout(Request $request){
        $this->authService->logout($request->user());
        // empty  successfull response
        return response()->json(['message'=>'successfully logged out']);
    }
}
