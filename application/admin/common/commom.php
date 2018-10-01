<?php
/**
 * Created by PhpStorm.
 * User: ly12lil
 * Date: 18-6-21
 * Time: 下午1:16
 */

namespace app\admin\common;


use app\admin\model\AdminLog;

class commom
{
    //操作记录
    public function AddLog($admin_id,$log)
    {
        $data = ['admin_id'=>$admin_id,'log'=>$log];
        AdminLog::create($data);
    }
}