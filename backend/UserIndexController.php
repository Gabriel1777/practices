<?php

namespace App\Http\Controllers\User;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

class UserIndexController extends ApiController
{
    private $user;

    public function __construct(User $user)
    {
        $this->user = $user;
        $this->middleware('auth:api');
    }

    public function index()
    {
        try {
            return $this->showAll($this->user, 200);
        } catch (\Exception $exception) {
            return $this->errorResponse($exception->getMessage(), 400);
        }
    }
}
