<?php
/**
 * Created by PhpStorm.
 * User: Dang Meng
 * Date: 2018/11/15
 * Time: 10:00
 * 管理员
 */
namespace app\manager\controller;
use app\marketm\controller\Common;
use think\Controller;
use think\Db;
use think\Request;

class Index extends Controller{
    public function __construct(Request $request = null)
    {
        parent::__construct($request);
        $userInfo=session('userInfo');
        if(empty($userInfo)){
            $this->redirect('marketm/login/login');
        }
    }

    public function index(){
        $userInfo=session('userInfo');
        $u_id=$userInfo['u_id'];
        $where=" 1 =1 ";
        $keywords=trim($this->request->param('keywords'));
        if(isset($keywords) && !empty($keywords)){
            $where.=" and ( h_b_id like '%".$keywords."%')";
            $this->assign('keywords',$keywords);
        }
        $houses=Db::table('dcxw_house')
            ->where($where)
//            ->where(['h_admin' => $u_id])
            ->order('h_addtime desc')
            ->limit(8)
            ->select();
        $count=Db::table('dcxw_house')
            ->where($where)
//            ->where(['h_admin' => $u_id])
            ->count();
        $connomModel=new Common();
        foreach($houses as $k =>$v){
            $houses[$k]['h_isable']=$connomModel->getHouseStatus($v['h_isable']);
            $houses[$k]['m_id']=$connomModel->getMasterStatus($v['h_b_id']);
            $houses[$k]['a_id']=$connomModel->getAttachStatus($v['h_b_id']);
            $houses[$k]['h_money']=$connomModel->getDecorateMoney($v['h_b_id']);
            $houses[$k]['h_addtime']=date('Y年m月d日',$v['h_addtime']);
            $payInfo=Db::table('dcxw_house_pay')->where(['hp_house_code' =>$v['h_b_id']])->column('hp_paid_ratio');
            if($payInfo){
                $houses[$k]['paid_ratio']=($payInfo[0]*100)."%";
                $houses[$k]['is_paid_ratio']=1;
            }else{
                $houses[$k]['paid_ratio']="0";
                $houses[$k]['is_paid_ratio']=2;
            }
        }
        $this->assign('count',$count);
        $this->assign('houses',$houses);
        return $this->fetch();
    }


    /*
     * 回款信息
     * */
    public function payment(){
        $h_id=trim($_GET['h_id']);
        //户主的姓名和电话
        $master=Db::table('dcxw_house_master')
            ->where(['hm_house_code' => $h_id])
            ->field('hm_name,hm_phone')
            ->find();
        $this->assign('master',$master);
        //客户经理姓名和电话
        $houseInfo=Db::table('dcxw_house')
            ->where(['h_b_id' => $h_id])
            ->field('h_admin')
            ->find();
        $manager=Db::table('dcxw_user')
            ->where(['u_id' => $houseInfo['h_admin']])
            ->field('u_name,u_phone,u_job')
            ->find();
        $this->assign('manager',$manager);
        //回款总数和已回款金额
        $payMoney=Db::table('dcxw_house_pay')
            ->join('dcxw_user','dcxw_user.u_id = dcxw_house_pay.hp_admin')
            ->where(['hp_house_code' => $h_id])
            ->field('dcxw_house_pay.*,dcxw_user.u_name')
            ->find();
        if($payMoney){
            $payMoney['hp_addtime']=date('Y年m月d日H时i分s秒');
            $payMoney['hp_paid_ratio']=($payMoney['hp_paid_ratio']*100)."%";
        }
        $this->assign('payMoney',$payMoney);
        //回款记录
        $payLog=Db::table('dcxw_house_pay_log')
            ->join('dcxw_user','dcxw_user.u_id = dcxw_house_pay_log.hpl_user')
            ->where(['hpl_house_code' => $h_id])
            ->order('hpl_addtime desc')
            ->limit(8)
            ->field('dcxw_house_pay_log.*,dcxw_user.u_name')
            ->select();
        foreach($payLog as $k => $v){
            $payLog[$k]['hpl_img']=explode(',',$v['hpl_img'])[0];
        }
        $count=Db::table('dcxw_house_pay_log')
            ->join('dcxw_user','dcxw_user.u_id = dcxw_house_pay_log.hpl_user')
            ->where(['hpl_house_code' => $h_id])
            ->count();
        $this->assign('count',$count);
        if($payLog){
            foreach($payLog as $k => $v){
                $payLog[$k]['hpl_addtime'] = date('m-d H:i',$v['hpl_addtime']);
            }
        }
        $this->assign('payLog',$payLog);

        $this->assign('h_b_id',$h_id);
        return $this->fetch();
    }


    public function person(){
        return $this->fetch();
    }

    public function logdetails(){
        $hpl_id=intval(trim($_GET['hpl_id']));
        $logs=Db::table('dcxw_house_pay_log')
            ->join('dcxw_user','dcxw_user.u_id = dcxw_house_pay_log.hpl_user')
            ->where(['hpl_id' => $hpl_id])
            ->field('dcxw_house_pay_log.*,dcxw_user.u_name,dcxw_user.u_job')
            ->find();
        if($logs){
            if($logs['hpl_img']){
                $logs['hpl_imgs']=explode(',',$logs['hpl_img']);
                $logs['hpl_img_first']=explode(',',$logs['hpl_img'])[0];
                if(count($logs['hpl_imgs']) >=1){
                    unset($logs['hpl_imgs'][0]);
                }
            }
            $logs['hpl_addtime']=date('Y年m月d日 H时i分',$logs['hpl_addtime']);
            $logs['hpl_money']=number_format($logs['hpl_money'],2);
        }
        $this->assign('logs',$logs);
        return $this->fetch();
    }




    public function decorate(){
        $h_id=trim($_GET['b_id']);
        $commomModel=new Common();
        $step=Db::table('dcxw_house_decorate_status')
            ->where(['hds_house_code' => $h_id])
            ->order('hds_change_time desc')
            ->select();
        foreach ($step as $k => $v){
            $step[$k]['hds_end_statuss']=$commomModel->getStatus($v['hds_end_status']);
            $step[$k]['hds_change_time']=date('Y-m-d H:i:s',$v['hds_change_time']);
            //日志记录
            $step[$k]['decorate_log']=Db::table('dcxw_house_decorate_log')
                ->where(['hdl_status' =>$v['hds_end_status'],'hdl_house_code' =>$h_id])
                ->order('hdl_addtime desc')
                ->select();
            $step[$k]['decorate_count']=Db::table('dcxw_house_decorate_log')
                ->where(['hdl_status' =>$v['hds_end_status'],'hdl_house_code' =>$h_id])
                ->count();
            foreach ($step[$k]['decorate_log'] as $key =>$val){
                $step[$k]['decorate_log'][$key]['hdl_admin'] =$commomModel->getUserName($val['hdl_admin']);
            }
        }
        $this->assign('step',$step);
        $this->assign('h_id',$h_id);
        return $this->fetch();
    }


    public function preview(){
        $h_id=trim($_GET['h_id']);
        //房屋基本信息
        $house=Db::table('dcxw_house')
            ->where(['h_b_id' => $h_id])
            ->find();
        $commodel=new Common();
        if($house){
            $house['h_house_type']=$commodel->getHouseTypeNameByTypeId($house['h_house_type']);
            $house['h_head']=$commodel->houseHead($house['h_head']);
            $house['h_config']=explode(',',$house['h_config']);
            $house['h_addtime']=date('Y-m-d H:i:s',$house['h_addtime']);
            if($house['h_img']){
                $house['h_imgs']=explode(',',$house['h_img']);
                $house['h_img_first']=explode(',',$house['h_img'])[0];
                if(count($house['h_imgs']) >=1){
                    unset($house['h_imgs'][0]);
                }
                $house['h_img']=explode(',',$house['h_img']);
                $house['config_img']=[];
                for($i=0;$i<count($house['h_config']);$i++){
                    $house['config_img'][$i]=Db::table('dcxw_type')->where(['type_id' => $house['h_config'][$i]])->field('type_name,type_img')->find();
                }
            }
        }
        $this->assign('hous',$house);
        //客户经理信息
        $u_id=$house['h_admin'];
        $manger=Db::table('dcxw_user')
            ->where(['u_id' =>$u_id])
            ->field('u_name,u_phone,u_job')
            ->find();
        $this->assign('manger',$manger);
        //户主信息
        $master=Db::table('dcxw_house_master')
            ->where(['hm_house_code' => $h_id])
            ->find();
        $this->assign('master',$master);
        //回款信息
        $payInfo=Db::table('dcxw_house_pay')
            ->where(['hp_house_code' => $h_id])
            ->find();
        if($payInfo){
            $payInfo['hp_money']=number_format($payInfo['hp_money'],2);
            $payInfo['hp_paid']=number_format($payInfo['hp_paid'],2);
            $payInfo['hp_will_pay']=number_format($payInfo['hp_will_pay'],2);
            $payInfo['hp_paid_ratio']=($payInfo['hp_paid_ratio']*100)."%";
        }
        $this->assign('payInfo',$payInfo);
        $payLogs=Db::table('dcxw_house_pay_log')
            ->where(['hpl_house_code' => $h_id])
            ->order('hpl_addtime desc')
            ->select();
        if($payLogs){
            foreach ($payLogs as $k => $v){
                $payLogs[$k]['hpl_addtime'] = date('Y-m-d H:i',$v['hpl_addtime']);
                $payLogs[$k]['hpl_money'] = number_format($v['hpl_money'],2);
            }
        }
        $this->assign('payLogs',$payLogs);
        //附属信息
        $attach=Db::table('dcxw_house_attachment')
            ->where(['ha_house_code' => $h_id])
            ->find();
        if($attach){
            if($attach['ha_contact_img']){
                $attach['ha_contact_imgs']=explode(',',$attach['ha_contact_img']);
                $attach['ha_contact_img_first']=explode(',',$attach['ha_contact_img'])[0];
                if(count($attach['ha_contact_imgs']) >=1){
                    unset($attach['ha_contact_imgs'][0]);
                }
            }
            $attach['ha_deadline']=date("Y-m-d",$attach['ha_deadline']);
            $attach['ha_decorate_permit']=date("Y-m-d",$attach['ha_decorate_permit']);
            $attach['ha_elect_type']=$commodel->getElectTypeName($attach['ha_elect_type']);
            $attach['ha_warm_type']=$commodel->getWarmTypeName($attach['ha_warm_type']);
            $attach['ha_wuye_fee_type']=$commodel->getWuYeFeeTypeName($attach['ha_wuye_fee_type']);
        }
        $this->assign('attach',$attach);
        return $this->fetch();
    }



    /*
     * 日志详情
     * */
    public function details(){
        $hdl_id=trim($_GET['hdl_id']);
        $daily=Db::table('dcxw_house_decorate_log')
            ->join('dcxw_user','dcxw_user.u_id = dcxw_house_decorate_log.hdl_admin')
            ->where(['hdl_id' => $hdl_id])
            ->field('dcxw_house_decorate_log.*,dcxw_user.u_name,dcxw_user.u_job')
            ->find();
        if($daily){
            if($daily['hdl_img']){
                $daily['hdl_imgs']=explode(',',$daily['hdl_img']);
                $daily['hdl_img_first']=explode(',',$daily['hdl_img'])[0];
                if(count($daily['hdl_imgs']) >=1){
                    unset($daily['hdl_imgs'][0]);
                }
            }
            $daily['hdl_addtime']=date('Y年m月d日 H时i分',$daily['hdl_addtime']);
        }
        $houseInfo=Db::table('dcxw_house')
            ->where(['h_b_id' => $daily['hdl_house_code']])
            ->field('h_building,h_address')
            ->find();
        $this->assign('house',$houseInfo);
        $connomModel=new Common();
        $daily['hdl_status']=$connomModel->getStatus($daily['hdl_status']);
        $this->assign('logs',$daily);
        return $this->fetch();
    }



    /*
    * 出租记录
    * */
    public function rent()
    {
        $h_id=trim($_GET['h_id']);
        $where=" 1 =1 ";
        $keywords=trim($this->request->param('keywords'));
        if(isset($keywords) && !empty($keywords)){
            $where.=" and ( hr_name like '%".$keywords."%' or hr_phone like '%".$keywords."%' )";
            $this->assign('keywords',$keywords);
        }
        $houseInfo=Db::table('dcxw_house')
            ->where(['h_b_id' => $h_id])
            ->field('h_building,h_address,h_area,h_isable,h_b_id')
            ->find();
        $this->assign('house',$houseInfo);
        $rentLog=Db::table('dcxw_house_rent_log')
            ->join('dcxw_house_rent','dcxw_house_rent_log.hrl_renter_id = dcxw_house_rent.hr_id')
            ->join('dcxw_house_rent_channel','dcxw_house_rent_channel.hrc_id = dcxw_house_rent_log.hrl_rent_channel')
            ->where(['hrl_house_code' => $h_id])
            ->where($where)
            ->limit(10)
            ->field('dcxw_house_rent_log.*,dcxw_house_rent.hr_name,dcxw_house_rent.hr_phone,dcxw_house_rent_channel.hrc_title')
            ->order('hrl_status,hrl_rent_time desc')
            ->select();
        $count=Db::table('dcxw_house_rent_log')
            ->join('dcxw_house_rent','dcxw_house_rent_log.hrl_renter_id = dcxw_house_rent.hr_id')
            ->where(['hrl_house_code' => $h_id])
            ->where($where)->count();
        if($rentLog)
        {
            foreach($rentLog as $k => $v)
            {
                $rentLog[$k]['hrl_rent_time']=date('Y/m/d',$v['hrl_rent_time']);
                $rentLog[$k]['hrl_dead_time']=date('Y/m/d',$v['hrl_dead_time']);
            }
        }
        $this->assign('count',$count);
        $this->assign('h_id',$h_id);
        $this->assign('rentLog',$rentLog);
        return $this->fetch();
    }

    /*
     * 出租记录加载更多
     * */
    public function logmore(){
        $h_id=trim($_POST['h_id']);
        $where='hrl_house_code = '.$h_id;

        if($_POST){
            $page=intval(trim($_POST['page']));
        }else{
            $page=1;
        }
        $limit=8;
        $rentLog=Db::table('dcxw_house_rent_log')
            ->join('dcxw_house_rent','dcxw_house_rent_log.hrl_renter_id = dcxw_house_rent.hr_id')
            ->join('dcxw_house_rent_channel','dcxw_house_rent_channel.hrc_id = dcxw_house_rent_log.hrl_rent_channel')
            ->where($where)
            ->limit(($page-1)*$limit,$limit)
            ->field('dcxw_house_rent_log.*,dcxw_house_rent.hr_name,dcxw_house_rent.hr_phone,dcxw_house_rent_channel.hrc_title')
            ->order('hrl_status,hrl_rent_time desc')
            ->select();
        if($rentLog)
        {
            foreach($rentLog as $k => $v)
            {
                $rentLog[$k]['hrl_rent_time']=date('Y/m/d',$v['hrl_rent_time']);
                $rentLog[$k]['hrl_dead_time']=date('Y/m/d',$v['hrl_dead_time']);
            }
        }
        if($rentLog){
            $this->success('更多完成','',$rentLog);
        }else{
            $this->error('更多失败','',$rentLog);
        }
    }



    /*
    * 租客信息
    * */
    public function renter()
    {
        $userInfo=session('userInfo');
        $hr_id=intval(trim($_GET['hr_id']));
        if($_POST){
            $renter=Db::table('dcxw_house_rent')
                ->where(['hr_id' => $hr_id])
                ->find();
            //若有信息是修改，没有信息是添加
            if($renter){
                $data=$_POST;
                $data['hr_addtime']=time();
                $data['hr_admin']=$userInfo['u_id'];
                $update=Db::table('dcxw_house_rent')
                    ->where(['hr_id' => $hr_id])
                    ->update($data);
                if($update){
                    $this->success('修改成功！','',$renter);
                }else{
                    $this->error('修改失败！','',$renter);
                }
            }else{
                $data=$_POST;
                $data['hr_addtime']=time();
                $data['hr_admin']=$userInfo['u_id'];
                $add=Db::table('dcxw_house_rent')->insert($data);
                if($add){
                    $this->success('添加成功！');
                }else{
                    $this->error('添加失败！');
                }
            }
        }else{
            $renter=Db::table('dcxw_house_rent')
                ->where(['hr_id' => $hr_id])
                ->find();
            if($renter){
                $renter['hr_addtime']=date('Y-m-d H:i:s',$renter['hr_addtime']);
                $masterArr=Db::table('dcxw_user')
                    ->where(['u_id' => $renter['hr_admin']])
                    ->column('u_name');
                $renter['hr_admin']=$masterArr[0];
            }
        }
        $this->assign('renter',$renter);
        return $this->fetch();
    }


    /*
     * 出租信息详情
     * */
    public function rentdetail(){
        $hrl_id=intval(trim($_GET['hrl_id']));
        //根据出租记录id找出房源编号
        $rentInfo=Db::table('dcxw_house_rent_log')
            ->join('dcxw_house_rent_channel','dcxw_house_rent_channel.hrc_id = dcxw_house_rent_log.hrl_rent_channel')
            ->where(['hrl_id' => $hrl_id])
            ->field('dcxw_house_rent_channel.hrc_title,dcxw_house_rent_log.*')
            ->find();
        if($rentInfo){
            if($rentInfo['hrl_contact_img']){
                $rentInfo['hrl_contact_imgs']=explode(',',$rentInfo['hrl_contact_img']);
                $rentInfo['hrl_contact_img_first']=explode(',',$rentInfo['hrl_contact_img'])[0];
                if(count($rentInfo['hrl_contact_imgs']) >=1){
                    unset($rentInfo['hrl_contact_imgs'][0]);
                }
            }
            $rentInfo['hrl_rent_time']=date('Y/m/d',$rentInfo['hrl_rent_time']);
            $rentInfo['hrl_dead_time']=date('Y/m/d',$rentInfo['hrl_dead_time']);
        }
        $this->assign('rent',$rentInfo);
        $h_code=$rentInfo['hrl_house_code'];
        $renter_id=$rentInfo['hrl_renter_id'];
        $housedata=Db::table('dcxw_house')
            ->where(['h_b_id' => $h_code])
            ->field('h_area,h_b_id,h_building,h_address')
            ->find();
        $renterInfo=Db::table('dcxw_house_rent')
            ->where(['hr_id' =>$renter_id])
            ->find();
        $this->assign('renter',$renterInfo);
        $this->assign('house',$housedata);
        return $this->fetch();
    }


    /*
  * 收租记录
  * */
    public function paylog()
    {
        //出租信息编号
        $h_id=trim($_GET['h_id']);
        $commonModel=new Common();
        //房源编号；
        $rentInfo=Db::table('dcxw_house_rent_log')
            ->where(['hrl_id' => $h_id])
            ->column('hrl_house_code');
        $payLog=Db::table('dcxw_house_rent_pay_log')
            ->join('dcxw_house_rent_log','dcxw_house_rent_log.hrl_id = dcxw_house_rent_pay_log.hrpl_rent_id')
            ->where(['hrpl_rent_id' => $h_id])
            ->order('hrpl_addtime desc')
            ->limit(10)
            ->field('dcxw_house_rent_pay_log.*,dcxw_house_rent_log.hrl_renter_id')
            ->select();
        $count=Db::table('dcxw_house_rent_pay_log')
            ->join('dcxw_house_rent_log','dcxw_house_rent_log.hrl_id = dcxw_house_rent_pay_log.hrpl_rent_id')
            ->where(['hrpl_rent_id' => $h_id])
            ->count();
        if($payLog)
        {
            foreach ($payLog as $k => $v)
            {
                $payLog[$k]['hrpl_addtime'] = date('Y-m-d H:i:s',$v['hrpl_addtime']);
                $payLog[$k]['hrpl_addtimes'] = date('Y年m月d日H时i分',$v['hrpl_addtime']);
                $payLog[$k]['hrpl_img'] = explode(',',$v['hrpl_img'])[0];
                $payLog[$k]['hrpl_rent_name'] = $commonModel->getRenterNameViaRentId($v['hrl_renter_id']);
                $payLog[$k]['hrpl_rent_phone'] = $commonModel->getRenterPhoneViaRentId($v['hrl_renter_id']);

            }
        }
        $this->assign('count',$count);
        $this->assign('h_id',$h_id);
        $this->assign('h_b_id',$rentInfo[0]);
        $this->assign('payLog',$payLog);
        return $this->fetch();
    }

    /*
     * 支付记录加载更多
     * */
    public function paymore(){
        $h_id=trim($_POST['h_id']);
        $where='hrpl_rent_id = '.$h_id;
        if($_POST){
            $page=intval(trim($_POST['page']));
        }else{
            $page=1;
        }
        $limit=8;
        $payLog=Db::table('dcxw_house_rent_pay_log')
            ->join('dcxw_house_rent_log','dcxw_house_rent_log.hrl_id = dcxw_house_rent_pay_log.hrpl_rent_id')
            ->where($where)
            ->limit(($page-1)*$limit,$limit)
            ->order('hrl_addtime desc')
            ->select();
        $commonModel=new Common();
        if($payLog)
        {
            foreach ($payLog as $k => $v)
            {
                $payLog[$k]['hrpl_addtime'] = date('Y-m-d H:i:s',$v['hrpl_addtime']);
                $payLog[$k]['hrpl_addtimes'] = date('Y年m月d日H时i分',$v['hrpl_addtime']);
                $payLog[$k]['hrpl_img'] = explode(',',$v['hrpl_img'])[0];
                $payLog[$k]['hrpl_rent_name'] = $commonModel->getRenterNameViaRentId($v['hrl_renter_id']);
                $payLog[$k]['hrpl_rent_phone'] = $commonModel->getRenterPhoneViaRentId($v['hrl_renter_id']);

            }
        }
        if($payLog){
            $this->success('更多完成','',$payLog);
        }else{
            $this->error('更多失败','',$payLog);
        }
    }


    /*
     * 租金详情
     * */
    public function paydetail()
    {
        $hdl_id=intval(trim($_GET['hdl_id']));
        $details=Db::table('dcxw_house_rent_pay_log')
            ->where(['hrpl_id' => $hdl_id])
            ->join('dcxw_user','dcxw_user.u_id = dcxw_house_rent_pay_log.hrpl_user')
            ->field('dcxw_house_rent_pay_log.*,dcxw_user.u_name,dcxw_user.u_job')
            ->find();
        if($details){
            $details['hrpl_addtime']=date('Y年m月d日 H时i分',$details['hrpl_addtime']);
            if($details['hrpl_img']){
                $details['hrpl_imgs']=explode(',',$details['hrpl_img']);
                $details['hrpl_img_first']=explode(',',$details['hrpl_img'])[0];
                if(count($details['hrpl_imgs']) >=1){
                    unset($details['hrpl_imgs'][0]);
                }
            }
        }
        $this->assign('details',$details);
        $rent_id=$details['hrpl_rent_id'];
        $payLog=Db::table('dcxw_house_rent_pay_log')
            ->join('dcxw_house_rent_log','dcxw_house_rent_log.hrl_id = dcxw_house_rent_pay_log.hrpl_rent_id')
            ->where(['hrpl_rent_id' => $rent_id])
            ->order('hrpl_addtime desc')
            ->field('dcxw_house_rent_pay_log.*,dcxw_house_rent_log.hrl_renter_id,hrl_house_code')
            ->find();
        $commonModel=new Common();
        $payLog['rent_name']=$commonModel->getRenterNameViaRentId($payLog['hrl_renter_id']);
        $payLog['rent_phone']=$commonModel->getRenterPhoneViaRentId($payLog['hrl_renter_id']);
        $this->assign('payLog',$payLog);
        return $this->fetch();
    }




    /*
     * 交接信息
     * */
    public function  allot()
    {
        $h_id=trim($_GET['h_id']);
        $commModel= new Common();
        $marToDec=Db::table('dcxw_house_allocate')
            ->where(['hat_house_code' => $h_id ,'hat_is_assign' => 1])
            ->order('hat_add_time')
            ->select();
        if($marToDec){
            foreach ($marToDec as $k =>$v)
            {
                $marToDec[$k]['hat_add_time']=date('Y年m月d日 H时i分',$v['hat_add_time']);
                $marToDec[$k]['hat_assign_time']=date('Y年m月d日 H时i分',$v['hat_assign_time']);
                $marToDec[$k]['hat_assign_too']=$commModel->getUserName($v['hat_assign_to']);
                $marToDec[$k]['hat_assign_to_job']=$commModel->getUserJob($v['hat_assign_to']);
                $marToDec[$k]['hat_assigner_name']=$commModel->getUserName($v['hat_assigner']);
                $marToDec[$k]['hat_assigner_job']=$commModel->getUserJob($v['hat_assigner']);
                $marToDec[$k]['hat_admin_name']=$commModel->getUserName($v['hat_admin']);
                $marToDec[$k]['hat_admin_job']=$commModel->getUserJob($v['hat_admin']);
                if($v['hat_type'] == 1){
                    $marToDec[$k]['hat_assign_title'] = "事业部->工程部 交接";
                }else{
                    $marToDec[$k]['hat_assign_title'] = "工程部->运营部 交接";
                }
            }
        }
        $this->assign('marToDec',$marToDec);
        return $this->fetch();
    }


    /*
     * 维护记录
     * */
    public function maintain()
    {
        $h_id=trim($_GET['h_id']);
        $maintLog=Db::table('dcxw_house_maintenance')
            ->where(['hmt_house_code' => $h_id])
            ->order('hmt_add_time desc')
            ->limit(10)
            ->select();
        if($maintLog){
            foreach ($maintLog as $k => $v){
                $maintLog[$k]['hmt_img']=explode(',',$v['hmt_img'])[0];
            }
        }
        $count=Db::table('dcxw_house_maintenance')
            ->where(['hmt_house_code' => $h_id])
            ->count();
        $this->assign('h_id',$h_id);
        $this->assign('count',$count);
        $this->assign('maintLog',$maintLog);
        return $this->fetch();
    }


    /*
    * 出租记录加载更多
    * */
    public function mainmore(){
        $h_id=trim($_POST['h_id']);
        $where='hmt_house_code = '.$h_id;

        if($_POST){
            $page=intval(trim($_POST['page']));
        }else{
            $page=1;
        }
        $limit=8;
        $rentLog=Db::table('dcxw_house_maintenance')
            ->where($where)
            ->limit(($page-1)*$limit,$limit)
            ->order('hmt_add_time desc')
            ->select();
        if($rentLog)
        {
            foreach($rentLog as $k => $v)
            {
                $rentLog[$k]['hmt_add_time']=date('Y/m/d',$v['hmt_add_time']);
            }
        }
        if($rentLog){
            $this->success('更多完成','',$rentLog);
        }else{
            $this->error('更多失败','',$rentLog);
        }
    }

    public function maindetails(){
        $hmt_id=intval(trim($this->request->param('hmt_id')));
        $maintInfo=Db::table('dcxw_house_maintenance')
            ->where(['hmt_id' => $hmt_id])
            ->find();
        if($maintInfo){
            $commomModel=new \app\marketm\controller\Common();
            if($maintInfo['hmt_img']){
                $maintInfo['hmt_imgs']=explode(',',$maintInfo['hmt_img']);
                $maintInfo['hmt_img_first']=explode(',',$maintInfo['hmt_img'])[0];
                if(count($maintInfo['hmt_imgs']) >=1){
                    unset($maintInfo['hmt_imgs'][0]);
                }
            }
            $maintInfo['hmt_add_time']=date('Y-m-d H:i:s',$maintInfo['hmt_add_time']);
            $maintInfo['u_job']=$commomModel->getUserJob($maintInfo['hmt_admin']);
            $maintInfo['hmt_admin']=$commomModel->getUserName($maintInfo['hmt_admin']);
        }
        $this->assign('logs',$maintInfo);
        return $this->fetch();
    }

}