<?php

namespace App\Http\Controllers\User;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\ApiController;
use App\Http\Requests\User\UserCreateRequest;

class UserCreateController extends ApiController
{
    private $user;

    public function __construct(User $user){
    	$this->user = $user;
    	$this->middleware("auth:api");
    }

    public function store(UserCreateRequest $request)
    {
    	DB::beginTransaction();
    	try{
    		$user = $this->user->setData($request->all());
    		$user->save();
    		DB::commit();
    		return $this->showOne($user, 200);
    	} catch (\Exception $exception){
    		DB::rollback();
    		return $this->errorResponse($exception->getMessage(), 400);
    	}
    }
}