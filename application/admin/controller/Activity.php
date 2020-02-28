<?php

namespace app\admin\controller;

use app\common\controller\Backend;
use think\db;
use think\Loader;
use think\Request;
use PHPExcel_IOFactory;
/**
 * 活动管理
 *
 * @icon fa fa-circle-o
 */


Loader::import('phpqrcode.phpqrcode',EXTEND_PATH,'.php');
class Activity extends Backend
{
    protected $multiFields="notcharge,notaudit";
    /**
     * Activity模型对象
     * @var \app\admin\model\Activity
     */
    protected $model = null;

    public function _initialize()
    {
        parent::_initialize();
        $this->model = new \app\admin\model\Activity;
        $this->view->assign("notchargeList", $this->model->getNotchargeList());
        $this->view->assign("notauditList", $this->model->getNotauditList());
        $hx=db('vip')->where(['status'=>1,'auditman'=>1,'deletetime'=>null])->select();
        $hexiaoman=[];

        foreach($hx as &$item){
            $hexiaoman[$item['openid']]=$item['name'];
        }
        unset($item);
        $this->assign('hxlist',$hexiaoman);
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
        //设置过滤方法
        $this->request->filter(['strip_tags']);
        if ($this->request->isAjax()) {
            //如果发送的来源是Selectpage，则转发到Selectpage
            if ($this->request->request('keyField')) {
                return $this->selectpage();
            }
            list($where, $sort, $order, $offset, $limit) = $this->buildparams();
            $total = $this->model
                ->where($where)
                ->order($sort, $order)
                ->count();

            $list = $this->model
                ->where($where)
                ->order($sort, $order)
                ->limit($offset, $limit)
                ->select();

            $list = collection($list)->toArray();

            if($list){
                foreach( $list as &$item){
                    $user=explode(',',$item['audit_id']);
                    foreach($user as $k=>$v){
                        $username=db('vip')->where(['openid'=>$v,'deletetime'=>null])->field('name')->find();
                        if($username){
                            $user[$k]=$username['name'];
                        }
                    }
                    $audit=implode(',',$user);
                    $item['audit_id']=$audit;
                }
                unset($item);
            }
            $result = array("total" => $total, "rows" => $list);
            return json($result);
        }
        return $this->view->fetch();
    }





    /**
     * 编辑
     */
    public function form($ids = null)
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
                $form=[];

                $title=$params['title'];
                $type=$params['type'];
                if($title){
                    $futitle=$params['futitle'];
                    foreach ($title as $k=>$v){
                        if(!empty($v)){
                            $form[$k]['title']=$v;
                            $form[$k]['futitle']=isset($futitle)?$futitle[$k]:[];
                            $form[$k]['type']=isset($type)?$type[$k]:[];
                        }
                    }

                }
                if(!empty($form)){
                    $params['custom']=json_encode($form);
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
        if($row){
            $row['custom'] = $row['custom'] ? json_decode($row['custom'], true) : [];
        }
        $this->view->assign("row", $row);
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
                $params = $this->preExcludeFields($params);
                if($params['notcharge']==0){
                    $params['charge']=0;
                }
                if(!is_numeric($params['views'])){
                    return $this->error('浏览量请填数字');
                }
                if ($this->dataLimit && $this->dataLimitFieldAutoFill) {
                    $params[$this->dataLimitField] = $this->auth->id;
                }
                $params['audit_id']=implode(',',$params['audit_id']);
                $params['custom']='[{"title":"\u6295\u6807\u5355\u4f4d","futitle":"\u540d\u79f0","type":"0"},{"title":"\u8054\u7cfb\u4eba","futitle":"\u59d3\u540d","type":"0"},{"title":"\u90ae\u7bb1","futitle":"\u6709\u6548\u90ae\u7bb1","type":"0"},{"title":"\u8054\u7cfb\u7535\u8bdd","futitle":"\u7535\u8bdd\u53f7\u7801","type":"0"}]';
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
                    $url=$this->model->getLastInsID();
                    $add['url_address']='hx.le-cx.com/vote?activity_id='.$url;
                    db('activity')->where(['id'=>$url])->update($add);
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
                    $this->success('请添加表单和票种信息!');
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
        //halt($row);
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
                if($params['notcharge']==0){
                    $params['charge']=0;
                }

                if(!is_numeric($params['views'])){
                    return $this->error('浏览量请填数字');
                }

                $params['audit_id']=implode(',',$params['audit_id']);
                $params = $this->preExcludeFields($params);
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

    public function ajax(){
        $data=input();
        $url='http://bl.le-cx.com';
        $qrcode = new \QRcode();

        // $qrimage = new \QRimage();

        $value = $url;                    //二维码内容
        $errorCorrectionLevel = 'H';    //容错级别
        $matrixPointSize = 6;           //生成图片大小

        ob_start();
        $qrcode::png($value,false , $errorCorrectionLevel, $matrixPointSize, 2);
        // $object->png($url, false, $errorCorrectionLevel, $matrixPointSize, 2); //这里就是把生成的图片流从缓冲区保存到内存对象上，使用base64_encode变成编码字符串，通过json返回给页面。
        $imageString = base64_encode(ob_get_contents()); //关闭缓冲区
        ob_end_clean(); //把生成的base64字符串返回给前端
        $data = array( 'code'=>200, 'data'=>"data:image/jpg;base64,".$imageString );
        return json_encode($data);
    }


    public function export($ids = null)
    {
        $path = dirname(__FILE__);
        $hexiao = input();
        vendor("PHPExcel");
        vendor("PHPExcel.Writer.Excel5");
        vendor("PHPExcel.Writer.Excel2007");
        vendor("PHPExcel.IOFactory");
        $objPHPExcel = new \PHPExcel();
        $objWriter = new \PHPExcel_Writer_Excel5($objPHPExcel);
        $objWriter = new \PHPExcel_Writer_Excel2007($objPHPExcel);
        $ac=db('activity')->where(['id'=>$ids])->find();
        if(empty($ac['custom'])){
            return $this->error('该活动无表单信息，不可导出！');
        }
        $cus=(array)json_decode($ac['custom']);
        if(count($cus)<3){
            return  $this->error('该活动未按规定添加表单信息，不可导出！');
        }
        $sql = db('signlist')->where(['activity_id'=>$ids,'deletetime'=>null])->order('sernum asc')->field('sernum,cusform,updatetime')->select();
        var_dump($sql);die;
        if(empty($sql)){
            return '无数据';
        }
        foreach ($sql as $k=>$v){
            $sql[$k]['cusform']=(array)json_decode($sql[$k]['cusform'],true);
        }

        /*--------------开始从数据库提取信息插入Excel表中------------------*/
//$i=2; //定义一个i变量，目的是在循环输出数据是控制行数
        $count = count($sql); //计算有多少条数据
//echo $count;
//die;
        if($hexiao['is_hexiao'] == 1){

            $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A1', '序号')
                ->setCellValue('B1', '投标人')
                ->setCellValue('C1', '联系人')
                ->setCellValue('D1', '邮箱')
                ->setCellValue('E1', '联系电话')
                ->setCellValue('F1', '签到时间');

            for ($i = 2; $i <= $count+1; $i++) {
                $objPHPExcel->getActiveSheet()->setCellValue('A' . $i, $sql[$i-2]['sernum']);
                $objPHPExcel->getActiveSheet()->setCellValue('B' . $i, $sql[$i-2]['cusform'][0]['content']);
                $objPHPExcel->getActiveSheet()->setCellValue('C' . $i, $sql[$i-2]['cusform'][1]['content']);
                $objPHPExcel->getActiveSheet()->setCellValue('D' . $i, $sql[$i-2]['cusform'][2]['content']);
                $objPHPExcel->getActiveSheet()->setCellValue('E' . $i, $sql[$i-2]['cusform'][3]['content']);
                $objPHPExcel->getActiveSheet()->setCellValue('F' . $i, date('Y-m-d h:i:s',$sql[$i-2]['updatetime']));
            }
        }else{
            $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A1', '序号')
                ->setCellValue('B1', '投标人')
                ->setCellValue('C1', '联系人')
                ->setCellValue('D1', '联系电话')
                ->setCellValue('E1', '签到时间');

            for ($i = 2; $i <= $count+1; $i++) {
                $objPHPExcel->getActiveSheet()->setCellValue('A' . $i, $sql[$i-2]['sernum']);
                $objPHPExcel->getActiveSheet()->setCellValue('B' . $i, $sql[$i-2]['cusform'][0]['content']);
                $objPHPExcel->getActiveSheet()->setCellValue('C' . $i, $sql[$i-2]['cusform'][1]['content']);
                $objPHPExcel->getActiveSheet()->setCellValue('D' . $i, $sql[$i-2]['cusform'][3]['content']);
                $objPHPExcel->getActiveSheet()->setCellValue('E' . $i, date('Y-m-d h:i:s',$sql[$i-2]['updatetime']));
            }
        }

        /*--------------下面是设置其他信息------------------*/

        $objPHPExcel->getActiveSheet()->settitle('信息'); //设置sheet的名称
        $objPHPExcel->setActiveSheetIndex(0); //设置sheet的起始位置
        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5'); //通过PHPExcel_IOFactory的写函数将上面数据写出来
        $PHPWriter = \PHPExcel_IOFactory::createWriter( $objPHPExcel,"Excel2007");
        header('Content-Disposition: attachment;filename="签到信息.xlsx"');
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        $PHPWriter->save("php://output"); //表示在$path路径下面生成demo.xlsx文件
        echo '导出成功';
    }
}
