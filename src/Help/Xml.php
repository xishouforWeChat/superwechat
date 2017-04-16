<?php
/**
 * Class Xml
 *
 * @author xuzongchao
 *
 */
class Xml 
{
    /**
     * 将数组转换为xml实体
     *
     * @param $values
     *
     * @return string
     *
     * @throws \Superwechat\Core\Exception
     */
	public static function toXml($values)
	{
        if(!is_array($values)
            || count($values) <= 0)
        {
            throw new \Superwechat\Core\Exception("数组数据异常！");
        }

        $xml = "<xml>";
        foreach ($values as $key=>$val)
        {
            if (is_numeric($val)){
                $xml.="<".$key.">".$val."</".$key.">";
            }else{
                $xml.="<".$key."><![CDATA[".$val."]]></".$key.">";
            }
        }
        $xml.="</xml>";
        return $xml;
    }

    /**
     * 将xml转换为数组
     *
     * @param $xml
     *
     * @return mixed
     */
    public static function fromXml($xml)
    {
        if(!$xml){
            throw new WxPayException("xml数据异常！");
        }
        //将XML转为array
        //禁止引用外部xml实体
        libxml_disable_entity_loader(true);
        $values = json_decode(json_encode(simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA)), true);
        return $values;
    }

}