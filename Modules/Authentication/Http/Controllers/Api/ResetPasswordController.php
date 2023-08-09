<?php

namespace Modules\Authentication\Http\Controllers\Api;

use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Modules\Authentication\Http\Requests\Api\ResetPasswordRequest;
use Modules\Core\Http\Controllers\Api\CoreController;

class ResetPasswordController extends CoreController
{
    public function reset(ResetPasswordRequest $request)
    {
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user) use ($request) {
                $user->forceFill([
                    'password' => Hash::make($request->password),
                    'remember_token' => Str::random(60),
                ])->save();

                event(new PasswordReset($user));
            }
        );

        return $status === Password::PASSWORD_RESET
            ? $this->successResponse(__('Password successfully reset!'), ['response' => $status])
            : $this->errorResponse(__('Password could not be reset!'), ['email' => $status]);
    }
}
