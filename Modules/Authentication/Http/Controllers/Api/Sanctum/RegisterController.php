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
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'gender' => $request->gender,
            'birthdate' => $request->birthdate,
            'address' => $request->address,
            'phone_number' => str_replace(" ", "", $request->phone_number),
        ]);

        $user->assignRole('customer');

        Mail::send(new VerifyEmailMail($user));

        return $this->successResponse(
            __('Your user account has been successfully created. A verification email has been sent to you.'),
            []
        );
    }
}
