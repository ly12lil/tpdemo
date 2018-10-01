<?php
/**
 * Created by PhpStorm.
 * User: ly12lil
 * Date: 18-6-20
 * Time: 下午1:53
 */

namespace app\admin\common\validate;


use think\Validate;

class AdminUser extends Validate
{
    protected $rule = [
        'name|用户名'=>[
            'require',
            'length'=>'2,20',
            'unique'=>'admin_user', // 该字段必须在 think_admin_user 中是唯一的 如果存在就报错
        ],
        'email|邮箱'=>[
            'require',
            'email',
            'unique'=>'admin_user', // 该字段必须在 think_admin_user 中是唯一的 如果存在就报错
        ],
        'password|用户名'=>[
            'require',
            'length'=>'７,15',
        ],
        'avatar|头像'=>[
            'require',
        ],
        'uid|权限'=>[
            'require',
        ],
    ];
}