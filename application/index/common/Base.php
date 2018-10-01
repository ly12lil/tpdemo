<?php
/**
 * Created by PhpStorm.
 * User: ly12lil
 * Date: 18-6-20
 * Time: 上午9:21
 */

namespace app\index\common;

use app\admin\model\SystemCarousel;
use app\admin\model\SystemLinks;
use app\admin\model\SystemInfo;
use think\Controller;
use think\Db;

class Base extends Controller
{
    protected function _initialize()
    {
        if (Db::table('think_system_info')->value('status') == 0){
             exit('<h1>网站维护中!</h1>');
        }
        $sys_data = SystemInfo::get('1');
        $carousel = SystemCarousel::order('priority', 'asc')->select();
        $links = SystemLinks::order('priority', 'asc')->select();
        $this->assign('carousel',$carousel);
        $this->assign('links',$links);
        $this->assign('sys_data',$sys_data);
    }
}