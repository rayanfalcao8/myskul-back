<?php

namespace Modules\Authentication\Http\Controllers\Api;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Modules\Authentication\Http\Requests\Api\ForgetPasswordRequest;
use Modules\Core\Http\Controllers\Api\CoreController;
use Modules\User\Entities\User;

/**
 * @group  Users management
 *
 * APIs for managing users
 *
 * @Resource("User")
 */
class ForgotPasswordController extends CoreController
{
    /**
     * Forgot password.
     *
     * Request for a new password
     *
     * @Post("/forget-password")
     * @Versions({"v1"})
     * @Request({
        "email": "you@address.com"
        })
     */
    public function forgot(ForgetPasswordRequest $request)
    {
        DB::table('password_resets')->where(['email'=> $request->email])->delete();

        $token = hash('sha256', $request->email);
        DB::table('password_resets')->insert([
            'email' => $request->email,
            'token' => $token,
            'created_at' => Carbon::now()
        ]);

        $user = User::query()->where('email', $request->email)->first();
        if($user == null) {
            return $this->errorResponse(__("User not found"));
        }
        Mail::send('authentication::forgot-password', ['url' => 'myskulapp://mobile.digihealthsarl.com/auth/reset?token='.$token.'&email='.$user->email, 'user' => $user, 'logo' => 'img/logo.png'],
            function($message) use($request){
                $message->to($request->email);
                $message->subject('Reset Password Notification');
                $message->attach('img/logo.png', [
                    'as' => 'logo.png',
                    'mime' => 'image/png',
                ]);

                $message->embedData(file_get_contents('img/logo.png'), 'logo.png', 'image/png');
            }
        );

        return $this->successResponse(__('Password reset e-mail successfully send!'), ['token' => $token, 'user' => $user]);
    }
}
