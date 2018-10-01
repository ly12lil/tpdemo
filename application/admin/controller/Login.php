<?php
/**
 * Created by PhpStorm.
 * User: ly12lil
 * Date: 18-6-20
 * Time: 上午9:20
 */

namespace app\admin\controller;



use app\admin\common\Base;
use app\admin\model\AdminUser;
use think\Config;
use think\Controller;
use think\Cookie;
use think\Db;
use think\Request;
use think\Session;
use think\auth\Auth;
class Login extends Controller
{
    public function _initialize()
    {
        if (Session::has('admin_uid')){
            $this->success('您已经登录','admin/index/index');
        }
    }
    public function index()
    {
        return $this->fetch();
    }

    public function loginCheck(Request $request)
    {
        if ($request->isAjax()){
            $data = $request->param();
            if (isset($data['name']) && isset($data['password'])){;
                $rule = ['name|用户名'=>'require','password|密码'=>'require'];
                $res = $this->validate($data,$rule);
                if (true !== $res){
                    return json(['status'=>0,'message'=>$res]);
                }
                $user = AdminUser::get(function($query) use($data){
                    $query->where('name',$data['name'])
                        ->where('password',md5(Config::get('public_key').$data['password']));
                });
                if ($user !== null){
                    Session::set('admin_name',$user['name']);
                    Session::set('admin_id',$user['id']);
                    Session::set('admin_uid',$user['uid']);
                    Cookie::set('yhxx',['avatar'=>$user['avatar'],'create_time'=>$user['create_time']]);
                    return json(['status'=>1,'message'=>'登录成功']);

                }else {
                    return json(['status'=>0,'message'=>'用户名或密码错误']);
                }
            }else{
                return json(['status'=>0,'message'=>'传入参数不正常']);
            }
        }else{
            $this->error('访问类型错误','index/index/index');
        }
    }

//    //临时写入管理员用户
//    public function test()
//    {
////        dump(AdminUser::all());
////        $data =[
////            'name'=>'admin',
////            'password'=>md5(Config::get('public_key').'123456'),
////            'avatar'=>'https://cdn.xzzte.cn/20180528103504.gif',
////            'email'=>'908931137@qq.com',
////            'uid'=>'1'
////        ];
////        $a = AdminUser::create($data);
////        dump($a);
//    }
}