<?php
namespace app\index\controller;


use app\admin\model\SystemCarousel;
use app\admin\model\SystemLinks;
use app\index\common\Base;
use think\Config;
use think\Controller;

class Index extends Base
{
    public function index()
    {

//        $carousel = SystemCarousel::order('priority', 'asc')->select();
//        $links = SystemLinks::order('priority', 'asc')->select();
//        $this->assign('carousel',$carousel);
//        $this->assign('links',$links);
        return $this->fetch();
    }

    public function t()
    {
        dump(\think\Db::table('think_article')->where('sclassify_id','=',9)->limit(3)->select());
    }

}