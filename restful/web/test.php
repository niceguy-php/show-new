<?php
class Test{
    const TOKEN = 'c4ca4238a0b923820dcc509a6f75849b';
    public function wechat(){
        $this->log('start');
        if(isset($GLOBALS["HTTP_RAW_POST_DATA"])){
            $postStr = $GLOBALS["HTTP_RAW_POST_DATA"];
            if (!empty($postStr)){
                $this->log($postStr);
                $postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);

                $fromUsername = $postObj->FromUserName;
                $toUsername = $postObj->ToUserName;
                $keyword = trim($postObj->Content);
                $type = $postObj->MsgType;
                $this->openid = (string) $postObj->FromUserName;

                if($type=='event'){

                    if('subscribe'==$postObj->Event){

                        /*$r = new stdClass();
                        $r->tit = '【抢红包】点击进入，速领现金';
                        $r->des = '【抢红包】点击进入，速领现金';
                        $r->pic = '/data/resource/examples/red_envelope.jpg';
                        $r->ourl = 'http://mp.weixin.qq.com/s?__biz=MzA4Mjk1MjY5MA==&mid=207612090&idx=1&sn=c66dd84e273cbd484750460748ef3114#rd';

                        $r1 = new stdClass();
                        $r1->tit = '【颜值高】你的朋友圈一定有这些人';
                        $r1->des = '【颜值高】你的朋友圈一定有这些人';
                        $r1->pic = '/data/resource/examples/see_story.jpg';
                        $r1->ourl = 'http://m.70c.com/w/SYCWQA';

                        $r3 = new stdClass();
                        $r3->tit = '【手别抖】免单的机会在此，根本停不下来！';
                        $r3->des = '【手别抖】免单的机会在此，根本停不下来！';
                        $r3->pic = '/data/resource/examples/play_game.jpg';
                        $r3->ourl = 'http://www.pbyaj.com/wap/tmpl/activity/zl';

                        $res = [$r,$r1,$r3];

                        $this->response_morearts($res, 1, $postObj);*/

                        $this->response_text('关注,标记sign',$postObj);return;
                    }elseif('unsubscribe'==$postObj->Event){
                        $this->response_text('取消关注,标记sign',$postObj);return;
                    }
                }

            }
        }else{
            $signature = $_GET["signature"];
            $timestamp = $_GET["timestamp"];
            $nonce = $_GET["nonce"];
            $this->log($signature);
            if($this->valid()){
            } else {
                $echoStr = $_GET["echostr"];
                echo $echoStr;die();
            }
        }
    }

    //回复多图文
    private function response_morearts($res,$rid,$postObj){
        $fromUsername = $postObj->FromUserName;
        $toUsername = $postObj->ToUserName;
        $textTpl = "<xml>
		<ToUserName><![CDATA[%s]]></ToUserName>
		<FromUserName><![CDATA[%s]]></FromUserName>
		<CreateTime>%s</CreateTime>
		<MsgType><![CDATA[%s]]></MsgType>
		<ArticleCount>%s</ArticleCount>
		<Articles>
		ITEM
		</Articles>
		</xml>";
        $resstr =  sprintf($textTpl, $fromUsername, $toUsername, time(), "news", count($res));
        $item = '';
        $subitem = "<item>
		<Title><![CDATA[%s]]></Title>
		<PicUrl><![CDATA[%s]]></PicUrl>
		<Url><![CDATA[%s]]></Url>
		</item>";
        foreach ($res as $r){
            $addpos = '?';
            if(stripos($r->ourl, '?')!==false){
                $addpos = '&';
            }
            $r->ourl = $r->ourl.$addpos.'wxid='.$fromUsername;
            if (stripos($r->ourl, 'wid=')==false) $r->ourl .= '&wid='.$this->wid;
            if (stripos($r->ourl, 'rid=')==false) $r->ourl .= '&rid='.$rid;
            //$r->ourl = $r->ourl.'#mp.weixin.qq.com';
            $item.=sprintf($subitem, $r->tit, 'http://www.pbyaj.com'.$r->pic, $r->ourl);
        }
        $resstr = str_replace('ITEM', $item, $resstr);
        echo $resstr;
    }

    //回复文本
    private function response_text($txt,$postObj){
        $fromUsername = $postObj->FromUserName;
        $toUsername = $postObj->ToUserName;
        $textTpl = "<xml>
		<ToUserName><![CDATA[%s]]></ToUserName>
		<FromUserName><![CDATA[%s]]></FromUserName>
		<CreateTime>%s</CreateTime>
		<MsgType><![CDATA[%s]]></MsgType>
		<Content><![CDATA[%s]]></Content>
		<FuncFlag>0</FuncFlag>
		</xml>";
        $res = sprintf($textTpl, $fromUsername, $toUsername, time(), "text", trim($txt));
        //Log::error($res);
        echo $res;
    }


    private function valid(){
        $echoStr = $_GET["echostr"];
        //valid signature , option
        if($this->checkSignature()){
            echo $echoStr;
            return true;
        }
        return false;
    }

    private function log($str=''){
        file_put_contents('/data/www/test.log',$str."\n\r",FILE_APPEND);
    }

    private function checkSignature(){
        $signature = $_GET["signature"];
        $timestamp = $_GET["timestamp"];
        $nonce = $_GET["nonce"];

        $token = self::TOKEN;
        $tmpArr = array($token, $timestamp, $nonce);
        sort($tmpArr, SORT_STRING);
        $tmpStr = implode( $tmpArr );
        $tmpStr = sha1( $tmpStr );

        if( $tmpStr == $signature ){
            return true;
        }else{
            return false;
        }
    }
}

$obj = new Test();
$obj->wechat();