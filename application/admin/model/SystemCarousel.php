<?php
/**
 * Created by PhpStorm.
 * User: ly12lil
 * Date: 18-6-21
 * Time: 上午11:35
 */

namespace app\admin\model;


use think\Model;

class SystemCarousel extends Model
{
    protected $pk = 'id';
    protected $autoWriteTimestamp = true;
    protected $dateFormat = 'Y年m月d日';
}