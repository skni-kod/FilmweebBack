<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends BaseController
{
    public function register(RegisterRequest $request)
    {
        $requestData = $request->validated();
        $requestData['password'] = Hash::make($request['password']);
        $user = User::create($requestData);

        return $this->sendResponse([
            'user' => new UserResource($user),
            'token' => $user->createToken('token-filmweeb')->plainTextToken
        ], 'User successfully registered', Response::HTTP_CREATED);
    }

    public function login(LoginRequest $request)
    {
        if (!$token = auth()->attempt($request->validated())) {
            $this->sendError('Unauthorized', null, Response::HTTP_UNAUTHORIZED);
        }

        return $this->sendResponse([
            'user' => new UserResource(auth()->user()),
            'token' => $token,
        ], 'User successfully login');
    }
}
