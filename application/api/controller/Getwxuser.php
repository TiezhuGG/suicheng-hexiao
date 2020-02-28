<?php
/**
 * 获取微信用户信息
 * @author: Lucky hypo
 */

namespace app\api\controller;

use app\admin\command\Api;

class Getwxuser extends Api

{
    private $appid = 'wxd6f30cb38ce4a273';
    private $appsecret = 'e9d427abc1055d862a79cec774e67307';

    /**
     * 1、获取微信用户信息，判断有没有code，有使用code换取access_token，没有去获取code。
     * @return array 微信用户信息数组
     */
    public function get_user_all()
    {
        $appid = $this->appid;
        $secret = $this->appsecret;
        $code = $_GET['code'];//获取code

        //$state = $_GET['state']; //获取参数
        $weixin = file_get_contents("https://api.weixin.qq.com/sns/oauth2/access_token?appid=$appid&secret=$secret&code=$code&grant_type=authorization_code");//通过code换取网页授权access_token
        $jsondecode = json_decode($weixin); //对JSON格式的字符串进行编码
        $array = get_object_vars($jsondecode);//转换成数组
        if (!empty($array['openid'])) {
            $access_token = $array['access_token'];
            $openid = $array['openid'];
            $url = "https://api.weixin.qq.com/sns/userinfo?access_token=$access_token&openid=$openid&lang=zh_CN";
            $user = file_get_contents($url);
            $userinfo = json_decode($user);
            $userlist = get_object_vars($userinfo);//转换成数组
            if ($userlist['openid']) {
                $data['openid'] = $openid;
                $data['name'] = $userlist['nickname'];
                $wx = db('vip')->where(['openid' => $openid, 'deletetime' => null])->find();
                if ($wx) {
                    return json_encode(['code' => '200', 'msg' => '请求成功', 'userid' => $wx['id'], 'openid' => $openid, 'name' => $data['name']]);
                }
                $data['images'] = $userlist['headimgurl'];
                $data['createtime'] = time();
                $data['updatetime'] = time();
                $add = db('vip')->insertGetId($data);
                if ($add) {
                    return json_encode(['code' => '200', 'msg' => '请求成功', 'userid' => $add, 'openid' => $openid, 'name' => $data['name']]);
                } else {
                    return json_encode(['code' => '400', 'msg' => '请求失败']);
                }

            } else {
                return json_encode(['code' => '404', 'msg' => '未找到用户信息']);
            }
        } else {
            return json_encode(['code' => '401', 'msg' => 'code错误']);
        }
    }

    /**
     * 2、用户授权并获取code
     * @param string $callback 微信服务器回调链接url
     */
    private function get_code($callback)
    {
        $appid = $this->appid;
        $scope = 'snsapi_userinfo';
        $state = md5(uniqid(rand(), TRUE));//唯一ID标识符绝对不会重复
        $url = 'https://open.weixin.qq.com/connect/oauth2/authorize?appid=' . $appid . '&redirect_uri=' . urlencode($callback) . '&response_type=code&scope=' . $scope . '&state=' . $state . '#wechat_redirect';
        header("Location:$url");
    }

    /**
     * 3、使用code换取access_token
     * @param string 用于换取access_token的code，微信提供
     * @return array access_token和用户openid数组
     */
    private function get_access_token($code)
    {
        $appid = $this->appid;
        $appsecret = $this->appsecret;
        $url = "https://api.weixin.qq.com/sns/jscode2session?appid=$appid&secret=$appsecret&js_code=$code&grant_type=authorization_code";
        $user = json_decode(file_get_contents($url));
        if (isset($user->errcode)) {
            echo 'error:' . $user->errcode . '<hr>msg  :' . $user->errmsg;
            exit;
        }
        $data = json_decode(json_encode($user), true);//返回的json数组转换成array数组
        return $data;
    }

    /**
     * 4、使用access_token获取用户信息
     * @param string access_token
     * @param string 用户的openid
     * @return array 用户信息数组
     */
    private function get_user_info($access_token, $openid)
    {
        $url = 'https://api.weixin.qq.com/sns/userinfo?access_token=' . $access_token . '&openid=' . $openid . '&lang=zh_CN';
        $user = json_decode(file_get_contents($url));
        if (isset($user->errcode)) {
            echo 'error:' . $user->errcode . '<hr>msg  :' . $user->errmsg;
            exit;
        }
        $data = json_decode(json_encode($user), true);//返回的json数组转换成array数组
        return $data;
    }
}

?>