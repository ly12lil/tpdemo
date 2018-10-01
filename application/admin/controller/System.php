<?php
/**
 * Created by PhpStorm.
 * User: ly12lil
 * Date: 18-6-20
 * Time: 下午1:32
 */

namespace app\admin\controller;


use app\admin\common\Base;
use app\admin\common\commom;
use app\admin\model\AdminUser;
use app\admin\model\SystemClassify;
use app\admin\model\SystemCarousel;
use app\admin\model\SystemInfo;
use app\admin\model\SystemLinks;
use app\admin\model\SystemSclassify;
use think\Request;
use app\admin\model\AdminInfo;
use think\Session;

class System extends Base
{
    protected function _initialize(){
        $this->isLogin();
        $this->assign('menu','系统管理');
    }
    public function setup()
    {
        $this->assign('submenu','基本设置');
        $data  = SystemInfo::get('1');
        $this->assign('sys_info',$data);
        $this->assign('page_title','系统信息');
        echo $this->fetch();
    }

//    public function doSetup(Request $request)
//    {
//        $data = $request->param();
//        $res = $this->validate($data,'app\admin\common\validate\SystemInfo');
//        if (true !== $res){
//            return json(['status'=>0,'message'=>$res]);
//        }
//        if (SystemInfo::where('id','1')->data($data)->update()){
//            return json(['status'=>1,'message'=>'更新成功']);
//        }else{
//            return json(['status'=>0,'message'=>'更新失败']);
//        }
//    }

    public function doSetup(Request $request)
    {
        $data = $request->param();
        $res = $this->validate($data,'app\admin\common\validate\SystemInfo');
        if (true !== $res){
            return '<script>alert("'.$res.'");history.back(-1)</script>';
        }
        $file = $request->file('imageFile');
        if ($file != null){
            $info = $file->validate([
                'size'=>'2000000',
                'ext'=>'jpeg,jpg,png,gif'
            ])->move('uploads');
            if($info){
                //上传成功把图片文件路径赋给 $data 数组中的 logo 字段 因为需要传递到数据库中
                $data['logo'] = $info->getSaveName();
                if ($data['h_logo'] != null){
                    unlink('uploads/'.$data['h_logo']);
                }
            }else{
                return '<script>alert("'.$file->getError().'");history.back(-1)</script>';
            }
        }
        unset($data['h_logo']);
        if (SystemInfo::where('id','1')->data($data)->update()){
            $comm = new commom();
            $comm->AddLog(Session::get('admin_id'),'更新系统信息');
            return '<script>alert("更新成功");;history.back(-1)</script>';
        }else{
            return '<script>alert("更新失败");;history.back(-1)</script>';
        }

    }
    
    //添加轮播图
    public function carousel()
    {
        $this->assign('submenu','轮播图设置');
        $data = SystemCarousel::paginate(10);
        $this->assign('data',$data);
        return $this->fetch();
    }
    public function doCarousel(Request $request)
    {
        $data = $request->param();
        $file = $request->file('imageFile');
        if ($file != null){
            $info = $file->validate([
                'size'=>'2000000',
                'ext'=>'jpeg,jpg,png,gif'
            ])->move('uploads');
            if($info){
                //上传成功把图片文件路径赋给 $data 数组中的 logo 字段 因为需要传递到数据库中
                $data['img'] = $info->getSaveName();

            }else{
                return '<script>alert("'.$file->getError().'");history.back(-1)</script>';
            }
        }

        $res = $this->validate($data,'app\admin\common\validate\SystemCarousel');
        if (true !== $res){
            return '<script>alert("'.$res.'");history.back(-1)</script>';
        }

        if (SystemCarousel::create($data)){
            $comm = new commom();
            $comm->AddLog(Session::get('admin_id'),'添加轮播图'.$data['name']);
            return '<script>alert("添加成功");;history.back(-1)</script>';
        }else{
            return '<script>alert("添加失败");;history.back(-1)</script>';
        }
    }

    public function reCarousel(Request $request)
    {
        if ($request->isGet()){
            $id = $request->param('id');
            $img = SystemCarousel::where('id',$id)->value('img');
            if (SystemCarousel::where('id',$id)->delete()){
                unlink('uploads/'.$img);
                $comm = new commom();
                $comm->AddLog(Session::get('admin_id'),'删除轮播图'.$id);
                return '<script>alert("删除成功");;history.back(-1)</script>';
            }else{
                return '<script>alert("删除失败");;history.back(-1)</script>';
            }
        }else{
            $this->error('错误');
        }
    }
    
    //友情链接
    public function links()
    {
        $this->assign('submenu','友情链接');
        $data = SystemLinks::paginate(10);
        $this->assign('data',$data);
        return $this->fetch();
    }

    public function dolinks(Request $request)
    {
        if ($request->isAjax()){
            $data = $request->param();
            $res = $this->validate($data,'app\admin\common\validate\SystemLinks');
            if (true !== $res){
                return json(['status'=>0,'message'=>$res]);
            }
            if (SystemLinks::create($data)){
                $comm = new commom();
                $comm->AddLog(Session::get('admin_id'),'添加友情链接'.$data['name']);
                return json(['status'=>1,'message'=>'添加成功']);
            }else{
                return json(['status'=>0,'message'=>'添加失败']);
            }
        }else{
            $this->error('访问形式错误');
        }
    }

    public function userinfo()
    {
        $this->assign('submenu','用户管理');
        $data = AdminUser::paginate(10);
        $this->assign('data',$data);
        return $this->fetch();
    }

    public function relinks(Request $request)
    {
        if ($request->isGet()){
            $id = $request->param('id');
            if (SystemLinks::where('id',$id)->delete()){
                $comm = new commom();
                $comm->AddLog(Session::get('admin_id'),'删除友情链接'.$id);
                return '<script>alert("删除成功");;history.back(-1)</script>';
            }else{
                return '<script>alert("删除失败");;history.back(-1)</script>';
            }
        }else{
            $this->error('错误');
        }
    }

    public function douserinfo(Request $request)
    {
        $data = $request->param();
        $file = $request->file('upimg');
        if ($file != null){
            $info = $file->validate([
                'size'=>'2000000',
                'ext'=>'jpeg,jpg,png,gif'
            ])->move('uploads');
            if($info){
                //上传成功把图片文件路径赋给 $data 数组中的 logo 字段 因为需要传递到数据库中
                $data['avatar'] = $info->getSaveName();

            }else{
                return '<script>alert("'.$file->getError().'");history.back(-1)</script>';
            }
        }

        $res = $this->validate($data,'app\admin\common\validate\AdminUser');
        if (true !== $res){
            return '<script>alert("'.$res.'");history.back(-1)</script>';
        }

        if (AdminUser::create($data)){
            $comm = new commom();
            $comm->AddLog(Session::get('admin_id'),'添加用户'.$data['name']);
            return '<script>alert("添加成功");;history.back(-1)</script>';
        }else{
            return '<script>alert("添加失败");;history.back(-1)</script>';
        }
    }

    public function reuserinfo(Request $request)
    {
        if ($request->isGet()){
            $id = $request->param('id');
            if (AdminUser::where('id',$id)->delete()){
                $comm = new commom();
                $comm->AddLog(Session::get('admin_id'),'删除用户'.$id);
                return '<script>alert("删除成功");;history.back(-1)</script>';
            }else{
                return '<script>alert("删除失败");;history.back(-1)</script>';
            }
        }else{
            $this->error('错误');
        }
    }
    
    //分类
    public function classify()
    {
        $this->assign('submenu','分类设置');
        $data = SystemClassify::order('create_time', 'desc')->paginate(10);
        $this->assign('data',$data);
        return $this->fetch();
    }

    public function doclassify(Request $request)
    {
        if ($request->isAjax()){
            $data = $request->param();
            $data['user_id'] = Session::get('admin_id');
            $data['user_name'] = Session::get('admin_name');
            $res = $this->validate($data,'app\admin\common\validate\SystemClassify');
            if (true !== $res){
                return json(['status'=>0,'message'=>$res]);
            }
            if (SystemClassify::create($data)){
                $comm = new commom();
                $comm->AddLog(Session::get('admin_id'),'添加分类'.$data['name']);
                return json(['status'=>1,'message'=>'添加成功']);
            }else{
                return json(['status'=>0,'message'=>'添加失败']);
            }
        }else{
            $this->error('访问形式错误');
        }
    }
    public function reclassify(Request $request)
    {
        if ($request->isGet()){
            $id = $request->param('id');
            if (SystemClassify::where('id',$id)->delete()){
                $comm = new commom();
                $comm->AddLog(Session::get('admin_id'),'删除子记录'.$id);
                return '<script>alert("删除成功");;history.back(-1)</script>';
            }else{
                return '<script>alert("删除失败");;history.back(-1)</script>';
            }
        }else{
            $this->error('错误');
        }
    }
    public function sclassify()
    {
        $this->assign('submenu','子分类');
        $data = SystemSclassify::order('create_time', 'desc')->paginate(10);
        $cay = SystemClassify::where('static',1)->select();
        $this->assign('cay',$cay);
        $this->assign('data',$data);
        return $this->fetch();
    }
    public function dosclassify(Request $request)
    {
        if ($request->isAjax()){
            $data = $request->param();
            $data['user_id'] = Session::get('admin_id');
            $res = $this->validate($data,'app\admin\common\validate\SystemSclassify');
            if (true !== $res){
                return json(['status'=>0,'message'=>$res]);
            }
            if (SystemSclassify::create($data)){
                $comm = new commom();
                $comm->AddLog(Session::get('admin_id'),'添加子分类'.$data['name']);
                return json(['status'=>1,'message'=>'添加成功']);
            }else{
                return json(['status'=>0,'message'=>'添加失败']);
            }
        }else{
            $this->error('访问形式错误');
        }
    }
    public function resclassify(Request $request)
    {
        if ($request->isGet()){
            $id = $request->param('id');
            if (SystemSclassify::where('id',$id)->delete()){
                $comm = new commom();
                $comm->AddLog(Session::get('admin_id'),'删除子记录'.$id);
                return '<script>alert("删除成功");;history.back(-1)</script>';
            }else{
                return '<script>alert("删除失败");;history.back(-1)</script>';
            }
        }else{
            $this->error('错误');
        }
    }
}