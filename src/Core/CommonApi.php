<?php
namespace Superwechat\Core;

use Superwechat\Core\AccessToken;
use GuzzleHttp\Psr7\Uri;
use Psr\Http\Message\RequestInterface;
use Superwechat\Core\Http;
use Superwechat\Lib\Connection;

/**
 * CommonApi
 * 
 * @author xuzongchao
 */
abstract class CommonApi
{
	/**
	 * Http instance
	 * 
	 * @var \Superwechat\Core\Http;
	 */
	protected $http;
	
	/**
	 * request token
	 * 
	 * @var AccessToken $accessToken
	 */
	protected $accessToken;
	
	/**
	 * Constructor
	 * 
	 * @param \Superwechat\Core\AccessToken $accessToken
	 */
	public function __construct(AccessToken $accessToken)
    {
		$this->setAccessToken($accessToken);
	}
	
	/**
	 * Set AccessToken
	 * 
	 * @param \Superwechat\Core\AccessToken $accessToken
	 */
	public function setAccessToken(AccessToken $accessToken)
    {
		$this->accessToken = $accessToken;
	}
	
	/**
	 * Parse JSON from response and check error.
	 *
	 * @param string $method
	 * @param array  $args
	 *
	 * @return \Superwechat\Lib\Connection
	 */
	public function parseJSON($method, array $args)
	{
		$http = $this->getHttp();
	
		$contents = $http->parseJSON(call_user_func_array([$http, $method], $args));
	
		
		$this->checkAndThrow($contents);
		
		return new Connection($contents);
		return $contents;
	}
	
	public function checkAndThrow($contents)
	{
		if (array_key_exists('errcode', $contents) && $contents['errcode'] != 0) {
			exit(Config::getErrorTips($contents['errcode']));
		}
	}
	
	/**
	 * 
	 * @param string $method
	 * @param array $args
	 * 
	 * @return mixed
	 */
	public function downlad($method, array $args)
	{
		$http = $this->getHttp();
		return call_user_func_array([$http, $method], $args);
	}
	
	/**
	 * accessTokenMiddleware
	 */
	protected function accessTokenMiddleware()
	{
		 return function (callable $handler) {
            return function (RequestInterface $request, array $options) use ($handler) {
                if (!$this->accessToken) {
                    return $handler($request, $options);
                }

                $field = $this->accessToken->getQueryName();
                $token = $this->accessToken->getAccessToken(false);
			
                $request = $request->withUri(Uri::withQueryValue($request->getUri(), $field, $token));
                
                return $handler($request, $options);
            };
        };
	}
	
	/**
	 * Register middleWare 
	 */
	public function regsiterMiddleWare()
	{
		$this->http->addMiddleWare($this->accessTokenMiddleware());
	}
	
	/**
	 * Get accessToken
	 * 
	 * @return string
	 */
	public function getAccessToken()
    {
		return $this->accessToken;
	}
	
	/**
	 * Get Http
	 * 
	 * @return Http
	 */
	public function getHttp()
    {
		if (is_null($this->http)) {
			$this->http = new Http();
		}
		
		if (count($this->http->getMiddleWares()) === 0) {
			$this->regsiterMiddleWare();
		}
		return $this->http;
	}
	
	/**
	 * Set A http 
	 * 
	 * @param Http $http
	 */
	public function setHttp(Http $http)
    {
		$this->http = $http;
	}
	
}