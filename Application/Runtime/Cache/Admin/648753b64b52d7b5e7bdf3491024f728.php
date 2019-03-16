<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>三众能源·中关村集成电路设计园能源管理系统</title>
    <!-- CSS -->
    <!--<link rel="stylesheet" href="/szny/Public/adminlogin/css/bootstrap.min.css">-->
    <!--<link rel="stylesheet" href="/szny/Public/adminlogin/css/font-awesome.min.css">-->
    <!--<link rel="stylesheet" href="/szny/Public/adminlogin/css/form-elements.css">-->
    <!--<link rel="stylesheet" href="/szny/Public/adminlogin/css/style.css">-->

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <!--<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>-->
    <!--<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>-->
    <![endif]-->
    <style>
        html,body {
            width: 100%;
            height: 100%;
        }
        body {
            background: url('/szny/Public/adminlogin/img/loginbg.png');
            background-size: cover;
        }
        * {
            padding: 0;
            margin: 0;
            box-sizing: border-box;
        }
        a {
            text-decoration: none;
            color: #333;
        }
        input {
            outline: none;
            border: none;
        }
        .title {
            height: 80px;
            padding-left: 44px;
            padding-top: 18px;
            background: #0b3d85;
            color: #fff;
        }
        .logo {
            float: left;
        }
        .shuline {
            width: 2px;
            height: 44px;
            background: #fff;
            float: left;
            margin: 0 15px;
        }
        .company_name {
            float: left;
            height: 44px;
        }
        .english_name {
            font-size: 12px;
            margin-top: 5px;
            min-width: 400px;
        }

        .login_window {
            width: 350px;
            height: 250px;
            background: #0b3d85;
            position: fixed;
            border-radius: 10px;
            bottom: 50%;
            transform: translateY(50%);
            right: 10%;
            padding: 10px 20px;
            color: #fff;


        }
        .login_user {
            margin-left: -5px;
            border-left: 5px solid #6cc134;
            padding-left: 5px;
        }
        .login_window input[type="text"],
        .login_window input[type="password"] {
            display: block;
            margin-top: 20px;
            width: 100%;
            height: 40px;
            background: #fff;
            border-radius: 5px;
            padding-left: 10px;
            font-size: 16px;
        }
        .login_window input[type="checkbox"] {
            margin-left: 10px;
            margin-top: 10px;
        }
        .login_window input[type="button"] {
            display: block;
            margin-top: 20px;
            width: 100%;
            height: 40px;
            background: #6cc134;
            border-radius: 5px;
            color: #fff;
            font-size: 16px;
        }
        .footer {
            height: 60px;
            width: 100%;
            background: #0b3d85;
            position: fixed;
            bottom: 0;
            left: 0;
            line-height: 60px;

        }
        .build-message {
            float: right;
            color: #797f8b;
            margin-right: 50px;

        }
    </style>

    <script type="text/javascript" src="/szny/Public/adminlogin/jquery.min.js"></script>
    <script type="text/javascript">

        document.onkeydown=function(event) {
            var e = event || window.event || arguments.callee.caller.arguments[0];
            if (e && e.keyCode == 13) { // enter 键
                login();
            }
        };

        function login()
        {
            var $formBody = $('#form-body');
            $.post('/szny/index.php/Admin/Adminlogin/dologin', $formBody.serialize(),
                    function(rep, status) {
//                        alert(rep + "_" + status);
                        if ("登录成功" == rep) {
                            window.location.href = "/szny/index.php/Admin/Frame";
                        }
                        else {
                            alert("登录失败");
                        }
                    }
            );
        };

        function getBrowser(){
            var userAgent = navigator.userAgent; //取得浏览器的userAgent字符串
            var isOpera = userAgent.indexOf("Opera") > -1; //判断是否Opera浏览器
            var isIE = userAgent.indexOf("compatible") > -1 && userAgent.indexOf("MSIE") > -1 && !isOpera; //判断是否IE浏览器
            var isFF = userAgent.indexOf("Firefox") > -1; //判断是否Firefox浏览器
            var isSafari = userAgent.indexOf("Safari") > -1; //判断是否Safari浏览器
            if (isIE) {
                var IE5 = IE55 = IE6 = IE7 = IE8 = false;
                var reIE = new RegExp("MSIE (\\d+\\.\\d+);");
                reIE.test(userAgent);
                var fIEVersion = parseFloat(RegExp["$1"]);
                IE55 = fIEVersion == 5.5;
                IE6 = fIEVersion == 6.0;
                IE7 = fIEVersion == 7.0;
                IE8 = fIEVersion == 8.0;
                if (IE55) {
                    return "IE55";
                }
                if (IE6) {
                    return "IE6";
                }
                if (IE7) {
                    return "IE7";
                }
                if (IE8) {
                    return "IE8";
                }
            }//isIE end
            if (isFF) {
                return "FF";
            }
            if (isOpera) {
                return "Opera";
            }
        }//myBrowser() end
        //以下是调用上面的函数
        if (getBrowser() == "FF") {
            //alert("我是 Firefox");
        }
        if (getBrowser() == "Opera") {
            //alert("我是 Opera");
        }
        if (getBrowser() == "Safari") {
            //alert("我是 Safari");
        }
        if (getBrowser() == "IE55") {
            location.href = ("/szny/index.php/Admin/Adminlogin/browercheckerror");
//            alert("我是 IE5.5");
        }
        if (getBrowser() == "IE6") {
            location.href = ("/szny/index.php/Admin/Adminlogin/browercheckerror");
//            alert("我是 IE6");
        }
        if (getBrowser() == "IE7") {
            location.href = ("/szny/index.php/Admin/Adminlogin/browercheckerror");
//            alert("我是 IE7");
        }
        if (getBrowser() == "IE8") {
            location.href = ("/szny/index.php/Admin/Adminlogin/browercheckerror");
//            alert("我是 IE8");
        }
    </script>

</head>
<body>
<div class="title">
    <!--<a href="#" class="logo"><img src="/szny/Public/adminlogin/img/logo.png" alt=""></a>-->
    <!--<span class="shuline"></span>-->
    <!--<div class="company_name">-->
        <img src="/szny/Public/img/banner.png" alt="" style="height: 40px">
        <!--<p>中关村集成电路设计园能源管理系统</p>-->
        <!--<p class="english_name">Zhongguancun integrated circuit design Park energy management systerm</p>-->
    <!--</div>-->
</div>

<div class="login_window">

    <p class="login_user">系统登录</p>
    <form onkeydown="if(event.keyCode==13){return false;}"  action="" method="post" id="form-body">
        <input type="text" name="emp_account" placeholder="请输入用户名" value="admin">
        <input type="password" name="emp_password" placeholder="请输入密码" value="123456">
        <!--<input type="checkbox" checked="true"> 记住密码-->
        <input type="button" onclick="login()"  value="登   录">
    </form>
</div>

<div class="footer">
    <p class="build-message">© 2017-2018 中关村集成电路设计园能源管理系统</p>
</div>

<script src="/szny/Public/adminlogin/jquery-1.12.4.js"></script>
</body>
</html>
<script src="/szny/Public/adminframework/js/jquery.min.js?v=2.1.4"></script>
<script src="/szny/Public/adminframework/js/bootstrap.min.js?v=3.3.5"></script>
<script src="/szny/Public/adminframework/js/plugins/metisMenu/jquery.metisMenu.js"></script>
<script src="/szny/Public/adminframework/js/plugins/slimscroll/jquery.slimscroll.min.js"></script>
<script src="/szny/Public/adminframework/js/plugins/layer/layer.min.js"></script>

<!-- 自定义js -->
<script src="/szny/Public/adminframework/js/hplus_atp.js?v=4.0.0"></script>
<script type="text/javascript" src="/szny/Public/adminframework/js/contabs.js"></script>