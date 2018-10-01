<?php
/**
 * Created by PhpStorm.
 * User: ly12lil
 * Date: 18-6-21
 * Time: 下午1:19
 */

namespace app\admin\controller;

use app\admin\common\commom;
use app\admin\common\Base;
use app\admin\model\AdminLog;
use app\admin\model\AdminUser;
use think\Cookie;
use think\Request;
use think\Session;

class User extends Base
{

    protected function _initialize(){
        $this->isLogin();
        $this->assign('menu','个人信息');
    }

    public function log()
    {
        $this->assign('submenu','操作记录');
        $data = AdminLog::where('admin_id',Session::get('admin_id'))->order('create_time', 'desc')->paginate(10);
        $this->assign('data',$data);
//        dump($data);
        return $this->fetch();
    }

    public function relog(Request $request)
    {
        if ($request->isGet()){
            $id = $request->param('id');
            if (AdminLog::where('id',$id)->delete()){
                return '<script>alert("删除成功");;history.back(-1)</script>';
            }else{
                return '<script>alert("删除失败");;history.back(-1)</script>';
            }
        }else{
            $this->error('错误');
        }
    }

    //退出
    public function out()
    {
        Session::clear();
        Cookie::delete('yhxx');
        $this->success('退出成功','admin/login/index');
    }




}