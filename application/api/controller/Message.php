<?php
/**
 * Created by PhpStorm.
 * User: apple
 * Date: 2019/8/23
 * Time: 下午5:10
 */

namespace app\api\controller;
use app\common\controller\Api;

class Message extends Api
{
    /**
     * 发送模板消息
     */
    protected $noNeedLogin = '*';
    protected $appid ='wxd6f30cb38ce4a273';
    protected $appsecret ='e9d427abc1055d862a79cec774e67307';

    public function send_notice($openid,$type,$username,$activity_name,$activity_id){
        if(empty($openid)){
            return json_encode(['code'=>'203','msg'=>'缺少参数openid']);
        }
        //获取access_token
        if (!empty($_COOKIE['access_token'])){
            $access_token2=$_COOKIE['access_token'];
        }else{
            $url="https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=$this->appid&secret=$this->appsecret";
            $json_token=$this->curl_post($url);
            $access_token1=json_decode($json_token,true);
            $access_token2=$access_token1['access_token'];
            setcookie('access_token',$access_token2,7200);
        }
        //模板消息
        $json_template = $this->json_tempalte($openid,$type,$activity_name,$username,$activity_id);
        $url="https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=".$access_token2;
        $res=json_decode($this->curl_post($url,urldecode($json_template)));
        $res=(array)$res;
        if ($res['errcode']==0){
                return 1;
        }else{
            return 0;
        }
    }

    /**
     * 将模板消息json格式化
     */
    public function json_tempalte($openid,$type,$activity_name,$name,$activity_id){

        $vip=db('vip')->where(['openid'=>$openid,'deletetime'=>null])->find();
        if($vip){
            $sign['vip_id']=$vip['id'];
        }
        $sign['activity_id']=$activity_id;
        $sign['aduit']=['<>','2'];
        $sign['deletetime']=null;
        $signlist=db('signlist')->where($sign)->find();
        //模板消息
        $content="";
        $tongzhi="";
        $sernum='';

        switch ($type){
            case 0:
                $content='您已报名'.$activity_name.'活动';
                $tongzhi='已报名';
                break;
            case 1:
                $content='您报名的'.$activity_name.'活动审核已通过';
                $tongzhi='审核通过';
                break;
            case 2:
                $content='您报名的'.$activity_name.'活动审核被拒绝';
                $tongzhi='审核拒绝';
                break;
            case 3:
                $content='您报名的'.$activity_name.'活动已核销';
                $tongzhi='核销完成';
                $sernum=$signlist['sernum']?$signlist['sernum']:'-';
                break;
        }

        $template=array(
            'touser'=> $openid,     //用户openid
            'template_id'=>"_6UDPJd303grHNuJgd6U40HhvekByKx4mddT-K-B-7k",  //在公众号下配置的模板id
            'url'=>"hx.le-cx.com/vote?activity_id=".$activity_id,  //点击模板消息会跳转的链接
            'topcolor'=>"#7B68EE",
            'data'=>array(
                'first'=>array('value'=>urlencode($content)),
                'keyword1'=>array('value'=>urlencode($activity_name)),   //keyword需要与配置的模板消息对应
                'keyword2'=>array('value'=>urlencode(date("Y-m-d H:i:s"))),
                'keyword3'=>array('value'=>urlencode($tongzhi)),
                'remark'  =>array('value'=>urlencode($sernum)),
                )
        );
        $json_template=json_encode($template);
        return $json_template;
    }


    /**
     * @param $url
     * @param array $data
     * @return mixed
     * curl请求
     */
    function curl_post($url , $data=array()){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        // POST数据
        curl_setopt($ch, CURLOPT_POST, 1);
        // 把post的变量加上
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        $output = curl_exec($ch);
        curl_close($ch);
        return $output;
    }


    public function getopenid()
    {
        $params = $_POST;
        if (empty($params['code'])) {
            return '参数不存在';
        }
        $code=$params['code'];
        $ch = curl_init();
        $url = "https://api.weixin.qq.com/sns/jscode2session?appid=wx2a966470894860fa&secret=3c6a2e3f3902e081fe7696c492452994&js_code=$code&grant_type=authorization_code";
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_0);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        $res = curl_exec($ch);
        curl_close($ch);
        $res_decode = json_decode($res,true);
        halt($res_decode);
        if($res_decode){
            $data['code']='200';
            $data['msg']='success';
            $data['openid']=$res_decode['openid'];
            $data['session_key']=$res_decode['session_key'];
            echo json_encode($data);
        }else{
            $data['code']='400';
            $data['msg']='error';
            echo json_encode($data);
        }

    }
}