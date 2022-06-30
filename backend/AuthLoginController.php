<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Http\Controllers\ApiController;
use App\Http\Requests\Auth\AuthUserEmailRequest;

class AuthEmailController extends ApiController
{
    public function login(AuthUserEmailRequest $request)
    {
        try {
            $credentials = $request->only('email', 'password');
            $token = $this->validateCredentials($credentials);
            $this->validateRole($request->role_id);
            $this->validateState();
            return $this->responseToken($token);
        } catch (\Exception $exception) {
            return $this->errorResponse($exception->getMessage(), 400);
        }
    }
}
