<?php

namespace App\Http\Controllers;

use App\Exceptions\LoginInvalidException;
use App\Http\Requests\AuthLoginRequest;
use App\Http\Requests\AuthRegisterRequest;
use App\Http\Requests\AuthVerifyEmailRequest;
use App\Http\Resources\UserResource;
use App\Services\AuthService;

class AuthController extends Controller
{
    private AuthService $authService;

    /**
     * AuthController constructor.
     * @param  AuthService  $authService
     */
    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    /**
     * @param  AuthLoginRequest  $authLoginRequest
     * @return UserResource
     * @throws LoginInvalidException
     */
    public function login(AuthLoginRequest $authLoginRequest): UserResource
    {
        $input = $authLoginRequest->validated();
        $token = $this->authService->login($input['email'], $input['password']);

        return (new UserResource(auth()->user()))->additional($token);
    }

    public function register(AuthRegisterRequest $request)
    {
        $input = $request->validated();
        $user = $this->authService->register($input['first_name'], $input['last_name'] ?? '', $input['email'],
            $input['password']);

        return new UserResource($user);
    }

    public function verifyEmail(AuthVerifyEmailRequest $request)
    {
        $input = $request->validated();

        $user = $this->authService->verifyEmail($input['token']);

        return new UserResource($user);
    }
}
