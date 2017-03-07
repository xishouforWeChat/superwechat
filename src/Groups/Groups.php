<?php
namespace Superwechat\Groups;

use Superwechat\Core\CommonApi;
use Superwechat\Core\AccessToken;

/**
 * Class Groups
 * @author xuzongchao
 */
class Groups extends CommonApi
{
	const API_GROUP_CREATE = "https://api.weixin.qq.com/cgi-bin/groups/create";
	const API_GROUP_GET = "https://api.weixin.qq.com/cgi-bin/groups/get";
	const API_GROUP_GETID = "https://api.weixin.qq.com/cgi-bin/groups/getid";
	const API_GROUP_UPDATE = "https://api.weixin.qq.com/cgi-bin/groups/update";
	const API_MEMBERS_UPDATE = "https://api.weixin.qq.com/cgi-bin/groups/members/update";
	const API_MEMBERS_BATCHUPDATE = "https://api.weixin.qq.com/cgi-bin/groups/members/batchupdate";
	const API_GROUP_DELETE = "https://api.weixin.qq.com/cgi-bin/groups/delete";
	
	
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
	 * Create a group
	 * 
	 * @param array $groupArr
	 * 
	 * @return
	 */
	public function create(array $groupArr) 
	{
		return $this->parseJSON('json', [self::API_GROUP_CREATE, $groupArr]);
	}
	
	/**
	 * Modify user group name
	 * 
	 * @param array $groupData
	 */
	public function update(array $groupData)
	{
		return $this->parseJSON('json', [self::API_GROUP_UPDATE, $groupData]);
	}
	
	/**
	 * Mobile users to groups
	 * 
	 * @param string $openid
	 * @param string $toGroupId
	 * 
	 * @return \Superwechat\Core\Collection
	 */
	public function memberUpdate( $openid,  $toGroupId)
	{
		return $this->parseJSON('json', [self::API_MEMBERS_UPDATE, ['openid' => $openid,'to_groupid' => $toGroupId]]);
	}
	
	/**
	 * Batch mobile users to group
	 * 
	 * @param array $openidList
	 * @param int $toGroupId
	 */
	public function memberBatchupdate(array $openidList, $toGroupId)
	{
		return $this->parseJSON('json', [self::API_MEMBERS_BATCHUPDATE, ['openid_list' => $openidList,'to_groupid' => $toGroupId]]);
	}
	
	/**
	 * Delete group
	 * 
	 * @return \Superwechat\Core\Collection
	 */
	public function delete($groupId)
	{
		return $this->parseJSON('json', [self::API_GROUP_DELETE, ['group' => ['id' => $groupId]]]);
	}
	
	/**
	 * Get all groups
	 */
	public function all()
	{
		return $this->parseJSON('get', [self::API_GROUP_GET]);
	}
	
	/**
	 * Get the user's group
	 * 
	 * @param string $openId
	 */
	public function getMemberGroupId($openId) 
	{
		return $this->parseJSON('json', [self::API_GROUP_GETID,['openid' => $openId]]);
	}
}