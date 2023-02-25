<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;
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
        if (!Auth::attempt($request->validated())) {
            $this->sendError('Unauthorized', null, Response::HTTP_UNAUTHORIZED);
        }
        $user = $request->user();

        return $this->sendResponse([
            'user' => new UserResource($user),
            'token' => $user->createToken('token-filmweeb')->plainTextToken
        ], 'User successfully login');
    }

    /**
     * Redirect the user to the Provider authentication page.
     *
     * @param $provider
     * @return JsonResponse
     */
    public function redirectToProvider($provider)
    {
        $validated = $this->validateProvider($provider);
        if (!is_null($validated)) {
            return $validated;
        }

        return Socialite::driver($provider)->stateless()->redirect();
    }

    /**
     * Obtain the user information from Provider.
     *
     * @param $provider
     * @return JsonResponse
     */
    public function handleProviderCallback($provider)
    {
        $validated = $this->validateProvider($provider);
        if (!is_null($validated)) {
            return $validated;
        }
        try {
            $user = Socialite::driver($provider)->stateless()->user();
        } catch (ClientException $exception) {
            return $this->sendError('Invalid credentials provided.', null, Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $userCreated = User::firstOrCreate(
            [
                'email' => $user->getEmail()
            ],
            [
                'email_verified_at' => now(),
                'name' => $user->getName(),
                'status' => true,
            ]
        );
        $userCreated->providers()->updateOrCreate(
            [
                'provider' => $provider,
                'provider_id' => $user->getId(),
            ],
            [
                'avatar' => $user->getAvatar()
            ]
        );
        $token = $userCreated->createToken('token-filmweeb')->plainTextToken;

        return $this->sendResponse([
            'user' => new UserResource($userCreated),
            'token' => $token
        ], 'User login successful by ' . $provider);
    }

    /**
     * @param $provider
     * @return JsonResponse
     */
    protected function validateProvider($provider)
    {
        if (!in_array($provider, ['github'])) {
            return $this->sendError('Please login using github', null, Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }
}