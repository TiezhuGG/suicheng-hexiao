<?php

namespace app\admin\model;

use think\Model;
use traits\model\SoftDelete;

class Activity extends Model
{

    use SoftDelete;

    

    // 表名
    protected $name = 'activity';
    
    // 自动写入时间戳字段
    protected $autoWriteTimestamp = 'int';

    // 定义时间戳字段名
    protected $createTime = 'createtime';
    protected $updateTime = 'updatetime';
    protected $deleteTime = 'deletetime';

    // 追加属性
    protected $append = [
        'signuptime_text',
        'audittime_text',
        'notcharge_text',
        'notaudit_text'
    ];
    

    
    public function getNotchargeList()
    {
        return ['0' => __('Notcharge 0'), '1' => __('Notcharge 1')];
    }

    public function getNotauditList()
    {
        return ['0' => __('Notaudit 0'), '1' => __('Notaudit 1')];
    }


    public function getSignuptimeTextAttr($value, $data)
    {
        $value = $value ? $value : (isset($data['signuptime']) ? $data['signuptime'] : '');
        return is_numeric($value) ? date("Y-m-d H:i:s", $value) : $value;
    }


    public function getAudittimeTextAttr($value, $data)
    {
        $value = $value ? $value : (isset($data['audittime']) ? $data['audittime'] : '');
        return is_numeric($value) ? date("Y-m-d H:i:s", $value) : $value;
    }


    public function getNotchargeTextAttr($value, $data)
    {
        $value = $value ? $value : (isset($data['notcharge']) ? $data['notcharge'] : '');
        $list = $this->getNotchargeList();
        return isset($list[$value]) ? $list[$value] : '';
    }


    public function getNotauditTextAttr($value, $data)
    {
        $value = $value ? $value : (isset($data['notaudit']) ? $data['notaudit'] : '');
        $list = $this->getNotauditList();
        return isset($list[$value]) ? $list[$value] : '';
    }

    protected function setSignuptimeAttr($value)
    {
        return $value === '' ? null : ($value && !is_numeric($value) ? strtotime($value) : $value);
    }

    protected function setAudittimeAttr($value)
    {
        return $value === '' ? null : ($value && !is_numeric($value) ? strtotime($value) : $value);
    }


}
