<?php
/**
 * Created by PhpStorm.
 * User: apple
 * Date: 2019/8/28
 * Time: 下午6:12
 */

namespace app\api\controller;

use app\admin\command\Api;
use think\Loader;

//Loader::import('phpqrcode.phpqrcode',EXTEND_PATH,'.php');
class Sign extends Api
{
    protected $noNeedLogin='*';

    private  $data=[];
    //报名
    public function addsign(){

        $data=$_GET;
        if(!empty($data['userid'])){
            $vip['vip_id']=$data['userid'];   //用户id
            $vip['activity_id']=$data['activity_id'];   //活动id
            $vip['aduit']=$data['status'];   //审核状态
            $vip['deletetime']=null;   //审核状态
            $sign=db('signlist')->where($vip)->find();
            $user=db('vip')->where(['id'=>$vip['vip_id']])->find();
            if($sign){
                return json_encode($this->data=['code'=>203,'msg'=>'已报名该活动']);
            }else{
                unset($vip['deletetime']);
                $activity=db('activity')->where(['id'=>$data['activity_id'],'deletetime'=>null])->find();
                if(!empty($activity)&&$activity['notaudit']==0){
                    $vip['aduit']==1;
                }
                if($activity['signuptime']>time()){
                    return json_encode($this->data=['code'=>202,'msg'=>'未到报名时间']);
                }
                if(strtotime(date($activity['signupendtime']))<time()){
                    return json_encode($this->data=['code'=>204,'msg'=>'报名时间已过']);

                }
                /*$sernum=db('signlist')->where(['activity_id'=>$vip['activity_id'],'aduit'=>['<>','2'],'deletetime'=>null])->order('sernum desc')->find();
                if(empty($sernum)){
                    $vip['sernum']=1;
                }else{
                    $vip['sernum']=$sernum['sernum']+1;
                }*/
                $vip['activity_name']=$data['activity_name'];   //活动名称
                $vip['paper_id']=$data['paper_id'];   //票种id
                $vip['username']=$data['username'];   //用户名
                $vip['cusform']=$data['cusform'];   //表单
                $vip['papernum']=randUnique();
                $vip['signtime']=time();   //报名时间
                $vip['createtime']=time();   //创建时间
                $vip['updatetime']=time();   //修改时间
                $add=db('signlist')->insertGetId($vip);
                $qr['qrcode']=$this->qrcode($add);
                $upqr=db('signlist')->where(['id'=>$add])->update($qr);
                $me=new Message();
                $me->send_notice($user['openid'],0,$vip['username'],$vip['activity_name'], $vip['activity_id']);
                if($add&&$upqr){
                    return json_encode($this->data=['code'=>200,'msg'=>'请求成功']);
                }else{
                    return json_encode($this->data=['code'=>400,'msg'=>'请求失败']);
                }
            }

        }else{

            return json_encode($this->data=['code'=>201,'msg'=>'缺少参数']);
        }
    }

    //获取票种信息'
    ///@data['activity_id']  活动id
    /// @data['user_id']    用户id
    public function  getsigninfo(){
        $data=$_GET;
        $ac=db('activity')->where(['id'=>$data['activity_id'],'deletetime'=>null])->find();
        if(!empty($ac)){
            if($ac['notaudit']==0){
                $signinfo=db('signlist')->where(['activity_id'=>$data['activity_id'],'vip_id'=>$data['user_id'],'deletetime'=>null])->find();
                if(empty($signinfo)){
                    return json_encode($this->data=['code'=>205,'msg'=>'未报名','pay'=>0]);
                }
                $paper=db('paper')->where(['id'=>$signinfo['paper_id'],'deletetime'=>null])->find();
                $signinfo['paper']=$paper;
                if($paper['charge']==1){
                    $orderinfo=db('order')->where(['activity_id'=>$data['activity_id'],'user_id'=>$data['user_id'],'status'=>1,'deletetime'=>null])->find();
                    if($orderinfo){
                        $signinfo['cusform']=json_decode($signinfo['cusform']);
                        return json_encode($this->data=['code'=>200,'msg'=>'请求成功','pay'=>1,'data'=>$signinfo]);
                    }else{
                        return json_encode($this->data=['code'=>204,'msg'=>'审核成功尚未支付','pay'=>0,'paper'=>$paper]);
                    }
                }else{
                    return json_encode($this->data=['code'=>200,'msg'=>'请求成功','pay'=>1,'data'=>$signinfo]);
                }
            }
        }
        $signinfo=db('signlist')->where(['activity_id'=>$data['activity_id'],'vip_id'=>$data['user_id'],'deletetime'=>null])->order('id','desc')->find();
        if($signinfo){
              switch ($signinfo['aduit']){
                  case 0:
                      return json_encode($this->data=['code'=>201,'msg'=>'审核中','pay'=>0]);
                  case 2:
                      return json_encode($this->data=['code'=>206,'msg'=>'审核拒绝','pay'=>0]);
              }
          $paper=db('paper')->where(['id'=>$signinfo['paper_id'],'deletetime'=>null])->find();
          $signinfo['paper']=$paper;
          if($paper['charge']==1){
              $orderinfo=db('order')->where(['activity_id'=>$data['activity_id'],'user_id'=>$data['user_id'],'status'=>1,'deletetime'=>null])->find();
              if($orderinfo){
                  $signinfo['cusform']=json_decode($signinfo['cusform']);
                  return json_encode($this->data=['code'=>200,'msg'=>'请求成功','pay'=>1,'data'=>$signinfo]);
              }else{

                  return json_encode($this->data=['code'=>204,'msg'=>'审核成功尚未支付','pay'=>0,'paper'=>$paper]);

              }
          }else{
              $signinfo['cusform']=json_decode($signinfo['cusform']);
                  return json_encode($this->data=['code'=>200,'msg'=>'请求成功','pay'=>1,'data'=>$signinfo]);
          }
        }else{
            return json_encode($this->data=['code'=>205,'msg'=>'用户未报名该活动','pay'=>0]);
        }
    }


    public function qrcode($paper_id){
        include VENDOR_PATH.'phpqrcode/phpqrcode.php';
        $qrcode = new \QRcode();
        $url='zhuhong.le-cx.com/vote/confirm.html?paper_id='.$paper_id;
//         $qrimage = new \QRimage();

        $value = $url;                    //二维码内容
        $errorCorrectionLevel = 'H';    //容错级别
        $matrixPointSize = 6;           //生成图片大小

        ob_start();
        $qrcode::png($value,false , $errorCorrectionLevel, $matrixPointSize, 2);
        // $object->png($url, false, $errorCorrectionLevel, $matrixPointSize, 2); //这里就是把生成的图片流从缓冲区保存到内存对象上，使用base64_encode变成编码字符串，通过json返回给页面。
        $imageString = base64_encode(ob_get_contents()); //关闭缓冲区
        ob_end_clean(); //把生成的base64字符串返回给前端
        $data = array( 'code'=>200, 'data'=>"data:image/jpg;base64,".$imageString );
        return $this->base64_image_content($data['data'],'./upload');
    }



    function base64_image_content($base64_image_content,$path){
        //匹配出图片的格式
        if (preg_match('/^(data:\s*image\/(\w+);base64,)/', $base64_image_content, $result)){
            $type = $result[2];
            $new_file = $path."/".date('Ymd',time())."/";
            if(!file_exists($new_file)){
                //检查是否有该文件夹，如果没有就创建，并给予最高权限
                mkdir($new_file, 0777,true);
            }
            $new_file = $new_file.time().".{$type}";
            if (file_put_contents($new_file, base64_decode(str_replace($result[1], '', $base64_image_content)))){
                return '/'.$new_file;
            }else{
                return false;
            }
        }else{
            return false;
        }
    }

    //签到核销
    public function hexiao(){
        $data=$_GET;
        $vip=db('vip')->where(['openid'=>$data['openid'],'auditman'=>1,'deletetime'=>null])->find();
        if($vip){

            $sign=db('signlist')->where(['id'=>$data['signlist_id'],'deletetime'=>null])->find();
            $where['audit_id'] = array('like','%'.$vip['openid'].'%');
            $where['id'] =$sign['activity_id'] ;
            $hexiao=db('activity')->where($where)->find();
            if(empty($hexiao)){
                return json_encode($this->data=['code'=>202,'msg'=>'您不是该活动的核销员']);
            }
            if(!empty($sign)&&$sign['status']==1){
                return json_encode($this->data=['code'=>201,'msg'=>'该报名已审核通过']);
            }
            $activity=db('activity')->where(['id'=>$sign['activity_id']])->find();

            if($activity['audittime']>time()){
                return json_encode($this->data=['code'=>202,'msg'=>'未到核销时间']);
            }
            if(strtotime(date($activity['auditendtime']))<time()){
                return json_encode($this->data=['code'=>202,'msg'=>'核销时间已过']);
            }
            $acid['activity_id']=$sign['activity_id'];
            $acid['aduit']=['<>','2'];
            $acid['deletetime']=null;
            $signlist=db('signlist')->where($acid)->order('sernum desc')->find();
            if($signlist){
                $sernum=$signlist['sernum']+1;
            }else{
                $sernum=1;
            }
            $user=db('vip')->where(['id'=>$sign['vip_id']])->find();
            $up=db('signlist')->where(['id'=>$data['signlist_id'],'deletetime'=>null])->update(['status'=>1,'audit_id'=>$vip['id'],'sernum'=>$sernum]);
            if($up){
                $me=new Message();
                $me->send_notice($user['openid'],3,$sign['activity_name'],$vip['name'], $sign['activity_id']);
                return json_encode($this->data=['code'=>200,'msg'=>'请求成功']);
            }else{
                return json_encode($this->data=['code'=>400,'msg'=>'请求失败']);
            }
        }else{
            return json_encode($this->data=['code'=>401,'msg'=>'用户无权限']);
        }

    }

}