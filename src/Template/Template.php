<?php
namespace Superwechat\Template;
use Superwechat\Core\AccessToken;
use Superwechat\Core\CommonApi;

/**
 * Created by PhpStorm.
 * User: xuzongchao
 * Date: 17/4/17
 * Time: 17:53
 */

class Template extends CommonApi
{

    const API_SET_INDUSTRY = 'https://api.weixin.qq.com/cgi-bin/template/api_set_industry';
    const API_ADD_TEMPLATE = 'https://api.weixin.qq.com/cgi-bin/template/api_add_template';
    const API_SEND = 'https://api.weixin.qq.com/cgi-bin/message/template/send';


    /**
     * Template constructor.
     *
     * @param AccessToken $accessToken
     */
    public function __construct(AccessToken $accessToken)
    {
        parent::__construct($accessToken);
    }

    /**
     * 设置所属行业
     *
     * @param array $params
     *
     * @return \Superwechat\Lib\Connection
     */
    public function setIndustry(array $params)
    {
        return $this->parseJSON('post', [self::API_SET_INDUSTRY, $params]);
    }

    /**
     * 获得模板ID
     *
     * @param array $params
     *
     * @return \Superwechat\Lib\Connection
     */
    public function getTemplateId(array $params)
    {
        return $this->parseJSON('post', [self::API_ADD_TEMPLATE, $params]);
    }


    /**
     * 发送模板消息
     *
     * @param array $params
     *
     * @return \Superwechat\Lib\Connection
     */
    public function send($params)
    {
        return $this->parseJSON('post', [self::API_SEND, $params]);
    }
}