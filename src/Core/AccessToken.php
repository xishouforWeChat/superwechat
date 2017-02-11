<?php
namespace Superwechat\Core;

use Doctrine\Common\Cache\FilesystemCache;

class AccessToken {
	
	/**
	 * AppId
	 * 
	 * @var $appId
	 */
	protected $appId;
	
	/**
	 * appSecret
	 * 
	 * @var $appSecret
	 */
	protected $appSecret;
	
	/**
	 * 
	 * @var $cache
	 */
	protected $cache;
	
	/**
	 * cacheKey
	 * 
	 * @var $cacheKey
	 */
	protected $cacheKey;
	
	/**
	 * queryName
	 * 
	 * @var string 
	 */
	protected $queryName = 'access_token';
	
	/**
	 * prefix
	 * 
	 * @var $prefix
	 */
	protected $prefix = "supperchat.accesstoken";
	
	const ACCESS_TOKEN_API = "https://api.weixin.qq.com/cgi-bin/token";
	
	/**
	 * Constructor
	 * 
	 * @param string $appId
	 * @param string $appSecret
	 * @param Cache $cache
	 */
	public function __construct($appId, $appSecret, Cache $cache = null){
		$this->appId = $appId;
		$this->appSecret = $appSecret;
		$this->cache = $cache;
	}
	
	/**
	 * Return FilesystemCache
	 * 
	 * @return FilesystemCache
	 */
	public function getCache(){
		if (is_null($this->cache)) {
			return $this->cache = new FilesystemCache(sys_get_temp_dir());
		}
		return $this->cache;
	}
	
	/**
	 * Get cacheKey
	 * 
	 * @return string
	 */
	public function getCacheKey(){
		if (is_null($this->cacheKey)) {
			return $this->prefix.$this->appId;
		}
		return $this->cacheKey;
	}
	
	/**
	 * Get access_token
	 * 
	 * @param string $forceRefresh is force refresh token
	 * 
	 * @return $accessToken
	 */
	public function getAccessToken($forceRefresh = false){
		$cacheKey = $this->getCacheKey();
		$accessToken = $this->getCache()->fetch($cacheKey);
		if ($forceRefresh || ! $accessToken) {
			$token = $this->getAccessTokenFromServer();
			$this->cache->save($this->getCacheKey(), $token['access_token'], $token['expires_in'] -1200);
			return $token['access_token'];
		}
		return $accessToken;
	}
	
	/**
	 * Get access_token from wechat sdk API
	 * 
	 * @return string 
	 * 
	 * @throws Exception
	 */
	public function getAccessTokenFromServer(){
		$options = [
			'query'=>[
				'appid'      => $this->appId,
				'secret'     => $this->appSecret,
				'grant_type' => 'client_credential'
			]
		];
		$response = $this->getHttp()->request(self::ACCESS_TOKEN_API, "GET",$options);
		$body = $response->getBody();
		
		$body = json_decode($body, true);
		if ( ! array_key_exists('access_token', $body)){
			throw new Exception('access_token error:'.json_encode($body));
		}
		return $body;
	}
	
	/**
	 * Get Http
	 * 
	 * @return \Superchat\Core\Http
	 */
	public function getHttp(){
		$this->http = new Http();
		return $this->http;
	}
	
	/**
	 * Set appd
	 * 
	 * @param $appId
	 * 
	 * @return $this
	 */
	public function setAppId($appId){
		$this->appId = $appId;
		return $this;
	}
	
	/**
	 * Return appId
	 * 
	 * @return appid
	 */
	public function getAppId(){
		return $this->appId;
	}
	
	/**
	 * Set appSecret
	 * 
	 * @param  $appSecret
	 * 
	 * @return $this
	 */
	public function setAppSecret($appSecret){
		$this->appSecret = $appSecret;
		return $this;
	}
	
	/**
	 * @return string 
	 */
	public function getAppSecret(){
		return $this->appSecret;
	}
	
	public function setQueryName($queryName)
	{
		$this->queryName = $queryName;
	}
	
	public function getQueryName(){
		return $this->queryName;
	}
	
	public function getQueryFields(){
		return [$this->queryName => $this->getAccessToken()];
	}
	
	
}