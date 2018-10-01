<?php
/**
 * Created by PhpStorm.
 * User: ly12lil
 * Date: 18-6-28
 * Time: 上午8:52
 */

namespace app\index\controller;


use app\admin\model\Article;
use app\admin\model\SystemSclassify;
use app\index\common\Base;
use think\Request;

class Html extends Base
{
    public function index(Request $request)
    {
        if ($request->isGet()){
            $data = $request->param();

            //return json($data);
            $art = Article::where('sclassify_id',$data['sclassify_id'])->where('id',$data['id'])->find();
            if ($art == null){
                return '文章不存在';
            }
            $this->assign('data',$art);
            return $this->fetch();
//            return json($art);
        }else{
            $this->error('访问形式错误 ');
        }
    }

    public function listfl(Request $request)
    {
        if($request->isGet()){
            $sclassify_id=$request->param('sclassify_id');
            $flmc =SystemSclassify::where('id',$sclassify_id)->value('name');
            if ($flmc==null){
                return '分类不存在';
            }
            $art = Article::where('sclassify_id',$sclassify_id)->where('status',1)->order('create_time','desc')->field('name,text,img,sclassify_id,id')->paginate(5);
            $this->assign('data',$art);
            $this->assign('flmc',$flmc);
            return $this->fetch();

        }else{
            $this->error('访问形式错误');
        }
    }
}