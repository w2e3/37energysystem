<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no, width=device-width">
    <title>中关村集成电路设计院</title>
    <link rel="stylesheet" href="/szny/Public/vendor/diy_component/yuanqu_page/css/reset.css">
    <link rel="stylesheet" href="/szny/Public/vendor/diy_component/yuanqu_page/css/floor-new.css">
</head>

<body>
<div class="messagetop clearfix" style="margin-top: 20px;border:1px solid #ddd">
    <div class="msgtitle"><?php echo ($titname); ?></div>
    <iframe id = "message" frameborder=0 width=100% height="330px" marginheight=0 marginwidth=0 scrolling=no
            src='/szny/index.php/Admin/RgGeneral/func_regionenergychart?regiontype=<?php echo ($_GET['regiontype']); ?>&snname=<?php echo ($_GET['snname']); ?>&regionlevel=<?php echo ($_GET['regionlevel']); ?>&tabindex=<?php echo ($_GET['tabindex']); ?>&rgn_atpid=<?php echo ($_GET['rgn_atpid']); ?>'></iframe>
</div>


<div class="messagetop clearfix" style="margin-top: 20px;margin-right: 5px;padding-bottom:5px;border:1px solid #ddd;border-radius: 5px">
    <div class="yibiao">
        <!--<div class="msgtitle">本月能源花费</div>-->
        <div class="tablebox" >
            <iframe frameborder=0 width=100% style="min-height:350px"  marginheight=0 marginwidth=0 scrolling=no src='/szny/index.php/Admin/RgGeneral/func_energycoast?regiontype=<?php echo ($_GET['regiontype']); ?>&snname=<?php echo ($_GET['snname']); ?>&regionlevel=<?php echo ($_GET['regionlevel']); ?>&tabindex=0&rgn_atpid=<?php echo ($_GET['rgn_atpid']); ?>'></iframe>
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
            <iframe frameborder=0 width=100% style="min-height:350px" marginheight=0 marginwidth=0 scrolling=no src='/szny/index.php/Admin/RgGeneral/func_alarminfo?regiontype=<?php echo ($_GET['regiontype']); ?>&snname=<?php echo ($_GET['snname']); ?>&regionlevel=<?php echo ($_GET['regionlevel']); ?>&tabindex=0&rgn_atpid=<?php echo ($_GET['rgn_atpid']); ?>'></iframe>
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
<script>
    ATP_REGIONJUMbj = function (rgn_atpid) {
        window.parent.ATP_REGIONJUMBJ(rgn_atpid);
        // alert(region_id);
    };
</script>
</body>
</html>