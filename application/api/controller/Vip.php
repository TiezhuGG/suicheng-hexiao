<?php
/**
 * Created by PhpStorm.
 * User: apple
 * Date: 2019/8/28
 * Time: 下午3:49
 */

namespace app\api\controller;


use app\admin\command\Api;

class Vip extends Api
{
    protected $noNeedLogin = '*';
    /**
     * error code 说明.
     * <ul>

     *    <li>-41001: encodingAesKey 非法</li>
     *    <li>-41003: aes 解密失败</li>
     *    <li>-41004: 解密后得到的buffer非法</li>
     *    <li>-41005: base64加密失败</li>
     *    <li>-41016: base64解密失败</li>
     * </ul>
     */
    private $data=array(
        'code'=>'400',
        'msg'=>'请求失败',
    );

    public static $OK = 0;
    public static $IllegalAesKey = -41001;
    public static $IllegalIv = -41002;
    public static $IllegalBuffer = -41003;
    public static $DecodeBase64Error = -41004;


    //获取微信用户openid
    public function getopenid()
    {
        $params = $_POST;
        if (empty($params['code'])) {
            return '缺少参数code';
        }
        $code=$params['code'];
        $ch = curl_init();
        $url = "https://api.weixin.qq.com/sns/jscode2session?appid=wxd6f30cb38ce4a273&secret=e9d427abc1055d862a79cec774e67307&js_code=$code&grant_type=authorization_code";
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_0);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        $res = curl_exec($ch);
        curl_close($ch);
        $res_decode = json_decode($res,true);
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


    //添加微信用户数据到数据库
    public function insertuserinfo(){
        $params=$_POST;
        $result=$this->getuserinfo($params,$data);
        $model=db('vip');
        if($result==0){
            $data=(array)json_decode($data);
            $vip['openid']=$data['openId'];
            $vip['images']=$data['avatarUrl'];
            $vip['name']=$data['nickName'];
            $vip['createtime']=time();
            $vip['updatetime']=time();
            $v=$model->where(['openid'=>$vip['openid'],'deletetime'=>null])->find();
            if(!empty($v)){
                $cx['code']='201';
                $cx['msg']='用户已授权';
                $cx['userid']=$v['id'];
                $cx['images']=$data['avatarUrl'];
                $cx['name']=$data['nickName'];
                return json_encode($cx);
            }
            $add=$model->insert($vip);
            $id=$model->getLastInsID();
            if($add){
                $cx['code']=200;
                $cx['msg']='success';
                $cx['userid']=$id;
                $cx['images']=$data['avatarUrl'];
                $cx['name']=$data['nickName'];
                return json_encode($cx);
            }else{
                $cx['code']=400;
                $cx['msg']='error';
                return json_encode($cx);
            }

        }else{
            $cx['code']='400';
            $cx['msg']='解密失败';
            return json_encode($cx);
        }

    }


    //解密微信用户数据 头像 昵称和openid
    public function getuserinfo($params,&$data){
        $params['appid']='wx506a5e0d50b8ceb9';
        if (strlen($params['sessionkey']) != 24) {
            return $this::$IllegalAesKey;
        }
        $aesKey=base64_decode($params['sessionkey']);
        if (strlen($params['iv']) != 24) {
            return $this::$IllegalIv;
        }
        $aesIV=base64_decode($params['iv']);

        $aesCipher=base64_decode($params['encryptedData']);

        $result=openssl_decrypt( $aesCipher, "AES-128-CBC", $aesKey, 1, $aesIV);

        $dataObj=json_decode( $result );
        if( $dataObj  == NULL )
        {
            return $this::$IllegalBuffer;
        }
        if( $dataObj->watermark->appid != $params['appid'] )
        {
            return $this::$IllegalBuffer;
        }
        $data = $result;
        return $this::$OK;
    }

    //根据openid查询数据库是否有对应数据
    public function checkopenid(){
        $data=$_POST;
        $wh['openid']=$data['openid'];
        $wh['deletetime']=null;
        $result=db('vip')->where($wh)->find();
        if($result){
            $cx['code']=200;
            $cx['msg']='success';
            $cx['userid']=$result['id'];
            //$cx['token']=hash('sha256',$result['id'].rand(1,9999).$result['openid']);
            //Cache::set($cx['token'],'1',7200);
            $cx['name']=$result['name'];
            $cx['username']=$result['username'];
            $cx['phone']=$result['phone'];
            $cx['images']=$result['images'];
            return json_encode($cx);
        }else{
            $cx['code']=404;
            $cx['msg']='openid不存在';
            return json_encode($cx);
        }
    }

    public function getservice(){

        $as=db('service')->where(['status'=>1])->field('content,createtime')->find();
        if($as){
            return json_encode($this->data=['code'=>200,'msg'=>'请求成功','data'=>$as]);
        }else{
            return json_encode($this->data=['code'=>400,'msg'=>'请求失败或数据不存在']);
        }

    }

}