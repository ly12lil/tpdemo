<?php
/**
 * Created by PhpStorm.
 * User: ly12lil
 * Date: 18-6-20
 * Time: 上午9:43
 */

namespace app\admin\model;


use think\Config;
use think\Model;

class AdminUser extends Model
{
    protected $pk = 'id';
    protected $autoWriteTimestamp = true;
    protected $dateFormat = 'Y年m月d日';

    //设置时把password字段使用md5加密后上传到服务器
    //get的话就是获得时候干的了
    public function SetPasswordAttr($value)
    {
        return md5(Config::get('public_key').$value);
    }
}