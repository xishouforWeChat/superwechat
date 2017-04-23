<?php
/**
 * Created by PhpStorm.
 * User: xuzongchao
 * Date: 17/4/23
 * Time: 19:08
 */

namespace Superwechat\App\ServiceProviders;


use Pimple\Container;
use Pimple\ServiceProviderInterface;
use Superwechat\Template\Template;

class TemplateServiceProvider implements ServiceProviderInterface
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
        $pimple['template'] = function () use ($pimple) {
            return new Template($pimple['access_token']);
        };
    }
}