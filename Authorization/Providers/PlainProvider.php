<?php

namespace Modules\Flatiko\Services\Authorization\Providers;

use Modules\User\Entities\Sentinel\User;
use Modules\Flatiko\Helpers\FormatPhoneTrait;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Modules\Flatiko\Services\Authorization\UserAuthInterface;
use Modules\Flatiko\Services\Authorization\AuthorizationService;

class PlainProvider implements UserAuthInterface
{
    use FormatPhoneTrait;

    /**
     * @return string
     */
    public function getProvider(): string
    {
        return AuthorizationService::PLAIN_PROVIDER;
    }

    /**
     * @inheritdoc
     */
    public function register($request): User
    {
        if (!$user = User::where('telephone', $this->formatPhone($request->get('telephone')))->first()) {
            $user = $this->createUser([
                'email' => $request->get('email'),
                'password' => $request->get('password'),
                'first_name' => $request->get('first_name'),
                'last_name' => $request->get('last_name'),
                'telephone' => $this->formatPhone($request->get('telephone'))
            ]);
        }

        return $user;
    }

    /**
     * @inheritdoc
     */
    public function login($request): User
    {
        return User::where('email', $request->get('email'))->first();
    }

    /**
     * @inheritdoc
     */
    public function logout()
    {
        return true;
    }

    /**
     * @inheritdoc
     */
    public function forgotPassword()
    {
        // TODO: Implement forgotPassword() method.
    }

    /**
     * @param array $credentials
     *
     * @return bool|User
     */
    protected function createUser(array $credentials)
    {
        $user = Sentinel::registerAndActivate($credentials);
        $userGroup = Sentinel::findRoleBySlug('user');
        $userGroup->users()->attach($user);

        return $user;
    }
}
