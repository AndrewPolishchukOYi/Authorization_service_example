<?php

namespace Modules\Flatiko\Services\Authorization\Providers;

use Illuminate\Support\Str;
use Modules\Flatiko\Entities\UserSocial;
use Modules\Flatiko\Services\Authorization\AuthorizationService;
use Modules\Flatiko\Services\Authorization\UserAuthInterface;
use Modules\User\Entities\Sentinel\User;

class FacebookProvider extends PlainProvider implements UserAuthInterface
{
    /**
     * @inheritdoc
     */
    public function getProvider(): string
    {
        return AuthorizationService::FACEBOOK_PROVIDER;
    }

    /**
     * @inheritdoc
     */
    public function login($request): User
    {
        $userSocial = UserSocial::where('uid', $request->get('uid'))
            ->where('provider', $this->getProvider())
            ->first();

        return $userSocial->user;
    }

    /**
     * @inheritdoc
     */
    public function register($request): User
    {
        if (!$user = User::where('telephone', $this->formatPhone($request->get('telephone')))->first()) {
            $user = $this->createUser([
                'email' => $request->get('email'),
                'first_name' => $request->get('first_name'),
                'last_name' => $request->get('last_name'),
                'telephone' => $this->formatPhone($request->get('telephone')),
                'password' => Str::random(6),
                'social_link' => $request->get('social_link'),
                'social_avatar_link' => $request->get('social_avatar_link')
            ]);
        }

        UserSocial::create([
            'user_id' => $user->id,
            'provider' => $this->getProvider(),
            'uid' => $request->get('uid')
        ]);

        return $user;
    }

    /**
     * @inheritdoc
     */
    public function forgotPassword()
    {
        return true;
    }
}
