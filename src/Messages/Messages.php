<?php
namespace Superwechat\Messages;

use Superwechat\Core\Exception;
use Superwechat\Help\Xml;

/**
 * Created by PhpStorm.
 * User: xuzongchao
 * Date: 17/4/16
 * Time: 15:58
 */

class Messages
{
    /**
     * 认证token
     *
     * @var
     */
    protected $token = '';

    /**
     * 当前时间
     *
     * @var int
     */
    protected $nowTime;

    /**
     * 消息对象
     *
     * @var
     */
    public $msg;

    /**
     * Messages constructor.
     */
    public function __construct($token = '')
    {
        $this->nowTime = time();
        $this->token = $token;

        if ($token) {
            $this->valid($token);
        } else {
            $this->initParam();
        }

    }

    /**
     * 初始化参数
     */
    public function initParam()
    {
        $postStr = $GLOBALS["HTTP_RAW_POST_DATA"];

        if (!empty($postStr)) {
            $postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
            $this->msg = $postObj;
        } else {
            throw new Exception('非微信消息');
        }
    }

    /**
     * 验证微信签名
     */
    public function valid($token)
    {
        $echoStr = $_GET["echostr"];

        //valid signature , option
        if($this->checkSignature()){
            echo $echoStr;
            exit;
        }
    }

    /**
     * 检查签名
     *
     * @return bool
     */
    private function checkSignature()
    {
        $signature = $_GET["signature"];
        $timestamp = $_GET["timestamp"];

        $nonce = $_GET["nonce"];
        $token = $this->token;

        $tmpArr = array($token, $timestamp, $nonce);

        sort($tmpArr, SORT_STRING);

        $tmpStr = implode( $tmpArr );
        $tmpStr = sha1( $tmpStr );

        if( $tmpStr == $signature ){
            return true;
        }
        return false;
    }

    /**
     * 回复文本消息
     *
     * @param $toUserName
     * @param $content
     *
     * @return string
     */
    public function replyTxtMsg($toUserName, $content)
    {
        $msgArr = [
            'ToUserName'    => $toUserName,
            'FromUserName'  => $this->msg->ToUserName,
            'CreateTime'    => $this->nowTime,
            'MsgType'       => 'text',
            'Content'       => $content,
        ];

        exit(Xml::toXml($msgArr));
    }

    /**
     * 回复图片消息
     *
     * @param $toUserName
     * @param $mediaId
     *
     * @return string
     */
    public function replyImgMsg($toUserName, $mediaId)
    {
        $msgArr = [
            'ToUserName'    => $toUserName,
            'FromUserName'  => '',
            'CreateTime'    => $this->nowTime,
            'MsgType'       => 'image',
            'Image'         => [
                'MediaId'   => $mediaId
            ]
        ];

        exit(Xml::toXml($msgArr));
    }

    /**
     * 回复语言消息
     *
     * @param $toUserName
     * @param $mediaId
     *
     * @return string
     */
    public function replyVoiceMsg($toUserName, $mediaId)
    {
        $msgArr = [
            'ToUserName'    => $toUserName,
            'FromUserName'  => '',
            'CreateTime'    => $this->nowTime,
            'MsgType'       => 'voice',
            'Voice'         => [
                'MediaId'   => $mediaId
            ]
        ];

        exit(Xml::toXml($msgArr));
    }

    /**
     * 回复视频消息
     *
     * @param $toUserName
     * @param $mediaId
     * @param $title
     * @param $description
     *
     * @return string
     */
    public function replyVideoMsg($toUserName, $mediaId, $title, $description)
    {
        $msgArr = [
            'ToUserName'    => $toUserName,
            'FromUserName'  => '',
            'CreateTime'    => $this->nowTime,
            'MsgType'       => 'video',
            'Video'         => [
                'MediaId'       => $mediaId,
                'Title'         => $title,
                'Description'   => $description
            ]
        ];

        exit(Xml::toXml($msgArr));
    }

    /**
     * 回复音乐消息
     *
     * @param $toUserName
     * @param $title
     * @param $description
     * @param $musicUrl
     * @param $hqMusicUrl
     * @param $thumbMedaId
     *
     * @return string
     */
    public function replyMusicMsg($toUserName, $title = '', $description = '', $musicUrl = '', $hqMusicUrl = '', $thumbMedaId = '')
    {
        $msgArr = [
            'ToUserName'    => $toUserName,
            'FromUserName'  => $this->msg->ToUserName,
            'CreateTime'    => $this->nowTime,
            'MsgType'       => 'music',
            'Music'         => [
                'Title'         => $title,
                'Description'   => $description,
                'MusicUrl'      => $musicUrl,
                'HQMusicUrl'    => $hqMusicUrl,
                'ThumbMediaId'  => $thumbMedaId
            ]
        ];
        exit(Xml::toXml($msgArr));
    }


    /**
     * 回复图文消息
     *
     * @param $toUserName
     * @param $articles
     */
    public function replyArticlesMsg($toUserName, $articles)
    {

        $articleCount = count($articles);
        $msgArr = [
            'ToUserName'    => $toUserName,
            'FromUserName'  => $this->msg->ToUserName,
            'CreateTime'    => $this->nowTime,
            'MsgType'       => 'news',
            'ArticleCount'  => $articleCount,
            'Articles'      => $articles
        ];
        exit(Xml::toXml($msgArr));
    }
}