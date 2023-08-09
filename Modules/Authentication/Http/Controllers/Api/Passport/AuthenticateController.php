<?php

namespace Modules\Authentication\Http\Controllers\Api\Passport;

use Carbon\Carbon;
use Dingo\Api\Http\Request;
use Modules\Authentication\Actions\Authenticate;
use Modules\Authentication\Http\Requests\Api\LoginRequest;
use Modules\Authentication\Transformers\AuthenticateUserResource as UserResource;
use Modules\Core\Http\Controllers\Api\CoreController;
use Modules\User\Entities\User;

class AuthenticateController extends CoreController
{
    public function authenticate(LoginRequest $request)
    {
        /** @var User $user */
        $user = Authenticate::run($request);

        $tokenResult = $user->createToken($user->email);
        $token = $tokenResult->token;
        $token->save();

        if ($request->boolean('remember_me')) $token->expires_at = Carbon::now()->addWeeks();

        return $this->successResponse(__('Successful connection. Your token was successfully generated'), [
            'access_token' => $tokenResult->accessToken,
            'token_type' => 'Bearer',
            'expires_at' => Carbon::parse($tokenResult->token->expires_at)->toDateTimeString(),
            'user' => new UserResource($user),
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->token()->revoke();

        return $this->successResponse(__('Successfully logout'));
    }
}
