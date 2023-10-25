<?php

namespace Modules\Authentication\Http\Controllers\Api\Sanctum;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\ValidationException;
use Modules\Authentication\Http\Requests\Api\LoginRequest;
use Modules\Authentication\Transformers\AuthenticateUserResource as UserResource;
use Modules\Core\Http\Controllers\Api\CoreController;
use Modules\User\Entities\User;

class AuthenticateController extends CoreController
{
    public function login(LoginRequest $request)
    {
        $user = User::where('email', strtolower($request->input('email')))->first();

//        if (! empty($user->tokens())) {
//            $user->tokens()->delete();
//        }

        // check account status
        if ($user?->email_verified_at === null) {
            return $this->errorResponse(__('Attempting to login to an inactive user'), []);
        }

        $sanitized = [
            'email' => strtolower($request->input('email')),
            'password' => $request->input('password'),
        ];

        if (empty($user) || !Auth::attempt($sanitized)) {
            if ($user->created_at == null) {
                $data = [
                    'password' => Hash::make($user->new_password),
                ];
                $user->update($data);

                Mail::send('authentication::new-password', ['user' => $user, 'logo' => 'img/logo.png'],
                    function($message) use($user){
                        $message->to($user->email);
                        $message->subject('New Password Notification');
                        $message->attach('img/logo.png', [
                            'as' => 'logo.png',
                            'mime' => 'image/png',
                        ]);

                        $message->embedData(file_get_contents('img/logo.png'), 'logo.png', 'image/png');
                    }
                );

                throw ValidationException::withMessages([
                    'email' => __('Invalid password,password has been reset verify your mails.'),
                ]);
            }
            throw ValidationException::withMessages([
                'email' => __('Invalid email address or password.'),
            ]);
        }

        $user->last_login_at = Carbon::now();
        $user->last_login_ip = $request->ip();
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
