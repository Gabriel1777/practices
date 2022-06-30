<?php

namespace App\Http\Controllers\User;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\ApiController;
use App\Http\Requests\User\UserUpdateRequest;

class UserUpdateController extends ApiController
{
    private $user;

    public function __construct(User $user){
    	$this->user = $user;
    	$this->middleware("auth:api");
    }

    public function update(UserUpdateRequest $request, User $user)
    {
    	DB::beginTransaction();
    	try{
    		$this->user = $user->setData($request->all());
    		$this->user->save();
    		DB::commit();
    		return $this->showOne($this->user->refresh(), 200);
    	} catch (\Exception $exception){
    		DB::rollback();
    		return $this->errorResponse($exception->getMessage(), 400);
    	}
    }
}