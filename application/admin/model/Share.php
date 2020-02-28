<?php

namespace app\admin\model;

use think\Model;
use traits\model\SoftDelete;

class Share extends Model
{

    use SoftDelete;

    

    // 表名
    protected $name = 'share';
    
    // 自动写入时间戳字段
    protected $autoWriteTimestamp = 'int';

    // 定义时间戳字段名
    protected $createTime = 'createtime';
    protected $updateTime = 'updatetime';
    protected $deleteTime = 'deletetime';

    // 追加属性
    protected $append = [

    ];
    

    







}
