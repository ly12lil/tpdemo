<?php
/**
 * Created by PhpStorm.
 * User: ly12lil
 * Date: 18-6-26
 * Time: 下午1:36
 */

namespace app\admin\controller;


use app\admin\common\Base;
use app\admin\common\commom;
use app\admin\model\Article as ModelArticle;
use app\admin\model\SystemSclassify;
use think\Db;
use think\Image;
use think\Request;
use think\Session;


class Article extends Base
{
    protected function _initialize()
    {
        $this->isLogin();
        $this->assign('menu','文章管理');
    }

    public function release()
    {
        $this->assign('submenu','发布文章');
        $data  = SystemSclassify::where('static','1')->select();
        $this->assign('data',$data);
        $this->assign('page_title','系统信息');
        return $this->fetch();
    }

    public function dorelease(Request $request)
    {
        if ($request->isAjax()){
            $data = $request->param();
            $data['user_id'] = Session::get('admin_id');
            $res = $this->validate($data,'app\admin\common\validate\Article');
            if (true !== $res){
                return json(['status'=>0,'message'=>$res]);
            }
            if (ModelArticle::create($data)){
                $comm = new commom();
                $comm->AddLog(Session::get('admin_id'),'添加文章'.$data['name']);
                return json(['status'=>1,'message'=>'添加成功']);
            }else{
                return json(['status'=>0,'message'=>'添加失败']);
            }
        }else{
            $this->error('访问形式错误');
        }
    }
    public function modify()
    {
        $this->assign('submenu','文章管理');
        $data  = ModelArticle::order('create_time', 'desc')->paginate(10);;
        $this->assign('data',$data);
        $this->assign('page_title','系统信息');
        return $this->fetch();
    }

    public function remodify(Request $request)
    {
        if ($request->isGet()){
            $id = $request->param('id');
            if (ModelArticle::where('id',$id)->delete()){
                $comm = new commom();
                $comm->AddLog(Session::get('admin_id'),'删除文章'.$id);
                return '<script>alert("删除成功");;history.back(-1)</script>';
            }else{
                return '<script>alert("删除失败");;history.back(-1)</script>';
            }
        }else{
            $this->error('错误');
        }
    }
    
    //获得文章json形式
    public function getAc(Request $request)
    {
//        if ($request->isAjax()){
            $id = $request->param('id');
            $data = ModelArticle::get($id);
            return json($data);
//        }else{
//            $this->error('访问形式错误');
//        }
    }

    public function domodify(Request $request)
    {
        if ($request->isAjax()){
            $data = $request->param();
            $res = $this->validate($data,'app\admin\common\validate\MArticle');
            if (true !== $res){
                return json(['status'=>0,'message'=>$res]);
            }
            if (ModelArticle::where('id',$data['id'])->data($data)->update()){
                return json(['status'=>1,'message'=>'更新成功']);
            }else{
                return json(['status'=>0,'message'=>'更新失败']);
            }
        }else{
            $this->error('访问形式错误');
        }
    }

    
    //layui图片上传接口
    public function lay_img_upload(Request $request){
        $file = $request->file('file');
        if(empty($file)){
            $result["code"] = "1";
            $result["msg"] = "请选择图片";
            $result['data']["src"] = '';
        }else{
            // 移动到框架应用根目录/public/uploads/ 目录下
            $info = $file->validate([
                'size'=>'2000000',
                'ext'=>'jpeg,jpg,png,gif'
            ])->move(ROOT_PATH . 'public' . DS . 'uploads/layui' );
            if($info){
                $name_path =str_replace('\\',"/",$info->getSaveName());
                //添加水印
                $img = Image::open("uploads/layui/".$name_path);
                $img->text('xx版权所有','static/fonts/sy.ttf',20,'#ffffff')->save("uploads/layui/".$name_path,null,70);
                //成功上传后 获取上传信息
                $result["code"] = '0';
                $result["msg"] = "上传成功";
                $result['data']["src"] = "/uploads/layui/".$name_path;
            }else{
                // 上传失败获取错误信息
                $result["code"] = "2";
                $result["msg"] = $file->getError();
                $result['data']["src"] ='';
            }
        }
        return json_encode($result);
    }
    

}