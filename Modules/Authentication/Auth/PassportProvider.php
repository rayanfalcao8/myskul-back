<?php

namespace Modules\Authentication\Auth;

use Dingo\Api\Contract\Auth\Provider;
use Dingo\Api\Routing\Route;
use Illuminate\Auth\AuthManager;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class PassportProvider implements Provider
{
    /**
     * The instance of the Passport TokenGuard that handles authentication
     * for API requests.
     *
     * @var \Illuminate\Auth\AuthManager
     */
    protected $auth;

    /**
     * Create a new instance using the Guard implementation configured for
     * Passport.
     *
     * @param \Illuminate\Auth\AuthManager $auth
     */
    public function __construct(AuthManager $auth)
    {
        // This should match the name of the "guard" set in config/auth.php
        // for API requests that uses the "passport" driver:
        $this->auth = $auth->guard('api');
    }


    /**
     * Authenticate request with Basic.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Dingo\Api\Routing\Route $route
     *
     * @return mixed
     */
    public function authenticate(Request $request, Route $route)
    {
        if ($this->auth->check()) {
            return $this->auth->user();
        }

        throw new UnauthorizedHttpException(
            'Token',
            __('Not authenticated.')
        );
    }
}
