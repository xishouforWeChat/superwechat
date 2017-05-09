<?php

namespace Superwechat\App;
use Doctrine\Common\Cache\Cache;
use Doctrine\Common\Cache\FilesystemCache;
use Pimple\Container;
use Pimple\ServiceProviderInterface;
use Superwechat\Core\AccessToken;

/**
 * Created by PhpStorm.
 * User: xuzongchao
 * Date: 17/4/23
 * Time: 18:40
 */
class Application extends Container
{

    /**
     * @var array
     */
    protected $providers = [
        ServiceProviders\UserServiceProvider::class,
        ServiceProviders\TemplateServiceProvider::class,
        ServiceProviders\MessageServiceProvider::class,
        ServiceProviders\GroupServiceProvider::class,
        ServiceProviders\MediaServiceProvider::class,
        ServiceProviders\MenuServiceProvider::class,
    ];

    /**
     * Application constructor.
     *
     * @param array $values
     */
    public function __construct(array $values)
    {
        parent::__construct();
        $this['config'] = function () use ($values) {
            return new Config($values);
        };

        if (!empty($this['config']['cache']) && $this['config']['cache'] instanceof Cache) {
            $this['cache'] = $this['config']['cache'];
        } else {
            $this['cache'] = function () {
                return new FilesystemCache(sys_get_temp_dir());
            };
        }


        $this['access_token'] = function () {
            return new AccessToken(
                $this['config']['appId'],
                $this['config']['appSecret'],
                $this['config']['cache']
            );
        };

        $this->registerProviders();
    }

    /**
     * Magic method
     *
     * @param $id
     * @param $value
     */
    public function __set($id, $value)
    {
        $this->offsetSet($id, $value);
    }

    /**
     * Magic method
     *
     * @param $id
     *
     * @return mixed
     */
    public function __get($id)
    {
        return $this->offsetGet($id);
    }


    /**
     * Add Provider
     *
     * @param ServiceProviderInterface $provider
     *
     * @return $this
     */
    public function addProvider(ServiceProviderInterface $provider)
    {
        array_push($this->providers, $provider);
        return $this;
    }

    /**
     * Get All Providers
     *
     * @return array
     */
    public function getAllProviders()
    {
        return $this->providers;
    }


    /**
     * Set Providers
     *
     * @param array $providers
     */
    public function setProviders(array $providers)
    {
        $this->providers = [];

        if (!empty($providers)) {
            foreach ($providers as $provider) {
                $this->addProvider($provider);
            }
        }
    }


    /**
     * register providers
     */
    public function registerProviders()
    {
        if (!empty($this->providers)) {
            foreach ($this->providers as $provider) {
                $this->register(new $provider());
            }
        }
    }

}