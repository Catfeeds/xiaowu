<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:71:"G:\xampp\htdocs\bbb\public/../application/admin\view\banner\banner.html";i:1537518540;s:70:"G:\xampp\htdocs\bbb\public/../application/admin\view\index\header.html";i:1536287308;s:70:"G:\xampp\htdocs\bbb\public/../application/admin\view\index\footer.html";i:1525742360;}*/ ?>
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

<div style="margin: 20px;">
    <span class="layui-breadcrumb" lay-separator=">">
        <a>广告管理</a>
        <a><cite>banner</cite></a>
    </span>
    <div style="float:right;">
        <button class="layui-btn layui-btn-primary layui-btn-sm"  onclick="addBanner()"><i class="layui-icon"></i>添加banner</button>
    </div>
</div>
<hr/>
<section class="panel panel-padding" style="padding-top: 10px;padding-left: 10px;">
    <form class="layui-form layui-form-pane1">
        <div class="layui-form-item  demoTable">
            <div class="layui-inline">
                <div class="layui-input-inline">
                    <input type="text" name="keywords" id="keywords"  placeholder="请输入banner主题" class="layui-input">
                </div>
            </div>
            <div class="layui-inline">
                <div class="layui-input-inline">
                    <span class="layui-btn" data-type="reload">查询</span>
                    <a href="<?=url('banner/banner')?>" class="layui-btn layui-btn-warm">刷新</a>
                </div>
            </div>
        </div>
    </form>
</section>
<section>
    <table lay-filter="demo" id="test123" lay-skin="nob"></table>
</section>
<script type="text/html" id="barDemo">
    <a class="layui-btn layui-btn-xs" lay-event="edit"><i class="layui-icon">&#xe642;</i>编辑</a>
    <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del"><i class="layui-icon">&#xe640;</i>删除</a>
</script>
<script type="text/html" id="switchTpl">
    <input type="checkbox" name="sex" lay-skin="switch" value="{{d.ba_id}}" lay-text="是|否" lay-filter="sexDemo" {{ d.ba_isable == 1 ? 'checked' : '' }}>
</script>
<script>
    layui.use(['table','laydate','form'], function(){
        var table = layui.table
            ,form = layui.form;
        table.render({
            elem: '#test123'
            ,skin: 'line'
            ,url:'/admin/banner/bannerPc/'
            ,height: 'full-200'
            ,cols: [[
                {field:'ba_bid', width:180,  sort: true, title:'广告编号'}
                ,{field:'ba_title',width:330, title: '广告名称'}
                ,{field:'ba_img', title: '广告封面',width: 250,templet:'<div><img src="{{ d.ba_img}}"></div>'}
                ,{field:'ba_order',width:150,title: '广告排序',edit:'text', sort: true}
                ,{field:'ba_createtime',width:210, title: '操作时间'}
                ,{field:'ad_realname',width:170, title: '操作人'}
                ,{field:'ba_isable',width:147, templet: '#switchTpl',sort:true, unresize: true, title:'是否显示' }
                ,{align:'center',width:280, toolbar: '#barDemo',title:'操作' }
            ]]
            ,limit:15
            ,limits:[15,30,50]
            ,id: 'testReload'
            ,page:true
        });


        // //修改排序
        table.on('edit(demo)', function(obj){
            var value = obj.value;
            var ba_id = obj.data.ba_id;
            $.ajax({
                type: 'POST',
                url: "<?=url('banner/reOrder')?>",
                data:{ba_id:ba_id,value:value},
                dataType:  'json',
                success: function(data){
                    console.log(data);
                    layer.msg(data.msg);
                }
            });
        });
        table.on('tool(demo)', function(obj){
            var data = obj.data;
            if(obj.event === 'edit'){
                var ba_id = data.ba_id;
                window.location.href='<?=url("banner/editBanner")?>?ba_id='+ ba_id ;
            } else if(obj.event === 'del'){
                var ba_id = data.ba_id;
                layer.confirm('确定删除该图片？删除后不可恢复！', {
                    btn : [ '确定', '取消' ]//按钮
                }, function() {
                    $.ajax({
                        'type':"get",
                        'url':"<?=url('banner/delBanner')?>",
                        'data':{ba_id:ba_id},
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
                                        window.location.href='<?=url("banner/banner")?>';
                                    }
                                    ,cancel:function (index) {
                                        layer.close(index);
                                        window.location.href='<?=url("banner/banner")?>';
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
                url: "<?=url('banner/status')?>?ba_id="+id+ "&change="+change,
                dataType:  'json',
                success: function(data){
                    layer.msg(data.msg);
                }
            });
        });

        var $ = layui.$, active = {
            reload: function(){
                var keywords = $('#keywords').val();
                //执行重载
                table.reload('testReload', {
                    url: '/admin/banner/bannerPc/'
                    ,page: {
                        curr: 1 //重新从第 1 页开始
                    }
                    ,where: {
                        keywords: keywords
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

    function addBanner(){
        window.location.href='<?=url('banner/addBanner')?>';
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