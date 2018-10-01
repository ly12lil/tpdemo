<?php
/**
 * Created by PhpStorm.
 * User: ly12lil
 * Date: 18-6-22
 * Time: 上午9:27
 */

namespace app\admin\model;


use think\Model;

class SystemLinks extends Model
{
    protected $pk = 'id';
    protected $autoWriteTimestamp;
    protected $dateFormat = 'Y年m月d日';
}