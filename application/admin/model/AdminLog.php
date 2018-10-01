<?php
/**
 * Created by PhpStorm.
 * User: ly12lil
 * Date: 18-6-21
 * Time: 下午1:18
 */

namespace app\admin\model;


use think\Model;

class AdminLog extends Model
{
    protected $pk = 'id';
    protected $autoWriteTimestamp = true;
    protected $dateFormat = 'Y-m-d H:i:s';
}