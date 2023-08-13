<?php

namespace Modules\Authentication\Http\Controllers\Api;

use Illuminate\Auth\Events\Verified;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Mail;
use Modules\Authentication\Http\Requests\Api\EmailVerificationRequest;
use Modules\User\Emails\VerifyEmailMail;
use Modules\User\Entities\User;

class VerifyEmailController extends Controller
{
    public function __invoke(EmailVerificationRequest $request, $id)
    {
        $id = Crypt::decryptString($id);

        $user = User::findOrFail($id);

        if ($user->hasVerifiedEmail()) {
            return view('authentication::emailverified')->with([
                'user' => $user,
            ]);
        }

        if ($user->markEmailAsVerified()) {
            event(new Verified($user));
        }

        return view('authentication::emailverified')->with([
            'user' => $user,
        ]);
    }

    public function resendEmail(EmailVerificationRequest $request, $id)
    {
        $user = User::findOrFail($id);

        if ($user->hasVerifiedEmail()) {
            return view('authentication::emailverified')->with([
                'user' => $user,
            ]);
        }

        Mail::send(new VerifyEmailMail($user));

        return $this->successResponse(
            __('A verification email has been sent to you.'),
            ['user' => $user]
        );
    }
}
