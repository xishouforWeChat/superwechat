<?php
namespace Superwechat\User;

use Superwechat\Core\CommonApi;
use Superwechat\Core\AccessToken;

/**
 * Class User
 * 
 * @author xuzongchao
 */
class User extends CommonApi
{
	const API_USER_INFO = "https://api.weixin.qq.com/cgi-bin/user/info";
	const API_USER_LIST_INFO = "https://api.weixin.qq.com/cgi-bin/user/info/batchget";
	const API_UPDATE_USER_MARK = "https://api.weixin.qq.com/cgi-bin/user/info/updateremark";
	const API_GET_USERLIST = "https://api.weixin.qq.com/cgi-bin/user/get";
	
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
	 * Get user information
	 * 
	 * @param unknown $openId
	 * @param string $lang
	 */
	public function getUserInfo($openId, $lang = 'zh_CN')
	{
		return  $this->parseJSON('get', [self::API_USER_INFO,['openId' => $openId, 'lang' => $lang]]);
	}
	
	/**
	 * Batch get user information
	 * 
	 * @param array $user_list
	 */
	public function getUserListInfo(array $user_list)
	{
		return $this->parseJSON('json', [self::API_USER_LIST_INFO,['user_list' => $user_list]]);
	}
	
	/**
	 * Set the name of the note
	 * 
	 * @param string $openId
	 * @param string $remark
	 * 
	 */
	public function updateUserMark($openId, $remark)
	{
		return $this->parseJSON('json', [self::API_UPDATE_USER_MARK, ['openid' => $openId, 'remark' => $remark]]);
	}
	
	/**
	 * Get a list of followers
	 * 
	 * @param string $nextOpenId
	 */
	public function getUserList($nextOpenId = NULL)
	{
		return $this->parseJSON('get', [self::API_GET_USERLIST,['next_openid' => $nextOpenId]]);
	}
}