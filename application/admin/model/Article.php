<?php
/**
 * Created by PhpStorm.
 * User: ly12lil
 * Date: 18-6-27
 * Time: 上午9:28
 */

namespace app\admin\model;


use think\Model;

class Article extends Model
{
    protected $pk = 'id';
    protected $autoWriteTimestamp = true;
    protected $dateFormat = 'Y年m月d日';
}