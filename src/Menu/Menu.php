<?php
namespace Superwechat\Menu;

use Superwechat\Core\CommonApi;
use Superwechat\Core\AccessToken;

/**
 * Class Menu
 * 
 * @author xuzongchao
 */
class Menu extends CommonApi
{
	const API_GET = "https://api.weixin.qq.com/cgi-bin/menu/get";
	const API_CREATE = "https://api.weixin.qq.com/cgi-bin/menu/create";
	const API_ADDCONDITION_CREATE = "https://api.weixin.qq.com/cgi-bin/menu/addconditional";
	const API_DELETE = "https://api.weixin.qq.com/cgi-bin/menu/delete";
	const API_CURRENT = "https://api.weixin.qq.com/cgi-bin/get_current_selfmenu_info";
	const API_ADDCONDITION_DELETE = "https://api.weixin.qq.com/cgi-bin/menu/delconditional";
	const API_MENU_TEST = "https://api.weixin.qq.com/cgi-bin/menu/trymatch";
	
	/**
	 * Request params
	 * @var array
	 */
	protected $param = array();
	
	/**
	 * Constructor
	 * 
	 * @param AccessToken $accessToken
	 */
	public function __construct(AccessToken $accessToken)
	{
		parent::__construct($accessToken);
	}
	
	/**
	 * Create menu
	 */
	public function create(array $param)
	{
		$this->param = array_merge($this->param, $param);
		
		if (isset($param['matchrule'])) {
			return $this->parseJSON('json', [self::API_ADDCONDITION_CREATE,$this->param]);
		}
		
		return $this->parseJSON('json', [self::API_CREATE,$this->param]);
	}
	
	/**
	 * Get Current Menu
	 */
	public function current()
	{
		return $this->parseJSON('get', [self::API_CURRENT]);
	}
	
	/**
	 * Delete all menu
	 * 
	 * @return array
	 */
	public function delete($menuid = NULL)
	{
		if ($menuid === NULL) {
			return $this->parseJSON('post', [self::API_DELETE]);
		}
		return $this->parseJSON('post', [self::API_ADDCONDITION_DELETE,['menuid' => $menuid]]);
	}
	
	/**
	 * Get all menu
	 * 
	 * @return 
	 */
	public function all(){
		return $this->parseJSON('get', [self::API_GET]);
	}
	
	/**
	 * Test
	 */
	public function test()
	{
		return $this->parseJSON('get', [self::API_MENU_TEST, $this->param]);
	}
}