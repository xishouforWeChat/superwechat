<?php
namespace Superwechat\Media;
use Superwechat\Core\CommonApi;
use Superwechat\Core\AccessToken;

/**
 * Class Media
 * 
 * @author xuzongchao
 *
 */
class Media extends CommonApi
{
	const API_MEDIA_UPLOAD = 'https://api.weixin.qq.com/cgi-bin/media/upload';
	const API_MEDIA_GET = 'https://api.weixin.qq.com/cgi-bin/media/get';
	const API_MEDIA_UPLOADIMG = 'https://api.weixin.qq.com/cgi-bin/media/uploadimg';
	const API_MATERIAL_ADD_NEWS = 'https://api.weixin.qq.com/cgi-bin/material/add_news';
	const API_MATERIAL_ADD_MATERIAL = 'https://api.weixin.qq.com/cgi-bin/material/add_material';
	const API_MATERIAL_GET_MATERIAL = 'https://api.weixin.qq.com/cgi-bin/material/get_material';
	const API_MATERIAL_DEL_MATERIAL = 'https://api.weixin.qq.com/cgi-bin/material/del_material';
	const API_MATERIAL_UPDATE_NEWS = 'https://api.weixin.qq.com/cgi-bin/material/update_news';
	const API_MATERIAL_GET_MATERIALCOUNT = 'https://api.weixin.qq.com/cgi-bin/material/get_materialcount';
	const API_MATERIAL_BATCHGET_MATERIAL = 'https://api.weixin.qq.com/cgi-bin/material/batchget_material';


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
	 * Upload Media data
	 * 
	 * @param string $type 媒体文件类型，分别有图片（image）、语音（voice）、视频（video）和缩略图（thumb）
	 * @param array $uploadParam
	 * 
	 * @return \Superwechat\Lib\Connection
	 */
	public function upload($type, array $uploadParam)
	{
		$uri = self::API_MEDIA_UPLOAD . '?type='.$type;
		return $this->parseJSON('upload', [$uri, $uploadParam]);
	}
	
	
	/**
	 * Get Media 
	 * 
	 * @param string $mediaId
	 * 
	 * @return mixed
	 */
	public function get($mediaId)
	{
		return $this->downlad('get', [self::API_MEDIA_GET, ['media_id' => $mediaId]]);
	}
	
	/**
	 * Upload picture material
	 * 
	 * @param array $data
	 * 
	 * @return \Superwechat\Lib\Connection
	 */
	public function uploadimg(array $data)
	{
		return $this->parseJSON('upload', [self::API_MEDIA_UPLOADIMG, $data]);
	}
	
	/**
	 * New permanent graphic material
	 * 
	 * @param array $params
	 * 
	 * @return \Superwechat\Lib\Connection
	 */
	public function addNews(array $params)
	{
		return $this->parseJSON('post', [self::API_MATERIAL_ADD_NEWS, $params]);
	}
	
	/**
	 * Add other types of permanent material
	 * 
	 * @param array $uploadParam
	 * 
	 * @return \Superwechat\Lib\Connection
	 */
	public function addMaterial(array $uploadParam)
	{
		return $this->parseJSON('upload', [self::API_MATERIAL_ADD_MATERIAL, $uploadParam]);
	}
	
	/**
	 * Get permanent material
	 * 
	 * @param string $mediaId
	 * @param string $type 
	 * 
	 * @return \Superwechat\Lib\Connection
	 */
	public function getMaterial($mediaId, $type = 'other')
	{
		if ($type != 'other') {
			return $this->parseJSON('get', [self::API_MATERIAL_GET_MATERIAL, ['media_id' => $mediaId]]);
		}
		return $this->downlad('get', [self::API_MATERIAL_GET_MATERIAL, ['media_id' => $mediaId]]);
	}
	
	/**
	 * Delete permanent material
	 * 
	 * @param string $mediaId
	 * 
	 * @return \Superwechat\Lib\Connection
	 */
	public function delMaterial($mediaId) 
	{
		return $this->parseJSON('post', [self::API_MATERIAL_DEL_MATERIAL, ['media_id' => $mediaId]]);
	}
	
	/**
	 * Modify permanent graphic material
	 * 
	 * @param array $params
	 * 
	 * @return \Superwechat\Lib\Connection
	 */
	public function updateNews(array $params)
	{
		return $this->parseJSON('post', [self::API_MATERIAL_UPDATE_NEWS, $params]);
	}
	
	/**
	 * Total number of material
	 * 
	 * @return \Superwechat\Lib\Connection
	 */
	public function getMaterialCount()
	{
		return $this->parseJSON('get', [self::API_MATERIAL_GET_MATERIALCOUNT]);
	}
	
	/**
	 * Get material list
	 * 
	 * @param array $params
	 * 
	 * @return \Superwechat\Lib\Connection
	 */
	public function batchgetMaterial(array $params)
	{
		return $this->parseJSON('post', [self::API_MATERIAL_BATCHGET_MATERIAL, $params]);
	}
	
}