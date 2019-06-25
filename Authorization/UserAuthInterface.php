<?php

namespace Modules\Flatiko\Services\Authorization;

use Illuminate\Http\Request;
use Modules\User\Entities\Sentinel\User;

interface UserAuthInterface
{
    /**
     * @param $request
     *
     * @return User
     */
    public function register($request) : User;

    /**
     * @param Request $request
     *
     * @return User
     */
    public function login($request) : User;

    /**
     * @return mixed
     */
    public function logout();

    /**
     * @return mixed
     */
    public function forgotPassword();
}