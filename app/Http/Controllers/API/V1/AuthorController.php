<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Filters\V1\AuthorFilter;
use App\Models\User;
use App\Http\Requests\API\V1\StoreUserRequest;
use App\Http\Requests\API\V1\UpdateUserRequest;
use App\Http\Resources\V1\UserResource;

class AuthorController extends ApiController
{
    public function index(AuthorFilter $filters)
    {
       return UserResource::collection(User::filter($filters)->paginate());
    }

    public function store(StoreUserRequest $request)
    {
        //
    }

    public function show(User $author)
    {
        if($this->include('tickets')) {
            return new UserResource($author->load('tickets'));
        }
        return new UserResource($author);
    }

    public function update(UpdateUserRequest $request, User $author)
    {
        //
    }

    public function destroy(User $author)
    {
        //
    }
}
