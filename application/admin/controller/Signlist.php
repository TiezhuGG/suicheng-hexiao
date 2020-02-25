<?php

namespace app\admin\controller;

use app\common\controller\Backend;
use think\Cache;
use think\db;
use app\api\controller\Message;
use PhpOffice\PhpSpreadsheet\Helper\Sample;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpOffice\PhpSpreadsheet\Worksheet\PageSetup;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

/**
 * 
 *
 * @icon fa fa-circle-o
 */

class Signlist extends Backend
{
    
    /**
     * Signlist模型对象
     * @var \app\admin\model\Signlist
     */
    protected $model = null;
    protected $multiFields="aduit";
    protected $searchFields = 'activity_name,username';
    public function _initialize()
    {
        parent::_initialize();
        $this->model = new \app\admin\model\Signlist;
        $this->view->assign("statusList", $this->model->getStatusList());
        $this->view->assign("aduitList", $this->model->getAduitList());
        $data=input();
        if(!empty($data['a'])){
            Cache::set('id',$data['ids']);
        }
        $namelist=db('activity')->where(['deletetime'=>null])->field('id,activityname')->select();
        $nametypelist=[];
        if(!empty($namelist)){
            foreach($namelist as &$item){
                $nametypelist[$item['id']]=$item['activityname'];
            }
            unset($item);
        }

        $viplist=db('vip')->where(['deletetime'=>null])->field('id,name')->select();
        $vipname=[];
        if(!empty($viplist)){
            foreach($viplist as &$item){
                $vipname[$item['id']]=$item['name'];
            }
            unset($item);
        }
        $hexiaolist=db('vip')->where(['auditman'=>1,'deletetime'=>null])->field('id,name')->select();
        $hexiaoname=[];
        if(!empty($hexiaolist)){
            foreach($hexiaolist as &$item){
                $hexiaoname[$item['id']]=$item['name'];
            }
            unset($item);
        }
        $this->assign('nametypelist',$nametypelist);
        $this->assign('hexiao',$hexiaoname);
        $this->assign('vipname',$vipname);
    }
    
    /**
     * 默认生成的控制器所继承的父类中有index/add/edit/del/multi五个基础方法、destroy/restore/recyclebin三个回收站方法
     * 因此在当前控制器中可不用编写增删改查的代码,除非需要自己控制这部分逻辑
     * 需要将application/admin/library/traits/Backend.php中对应的方法复制到当前控制器,然后进行修改
     */

    /**
     * 查看
     */
    public function index()
    {
        if(Cache::get('id')){
            $activity['activity_id']=Cache::get('id');
        }
        //设置过滤方法
        $this->request->filter(['strip_tags']);
        if ($this->request->isAjax()) {
            //如果发送的来源是Selectpage，则转发到Selectpage
            if ($this->request->request('keyField')) {
                return $this->selectpage();
            }
            list($where, $sort, $order, $offset, $limit) = $this->buildparams();
            if(!empty($activity['activity_id'])){
                $total = $this->model
                    ->where($activity)
                    ->where($where)
                    ->order($sort, $order)
                    ->count();

                $list = $this->model
                    ->where($activity)
                    ->where($where)
                    ->order($sort, $order)
                    ->limit($offset, $limit)
                    ->select();
            }else{
                $total = $this->model
                    ->where($where)
                    ->order($sort, $order)
                    ->count();

                $list = $this->model
                    ->where($where)
                    ->order($sort, $order)
                    ->limit($offset, $limit)
                    ->select();

            }
            Cache::set('id',null);
            $list = collection($list)->toArray();
            if($list){
                foreach($list as &$item){
                    $vip_name=db('vip')->where(['id'=>$item['audit_id']])->find();
                    $item['audit_id']=$vip_name['name']?$vip_name['name']:'-';

                }
            }
            $result = array("total" => $total, "rows" => $list);
            return json($result);
        }
        return $this->view->fetch();
    }


    /**
     * 添加
     */
    public function add()
    {
        if ($this->request->isPost()) {

            $params = $this->request->post("row/a");
            if ($params) {
                $vip_name=db('vip')->where(['id'=>$params['vip_id']])->field('name')->find();
                 if($vip_name){
                    $params['username']=$vip_name['name'];
                }else{
                    return ;
                }
                $activi_name=db('activity')->where(['id'=>$params['activity_id']])->field('activityname,notcharge,notaudit,signupnum')->find();
                if($activi_name){
                    $params['activity_name']=$activi_name['activityname'];
                }else {
                    return;
                }
                $signnum=db('signlist')->where(['activity_id'=>$params['activity_id']])->count();
                if($signnum>=$activi_name['signupnum']){
                    $this->error('名额已满，请修改报名人数');
                }

                $aduit=db('signlist')->where(['activity_id'=>$params['activity_id']])->find();
                if($signnum>=$activi_name['signupnum']){
                    $this->error('核销名额已满');
                }

                $params = $this->preExcludeFields($params);

                if ($this->dataLimit && $this->dataLimitFieldAutoFill) {
                    $params[$this->dataLimitField] = $this->auth->id;
                }
                $result = false;
                Db::startTrans();
                try {
                    //是否采用模型验证
                    if ($this->modelValidate) {
                        $name = str_replace("\\model\\", "\\validate\\", get_class($this->model));
                        $validate = is_bool($this->modelValidate) ? ($this->modelSceneValidate ? $name . '.add' : $name) : $this->modelValidate;
                        $this->model->validateFailException(true)->validate($validate);
                    }
                    $result = $this->model->allowField(true)->save($params);
                    Db::commit();
                } catch (ValidateException $e) {
                    Db::rollback();
                    $this->error($e->getMessage());
                } catch (PDOException $e) {
                    Db::rollback();
                    $this->error($e->getMessage());
                } catch (Exception $e) {
                    Db::rollback();
                    $this->error($e->getMessage());
                }
                if ($result !== false) {
                    $this->success();
                } else {
                    $this->error(__('No rows were inserted'));
                }
            }
            $this->error(__('Parameter %s can not be empty', ''));
        }
        return $this->view->fetch();
    }


    /**
     * 编辑
     */
    public function edit($ids = null)
    {
        $row = $this->model->get($ids);
        if (!$row) {
            $this->error(__('No Results were found'));
        }
        $adminIds = $this->getDataLimitAdminIds();
        if (is_array($adminIds)) {
            if (!in_array($row[$this->dataLimitField], $adminIds)) {
                $this->error(__('You have no permission'));
            }
        }
        if ($this->request->isPost()) {
            $params = $this->request->post("row/a");
            if ($params) {
                $params = $this->preExcludeFields($params);
                $info=db('signlist')->where(['id'=>$ids,'deletetime'=>null])->find();
                $vipinfo=db('vip')->where(['id'=>$info['vip_id']])->find();


                $acid['activity_id']=$params['activity_id'];
                $acid['aduit']=['<>','2'];
                $acid['deletetime']=null;
                $signlist=db('signlist')->where($acid)->order('sernum desc')->find();
                if($signlist){
                    $params['sernum']=$signlist['sernum']+1;
                }else{
                    $params['sernum']=1;
                }
                $mes=new Message();
                //微信模板消息发送
                $mes->send_notice($vipinfo['openid'],$params['aduit'],$info['username'],$info['activity_name'],$info['activity_id']);
                $vip_name=db('vip')->where(['id'=>$params['vip_id']])->field('name')->find();
                if($vip_name){
                    $params['username']=$vip_name['name'];
                }
                $activity_name=db('activity')->where(['id'=>$params['activity_id']])->field('activityname')->find();
                if($activity_name){
                    $params['activity_name']=$activity_name['activityname'];
                }
                $params['signtime']=strtotime($params['signtime']);
                $params['updatetime']=strtotime($params['updatetime']);
                $result = false;
                Db::startTrans();
                try {
                    //是否采用模型验证
                    if ($this->modelValidate) {
                        $name = str_replace("\\model\\", "\\validate\\", get_class($this->model));
                        $validate = is_bool($this->modelValidate) ? ($this->modelSceneValidate ? $name . '.edit' : $name) : $this->modelValidate;
                        $row->validateFailException(true)->validate($validate);
                    }
                    $result = $row->allowField(true)->save($params);
                    Db::commit();
                } catch (ValidateException $e) {
                    Db::rollback();
                    $this->error($e->getMessage());
                } catch (PDOException $e) {
                    Db::rollback();
                    $this->error($e->getMessage());
                } catch (Exception $e) {
                    Db::rollback();
                    $this->error($e->getMessage());
                }
                if ($result !== false) {
                    $this->success();
                } else {
                    $this->error(__('No rows were updated'));
                }
            }
            $this->error(__('Parameter %s can not be empty', ''));
        }
        $this->view->assign("row", $row);
        return $this->view->fetch();
    }

    public function checkhd(){
        $data=input();
        $aclist=db('activity')->where($data)->find();
        if($aclist['notaudit']){
            return 1;
        }else{
            return 0;
        }
    }


    /**
     * 批量更新
     */
    public function multi($ids = "")
    {
        $ids = $ids ? $ids : $this->request->param("ids");
        if ($ids) {
            if ($this->request->has('params')) {
                parse_str($this->request->post("params"), $values);
                $values = array_intersect_key($values, array_flip(is_array($this->multiFields) ? $this->multiFields : explode(',', $this->multiFields)));
                if ($values || $this->auth->isSuperAdmin()) {
                    $adminIds = $this->getDataLimitAdminIds();
                    if (is_array($adminIds)) {
                        $this->model->where($this->dataLimitField, 'in', $adminIds);
                    }
                    $count = 0;
                    Db::startTrans();
                    try {
                        $list = $this->model->where($this->model->getPk(), 'in', $ids)->select();
                        foreach ($list as $index => $item) {
                            $count += $item->allowField(true)->isUpdate(true)->save($values);
                        }
                        Db::commit();
                    } catch (PDOException $e) {
                        Db::rollback();
                        $this->error($e->getMessage());
                    } catch (Exception $e) {
                        Db::rollback();
                        $this->error($e->getMessage());
                    }
                    if ($count) {
                        if($values['aduit']){
                            $info=db('signlist')->where(['id'=>$ids,'deletetime'=>null])->find();
                            $vipinfo=db('vip')->where(['id'=>$info['vip_id']])->find();
                            $mes=new Message();
                            $data=$mes->send_notice($vipinfo['openid'],1,$info['username'],$info['activity_name'],$info['activity_id']);
                            if($data==1){
                                return $this->success('消息发生成功');
                            }
                        }
                        $this->success();
                    } else {
                        $this->error(__('No rows were updated'));
                    }
                } else {
                    $this->error(__('You have no permission'));
                }
            }
        }
        $this->error(__('Parameter %s can not be empty', 'ids'));
    }



    public function form($ids = null){

        $row = $this->model->get($ids);
        if (!$row) {
            $this->error(__('No Results were found'));
        }
        $adminIds = $this->getDataLimitAdminIds();
        if (is_array($adminIds)) {
            if (!in_array($row[$this->dataLimitField], $adminIds)) {
                $this->error(__('You have no permission'));
            }
        }
        if ($this->request->isPost()) {
            $params = $this->request->post("row/a");
            if ($params) {
                $params = $this->preExcludeFields($params);
                $info=db('signlist')->where(['id'=>$ids,'deletetime'=>null])->find();
                if($params['aduit']==$info['aduit']&&$params['status']==$info['status']){
                    return $this->success();
                }
                $vipinfo=db('vip')->where(['id'=>$info['vip_id']])->find();
                $mes=new Message();
                //微信模板消息发送
                $mes->send_notice($vipinfo['openid'],$params['aduit'],$info['username'],$info['activity_name'],$info['activity_id']);

                $vip_name=db('vip')->where(['id'=>$params['vip_id']])->field('name')->find();
                if($vip_name){
                    $params['username']=$vip_name['name'];
                }
                $activity_name=db('activity')->where(['id'=>$params['activity_id']])->field('activityname')->find();
                if($activity_name){
                    $params['activity_name']=$activity_name['activityname'];
                }
                $result = false;
                Db::startTrans();
                try {
                    //是否采用模型验证
                    if ($this->modelValidate) {
                        $name = str_replace("\\model\\", "\\validate\\", get_class($this->model));
                        $validate = is_bool($this->modelValidate) ? ($this->modelSceneValidate ? $name . '.edit' : $name) : $this->modelValidate;
                        $row->validateFailException(true)->validate($validate);
                    }
                    $result = $row->allowField(true)->save($params);
                    Db::commit();
                } catch (ValidateException $e) {
                    Db::rollback();
                    $this->error($e->getMessage());
                } catch (PDOException $e) {
                    Db::rollback();
                    $this->error($e->getMessage());
                } catch (Exception $e) {
                    Db::rollback();
                    $this->error($e->getMessage());
                }
                if ($result !== false) {
                    $this->success();
                } else {
                    $this->error(__('No rows were updated'));
                }
            }
            $this->error(__('Parameter %s can not be empty', ''));
        }

        $as=json_decode($row['cusform']);
        if($as){
            foreach($as as $k=>$v){
                if(!is_array($as[$k])){
                    $as[$k]=(array)$as[$k];
                }
            }
        }else{
            return '无表单提交';
        }
        $this->view->assign("row", $as);
        return $this->view->fetch();
    }


    public function hexiao(){

        if($this->request->isPost()){
            $data=input();
           $signid=$this->cut_str($data['row'],'=',-1); //输出 123
           $sign=db('signlist')->where(['id'=>$signid,'deletetime'=>null])->find();
           if(!empty($sign)&&$sign['status']==1){
               $this->error('审核已通过','signlist/hexiao','',1);
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
            $up=db('signlist')->where(['id'=>$signid,'deletetime'=>null])->update(['status'=>1,'audit_id'=>10,'sernum'=>$sernum]);
            if($up){
                $me=new Message();
                $me->send_notice($user['openid'],3,$sign['activity_name'],$sign['username'], $sign['activity_id']);
                $this->success('审核通过','signlist/hexiao','',1);
            }else{
                $this->error('审核失败','signlist/hexiao','',1);
            }


        }

        return $this->view->fetch();
    }

    function cut_str($str,$sign,$number){
        $array=explode($sign, $str);
        $length=count($array);
        if($number<0){
            $new_array=array_reverse($array);
            $abs_number=abs($number);
            if($abs_number>$length){
                return 'error';
            }else{
                return $new_array[$abs_number-1];
            }
        }else{
            if($number>=$length){
                return 'error';
            }else{
                return $array[$number];
            }
        }
    }
}
