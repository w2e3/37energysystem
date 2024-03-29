<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no, width=device-width">
    <title>中关村集成电路设计院</title>
    <link rel="stylesheet" href="/szny/Public/vendor/diy_component/yuanqu_page/css/reset.css">
    <link rel="stylesheet" href="/szny/Public/vendor/diy_component/yuanqu_page/css/yuanqu-new.css">
</head>

<body>
<div class="messagetop clearfix" style="margin-top: 20px;margin-right: 5px;border:1px solid #ddd;border-radius: 5px">
    <!--<div class="msgtitle">园区</div>-->
    <div class="yuanqutop">
        <img src="/szny/Public/vendor/diy_component/yuanqu_page/images/yuanqunew.png" width="100%">
        <!-- 2#D座 -->
        <a href="#" class="point1 onehouse" onclick="window.parent.parent.ATP_REGIONJUMP('guidF7E28F9A-E04C-4030-86E5-73A84A0B6CAD');"></a>
        <!-- 2#B座 -->
        <a href="#" class="point2 onehouse" onclick="window.parent.parent.ATP_REGIONJUMP('guid5BAF01C0-E54E-4F2D-8419-09EA0507F4F2');"></a>
        <!-- 2#A座 -->
        <a href="#" class="point3 onehouse" onclick="window.parent.parent.ATP_REGIONJUMP('guid077698E9-2942-430A-81E1-E54A98A3383C');"></a>
        <!-- 2#C座 -->
        <a href="#" class="point4 onehouse" onclick="window.parent.parent.ATP_REGIONJUMP('guid3BD09081-28C0-4ECD-BC25-0EB0DDF949B2');"></a>
        <!-- 2#F座 -->
        <a href="#" class="point5 onehouse" onclick="window.parent.parent.ATP_REGIONJUMP('guid75D5A56E-A723-4E16-AAF9-97E86195E0AF');"></a>
        <!-- 2#E座 -->
        <a href="#" class="point6 onehouse" onclick="window.parent.parent.ATP_REGIONJUMP('guid39E40DE8-E7B3-40D8-B8A8-E5C69AF1EBF5');"></a>
        <!-- 1# -->
        <a href="#" class="point7 onehouse" onclick="window.parent.parent.ATP_REGIONJUMP('guidBFE08660-A606-4CD1-BDE0-3720CD50CED4');"></a>
        <!-- 3# -->
        <a href="#" class="point8 onehouse" onclick="window.parent.parent.ATP_REGIONJUMP('guidF5B91891-FC25-4448-84B9-0D7A544EFE6C');"></a>
        <!-- 4# -->
        <a href="#" class="point9 onehouse" onclick="window.parent.parent.ATP_REGIONJUMP('guid8E6723F6-09D3-4CFF-B3AD-812A7F784201');"></a>
         <!-- 5# -->
        <a href="#" class="point10 onehouse" onclick="window.parent.parent.ATP_REGIONJUMP('guidDDE6FF51-B4DD-42C1-962A-ED42D5120E88');"></a>
         <!-- 6# -->
        <a href="#" class="point11 onehouse" onclick="window.parent.parent.ATP_REGIONJUMP('guidFEAFFDFB-4628-46D2-B39B-46F1EC76EF07');"></a>
         <!-- 7# -->
        <a href="#" class="point12 onehouse" onclick="window.parent.parent.ATP_REGIONJUMP('guidC65AC6F2-6962-470C-9367-FF87BA1CD5CC');"></a>
         <!-- 8# -->
        <a href="#" class="point13 onehouse" onclick="window.parent.parent.ATP_REGIONJUMP('guidB44A77BC-907D-42AC-812D-3E401E40B6CA');"></a>
         <!-- 9# -->
        <a href="#" class="point14 onehouse" onclick="window.parent.parent.ATP_REGIONJUMP('guid0CCA3B48-E22B-4636-A0EC-1F0E81AE0F08');"></a>
         <!-- 10# -->
        <a href="#" class="point15 onehouse" onclick="window.parent.parent.ATP_REGIONJUMP('guid3696CE0E-0616-4B32-8AB2-40AA8DB2E1D6');"></a>
         <!-- 11# -->
        <a href="#" class="point16 onehouse" onclick="window.parent.parent.ATP_REGIONJUMP('guid1F1285F0-C495-46D7-969A-D3711B12EA28');"></a>
    </div>
    <div class="yibiao-top">
        <iframe id = "message" frameborder=0 width=100% height="290px" marginheight=0 marginwidth=0 scrolling=no
                src='/szny/index.php/Admin/RgGeneral/func_regionrootenergychart?regiontype=<?php echo ($_GET['regiontype']); ?>&snname=<?php echo ($_GET['snname']); ?>&regionlevel=<?php echo ($_GET['regionlevel']); ?>&tabindex=<?php echo ($_GET['tabindex']); ?>&rgn_atpid=<?php echo ($_GET['rgn_atpid']); ?>'></iframe>
    </div>
</div>

<div class="messagetop clearfix" style="margin-top: 20px;margin-right: 5px;padding-bottom:5px;border:1px solid #ddd;border-radius: 5px">
    <div class="yibiao">
        <!--<div class="msgtitle">本月能源花费</div>-->
        <div class="tablebox" >
            <iframe frameborder=0 width=100% style="min-height:800px"  marginheight=0 marginwidth=0 scrolling=no src='/szny/index.php/Admin/RgGeneral/func_energycoastroot?regiontype=<?php echo ($_GET['regiontype']); ?>&snname=<?php echo ($_GET['snname']); ?>&regionlevel=<?php echo ($_GET['regionlevel']); ?>&tabindex=0&rgn_atpid=<?php echo ($_GET['rgn_atpid']); ?>'></iframe>
        </div>
    </div>
</div>

<div class="messagetop clearfix" style="margin-top: 20px;margin-right: 5px;padding-bottom:5px;border:1px solid #ddd;border-radius: 5px">
    <div class="yibiao">
        <div class="msgtitle">最近30天能源趋势图</div>
        <div class="tablebox" >
            <iframe frameborder=0 width=100% style="min-height:340px"  marginheight=0 marginwidth=0 scrolling=no src='/szny/index.php/Admin/RgGeneral/func_energytrend?regiontype=<?php echo ($_GET['regiontype']); ?>&snname=<?php echo ($_GET['snname']); ?>&regionlevel=<?php echo ($_GET['regionlevel']); ?>&tabindex=0&rgn_atpid=<?php echo ($_GET['rgn_atpid']); ?>'></iframe>
        </div>
    </div>
</div>

<div class="messagetop clearfix" style="margin-top: 20px;margin-right: 5px;padding-bottom:5px;border:1px solid #ddd;border-radius: 5px">
    <div class="yibiao">
        <div class="msgtitle">报警信息预览</div>
        <div class="tablebox" >
            <iframe frameborder=0 width=100% style="min-height:300px" marginheight=0 marginwidth=0 scrolling=no src='/szny/index.php/Admin/RgGeneral/func_alarminfo?regiontype=<?php echo ($_GET['regiontype']); ?>&snname=<?php echo ($_GET['snname']); ?>&regionlevel=<?php echo ($_GET['regionlevel']); ?>&tabindex=0&rgn_atpid=<?php echo ($_GET['rgn_atpid']); ?>'></iframe>
        </div>
    </div>
</div>

<script src="/szny/Public/vendor/diy_component/yuanqu_page/js/jquery-1.12.4.js"></script>
<script src="/szny/Public/vendor/diy_component/yuanqu_page/js/highcharts.js"></script>
<script src="/szny/Public/vendor/diy_component/yuanqu_page/js/highcharts-more.js"></script>
<script>
    $('.onehouse').on('mouseenter',function() {
        $(this).css('opacity',1).siblings('.onehouse').css('opacity',0);
    })
</script>
<script type="text/javascript">
    ATP_REGIONJUMbj = function (rgn_atpid) {
        window.parent.ATP_REGIONJUMBJ(rgn_atpid);
        // alert(region_id);
    };
</script>
</body>
</html>