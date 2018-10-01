<?php
/**
 * Created by PhpStorm.
 * User: ly12lil
 * Date: 18-6-20
 * Time: 下午1:53
 */

namespace app\admin\common\validate;


use think\Validate;

class SystemLinks extends Validate
{
    protected $rule = [
        'name|名称'=>[
            'require',
            'length'=>'2,20',
        ],
        'url|地址'=>[
            'require',
            'url',
            'length'=>'2,200',
        ],
        'priority|优先级'=>[
            'require',
            'length'=>'1,3',
            'float'
        ],
    ];
}