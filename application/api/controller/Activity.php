<?php
/**
 * Created by PhpStorm.
 * User: apple
 * Date: 2019/8/28
 * Time: 上午8:55
 */

namespace app\api\controller;
use app\admin\model\Signlist;
use app\common\controller\Api;
use think\Request;
use app\common\model\Config;
class Activity extends Api
{
    protected $noNeedLogin='*';

    private  $data=[];
    //获取活动列表
    public function getactivitylist(){
        $member_id = 19;
        $list = db('activity')->where(['deletetime'=>null])->field('id,activityname,logo,url_address,signuptime,signupendtime,statrtime')->select();

        if($list){
            foreach($list as $index => $item){
                $signlist_model = new Signlist();
                $is_sign = $signlist_model->where(['activity_id'=>$item['id'],'vip_id'=>$member_id])->find();
                $list[$index]['is_sign'] = $is_sign ? 1 : 0 ;
                $list[$index]['signuptime'] = date('Y-m-d H:i:s',$item['signuptime']);
            }
            return json_encode($this->data=['code'=>'200','msg'=>'请求成功','data'=>$list]);

        }else{

            return json_encode($this->data=['code'=>'201','msg'=>'无数据']);
        }
    }


    //获取指定活动的信息
    public function getactivityinfo(){

        $data=$_GET;
        if(!empty($data['activity_id'])&&!empty($data['openid'])){
            $info=db('activity')->where(['id'=>$data['activity_id'],'deletetime'=>null])->find();
                if(!empty($info)){
                $paper=db('paper')->where(['activity_id'=>$data['activity_id'],'deletetime'=>null])->field('id,papername,charge,chargenum,note')->select();
                if($paper){
                    $info['paper']=$paper;
                }
                if($info['notaudit']==1){
                    $info['aduitstatus']=1;
                }else{
                    $info['aduitstatus']=0;
                }
                $vip=db('vip')->where(['openid'=>$data['openid'],'deletetime'=>null])->find();
                if($vip){
                   $sign=db('signlist')->where(['activity_id'=>$data['activity_id'],'vip_id'=>$vip['id'],'deletetime'=>null])->order('id', 'desc')->find();
                   if(empty($sign)){
                       $info['notaudit']=-1;
                   }else if($sign['aduit']==2){
                       $info['notaudit']=2;
                   }else if($sign['aduit']==1){
                        $info['notaudit']=1;
                    }else if($sign['aduit']==0){
                        $info['notaudit']=0;
                    }
                }else{
                   return json_encode($this->data=['code'=>'401','msg'=>'openid不存在']);
                }
                $info['custom']=json_decode($info['custom']);
                $info['signuptime']=date('Y-m-d H:i:s',$info['signuptime']);
                    return json_encode($this->data=['code'=>'200','msg'=>'请求成功','data'=>$info]);
                }else{

                    return json_encode($this->data=['code'=>'400','msg'=>'请求失败']);

                }

        }else{

            return json_encode($this->data=['code'=>'201','msg'=>'缺少参数']);

        }

    }



}