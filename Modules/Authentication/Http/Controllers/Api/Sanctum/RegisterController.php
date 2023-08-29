<?php

namespace Modules\Authentication\Http\Controllers\Api\Sanctum;

use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Modules\Antecedent\Entities\Antecedent;
use Modules\Authentication\Actions\CreateNewUser;
use Modules\Authentication\Http\Requests\Api\RegisterRequest;
use Modules\Core\Http\Controllers\Api\CoreController;
use Modules\User\Emails\VerifyEmailMail;
use Modules\User\Entities\User;

class RegisterController extends CoreController
{
    public function register(RegisterRequest $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'gender' => $request->gender,
            'birthdate' => $request->birthdate,
            'town' => $request->town,
            'phoneNumber' => str_replace(" ", "", $request->phoneNumber),
        ]);

        $user->assignRole('customer');

        Mail::send(new VerifyEmailMail($user));

        return $this->successResponse(
            __('Your user account has been successfully created. A verification email has been sent to you.'),
            []
        );
    }
}
