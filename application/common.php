<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件

//根据id获得用户名
function getName($id){
    return \think\Db::table('think_admin_user')->where('id',$id)->value('name');
}

function getClassifyName($id){
    return \think\Db::table('think_system_classify')->where('id',$id)->value('name');
}

function getStaticName($static){
    if ($static == 1){
        return '启用';
    }else{
        return '禁用';
    }
}

function text($test1,$test2){
    return $test1;
}

function getClassList($id,$num){
    return \think\Db::table('think_article')->where('sclassify_id','=',$id)->order('create_time', 'desc')->limit($num)->select();
}

function getNav(){
    return \think\Db::table('think_system_classify')->where('static',1)->where('is_nav',1)->order('create_time','asc')->field('name,id')->select();
}
function getSNav($id){
    return \think\Db::table('think_system_sclassify')->where('classify_id',$id)->where('static',1)->where('is_nav',1)->order('create_time','asc')->field('name,id')->select();
}
//过滤文章摘要
function getArtContent($content){
    //去除html标签并获取最多30个并且追加...
    return mb_substr(strip_tags($content),0,30).'...';
}