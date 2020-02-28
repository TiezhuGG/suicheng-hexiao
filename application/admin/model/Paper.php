<?php

namespace app\admin\model;

use think\Model;
use traits\model\SoftDelete;

class Paper extends Model
{

    use SoftDelete;

    

    // 表名
    protected $name = 'paper';
    
    // 自动写入时间戳字段
    protected $autoWriteTimestamp = 'int';

    // 定义时间戳字段名
    protected $createTime = 'createtime';
    protected $updateTime = 'updatetime';
    protected $deleteTime = 'deletetime';

    // 追加属性
    protected $append = [
        'charge_text'
    ];
    

    
    public function getChargeList()
    {
        return ['0' => __('Charge 0'), '1' => __('Charge 1')];
    }


    public function getChargeTextAttr($value, $data)
    {
        $value = $value ? $value : (isset($data['charge']) ? $data['charge'] : '');
        $list = $this->getChargeList();
        return isset($list[$value]) ? $list[$value] : '';
    }




}
