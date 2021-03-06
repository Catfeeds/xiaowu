<?php
/**
 * Created by PhpStorm.
 * User: Dang Meng
 * Date: 2018/4/20
 * Time: 16:40
 */
namespace app\admin\controller;
use think\Controller;
use think\Db;
use think\Request;
class District extends Controller{
    public function __construct(Request $request = null)
    {
        parent::__construct($request);
        $adminName=session('adminName');
        if(empty($adminName)){
            $this->error('请先登录！','login/login');
        }
        if(isset($_SESSION['expiretime'])) {
            if($_SESSION['expiretime'] < time()) {
                unset($_SESSION['expiretime']);
                $this->error('您的登录身份已过期，请重新登录！','login/login');
                exit(0);
            } else {
                $_SESSION['expiretime'] = time() + 1800; // 刷新时间戳
            }
        }
    }
    //区域管理
    public function district(){
        $provInfo=Db::table('dcxw_province')->order('p_id desc')->select();
        $this->assign('provInfo',$provInfo);
        return $this->fetch();
    }

    public function city(){
        $cityInfo=Db::table('dcxw_city')
            ->join('dcxw_province','dcxw_city.p_id = dcxw_province.p_id')
            ->order('c_id desc')
            ->select();
        $this->assign('city',$cityInfo);
        return $this->fetch();
    }

    /*
     * 县区管理
     * */
    public function area(){
        $areaInfo=Db::table('dcxw_area')
            ->join('dcxw_province','dcxw_area.area_p_id = dcxw_province.p_id')
            ->join('dcxw_city','dcxw_city.c_id = dcxw_area.area_c_id')
            ->order('c_id desc')
            ->field('dcxw_province.p_name,dcxw_city.c_name,dcxw_area.*')
            ->select();
        $this->assign('areaInfo',$areaInfo);
        return $this->fetch();
    }
}