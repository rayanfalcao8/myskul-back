<?php

namespace Modules\Authentication\Http\Controllers\Api\Sanctum;

use Illuminate\Auth\Events\Registered;
use Modules\Authentication\Actions\CreateNewUser;
use Modules\Authentication\Http\Requests\Api\RegisterRequest;
use Modules\Core\Http\Controllers\Api\CoreController;

class RegisterController extends CoreController
{
    public function register(RegisterRequest $request)
    {
        $user = CreateNewUser::run($request);

        event(new Registered($user));

        // You can add you own customization here

        return $this->successResponse(
            __('Your user account has been successfully created. A verification email has been sent to you.'),
            ['user' => $user]
        );
    }
}
