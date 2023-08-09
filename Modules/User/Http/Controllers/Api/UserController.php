<?php

namespace Modules\User\Http\Controllers\Api;

use Dingo\Api\Http\Request;
use Modules\Core\Http\Controllers\Api\CoreController;

/**
 * @group  User account
 *
 * APIs for user informations and update profile
 *
 * @Resource("User", uri="/user")
 */
class UserController extends CoreController
{
    /**
     * User profile.
     *
     * Get the current User data
     *
     * security={ {"sanctum": {} }},
     * @Get("/me")
     * @Response(200, body={"user": User})
     * @Versions({"v1"})
     */
    public function me(Request $request)
    {
        return $this->successResponse(__('User information'), [
            'user' => $request->user(),
        ]);
    }
}
