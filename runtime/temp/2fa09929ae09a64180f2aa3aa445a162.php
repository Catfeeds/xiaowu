<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:70:"G:\xampp\htdocs\bbb\public/../application/index\view\common\index.html";i:1543387016;}*/ ?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>太空404</title>

    <style>
        html {
            margin: 0;
            padding: 0;
            background-color: white;
        }

        body,
        html {
            width: 100%;
            height: 100%;
            overflow: hidden;
        }

        #svgContainer {
            width: 640px;
            height: 512px;
            background-color: white;
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            margin: auto;
        }
        .not-found{
            font-size: 59px;
            text-align: center;
            color: #7e888b;
        }
        .not{
            margin-top: 39px;
            font-size: 59px;
            text-align: center;
            color: #7e888b;
        }
    </style>

</head>
<body>

<script type="text/javascript" src="__WAP__/js/bodymovin.js"></script>
<script type="text/javascript" src="__WAP__/js/data.js"></script>

<div class="not-found" >你找的页面不见了呢！<br/>
    <div style="margin-top: 70px;">
        <a class="not" href="javascript:history.back(-1);" >返回上一页</a>
    </div>
</div>
<div id="svgContainer"></div>
<script type="text/javascript">
    var svgContainer = document.getElementById('svgContainer');
    var animItem = bodymovin.loadAnimation({
        wrapper: svgContainer,
        animType: 'svg',
        loop: true,
        animationData: JSON.parse(animationData)
    });
</script>

</body>
</html>
