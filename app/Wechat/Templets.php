<?php

namespace App\Wechat;

use App\Wechat\Pub;
 
/**
 * 消息模板 
 *
 */
class Templets
{
    private $pub;

    function __construct()
    {
        $this->pub = new Pub;
    }

    /**
     * 文本
     *
     * [
     *      'OpenID' => 'xxxxxx', 
     *      'Content' => '内容'
     * ]
     *
     */
    public function text($array)
    {
        $templet = '
            <xml>
              <ToUserName><![CDATA['.$array['OpenID'].']]></ToUserName>
              <FromUserName><![CDATA['.$this->pub->name.']]></FromUserName>
              <CreateTime>'.time().'</CreateTime>
              <MsgType><![CDATA[text]]></MsgType>
              <Content><![CDATA['.$array['Content'].']]></Content>
            </xml>
        ';

        return $templet;
    }

    /**
     * 图文
     *
     * [
     *      'OpenID' => 'xxxxxx', 
     *      'Articles' => [
     *          ['title'=>'xxx', 'description'=>'xxx', 'picurl'=>'xxx', 'url'=>'xxx'],
     *          ['title'=>'xxx', 'description'=>'xxx', 'picurl'=>'xxx', 'url'=>'xxx'],
     *      ],
     * ]
     *
     */
    public function news($array) 
    {
        $items_templets = '';

        foreach ($array['Articles'] as $item) {
            $items_templets .= '
                <item>
                  <Title><![CDATA['.$item['title'].']]></Title>
                  <Description><![CDATA['.$item['description'].']]></Description>
                  <PicUrl><![CDATA['.$item['picurl'].']]></PicUrl>
                  <Url><![CDATA['.$item['url'].']]></Url>
                </item>
            ';
        }
        
        $templet = '
            <xml>
              <ToUserName><![CDATA['.$array['OpenID'].']]></ToUserName>
              <FromUserName><![CDATA['.$this->pub->name.']]></FromUserName>
              <CreateTime>'.time().'</CreateTime>
              <MsgType><![CDATA[news]]></MsgType>
              <ArticleCount>'.count($array['Articles']).'</ArticleCount>
              <Articles>
                '.$items_templets.'
              </Articles>
            </xml>
        ';

        $orign = '<xml>
<ToUserName><![CDATA['.$array['OpenID'].']]></ToUserName>
  <FromUserName><![CDATA['.$this->pub->name.']]></FromUserName>
  <CreateTime>'.time().'</CreateTime>
  <MsgType><![CDATA[news]]></MsgType>
  <ArticleCount>1</ArticleCount>
  <Articles>
    <item>
      <Title><![CDATA[title1]]></Title>
      <Description><![CDATA[description1]]></Description>
      <PicUrl><![CDATA[https://zl.viirose.com/image/welcome.jpg]]></PicUrl>
      <Url><![CDATA[https://zl.viirose.com]]></Url>
    </item>
  </Articles>
</xml>';
        $out = preg_replace('/\s(?=)/', '', sprintf($orign));
        return $out;
    }

    // END
}














