<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:71:"G:\xampp\htdocs\bbb\public/../application/marketm\view\index\indes.html";i:1539414035;}*/ ?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Hello MUI</title>
    <meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1,user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">

    <!--标准mui.css-->
    <link rel="stylesheet" href="__WAP__/css/mui.min.css">
    <!--App自定义的css-->
    <!--<link rel="stylesheet" type="text/css" href="../css/app.css"/>-->
</head>
<body>
<header class="mui-bar mui-bar-nav">
    <a class="mui-action-back mui-icon mui-icon-left-nav mui-pull-left"></a>
    <h1 class="mui-title">二级列表</h1>
</header>

<div class="mui-content">
    <div class="mui-card">
        <ul class="mui-table-view mui-table-view-chevron">
            <div class="mui-card">
                <div class="mui-card-content">
                    <div class="mui-card-content-inner">
                        <p><b>房源编号：【201810130002】</b>
                            <span style="float: right;">回款率：<span style="margin-left: 8px;" class="mui-badge mui-badge-danger">23%</span></span>
                        </p>
                        <p style="color: #333;">
                            房源标题：李晓倩添加的房源
                            <br/>
                            小区名称：汇成和苑
                            <br/>
                            装修款额：130000（元）
                            <br/>
                            房屋面积：145（㎡）
                            <br/>
                            合同编号：dcxw_0002
                            <br/>
                            签订日期：2018年10月10日
                            <br/>
                        </p>
                    </div>
                </div>
            </div>
            <li class="mui-table-view-cell mui-collapse">
                <a class="mui-navigate-right" href="#">户主信息</a>
                <div class="mui-collapse-content">
                    <form class="mui-input-group">
                        <div class="mui-input-row" style="width: 100% !important;">
                            <label>Input</label>
                            <input type="text" placeholder="普通输入框">
                        </div>
                        <div class="mui-input-row">
                            <label>Input</label>
                            <input type="text" class="mui-input-clear" placeholder="带清除按钮的输入框">
                        </div>

                        <div class="mui-input-row mui-plus-visible">
                            <label>Input</label>
                            <input type="text" class="mui-input-speech mui-input-clear" placeholder="语音输入">
                        </div>
                        <div class="mui-button-row">
                            <button class="mui-btn mui-btn-primary" type="button" onclick="return false;">确认</button>&nbsp;&nbsp;
                            <button class="mui-btn mui-btn-primary" type="button" onclick="return false;">取消</button>
                        </div>
                    </form>
                </div>
            </li>
            <li class="mui-table-view-cell mui-collapse">
                <a class="mui-navigate-right" href="#">回款信息</a>
                <ul class="mui-table-view mui-table-view-chevron">
                    <li class="mui-table-view-cell"><a class="mui-navigate-right" href="#">PC方案</a>
                    </li>
                    <li class="mui-table-view-cell"><a class="mui-navigate-right" href="#">手机方案</a>
                    </li>
                    <li class="mui-table-view-cell"><a class="mui-navigate-right" href="#">TV方案</a>
                    </li>
                </ul>
            </li>
            <li class="mui-table-view-cell mui-collapse">
                <a class="mui-navigate-right" href="#">房屋附属</a>
                <ul class="mui-table-view mui-table-view-chevron">
                    <li class="mui-table-view-cell"><a class="mui-navigate-right" href="#">公司新闻</a>
                    </li>
                    <li class="mui-table-view-cell"><a class="mui-navigate-right" href="#">行业新闻</a>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
</div>
</body>
<script src="__WEB__/js/jquery-1.10.2.min.js"></script>
<script src="__WAP__/js/mui.min.js"></script>
<script>
    mui.init({
        swipeBack:true //启用右滑关闭功能
    });
    window.addEventListener('toggle', function(event) {
        if (event.target.id === 'M_Toggle') {
            var isActive = event.detail.isActive;
            var table = document.querySelector('.mui-table-view');
            var card = document.querySelector('.mui-card');
            if (isActive) {
                card.appendChild(table);
                card.style.display = '';
            } else {
                var content = document.querySelector('.mui-content');
                content.insertBefore(table, card);
                card.style.display = 'none';
            }
        }
    });
</script>
</html>