<?php
/**
 * Created by PhpStorm.
 * User: ly12lil
 * Date: 18-6-20
 * Time: 下午1:53
 */

namespace app\admin\common\validate;


use think\Validate;

class SystemSclassify extends Validate
{
    protected $rule = [
        'classify_id|名称'=>[
            'require',
            'float'
        ],
        'name|名称'=>[
            'require',
            'length'=>'2,200',
        ],
        'user_id|用户id'=>[
            'require',
            'float'
        ],
        'static|启用状态'=>[
            'require',
            'float'
        ],
    ];
}