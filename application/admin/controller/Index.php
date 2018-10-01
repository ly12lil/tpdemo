<?php
/**
 * Created by PhpStorm.
 * User: ly12lil
 * Date: 18-6-20
 * Time: 上午10:55
 */

namespace app\admin\controller;


use app\admin\common\Base;
use app\admin\model\AdminUser;
use think\Session;

class Index extends Base
{
    protected function _initialize()
    {
        $this->isLogin();
    }

    public function index()
    {
        $this->assign('user_sum',AdminUser::count());
        return $this->fetch();
    }

    //站点管理　系统信息
    public function systemsetup()
    {
        $this->assign('page_title','系统信息');
        return $this->fetch();
    }
}