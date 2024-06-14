<?php

namespace App\Http\Controllers\API\V1;

use App\Models\User;
use App\Http\Requests\API\V1\StoreUserRequest;
use App\Http\Requests\API\V1\UpdateUserRequest;
use App\Http\Resources\V1\UserResource;

class UserController extends ApiController
{
    public function index()
    {
        if($this->include('tickets')) {
            return UserResource::collection(User::with(['tickets'])->paginate());
        }

        return UserResource::collection(User::paginate());
    }

    public function store(StoreUserRequest $request)
    {
        //
    }

    public function show(User $user)
    {
        if($this->include('tickets')) {
            return new UserResource($user->load('tickets'));
        }
        return new UserResource($user);
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        //
    }

    public function destroy(User $user)
    {
        //
    }
}
