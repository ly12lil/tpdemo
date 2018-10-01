<?php
/**
 * Created by PhpStorm.
 * User: ly12lil
 * Date: 18-6-20
 * Time: 下午1:51
 */

namespace app\admin\model;

use think\Model;

class SystemSclassify extends Model
{
    protected $pk = 'id';
    protected $autoWriteTimestamp = true;
    protected $dateFormat = 'Y年m月d日';
}