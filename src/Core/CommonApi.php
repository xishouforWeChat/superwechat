<?php
/**
 * CommonApi 
 * @author xuzongchao
 */
namespace Superwechat\Core;

use Superwechat\Core\AccessToken;
use GuzzleHttp\Psr7\Uri;
use Psr\Http\Message\RequestInterface;

abstract class CommonApi {
	/**
	 * Http instance
	 * 
	 * @var \Superchat\Core\Http;
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
	 * @param \Superchat\Core\AccessToken $accessToken
	 */
	public function __construct(AccessToken $accessToken){
		$this->setAccessToken($accessToken);
	}
	
	/**
	 * Set AccessToken
	 * 
	 * @param \Superchat\Core\AccessToken $accessToken
	 */
	public function setAccessToken(AccessToken $accessToken){
		$this->accessToken = $accessToken;
	}
	
	/**
	 * Parse JSON from response and check error.
	 *
	 * @param string $method
	 * @param array  $args
	 *
	 * @return \EasyWeChat\Support\Collection
	 */
	public function parseJSON($method, array $args)
	{
		$http = $this->getHttp();
	
		$contents = $http->parseJSON(call_user_func_array([$http, $method], $args));
	
		
		//$this->checkAndThrow($contents);
		
		//return new Collection($contents);
		return $contents;
	}
	
	/**
	 *
	 */
	protected function accessTokenMiddleware()
	{
		 return function (callable $handler) {
            return function (RequestInterface $request, array $options) use ($handler) {
                if (!$this->accessToken) {
                    return $handler($request, $options);
                }

                $field = $this->accessToken->getQueryName();
                $token = $this->accessToken->getAccessToken(true);
			
                $request = $request->withUri(Uri::withQueryValue($request->getUri(), $field, $token));
                
                return $handler($request, $options);
            };
        };
	}
	
	public function regsiterMiddleWare()
	{
		$this->http->addMiddleWare($this->accessTokenMiddleware());
	}
	
	/**
	 * Get accessToken
	 * 
	 * @return string
	 */
	public function getAccessToken(){
		return $this->accessToken;
	}
	
	public function getHttp(){
		if (is_null($this->http)) {
			$this->http = new Http();
		}
		
		if (count($this->http->getMiddleWares()) === 0) {
			$this->regsiterMiddleWare();
		}
		return $this->http;
	}
	
	public function setHttp(Http $http){
		$this->http = $http;
	}
	
}