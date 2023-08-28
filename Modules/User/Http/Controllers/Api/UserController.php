<?php

namespace Modules\User\Http\Controllers\Api;

use Dingo\Api\Http\Request;
use Illuminate\Support\Facades\Hash;
use Modules\Authentication\Transformers\AuthenticateUserResource;
use Modules\Core\Http\Controllers\Api\CoreController;
use Modules\User\Entities\User;

/**
 * @group  User account
 *
 * APIs for user informations and update profile
 *
 * @Resource("User", uri="/user")
 */
class UserController extends CoreController
{
    public function me(Request $request)
    {
        return $this->successResponse(__('User information'), [
            'user' => new AuthenticateUserResource($request->user()),
        ]);
    }

    public function exists(Request $request)
    {
        if($request->phone_number) {
            $user = User::query()->where('phone_number', $request->phone_number)->first();
            if($user) {
                return $this->successResponse(__('User exists'), [
                    'user' => new AuthenticateUserResource($user),
                ]);
            }

            return $this->errorResponse(__('User does not exist with this phone number'));
        }

        if($request->email) {
            $user = User::query()->where('email', $request->email)->first();
            if($user) {
                return $this->successResponse(__('User exists'), [
                    'user' => new AuthenticateUserResource($user),
                ]);
            }

            return $this->errorResponse(__('User does not exist with this email'));
        }

        return $this->errorResponse(__('Pass either the phone number or the email to check if the user exists'));
    }

    public function update(Request $request, int $id)
    {
        $user = User::findOrFail($id);
        $path = null;
        if($request->hasFile('profile_image')){

            $file = $request->file('profile_image');

            $name = now()->timestamp.".{$file->getClientOriginalName()}";

            $path = config('app.url').'/storage/'.$file->storeAs('profile', $name, 'public');
        }
        $data = array_filter([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'gender' => $request->gender,
            'birthdate' => $request->birthdate,
            'phone_number' => $request->phone_number,
            'address' => $request->address,
            'status' => $request->status??$user->status,
            'profile_photo_url' => $path,
        ]);
        $user->update($data);

        return $this->successResponse(
            __('Update user successfully'),
            ['user' => new AuthenticateUserResource($user)]
        );
    }

    public function updatePassword(Request $request) {
        $id = $request->user()->id;
        $user = User::findOrFail($id);

        if (Hash::check($request->password, $user->password)) {
            $data = [
                'password' => Hash::make($request->new_password),
            ];
            $user->update($data);

            return $this->successResponse(
                __('Update user password successfully'),
                ['user' => new AuthenticateUserResource($user)]
            );
        }
        return $this->errorResponse(
            __('Error updating password, old password incorrect'),
            500
        );
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);

//        $this->authorize(Policy::DELETE, $speciality);

        $user->delete();

        return $this->successResponse(__('Deleted user successfully!'));
    }
}
