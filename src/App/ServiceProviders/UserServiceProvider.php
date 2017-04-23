<?php
namespace Superwechat\App\ServiceProviders;
use Pimple\Container;
use Pimple\ServiceProviderInterface;
use Superwechat\User\User;

/**
 * Created by PhpStorm.
 * User: xuzongchao
 * Date: 17/4/23
 * Time: 18:48
 */
class UserServiceProvider implements ServiceProviderInterface
{
    /**
     * Registers services on the given container.
     *
     * This method should only be used to configure services and parameters.
     * It should not get services.
     *
     * @param Container $pimple A container instance
     */
    public function register(Container $pimple)
    {
        // TODO: Implement register() method.
        $pimple['user'] = function () use ($pimple) {
            return new User($pimple['access_token']);
        };

    }
}