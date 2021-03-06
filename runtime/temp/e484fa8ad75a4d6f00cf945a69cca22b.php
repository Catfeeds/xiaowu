<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:70:"G:\xampp\htdocs\bbb\public/../application/admin\view\msg\msgsigns.html";i:1527921101;s:70:"G:\xampp\htdocs\bbb\public/../application/admin\view\index\header.html";i:1536287308;s:70:"G:\xampp\htdocs\bbb\public/../application/admin\view\index\footer.html";i:1525742360;}*/ ?>
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
        <a>系统配置</a>
        <a><cite>信息配置</cite></a>
    </span>
        <div style="float:right;">
            <button class="layui-btn layui-btn-primary layui-btn-sm"  onclick="addSign()"><i class="layui-icon"></i>添加短信签名</button>
        </div>
    </div>
    <hr/>
    <ul class="layui-tab-title">
            <li><a href="<?=url('msg/msg')?>">短信接口</a></li>
            <li class="layui-this"><a>短信签名</a></li>
            <li><a href="<?=url('msg/msgtem')?>">短信模板</a></li>
        </ul>
    <table lay-skin="line" class="layui-table" lay-filter="demo" lay-data="{height: 'full-200', cellMinWidth:79, url:'/admin/msg/signData/', limit:20,limits:[20,30,50] ,id: 'testReload',page:true}" >
                    <thead>
                    <tr>
                        <th lay-data="{field:'ali_sign_id', width:150,  sort: true}">编号</th>
                        <th lay-data="{field:'ali_sign_name'}">签名名称</th>
                        <th lay-data="{field:'ali_sign_remarks', sort: true}">描述说明</th>
                        <th lay-data="{field:'ali_sign_addtime',sort: true}">操作时间</th>
                        <th lay-data="{field:'ad_realname',width:120,sort: true}">操作人</th>
                        <th lay-data="{field:'ali_sign_able',width:120, templet: '#switchTpl',sort:true, unresize: true}">是否显示</th>
                        <th lay-data="{width:160, toolbar: '#barDemo'}">操作</th>
                    </tr>
                    </thead>
                </table>
</div>
<script type="text/html" id="barDemo">
    <a class="layui-btn layui-btn-xs" lay-event="edit"><i class="layui-icon">&#xe642;</i>编辑</a>
    <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del"><i class="layui-icon">&#xe640;</i>删除</a>
</script>
<script type="text/html" id="switchTpl">
    <input type="checkbox" name="sex" lay-skin="switch" value="{{d.ali_sign_id}}" lay-text="是|否" lay-filter="sexDemo" {{ d.ali_sign_able == 1 ? 'checked' : '' }}>
</script>
<script>
    layui.use(['table','laydate','form'], function(){
        var table = layui.table
            ,form = layui.form;
        table.on('tool(demo)', function(obj){
            var data = obj.data;
            var sign_id = data.ali_sign_id;
            if(obj.event === 'edit'){
                window.location.href='<?=url("msg/editSign")?>?sign_id='+ sign_id ;
            } else if(obj.event === 'del'){
                layer.confirm('确定删除该签名？删除后不可恢复！', {
                    btn : [ '确定', '取消' ]//按钮
                }, function() {
                    $.ajax({
                        'type':"get",
                        'url':"<?=url('msg/delSign')?>",
                        'data':{sign_id:sign_id},
                        'success':function (result) {
                            if(result.code < 1){
                                layer.msg(result.msg);
                            }else {
                                layer.msg(result.msg);
                                layer.open({
                                    title: '信息'
                                    ,content: result.msg
                                    ,yes: function(index){
                                        layer.close(index);
                                        window.location.href='<?=url("msg/msgsigns")?>';
                                    }
                                    ,cancel:function (index) {
                                        layer.close(index);
                                        window.location.href='<?=url("msg/msgsigns")?>';
                                    }
                                });
                            }
                        },
                        'error':function () {
                            console.log('error');
                        }
                    })
                },function(){
                    layer.msg('您已取消该操作！',{
                        time: 2000
                    });
                });
            }
        });
        form.on('select(bu_p_id)', function(data){
            var p_id=data.value;
            $('#city').show();
            $.ajax({
                type: 'POST',
                url: "<?=url('user/getCityName')?>?p_id="+p_id,
                data: {p_id:p_id},
                dataType:  'json',
                success: function(data){
                    var code=data.data;
                    $("#bu_c_id").html("<option value=''>请选择城市</option>");
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
            $('#branchs').show();
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
        //调用该分站下面的管理员
        form.on('select(ba_branch)', function(data){
            var b_id=data.value;
            $.ajax({
                type: 'POST',
                url: "<?=url('admin/getAdminName')?>",
                data: {b_id:b_id},
                dataType:  'json',
                success: function(data){
                    var code=data.data;
                    $("#ba_admin").html("<option value=''>请选择操作人</option>");
                    $.each(code, function(i, val) {
                        var option1 = $("<option>").val(val.ad_id).text(val.ad_realname);
                        $("#ba_admin").append(option1);
                        form.render('select');
                    });
                    $("#ba_admin").get(0).selectedIndex=0;
                }
            });
        });
        //监听是否开启操作
        form.on('switch(sexDemo)', function(obj){
            var id = this.value;
            //如果选中状态是true,后台数据将要改为显示
            var change = obj.elem.checked;
            if(change){
                change = 1;
            }else{
                change = 0;
            }
            $.ajax({
                type: 'POST',
                url: "<?=url('msg/status')?>?sign_id="+id+ "&change="+change,
                dataType:  'json',
                success: function(data){
                    layer.msg(data.msg);
                }
            });
        });

        var $ = layui.$, active = {
            reload: function(){
                var keywords = $('#keywords').val();
                var ba_p_id = $('#ba_p_id').val();
                var bu_c_id = $('#bu_c_id').val();
                var ba_branch = $('#branch').val();
                var ba_admin = $('#ba_admin').val();
                var ba_via = $('#ba_via').val();
                //执行重载
                table.reload('testReload', {
                    url: '/admin/banner/bannerPc/'
                    ,page: {
                        curr: 1 //重新从第 1 页开始
                    }
                    ,where: {
                        keywords: keywords,
                        ba_p_id: ba_p_id,
                        bu_c_id: bu_c_id,
                        ba_branch: ba_branch,
                        ba_admin: ba_admin,
                        ba_via: ba_via
                    },
                    success:function (data) {
                        console.log(data);
                    }
                });
            }

        };
        $('.demoTable .layui-btn').on('click', function(){
            var type = $(this).data('type');
            active[type] ? active[type].call(this) : '';
        });
    });
</script>
<script type="text/javascript">
    function addSign(){
        window.location.href='<?=url('msg/addSign')?>';
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