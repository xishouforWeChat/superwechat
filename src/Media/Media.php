<?php
namespace Superwechat\Media;
use Superwechat\Core\CommonApi;

/**
 * Class Media
 * 
 * @author xuzongchao
 *
 */
class Media extends CommonApi
{
	const API_UPLOAD_URI = 'https://api.weixin.qq.com/cgi-bin/media/upload?type=image';
	
	
	public function upload(array $uploadParam)
	{
		return $this->parseJSON('post', [self::API_UPLOAD_URI, $uploadParam]);
	}
}