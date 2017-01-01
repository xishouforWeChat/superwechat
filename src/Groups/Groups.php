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
	 * Create A Groups
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
	 * Update Group Name
	 * 
	 * @param array $groupData
	 */
	public function update(array $groupData)
	{
		return $this->parseJSON('json', [self::API_GROUP_UPDATE, $groupData]);
	}
	
	/**
	 * 移动用户至分组
	 */
	public function memberUpdate( $openid,  $toGroupId)
	{
		return $this->parseJSON('json', [self::API_MEMBERS_UPDATE, ['openid' => $openid,'to_groupid' => $toGroupId]]);
	}
	
	/**
	 * 批量移动用户至分组
	 * 
	 * @param array $openidList
	 * @param int $toGroupId
	 */
	public function memberBatchupdate(array $openidList, $toGroupId)
	{
		return $this->parseJSON('json', [self::API_MEMBERS_BATCHUPDATE, ['openid_list' => $openidList,'to_groupid' => $toGroupId]]);
	}
	
	/**
	 * 删除用户分组
	 * 
	 * @return \EasyWeChat\Support\Collection
	 */
	public function delete($groupId)
	{
		return $this->parseJSON('json', [self::API_GROUP_DELETE, ['group' => ['id' => $groupId]]]);
	}
	
	/**
	 * 获取所有分组
	 */
	public function all()
	{
		return $this->parseJSON('get', [self::API_GROUP_GET]);
	}
	
	/**
	 * 获取用户分组
	 * 
	 * @param string $openId
	 */
	public function getMemberGroupId($openId) 
	{
		return $this->parseJSON('json', [self::API_GROUP_GETID,['openid' => $openId]]);
	}
}