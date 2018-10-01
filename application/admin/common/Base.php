<?php
/**
 * Created by PhpStorm.
 * User: ly12lil
 * Date: 18-6-20
 * Time: 上午9:21
 */

namespace app\admin\common;


use app\admin\model\AdminUser;
use app\admin\model\SystemInfo;
use think\auth\Auth;
use think\Controller;
use think\Session;

class Base extends Controller
{
    protected function _initialize()
    {
//        $module=$this->request->module();
//        $controller=$this->request->controller();
//        $action=$this->request->action();
    }

    //判断是否登录
    protected function isLogin(){
        if (!Session::get('admin_uid')){
            $this->error('非法访问请登录','admin/login/');
        }
        $auth=Auth::instance();
        $module=$this->request->module();
        $controller=$this->request->controller();
        $action=$this->request->action();
        if(!$auth->check($module.'/'.$controller.'/'.$action,Session::get('admin_uid')))
        {
            $this->error("没有权限");//,"index/login/index"
        }
    }
}