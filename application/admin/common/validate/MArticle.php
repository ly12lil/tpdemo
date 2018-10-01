<?php
/**
 * Created by PhpStorm.
 * User: ly12lil
 * Date: 18-6-27
 * Time: 上午9:25
 */

namespace app\admin\common\validate;


use think\Validate;

class MArticle extends Validate
{
    protected $rule = [
        'name|名称'=>[
            'require',
            'length'=>'2,200',
        ],
        'text|文本'=>[
            'require',
        ],
        'status|启用状态'=>[
            'require',
            'float'
        ],
    ];
}