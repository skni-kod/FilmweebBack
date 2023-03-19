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
    /**
     * @OA\Post(
     * path="/register",
     * summary="Sign up",
     * description="Register by email, password",
     * operationId="register",
     * tags={"Authentication"},
     * @OA\RequestBody(
     *    required=true,
     *    description="Pass user credentials",
     *    @OA\JsonContent(
     *       required={"user","email","password"},
     *       @OA\Property(property="user", type="string", format="string", example="foo_user"),
     *       @OA\Property(property="email", type="string", format="email", example="abc@abc.pl"),
     *       @OA\Property(property="password", type="string", format="password", example="PassWord12345"),
     *    ),
     * ),
     * @OA\Response(
     *    response=201,
     *    description="User created",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="Use has been created.")
     *        )
     *     )
     * )
     */
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

    /**
     * @OA\Post(
     * path="/login",
     * summary="Sign in",
     * description="Login by email, password",
     * operationId="login",
     * tags={"Authentication"},
     * @OA\RequestBody(
     *    required=true,
     *    description="Pass user credentials",
     *    @OA\JsonContent(
     *       required={"user","password"},
     *       @OA\Property(property="user", type="string", format="email", example="foo_user"),
     *       @OA\Property(property="password", type="string", format="password", example="PassWord12345"),
     *    ),
     * ),
     * @OA\Response(
     *    response=200,
     *    description="Success",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="Logged in successfully")
     *        )
     *     ),
     * @OA\Response(
     *    response=401,
     *    description="Unauthorized",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="Sorry, wrong email address or password. Please try again")
     *        )
     *     )
     * )
     */
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
    /**
     * @OA\Get (
     * path="/login/{provider}/redirect",
     * summary="Redirect",
     * description="Redirect to provider page to login using its provider",
     * operationId="providerAccess",
     * tags={"Authentication"},
     * @OA\RequestBody(
     *    required=true,
     *    description="Pass provider name",
     *    @OA\JsonContent(
     *       required={"provider name"},
     *       @OA\Property(property="provider_name", type="string", example="github"),
     *    ),
     * ),
     * @OA\Response(
     *    response=200,
     *    description="Success",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="Successfully redirected to provider page")
     *        )
     *     )
     * )
     */
    public function redirectToProvider($provider)
    {
        $validated = $this->validateProvider($provider);
        if (!is_null($validated)) {
            return $validated;
        }

        return Socialite::driver($provider)->stateless()->redirect()->getTargetUrl();
    }

    /**
     * Obtain the user information from Provider.
     *
     * @param $provider
     * @return JsonResponse
     */
    /**
     * @OA\Get (
     * path="/login/{provider}/callback",
     * summary="Handle provider callback",
     * description="Get provider response and handle it",
     * operationId="handleCallback",
     * tags={"Authentication"},
     * @OA\RequestBody(
     *    required=true,
     *    description="Pass provider name",
     *    @OA\JsonContent(
     *       required={"provider name"},
     *       @OA\Property(property="provider_name", type="string", example="github"),
     *    ),
     * ),
     * @OA\Response(
     *    response=200,
     *    description="Success",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="Success")
     *        )
     *     )
     * @OA\Response(
     *    response=422,
     *    description="Unprocessable entity",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="Unable to handle provider login")
     *        )
     *     )
     * )
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
