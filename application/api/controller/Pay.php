<?php
/**
 * Created by PhpStorm.
 * User: apple
 * Date: 2019/8/29
 * Time: 上午8:55
 */

namespace app\api\controller;

use addons\epay\controller\Api as wx;
use app\admin\command\Api;
use Yansongda\Pay\Gateways\Wechat as wxx;
use Yansongda\Pay\pay as zf;
class Pay extends Api
{

    private $data=[
        'code'=>'400',
        'msg'=>'请求失败'
    ];
    //发起支付
    public function wepay(){
        $data=$_GET;
        $od['activity_id']=$data['activity_id'];
        $od['user_id']=$data['user_id'];
        $paper=db('signlist')->where(['activity_id'=>$od['activity_id'],'vip_id'=>$od['user_id'],'deletetime'=>null,'aduit'=>['<>',2]])->find();
        $ac=db('paper')->where(['id'=>$paper['paper_id'],'deletetime'=>null])->find();
        $vity=db('activity')->where(['id'=>$od['activity_id'],'deletetime'=>null])->find();
        $vip=db('vip')->where(['id'=>$od['user_id'],'deletetime'=>null])->find();
        if($ac){
            $data['amount']=$ac['chargenum'];
        }else{
            $this->data=[
                'code'=>'400',
                'msg'=>'无票种信息',
            ];
            return json_encode($this->data);
        }

        if($vip){
            $data['openid']=$vip['openid'];
        }else{
            $this->data=[
                'code'=>'400',
                'msg'=>'无票种信息',
            ];
            return json_encode($this->data);
        }
        $od['createtime']=time();
        $od['updatetime']=time();
        $order=randUnique();
        $params = [
            'amount'=>$data['amount'],
            'orderid'=>$order,
            'type'=>"wechat",
            'title'=>'购买活动票',
            'method'=>"mp",
            'openid'=>$data['openid'],
        ];
        $od['order_id']=$order;
        $od['activity_name']=$vity['activityname'];
        $od['amount']=$data['amount'];
        $ord=db('order')->insert($od);
        if($ord){
            $zf=\addons\epay\library\Service::submitOrder($params);
            $this->data=[
                'code'=>'200',
                'msg'=>'请求成功',
                'data'=>json_decode($zf)
            ];
            return json_encode($this->data);
        }else{
            return json_encode($this->data);
        }
    }
}