<?php

namespace Modules\Authentication\Http\Controllers\Api;

use Illuminate\Support\Facades\Password;
use Modules\Authentication\Http\Requests\Api\ForgetPasswordRequest;
use Modules\Core\Http\Controllers\Api\CoreController;

class ForgotPasswordController extends CoreController
{
    public function forgot(ForgetPasswordRequest $request)
    {
        $response = Password::sendResetLink(
            $request->only('email')
        );

        return $response === Password::RESET_LINK_SENT
      ? $this->successResponse(__('Password reset e-mail successfully send!'), ['response' => $response])
      : $this->errorResponse(__('Email could be sent to this e-Mail address!'), ['email' => $request->only('email')], 401);
    }
}
