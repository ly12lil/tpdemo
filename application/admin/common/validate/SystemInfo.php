<?php
/**
 * Created by PhpStorm.
 * User: ly12lil
 * Date: 18-6-20
 * Time: 下午1:53
 */

namespace app\admin\common\validate;


use think\Validate;

class SystemInfo extends Validate
{
    protected $rule = [
        'keyword|关键词'=>[
            'require',
            'length'=>'2,20',
        ],
        'sitename|网站名称'=>[
            'require',
            'length'=>'2,200',
        ],
        'sitename|关键词'=>[
            'require',
            'length'=>'2,100',
        ],
        'copyright|版权信息'=>[
            'require',
            'length'=>'2,400',
        ],
        'title|网站标题'=>[
            'require',
            'length'=>'2,200',
        ],
        'subtitle|副标题'=>[
            'require',
            'length'=>'2,50',
        ]
    ];
}