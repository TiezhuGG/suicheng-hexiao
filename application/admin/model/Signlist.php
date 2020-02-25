<?php

namespace app\admin\model;

use think\Model;
use traits\model\SoftDelete;

class Signlist extends Model
{

    use SoftDelete;

    

    // 表名
    protected $name = 'signlist';
    
    // 自动写入时间戳字段
    protected $autoWriteTimestamp = 'int';

    // 定义时间戳字段名
    protected $createTime = 'createtime';
    protected $updateTime = 'updatetime';
    protected $deleteTime = 'deletetime';

    // 追加属性
    protected $append = [
        'signtime_text',
        'status_text',
        'aduit_text'
    ];
    

    
    public function getStatusList()
    {
        return ['0' => __('Status 0'), '1' => __('Status 1')];
    }

    public function getAduitList()
    {
        return ['0' => __('Aduit 0'), '1' => __('Aduit 1'),'2' => __('Aduit 2')];
    }


    public function getSigntimeTextAttr($value, $data)
    {
        $value = $value ? $value : (isset($data['signtime']) ? $data['signtime'] : '');
        return is_numeric($value) ? date("Y-m-d H:i:s", $value) : $value;
    }


    public function getStatusTextAttr($value, $data)
    {
        $value = $value ? $value : (isset($data['status']) ? $data['status'] : '');
        $list = $this->getStatusList();
        return isset($list[$value]) ? $list[$value] : '';
    }


    public function getAduitTextAttr($value, $data)
    {
        $value = $value ? $value : (isset($data['aduit']) ? $data['aduit'] : '');
        $list = $this->getAduitList();
        return isset($list[$value]) ? $list[$value] : '';
    }

    protected function setSigntimeAttr($value)
    {
        return $value === '' ? null : ($value && !is_numeric($value) ? strtotime($value) : $value);
    }


}
