<?php

namespace App\Http\Controllers\API;

use App\Traits\ApiResponses;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\LoginUserRequest;
use App\Models\User;
use App\Permissions\V1\Abilities;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    use ApiResponses;

    public function login(LoginUserRequest $request)
    {
        $data = $request->validated();
        if(! auth()->attempt($data)) {

            return $this->error('Invalid credentials.', 401);
        }

        // $user = auth()->user();
        $user = User::firstWhere('email', auth()->user()->email);
        return $this->ok(
            'Authenticated successfully',
            [
                'token' => $user->createToken(
                    'api token for ' . $user->email,
                    Abilities::getAbilities($user), // ['*' ], // permissions|abilities we can assign to user
                    now()->addMonth()
                )->plainTextToken,
                'token_type' => 'Bearer',
                'user' => $user,
            ]
            , 200
        );
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return $this->ok('');
    }
}
