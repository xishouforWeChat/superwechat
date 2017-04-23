<?php
/**
 * Created by PhpStorm.
 * User: xuzongchao
 * Date: 17/4/23
 * Time: 19:13
 */

namespace Superwechat\App\ServiceProviders;


use Pimple\Container;
use Pimple\ServiceProviderInterface;
use Superwechat\Groups\Groups;

class GroupServiceProvider implements ServiceProviderInterface
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
        $pimple['group'] = function () use ($pimple){
            return new Groups($pimple[access_token]);
        };
        // TODO: Implement register() method.
    }
}