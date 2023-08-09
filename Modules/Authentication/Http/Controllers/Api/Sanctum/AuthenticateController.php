<?php

namespace Modules\Authentication\Http\Controllers\Api\Sanctum;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Modules\Authentication\Actions\Authenticate;
use Modules\Authentication\Http\Requests\Api\LoginRequest;
use Modules\Authentication\Transformers\AuthenticateUserResource as UserResource;
use Modules\Core\Http\Controllers\Api\CoreController;

class AuthenticateController extends CoreController
{
    public function login(LoginRequest $request)
    {
        $user = Authenticate::run($request);

        if (! empty($user->tokens())) {
            $user->tokens()->delete();
        }

        $user->last_login_at = Carbon::now();
        $user->save();

        $token = $user->createToken($request->input('email'))->plainTextToken;

        return $this->successResponse(__('Successful connection. Your token was successfully generated'), [
            'token' => $token,
            'token_type' => 'Bearer',
            'user' => new UserResource($user),
        ]);
    }

    public function logout(Request $request)
    {
        if ($request->user()->currentAccessToken()) {
            $request->user()->currentAccessToken()->delete();
        }

        return $this->successResponse(__('Successful logout!'));
    }
}
