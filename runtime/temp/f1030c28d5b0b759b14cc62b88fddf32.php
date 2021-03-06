<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:67:"G:\xampp\htdocs\bbb\public/../application/admin\view\admin\add.html";i:1537521738;s:70:"G:\xampp\htdocs\bbb\public/../application/admin\view\index\header.html";i:1536287308;s:70:"G:\xampp\htdocs\bbb\public/../application/admin\view\index\footer.html";i:1525742360;}*/ ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="format-detection" content="telephone=no">
    <title>大城小屋后台管理系统</title>
    <link rel="stylesheet" href="__LAY__/css/layui.css">
    <script src="__PUBLIC__/static/jquery-1.10.2.min.js"></script>
    <script src="__LAY__/layui.js"></script>
	<style>
		.layui-body{
			left:0!important
		}
	</style>
</head>
<body class="layui-layout-body">

<div class="layui-body">
    <div style="margin: 20px;">
    <span class="layui-breadcrumb" lay-separator=">">
        <a>员工管理</a>
        <a href="<?=url('admin/admin')?>">员工列表</a>
        <a><cite>添加管理员</cite></a>
    </span>
        <div style="float:right;">
            <a href="<?=url('admin/admin')?>" class="layui-btn layui-btn-primary layui-btn-sm">
                <i class="layui-icon layui-icon-return"></i>
                返回列表</a>
        </div>
    </div>
    <hr/>
    <div style="padding: 15px;">
        <form class="layui-form layui-form-pane1" action="<?=url('admin/add')?>" method="post">
            <div class="layui-form-item">
                <label class="layui-form-label"><span style="color: red;">*</span>管理员姓名</label>
                <div class="layui-input-block">
                    <input type="text" name="ad_realname" lay-verify="required|title" placeholder="请输入管理员姓名" autocomplete="off" class="layui-input">
                </div>
            </div>
            <div class="layui-form-item" pane>
                <label class="layui-form-label"><span style="color: red;">*</span>性别</label>
                <div class="layui-input-block">
                    <input type="radio" name="ad_sex" value="1" title="男" checked>
                    <input type="radio" name="ad_sex" value="2" title="女">
                </div>
            </div>
            <?php if($ad_role == 1): ?>
            <div class="layui-form-item">
                <label class="layui-form-label"><span style="color: red;">*</span>基础信息</label>
                <div class="layui-input-inline">
                    <select name="ad_p_id" lay-verify="required" lay-filter="bu_p_id">
                        <option value="">请选择省份</option>
                        <?php if(is_array($prov) || $prov instanceof \think\Collection || $prov instanceof \think\Paginator): $i = 0; $__LIST__ = $prov;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                        <option value="<?php echo $vo['p_id']; ?>"><?php echo $vo['p_name']; ?></option>
                        <?php endforeach; endif; else: echo "" ;endif; ?>
                    </select>
                </div>
                <div class="layui-input-inline">
                    <select name="ad_c_id" lay-verify="required" id="bu_c_id" lay-filter="bu_c_id">
                        <option value="">请选择城市</option>
                    </select>
                </div>
                <div class="layui-input-inline">
                    <select name="ad_role" id="roleaa" lay-verify="required">
                        <option value="">请选择角色</option>
                        <?php if(is_array($role) || $role instanceof \think\Collection || $role instanceof \think\Paginator): $i = 0; $__LIST__ = $role;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                        <option value="<?php echo $vo['r_id']; ?>"><?php echo $vo['r_name']; ?></option>
                        <?php endforeach; endif; else: echo "" ;endif; ?>
                    </select>
                </div>
            </div>
            <?php else: ?>
            <div class="layui-form-item">
                <label class="layui-form-label"><span style="color: red;">*</span>所属站点</label>
                <div class="layui-input-inline">
                    <input type="text" class="layui-input" value="<?php echo $admin['p_name']; ?>-<?php echo $admin['c_name']; ?>-<?php echo $admin['b_name']; ?>" readonly/>
                </div>
            </div>
            <?php endif; ?>
            <div class="layui-form-item">
                <label class="layui-form-label"><span style="color: red;">*</span>手机号码</label>
                <div class="layui-input-block">
                    <input type="text" name="ad_phone" id="ad_phone" onblur="checkPhone()" lay-verify="required|phone" placeholder="请输入手机号码" autocomplete="off" class="layui-input">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label"><span style="color: red;">*</span>电子邮箱</label>
                <div class="layui-input-block">
                    <input type="text" name="ad_email" id="ad_email" onblur="checkEmail()" lay-verify="required|email" placeholder="请输入电子邮箱" autocomplete="off" class="layui-input">
                </div>
            </div>
            <div class="layui-form-item" pane>
                <label class="layui-form-label">是否启用</label>
                <div class="layui-input-block">
                    <input type="radio" name="ad_isable" value="1" title="是" checked>
                    <input type="radio" name="ad_isable" value="2" title="否">
                </div>
            </div>
            <div class="layui-form-item">
                <div class="layui-input-block">
                    <button class="layui-btn" lay-submit lay-filter="saveInfo">添加</button>
                    <a class="layui-btn layui-btn-primary" href="<?=url('admin/admin')?>">返回</a>
                </div>
            </div>
        </form>
    </div>
</div>
<script>
    layui.use(['form','jquery'], function(){
        var form = layui.form
            ,$ = layui.jquery;
        //自定义验证规则
        form.verify({
            title: function(value){
                if(value.length < 2){
                    return '至少得2个字符啊';
                }
            }
        });
        form.on('select(bu_p_id)', function(data){
            var p_id=data.value;
            $.ajax({
                type: 'POST',
                url: "<?=url('user/getCityName')?>?p_id="+p_id,
                data: {p_id:p_id},
                dataType:  'json',
                success: function(data){
                    var code=data.data;
                    $("#bu_c_id").html("<option value=''>请选择城市</option>");
                    $("#branch").html("<option value=''>请选择站点</option>");
                    $.each(code, function(i, val) {
                        var option1 = $("<option>").val(val.c_id).text(val.c_name);
                        $("#bu_c_id").append(option1);
                        form.render('select');
                    });
                    $("#bu_c_id").get(0).selectedIndex=0;
                }
            });
        });

        //调用该城市下面的分站
        form.on('select(bu_c_id)', function(data){
            var c_id=data.value;
            $.ajax({
                type: 'POST',
                url: "<?=url('admin/getBranchName')?>?c_id="+c_id,
                data: {c_id:c_id},
                dataType:  'json',
                success: function(data){
                    var code=data.data;
                    $("#branch").html("<option value=''>请选择站点</option>");
                    $.each(code, function(i, val) {
                        var option1 = $("<option>").val(val.b_id).text(val.b_name);
                        $("#branch").append(option1);
                        form.render('select');
                    });
                    $("#branch").get(0).selectedIndex=0;
                }
            });
        });
    });

    function checkPhone(){
        var ad_phone=$('#ad_phone').val();
        $.ajax({
            type:"post",
            url:"<?=url('admin/checkPhone')?>",
            dataType: 'json',
            data:{'ad_phone':ad_phone,'ad_id':'0'},
            success:function (data) {
                console.log(data);
                if(data.code >1){
                    layer.msg(data.msg, {icon: 2, time: 1000});
                }else if(data.code <= 1){
                    layer.msg(data.msg, {icon: 1, time: 1000});
                }
            },
            error:function (error) {
                console.log(error);
            }
        })
    }

    function checkEmail(){
        var ad_email=$('#ad_email').val();
        $.ajax({
            type:"post",
            url:"<?=url('admin/checkEmail')?>",
            dataType: 'json',
            data:{'ad_email':ad_email,'ad_id':'0'},
            success:function (data) {
                console.log(data);
                if(data.code >1){
                    layer.msg(data.msg, {icon: 2, time: 1000});
                }else if(data.code <= 1){
                    layer.msg(data.msg, {icon: 1, time: 1000});
                }
            },
            error:function (error) {
                console.log(error);
            }
        })
    }

</script>
</div>
<script>
    //JavaScript代码区域
    layui.use('element', function(){
        var element = layui.element;

    });
</script>
</body>
</html>