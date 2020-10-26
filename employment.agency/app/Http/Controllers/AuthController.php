<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Laravel\Sanctum\HasApiTokens;

class AuthController extends Controller
{


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function register(RegisterRequest $request)
    {
        $user = User::create($request->validated());
        $data = UserResource::make($user)->toArray($request) +
            ['api_token' => $user->createToken('api')->plainTextToken];
        return $this->created($data);
    }



    /**
     * @param LoginRequest $request
     * @return JsonResponse
     * @throws ValidationException
     */
    public function login(LoginRequest $request): JsonResponse
    {
        if (!auth()->once($request->validated())) {
            throw ValidationException::withMessages([
                'email' => 'Wrong Email or Password',
            ]);
        }
        /** @var User $user */
        $user = auth()->user();
        $data =  UserResource::make($user)->toArray($request) +
            ['api_token' => $user->createToken('api')->plainTextToken];
        return $this->success($data);
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return JsonResponse
     */
    public function logout(): JsonResponse
    {
        /** @var User $user */
        $user = auth()->user();
        $user->currentAccessToken()->delete();
        return $this->success('User logged out.');
    }

    /**
     * Fallback route action
     *
     * @return JsonResponse
     */
    public function fallback(): JsonResponse
    {
        return $this->error('Page Not Found.', JsonResponse::HTTP_NOT_FOUND);
    }
}
