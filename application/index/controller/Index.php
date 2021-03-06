<?php
/**
 * Created by PhpStorm.
 * User: Dang Meng
 * Date: 2018/9/7
 * Time: 14:12
 */
namespace app\index\controller;
use think\Controller;
use think\Db;

class Index extends Controller{


    /*
     * 大城小屋首页
     * */
    public function index(){
        /*获取用户设备和网络类型*/
        $agent = $_SERVER['HTTP_USER_AGENT'];
        if(strpos($agent,"NetFront") || strpos($agent,"iPhone") || strpos($agent,"MIDP-2.0") || strpos($agent,"Opera Mini") || strpos($agent,"UCWEB") || strpos($agent,"Android") || strpos($agent,"Windows CE") || strpos($agent,"SymbianOS")){
            //手机
            echo "<script>window.location.href='/mobile/index/'</script>";
        }
        //热线电话
        $hotLine=Db::table('dcxw_setinfo')->where(['s_key' => 'hotline'])->column('s_value');
        $this->assign('hotLine',$hotLine[0]);
        //网站导航
        $navInfo=Db::table('dcxw_nav')
            ->where(['nav_isable' => 1])
            ->order('nav_order desc')
            ->field('nav_title,nav_url')
            ->select();
        $this->assign('navinfo',$navInfo);
        //首页banner
        $banner=Db::table('dcxw_banner')->where(['ba_isable' => 1,'ba_via' => 1])->order('ba_order desc')->select();
        $this->assign('banner',$banner);

        //房源
        $house=Db::table('dcxw_house')
            ->join('dcxw_province','dcxw_province.p_id = dcxw_house.h_p_id')
            ->join('dcxw_city','dcxw_city.c_id = dcxw_house.h_c_id')
            ->join('dcxw_area','dcxw_area.area_id = dcxw_house.h_a_id')
            ->where(['h_isable' => 2])
            ->whereOr(['h_isable' => 4])
            ->limit(6)
            ->order('h_istop,h_view desc')
            ->field('dcxw_province.p_name,dcxw_city.c_name,dcxw_area.area_name,dcxw_house.*')
            ->select();
        $this->assign('house',$house);
        return $this->fetch();
    }
}