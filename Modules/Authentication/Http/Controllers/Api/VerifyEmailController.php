<?php

namespace Modules\Authentication\Http\Controllers\Api;

use Illuminate\Auth\Events\Verified;
use Illuminate\Routing\Controller;
use Modules\Authentication\Http\Requests\Api\EmailVerificationRequest;
use Modules\User\Entities\User;

class VerifyEmailController extends Controller
{
    public function __invoke(EmailVerificationRequest $request, int $id)
    {
        $user = User::findOrFail($id);

        if ($user->hasVerifiedEmail()) {
            return view('authentication::emailverified')->with([
                'user' => $user,
            ]);
        }

        if ($user->markEmailAsVerified()) {
            event(new Verified($user));
        }

        return view('authentication::email-verified')->with(['user' => $user]);
    }
}
