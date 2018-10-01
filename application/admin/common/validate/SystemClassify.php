<?php
/**
 * Created by PhpStorm.
 * User: ly12lil
 * Date: 18-6-20
 * Time: 下午1:53
 */

namespace app\admin\common\validate;


use think\Validate;

class SystemClassify extends Validate
{
    protected $rule = [
        'name|分类'=>[
            'require',
            'length'=>'2,20',
        ],
        'static|名称'=>[
            'require',
        ],
    ];
}