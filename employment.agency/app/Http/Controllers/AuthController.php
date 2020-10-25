<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AuthController extends Controller
{


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RegisterRequest $request)
    {
        $user = User::create($request->validated()); //->validated()
        return response()->json($user, 201);
    }

    // public function register(RegisterRequest $request): JsonResponse
    // {
    //     $user = User::create($request->validated());
    //     $data = UserResource::make($user)->toArray($request) +
    //         ['access_token' => $user->createToken('api')->plainTextToken];
    //     return $this->created($data);
    // }
}
