<?php
/**
 * Created by PhpStorm.
 * User: xuzongchao
 * Date: 17/4/23
 * Time: 19:17
 */

namespace Superwechat\App\ServiceProviders;


use Pimple\Container;
use Pimple\ServiceProviderInterface;
use Superwechat\Menu\Menu;

class MenuServiceProvider implements ServiceProviderInterface
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
        $pimple['menu'] = function () use ($pimple) {
            return new Menu($pimple['access_token']);
        };
        // TODO: Implement register() method.
    }
}