<?php

namespace Modules\Flatiko\Services\Authorization;

class AuthorizationService
{
    const FACEBOOK_PROVIDER = 'facebook';
    const GOOGLE_PROVIDER = 'google';
    const PLAIN_PROVIDER = 'plain';

    public $authAdapter = null;

    /**
     * AuthorizationService constructor.
     *
     * @param $provider
     */
    public function __construct($provider)
    {
        $className = 'Modules\Flatiko\Services\Authorization\Providers\\' . ucfirst($provider  . 'Provider');

        $this->authAdapter = new $className();
    }

    /**
     * @param $provider
     *
     * @return UserAuthInterface
     */
    public static function provider($provider)
    {
        return (new self($provider))->authAdapter;
    }
}
