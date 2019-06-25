<?php

namespace Modules\Flatiko\Services\Authorization\Providers;

use Modules\Flatiko\Services\Authorization\AuthorizationService;
use Modules\Flatiko\Services\Authorization\UserAuthInterface;

class GoogleProvider extends FacebookProvider implements UserAuthInterface
{
    /**
     * @inheritdoc
     */
    public function getProvider(): string
    {
        return AuthorizationService::GOOGLE_PROVIDER;
    }
}
