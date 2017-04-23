<?php

namespace Superwechat\App;
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
        \Superwechat\App\ServiceProviders\UserServiceProvider::class,
        \Superwechat\App\ServiceProviders\TemplateServiceProvider::class,
        \Superwechat\App\ServiceProviders\MessageServiceProvider::class,
        \Superwechat\App\ServiceProviders\GroupServiceProvider::class,
        \Superwechat\App\ServiceProviders\MediaServiceProvider::class,
        \Superwechat\App\ServiceProviders\MenuServiceProvider::class,
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

        $this['access_token'] = function () {
            return new AccessToken($this['config']['appId'], $this['config']['appSecret']);
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
        array_pull($this->providers, $provider);
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