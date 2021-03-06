<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:78:"G:\xampp\htdocs\bbb\public/../application/operation\view\index\rentdetail.html";i:1543806006;}*/ ?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>出租详情</title>
    <meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1,user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <link rel="stylesheet" href="__WAP__/css/mui.min.css">
    <style type="text/css">
        .mui-preview-image.mui-fullscreen {
            position: fixed;
            z-index: 20;
            background-color: #000;
        }
        .mui-preview-header,
        .mui-preview-footer {
            position: absolute;
            width: 100%;
            left: 0;
            z-index: 10;
        }
        .mui-preview-header {
            height: 44px;
            top: 0;
        }
        .mui-preview-footer {
            height: 50px;
            bottom: 0px;
        }
        .mui-preview-header .mui-preview-indicator {
            display: block;
            line-height: 25px;
            color: #fff;
            text-align: center;
            margin: 15px auto 4;
            width: 70px;
            background-color: rgba(0, 0, 0, 0.4);
            border-radius: 12px;
            font-size: 16px;
        }
        .mui-preview-image {
            display: none;
            -webkit-animation-duration: 0.5s;
            animation-duration: 0.5s;
            -webkit-animation-fill-mode: both;
            animation-fill-mode: both;
        }
        .mui-preview-image.mui-preview-in {
            -webkit-animation-name: fadeIn;
            animation-name: fadeIn;
        }
        .mui-preview-image.mui-preview-out {
            background: none;
            -webkit-animation-name: fadeOut;
            animation-name: fadeOut;
        }
        .mui-preview-image.mui-preview-out .mui-preview-header,
        .mui-preview-image.mui-preview-out .mui-preview-footer {
            display: none;
        }
        .mui-zoom-scroller {
            position: absolute;
            display: -webkit-box;
            display: -webkit-flex;
            display: flex;
            -webkit-box-align: center;
            -webkit-align-items: center;
            align-items: center;
            -webkit-box-pack: center;
            -webkit-justify-content: center;
            justify-content: center;
            left: 0;
            right: 0;
            bottom: 0;
            top: 0;
            width: 100%;
            height: 100%;
            margin: 0;
            -webkit-backface-visibility: hidden;
        }
        .mui-zoom {
            -webkit-transform-style: preserve-3d;
            transform-style: preserve-3d;
        }
        .mui-slider .mui-slider-group .mui-slider-item img {
            width: auto;
            height: auto;
            max-width: 100%;
            max-height: 100%;
        }
        .mui-android-4-1 .mui-slider .mui-slider-group .mui-slider-item img {
            width: 100%;
        }
        .mui-android-4-1 .mui-slider.mui-preview-image .mui-slider-group .mui-slider-item {
            display: inline-table;
        }
        .mui-android-4-1 .mui-slider.mui-preview-image .mui-zoom-scroller img {
            display: table-cell;
            vertical-align: middle;
        }
        .mui-preview-loading {
            position: absolute;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            display: none;
        }
        .mui-preview-loading.mui-active {
            display: block;
        }
        .mui-preview-loading .mui-spinner-white {
            position: absolute;
            top: 50%;
            left: 50%;
            margin-left: -25px;
            margin-top: -25px;
            height: 50px;
            width: 50px;
        }
        .mui-preview-image img.mui-transitioning {
            -webkit-transition: -webkit-transform 0.5s ease, opacity 0.5s ease;
            transition: transform 0.5s ease, opacity 0.5s ease;
        }
        @-webkit-keyframes fadeIn {
            0% {
                opacity: 0;
            }
            100% {
                opacity: 1;
            }
        }
        @keyframes fadeIn {
            0% {
                opacity: 0;
            }
            100% {
                opacity: 1;
            }
        }
        @-webkit-keyframes fadeOut {
            0% {
                opacity: 1;
            }
            100% {
                opacity: 0;
            }
        }
        @keyframes fadeOut {
            0% {
                opacity: 1;
            }
            100% {
                opacity: 0;
            }
        }
        p img {
            max-width: 100%;
            height: auto;
        }
    </style>
</head>
<body>
<header class="mui-bar mui-bar-nav">
    <a class="mui-icon mui-icon-left-nav mui-pull-left" href="<?=url('index/rentlog')?>?h_id=<?php echo $house['h_b_id']; ?>"></a>
    <h1 class="mui-title">出租详情</h1>
</header>
<div class="mui-content" style="padding-top: 40px;">
    <div class="mui-card">
        <div class="mui-card-content">
            <div class="mui-card-content-inner">
                <p><b>房源编号：【<?php echo $house['h_b_id']; ?>】</b>
                </p>
                <p><b>小区名称</b>：<?php echo $house['h_building']; ?>
                    <br/>
                    房屋面积：<?php echo $house['h_area']; ?>（㎡）
                    <br/>
                    房源地址：<?php echo $house['h_address']; ?>
                    <br/>
                </p>
            </div>
        </div>
    </div>
    <!--租客信息-->
    <div class="mui-card">
        <div class="mui-card-content">
            <div class="mui-card-content-inner">
                <p><b>租客信息</b></p>
                <p style="color: #333;">
                    姓名：<?php echo $renter['hr_name']; ?>
                    <br/>
                    联系方式：<?php echo $renter['hr_phone']; if($renter['hr_idcard'] != null): ?>
                    <br/>
                    身份证号：<?php echo $renter['hr_idcard']; endif; ?>
                </p>
            </div>
        </div>
    </div>
    <!--出租信息-->
    <div class="mui-card">
        <div class="mui-card-content">
            <div class="mui-card-content-inner">
                <p><b>出租信息</b></p>
                <p style="color: #333;">
                    合同编号：<?php echo $rent['hrl_contact_code']; ?>
                    <br/>
                    合同图片:
                    <p>
                        <?php if($rent['hrl_contact_img_first'] != null): ?>
                        <img src="__WEB__/img/one-btn.png" style="width: 20%" data-preview-src="<?php echo $rent['hrl_contact_img_first']; ?>" data-preview-group="1">
                        <?php endif; if($rent['hrl_contact_imgs'] != null): if(is_array($rent['hrl_contact_imgs']) || $rent['hrl_contact_imgs'] instanceof \think\Collection || $rent['hrl_contact_imgs'] instanceof \think\Paginator): $i = 0; $__LIST__ = $rent['hrl_contact_imgs'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$items): $mod = ($i % 2 );++$i;?>
                        <img style="display: none" src="<?php echo $items; ?>" data-preview-src="" data-preview-group="1">
                        <?php endforeach; endif; else: echo "" ;endif; endif; ?>
                    </p>
                    租房日期：<?php echo $rent['hrl_rent_time']; ?>-<?php echo $rent['hrl_dead_time']; ?>
                    <br/>
                    租房押金：<?php echo $rent['hrl_foregift']; ?>（元）
                    <br/>
                    租房单价：<?php echo $rent['hrl_rent_price']; ?>（元）/ <?php if($rent['hrl_rent_type'] == 1): ?>日<?php else: ?>月<?php endif; ?>
                    <br/>
                    付租方式：<?php if($rent['hrl_pay_type'] == 1): ?>日租金<?php else: ?>月租金<?php endif; ?>
                    <br/>
                    出租渠道：<?php echo $rent['hrc_title']; ?>
                    <br/>
                    电表底数：<?php echo $rent['hrl_elect_start']; if($rent['hrl_status'] == 2): ?>
                <br/>
                电表结数：<?php echo $rent['hrl_elect_end']; endif; ?>
                    <br/>
                    水表底数：<?php echo $rent['hrl_water_start']; if($rent['hrl_status'] == 2): ?>
                <br/>水表结数：<?php echo $rent['hrl_water_end']; endif; ?>
                <br/> 燃气底数：<?php echo $rent['hrl_air_start']; ?>
                <br/>
                <?php if($rent['hrl_status'] == 2): ?>
                燃气结数：<?php echo $rent['hrl_air_end']; endif; ?>
                </p>
            </div>
        </div>
    </div>
    <?php if($rent['hrl_status'] == 1): ?>
        <form class="mui-input-group layui-form" id="attachForm" style="background-color: #efeff4">
        <div class="mui-card">
            <div class="mui-input-row">
                <label>电表结数：</label>
                <input type="text" onkeyup="clearNoNum(this)" <?php if(isset($rent['hrl_elect_end'])): ?> value="<?php echo $rent['hrl_elect_end']; ?>" readonly  <?php endif; ?> class="layui-input" lay-verify="required" id="hrl_elect_end" name="hrl_elect_end">
                <input type="text" name="hrl_id" id="hrl_id" value="<?php echo $rent['hrl_id']; ?>" >
            </div>
            <div class="mui-input-row">
                <label>水表结数：</label>
                <input type="text" onkeyup="clearNoNum(this)" <?php if(isset($rent['hrl_water_end'])): ?> value="<?php echo $rent['hrl_water_end']; ?>" readonly <?php endif; ?> id="hrl_water_end" name="hrl_water_end" >
            </div>
            <div class="mui-input-row">
                <label>燃气结数：</label>
                <input type="text" onkeyup="clearNoNum(this)" <?php if(isset($rent['hrl_air_end'])): ?> value="<?php echo $rent['hrl_air_end']; ?>" readonly <?php endif; ?> id="hrl_air_end" name="hrl_air_end" >
            </div>
        </div>
        </form>
    <span id="finishRent" class="mui-btn mui-btn-primary mui-btn-block">完成出租</span>
    <?php endif; ?>
    </div>
</div>
<script src="__WEB__/js/jquery-1.10.2.min.js"></script>
<script src="__WAP__/js/mui.min.js"></script>
<script src="__WAP__/js/mui.zoom.js"></script>
<script src="__WAP__/js/mui.previewimage.js"></script>
<script>
    mui.previewImage();
</script>
<script>
    mui('body').on('tap','a',function(){
        if(this.href){
            window.top.location.href=this.href;
        }
    });
    function clearNoNum(obj){
        if(obj.value !=''&& obj.value.substr(0,1) == '.'){
            obj.value="";
        }
        obj.value = obj.value.replace(/^0*(0\.|[1-9])/, '$1');
        obj.value = obj.value.replace(/[^\d.]/g,"");
        obj.value = obj.value.replace(/\.{2,}/g,".");
        obj.value = obj.value.replace(".","$#$").replace(/\./g,"").replace("$#$",".");
        obj.value = obj.value.replace(/^(\-)*(\d+)\.(\d\d).*$/,'$1$2.$3');
        if(obj.value.indexOf(".")< 0 && obj.value !=""){
            if(obj.value.substr(0,1) == '0' && obj.value.length == 2){
                obj.value= obj.value.substr(1,obj.value.length);
            }
        }
    }
</script>
<script>
    mui.init({
        swipeBack:true //启用右滑关闭功能
    });
    $('#finishRent').click(function () {
        var elect_end=$('#hrl_elect_end').val();
        var water_end=$('#hrl_water_end').val();
        var air_end=$('#hrl_air_end').val();
        if(elect_end.length<=0 || water_end.length<=0 || air_end.length<=0){
            mui.alert('请输入要填写的信息后提交！', function() {
            });
        }else{
            var btnArray = ['否', '是'];
            mui.confirm('请确认信息准确无误？', 'Hello MUI', btnArray, function(e) {
                if (e.index == 1) {
                    $.ajax({
                        type:"post",
                        url:"<?=url('index/endrent')?>",
                        data:$('#attachForm').serialize(),
                        success:function (result) {
                            console.log(result);
                            if(result.code == '1'){
                                mui.alert(result.msg, function() {
                                    window.location.href="<?=url('index/rentdetail')?>?hrl_id=<?php echo $rent['hrl_id']; ?>";
                                });
                            }else{
                                mui.alert(result.msg, function() {
                                });
                            }
                        },
                        'error':function (error) {
                            console.log(error);
                        }
                    })
                }
            });
        }
    })
</script>
</body>

</html>