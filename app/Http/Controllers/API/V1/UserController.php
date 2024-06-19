<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Filters\V1\AuthorFilter;
use App\Http\Requests\API\V1\ReplaceUserRequest;
use App\Models\User;
use App\Http\Requests\API\V1\StoreUserRequest;
use App\Http\Requests\API\V1\UpdateUserRequest;
use App\Http\Resources\V1\UserResource;
use App\Policies\V1\UserPolicy;

class UserController extends ApiController
{
    protected $policyClass = UserPolicy::class;

    public function destroy(User $user)
    {
        $this->isAble('delete', $user);

        $user->delete();
        return $this->ok('User Deleted Successfully.');
    }

    public function index(AuthorFilter $filters)
    {
       return UserResource::collection(User::filter($filters)->paginate());
    }

    public function store(StoreUserRequest $request)
    {
        $this->isAble('store', User::class);

        $user = User::create($request->mappedAttributes());
        return new UserResource($user);
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
        $this->isAble('update', $user);

        $user->update($request->mappedAttributes());
        return new UserResource($user);
    }

    public function replace(ReplaceUserRequest $request, User $user)
    {
        $this->isAble('replace', $user);

        $user->update($request->mappedAttributes());
        return new UserResource($user);
    }
}
