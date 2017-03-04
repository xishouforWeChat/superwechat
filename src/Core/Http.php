<?php
namespace Superwechat\Core;

use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\Middleware;
use GuzzleHttp\HandlerStack;
use Psr\Http\Message\ResponseInterface;
use GuzzleHttp\Psr7\Uri;
use GuzzleHttp\Client;

/**
 * Http
 * 
 * @author xuzongchao
 *
 */
class Http {
	/**
	 * Http Client
	 * 
	 * @var Http Client
	 */
	protected $client;
	
	/**
	 * The middlewares
	 * 
	 * @var array
	 */
	protected $middlewares = [];
	
	/**
	 * Guzzle client default settings.
	 * 
	 * @var array
	 */
	protected static $defaults = [];
	
	/**
	 * Set Guzzle default options
	 * 
	 * @param array $defaults
	 */
	public static function setDefaultOptions($defaults = [])
	{
		self::$defaults = $defaults;
	}
	
	/**
	 * Get Guzzle default options
	 * 
	 * @return array
	 */
	public static function getDefaultOptions()
	{
		return self::$defaults;
	}
	
	/**
	 * Make a request
	 * 
	 * @param string $uri
	 * @param string $method
	 * @param array $options
	 * 
	 * @return ResponseInterface 
	 * 
	 * @throws HttpException
	 */
	public function request($uri, $method = "GET", $options = [])
    {
		$method = strtoupper($method);
		
		$options = array_merge(self::$defaults, $options);
		
		$handler = $this->getHanlder();
		
		$options['handler'] = $handler;
		
		$response =  $this->getClient()->request($method, $uri,$options);
		return $response;
	}
	
/**
     * GET request.
     *
     * @param string $url
     * @param array  $options
     *
     * @return ResponseInterface
     *
     * @throws HttpException
     */
    public function get($url, array $options = [])
    {
        return $this->request($url, 'GET', ['query' => $options]);
    }

    /**
     * POST request.
     *
     * @param string       $url
     * @param array|string $options
     *
     * @return ResponseInterface
     *
     * @throws HttpException
     */
    public function post($url, $options = [])
    {
        $key = is_array($options) ? 'form_params' : 'body';
        return $this->request($url, 'POST', [$key => $options]);
    }

    /**
     * JSON request.
     *
     * @param string       $url
     * @param string|array $options
     * @param int          $encodeOption
     *
     * @return ResponseInterface
     *
     * @throws HttpException
     */
    public function json($url, $options = [], $encodeOption = JSON_UNESCAPED_UNICODE)
    {
        is_array($options) && $options = json_encode($options, $encodeOption);
        return $this->request($url, 'POST', ['body' => $options, 'headers' => ['content-type' => 'application/json']]);
    }
    
    /**
     * Upload 
     * 
     * @param string $uri
     * @param array $param
     * 
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function upload($uri, $param = [])
    {
    	return $this->request($uri, 'POST', ['multipart' => $param]);
    }
    
    /**
     * @param \Psr\Http\Message\ResponseInterface|string $body
     *
     * @return mixed
     *
     * @throws \EasyWeChat\Core\Exceptions\HttpException
     */
    public function parseJSON($body)
    {
    	if ($body instanceof ResponseInterface) {
    		$body = $body->getBody();
    	}
    
    	// XXX: json maybe contains special chars. So, let's FUCK the WeChat API developers ...
    	//$body = $this->fuckTheWeChatInvalidJSON($body);
    
    	if (empty($body)) {
    		return false;
    	}
    
    	$contents = json_decode($body, true);
    
    	//Log::debug('API response decoded:', compact('contents'));
    
    	if (JSON_ERROR_NONE !== json_last_error()) {
    		throw new Exception('Failed to parse JSON: '.json_last_error_msg());
    	}
    
    	return $contents;
    }
	/**
	 * Return All stack
	 * 
	 * @return HandlerStack $stack
	 */
	public function getHanlder()
    {
		$stack = HandlerStack::create();
		foreach ($this->middlewares as $val) {
			$stack->push($val);
		}
		return $stack;
	}
	
	/**
	 * Get Http Client
	 * 
	 * @return HttpClient
	 */
	public function getClient()
	{
		if ( ! ($this->client instanceof HttpClient))
		{
			$this->client = new HttpClient();
		}
		return $this->client;
	}
	
	/**
	 * Seet client
	 * 
	 * @param HttpClient $client
	 */
	public function setClient(HttpClient $client)
	{
		$this->client = $client;
		return $this;
	}
	
	/**
	 * Add a middleware
	 * 
	 * @param callable $middleware
	 * 
	 * @return $this
	 */
	public function addMiddleWare(callable $middleware)
	{
		array_push($this->middlewares, $middleware);
		return $this;
	}
	
	/**
	 * Return all middlewares
	 * 
	 * @return array
	 */
	public function getMiddleWares()
	{
		return $this->middlewares;
	}
	
	
}