<?php

namespace App\Wechat;
 
use App\Wechat\Pub;

/**
 * 消息
 *
 * $p = xml_to_array($data) 需要: composer require mtownsend/xml-to-array
 * 
 */
class Message
{
    
    private $pub;

    function __construct()
    {
        $this->pub = new Pub;
    }


    /**
     * 文本
     *
     */
    public function text()
    {
        $templet = '
        <xml>
          <ToUserName><![CDATA[toUser]]></ToUserName>
          <FromUserName><![CDATA[fromUser]]></FromUserName>
          <CreateTime>12345678</CreateTime>
          <MsgType><![CDATA[news]]></MsgType>
          <ArticleCount>1</ArticleCount>
          <Articles>
            <item>
              <Title><![CDATA[title1]]></Title>
              <Description><![CDATA[description1]]></Description>
              <PicUrl><![CDATA[picurl]]></PicUrl>
              <Url><![CDATA[url]]></Url>
            </item>
          </Articles>
        </xml>
        ';
    }


    /**
     * 图文
     *
     */
    public function news()
    {
        
    }


    // END
}