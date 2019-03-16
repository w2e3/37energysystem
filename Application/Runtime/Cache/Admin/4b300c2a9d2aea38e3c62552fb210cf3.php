<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>园区首页</title>
	<link rel="stylesheet" href="/szny/Public/vendor/diy_component/yuanqu_page/css/yuanqu.css">
</head>
<body>
	<input type="hidden" value="<?php echo ($yearcon1["ydl"]); ?>" id="ydl1">

	<div class="full_building">
		<img src="/szny/Public/vendor/diy_component/yuanqu_page/images/yuanqu.jpg" width="100%">
		<!--1#楼-->
		<a href="/szny/index.php/Admin/Parkoverview/F1_ceng1F" class="point7 onehouse"></a>
		<div class="unusual7 unusual">
			<p>1#楼</p>
			<img src="/szny/Public/vendor/diy_component/yuanqu_page/images/unusual.png">
		</div>
		<!--2#楼-->
		<a href="/szny/index.php/Admin/Parkoverview/F2a_ceng1F" class="point3 onehouse"></a>
		<div class="unusual3 unusual">
			<p>2#A座</p>
			<img src="/szny/Public/vendor/diy_component/yuanqu_page/images/unusual.png">
		</div>
		<a href="/szny/index.php/Admin/Parkoverview/F2b_ceng1F" class="point2 onehouse"></a>
		<div class="unusual2 unusual">
			<p>2#B座</p>
			<img src="/szny/Public/vendor/diy_component/yuanqu_page/images/unusual.png">
		</div>
		<a href="/szny/index.php/Admin/Parkoverview/F2c_ceng1F" class="point4 onehouse"></a>
		<div class="unusual4 unusual">
			<p>2#C座</p>
			<img src="/szny/Public/vendor/diy_component/yuanqu_page/images/unusual.png">
		</div>
		<a href="/szny/index.php/Admin/Parkoverview/F2d_ceng1F" class="point1 onehouse"></a>
		<div class="unusual1 unusual">
			<p>2#D座</p>
			<img src="/szny/Public/vendor/diy_component/yuanqu_page/images/unusual.png">
		</div>
		<a href="/szny/index.php/Admin/Parkoverview/F2e_ceng1F" class="point6 onehouse"></a>
		<div class="unusual6 unusual">
			<p>2#E座</p>
			<img src="/szny/Public/vendor/diy_component/yuanqu_page/images/unusual.png">
		</div>
		<a href="/szny/index.php/Admin/Parkoverview/F2f_ceng1F" class="point5 onehouse"></a>
		<div class="unusual5 unusual">
			<p>2#F座</p>
			<img src="/szny/Public/vendor/diy_component/yuanqu_page/images/unusual.png">
		</div>
		<!--3#楼-->
		<a href="/szny/index.php/Admin/Parkoverview/F3_ceng1F" class="point8 onehouse"></a>
		<div class="unusual8 unusual">
			<p>3#楼</p>
			<img src="/szny/Public/vendor/diy_component/yuanqu_page/images/unusual.png">
		</div>

		<!-- 左边低楼 -->
		<a href="#" class="point9 onehouse"></a>
		<div class="unusual9 unusual">
			<p>4#楼</p>
			<img src="/szny/Public/vendor/diy_component/yuanqu_page/images/unusual.png">
			<!--<img src="/szny/Public/vendor/diy_component/yuanqu_page/images/usual.png">-->
		</div>
		<a href="#" class="point10 onehouse"></a>
		<div class="unusual10 unusual">
			<p>5#楼</p>
			<img src="/szny/Public/vendor/diy_component/yuanqu_page/images/unusual.png">
		</div>
		<a href="#" class="point11 onehouse"></a>
		<div class="unusual11 unusual">
			<p>6#楼</p>
			<img src="/szny/Public/vendor/diy_component/yuanqu_page/images/unusual.png">
		</div>
		<a href="#" class="point12 onehouse"></a>
		<div class="unusual12 unusual">
			<p>7#楼</p>
			<img src="/szny/Public/vendor/diy_component/yuanqu_page/images/unusual.png">
		</div>

		<!-- 右边低楼 -->
		<a href="#" class="point13 onehouse"></a>
		<div class="unusual13 unusual">
			<p>8#楼</p>
			<img src="/szny/Public/vendor/diy_component/yuanqu_page/images/unusual.png">
		</div>
		<a href="#" class="point14 onehouse"></a>
		<div class="unusual14 unusual">
			<p>9#楼</p>
			<img src="/szny/Public/vendor/diy_component/yuanqu_page/images/unusual.png">
		</div>
		<a href="#" class="point15 onehouse"></a>
		<div class="/szny/Public/vendor/diy_component/yuanqu_page/unusual15 unusual">
			<p>10#楼</p>
			<img src="/szny/Public/vendor/diy_component/yuanqu_page/images/unusual.png">
		</div>
		<a href="#" class="point16 onehouse"></a>
		<div class="unusual16 unusual">
			<p>11#楼</p>
			<img src="/szny/Public/vendor/diy_component/yuanqu_page/images/unusual.png">
		</div>
	</div>


	<div class="list-right" style="width: 360px;">

		<div class="energy_message7 energy_message">


				<?php if($alarmcount_bj1 != 0): ?><header style="background: #fc9900;cursor: pointer;"><p class="fl">1#楼（报警总数：<?php echo ($alarmcount_bj1); ?>条）</p><span class="fr zhankai"><a style="color: white" href="/szny/index.php/Admin/Rg/indexparkoverviewshell?regionlevel=region&rgn_atpid=guidBFE08660-A606-4CD1-BDE0-3720CD50CED4">更多</a></span></header>
					<?php else: ?>
					<header style="cursor: pointer;"><p class="fl">1#楼</p><span class="fr zhankai"><a style="color: white" href="/szny/index.php/Admin/Rg/indexparkoverviewshell?regionlevel=region&rgn_atpid=guidBFE08660-A606-4CD1-BDE0-3720CD50CED4">更多</a></span></header><?php endif; ?>



			<div class="alarmlist border_bottom">
				<ul class="num1">

						<?php if(is_array($bj1)): foreach($bj1 as $key=>$bj1): ?><a href="/szny/index.php/Admin/Rg/indexparkoverviewshell?regionlevel=region&rgn_atpid=guidBFE08660-A606-4CD1-BDE0-3720CD50CED4&rgn_atpidcurrent=<?php echo ($bj1["rgn_atpid"]); ?>">
								<li class="border_bottom clearfix">
									<div class="fl tips"><?php echo ($bj1["dev_name"]); ?></div>
									<div class="ll content">
										<div class="fl bold"><?php echo ($bj1["rgn_name"]); ?></div>
										<div class="fr text_right bold"><?php echo ($bj1["alm_datetime"]); ?></div><br>
										<div class="fl bold"><?php echo ($bj1["alm_content"]); ?></div>
									</div>
								</li>
							</a><?php endforeach; endif; ?>


				</ul>
				<div class="listfooter">
					<div><p>当日电能</p><p id="num1ydl"><?php if($list1["ydl"] == ''): ?>0Kwh<?php else: echo ($list1["ydl"]); ?>Kwh<?php endif; ?></p></div>
					<div><p>当日水能</p><p id="num1ysl"><?php if($list1["ysl"] == ''): ?>0T<?php else: echo ($list1["ysl"]); ?>T<?php endif; ?></p></div>
					<div><p>当日热能</p><p id="num1ynl"><?php if($list1["ynl"] == ''): ?>0Kwh<?php else: echo ($list1["ynl"]); ?>Kwh<?php endif; ?></p></div>
					<div><p>当日冷能</p><p id="num1yll"><?php if($list1["yll"] == ''): ?>0Kwh<?php else: echo ($list1["yll"]); ?>Kwh<?php endif; ?></p></div>
				</div>
			</div>
		</div>

		<div class="energy_message3 energy_message">

				<?php if($alarmcount_bj2a != 0): ?><header style="background: #fc9900;cursor: pointer;"><p class="fl">2#A座（报警总数：<?php echo ($alarmcount_bj2a); ?>条）</p><span class="fr zhankai"><a style="color: white" href="/szny/index.php/Admin/Rg/indexparkoverviewshell?regionlevel=region&rgn_atpid=guid077698E9-2942-430A-81E1-E54A98A3383C">更多</a></span></header>
					<?php else: ?>
					<header style="cursor: pointer;"><p class="fl">2#A座</p><span class="fr zhankai"><a style="color: white" href="/szny/index.php/Admin/Rg/indexparkoverviewshell?regionlevel=region&rgn_atpid=guid077698E9-2942-430A-81E1-E54A98A3383C">更多</a></span></header><?php endif; ?>


			<div class="alarmlist border_bottom">
				<ul class="num2a">

						<?php if(is_array($bj2a)): foreach($bj2a as $key=>$bj2a): ?><a href="/szny/index.php/Admin/Rg/indexparkoverviewshell?regionlevel=region&rgn_atpid=guid077698E9-2942-430A-81E1-E54A98A3383C&rgn_atpidcurrent=<?php echo ($bj1["rgn_atpid"]); ?>">
								<li class="border_bottom clearfix">
									<div class="fl tips"><?php echo ($bj2a["dev_name"]); ?></div>
									<div class="ll content">
										<div class="fl bold"><?php echo ($bj2a["rgn_name"]); ?></div>
										<div class="fr text_right bold"><?php echo ($bj2a["alm_datetime"]); ?></div><br>
										<div class="fl bold"><?php echo ($bj2a["alm_content"]); ?></div>
									</div>
								</li>
							</a><?php endforeach; endif; ?>


				</ul>
				<div class="listfooter">
					<div><p>当日电能</p><p id="num2aydl"><?php if($list2a["ydl"] == ''): ?>0Kwh<?php else: echo ($list2a["ydl"]); ?>Kwh<?php endif; ?></p></div>
					<div><p>当日水能</p><p id="num2aysl"><?php if($list2a["ysl"] == ''): ?>0T<?php else: echo ($list2a["ysl"]); ?>T<?php endif; ?></p></div>
					<div><p>当日热能</p><p id="num2aynl"><?php if($list2a["ynl"] == ''): ?>0Kwh<?php else: echo ($list2a["ynl"]); ?>Kwh<?php endif; ?></p></div>
					<div><p>当日冷能</p><p id="num2ayll"><?php if($list2a["yll"] == ''): ?>0Kwh<?php else: echo ($list2a["yll"]); ?>Kwh<?php endif; ?></p></div>
				</div>
			</div>
		</div>

		<div class="energy_message2 energy_message">

				<?php if($alarmcount_bj2b != 0): ?><header style="background: #fc9900;cursor: pointer;"><p class="fl">2#B座（报警总数：<?php echo ($alarmcount_bj2b); ?>条）</p><span class="fr zhankai"><a style="color: white" href="/szny/index.php/Admin/Rg/indexparkoverviewshell?regionlevel=region&rgn_atpid=guid5BAF01C0-E54E-4F2D-8419-09EA0507F4F2">更多</a></span></header>
					<?php else: ?>
					<header style="cursor: pointer;"><p class="fl">2#B座</p><span class="fr zhankai"><a style="color: white" href="/szny/index.php/Admin/Rg/indexparkoverviewshell?regionlevel=region&rgn_atpid=guid5BAF01C0-E54E-4F2D-8419-09EA0507F4F2">更多</a></span></header><?php endif; ?>


			<div class="alarmlist border_bottom">
				<ul class="num2b">

						<?php if(is_array($bj2b)): foreach($bj2b as $key=>$bj2b): ?><a href="/szny/index.php/Admin/Rg/indexparkoverviewshell?regionlevel=region&rgn_atpid=guid5BAF01C0-E54E-4F2D-8419-09EA0507F4F2&rgn_atpidcurrent=<?php echo ($bj1["rgn_atpid"]); ?>">
								<li class="border_bottom clearfix">
									<div class="fl tips"><?php echo ($bj2b["dev_name"]); ?></div>
									<div class="ll content">
										<div class="fl bold"><?php echo ($bj2b["rgn_name"]); ?></div>
										<div class="fr text_right bold"><?php echo ($bj2b["alm_datetime"]); ?></div><br>
										<div class="fl bold"><?php echo ($bj2b["alm_content"]); ?></div>
									</div>
								</li>
							</a><?php endforeach; endif; ?>


				</ul>
				<div class="listfooter">
					<div><p>当日电能</p><p id="num2bydl"><?php if($list2b["ydl"] == ''): ?>0Kwh<?php else: echo ($list2b["ydl"]); ?>Kwh<?php endif; ?></p></div>
					<div><p>当日水能</p><p id="num2bysl"><?php if($list2b["ysl"] == ''): ?>0T<?php else: echo ($list2b["ysl"]); ?>T<?php endif; ?></p></div>
					<div><p>当日热能</p><p id="num2bynl"><?php if($list2b["ynl"] == ''): ?>0Kwh<?php else: echo ($list2b["ynl"]); ?>Kwh<?php endif; ?></p></div>
					<div><p>当日冷能</p><p id="num2byll"><?php if($list2b["yll"] == ''): ?>0Kwh<?php else: echo ($list2b["yll"]); ?>Kwh<?php endif; ?></p></div>
				</div>
			</div>
		</div>

		<div class="energy_message4 energy_message">

				<?php if($alarmcount_bj2c != 0): ?><header style="background: #fc9900;cursor: pointer;"><p class="fl">2#C座（报警总数：<?php echo ($alarmcount_bj2c); ?>条）</p><span class="fr zhankai"><a style="color: white" href="/szny/index.php/Admin/Rg/indexparkoverviewshell?regionlevel=region&rgn_atpid=guid3BD09081-28C0-4ECD-BC25-0EB0DDF949B2">更多</a></span></header>
					<?php else: ?>
					<header style="cursor: pointer;"><p class="fl">2#C座</p><span class="fr zhankai"><a style="color: white" href="/szny/index.php/Admin/Rg/indexparkoverviewshell?regionlevel=region&rgn_atpid=guid3BD09081-28C0-4ECD-BC25-0EB0DDF949B2">更多</a></span></header><?php endif; ?>

			<div class="alarmlist border_bottom">
				<ul class="num2c">

						<?php if(is_array($bj2c)): foreach($bj2c as $key=>$bj2c): ?><a href="/szny/index.php/Admin/Rg/indexparkoverviewshell?regionlevel=region&rgn_atpid=guid3BD09081-28C0-4ECD-BC25-0EB0DDF949B2&rgn_atpidcurrent=<?php echo ($bj1["rgn_atpid"]); ?>">
								<li class="border_bottom clearfix">
									<div class="fl tips"><?php echo ($bj2c["dev_name"]); ?></div>
									<div class="ll content">
										<div class="fl bold"><?php echo ($bj2c["rgn_name"]); ?></div>
										<div class="fr text_right bold"><?php echo ($bj2c["alm_datetime"]); ?></div><br>
										<div class="fl bold"><?php echo ($bj2c["alm_content"]); ?></div>
									</div>
								</li>
							</a><?php endforeach; endif; ?>


				</ul>
				<div class="listfooter">
					<div><p>当日电能</p><p id="num2cydl"><?php if($list2c["ydl"] == ''): ?>0Kwh<?php else: echo ($list2c["ydl"]); ?>Kwh<?php endif; ?></p></div>
					<div><p>当日水能</p><p id="num2cysl"><?php if($list2c["ysl"] == ''): ?>0T<?php else: echo ($list2c["ysl"]); ?>T<?php endif; ?></p></div>
					<div><p>当日热能</p><p id="num2cynl"><?php if($list2c["ynl"] == ''): ?>0Kwh<?php else: echo ($list2c["ynl"]); ?>Kwh<?php endif; ?></p></div>
					<div><p>当日冷能</p><p id="num2cyll"><?php if($list2c["yll"] == ''): ?>0Kwh<?php else: echo ($list2c["yll"]); ?>Kwh<?php endif; ?></p></div>
				</div>
			</div>
		</div>

		<div class="energy_message1 energy_message">

				<?php if($alarmcount_bj2d != 0): ?><header style="background: #fc9900;cursor: pointer;"><p class="fl">2#D座（报警总数：<?php echo ($alarmcount_bj2d); ?>条）</p><span class="fr zhankai"><a style="color: white" href="/szny/index.php/Admin/Rg/indexparkoverviewshell?regionlevel=region&rgn_atpid=guidF7E28F9A-E04C-4030-86E5-73A84A0B6CAD">更多</a></span></header>
					<?php else: ?>
					<header style="cursor: pointer;"><p class="fl">2#D座</p><span class="fr zhankai"><a style="color: white" href="/szny/index.php/Admin/Rg/indexparkoverviewshell?regionlevel=region&rgn_atpid=guidF7E28F9A-E04C-4030-86E5-73A84A0B6CAD">更多</a></span></header><?php endif; ?>


			<div class="alarmlist border_bottom">
				<ul class="num2d">

						<?php if(is_array($bj2d)): foreach($bj2d as $key=>$bj2d): ?><a href="/szny/index.php/Admin/Rg/indexparkoverviewshell?regionlevel=region&rgn_atpid=guidF7E28F9A-E04C-4030-86E5-73A84A0B6CAD&rgn_atpidcurrent=<?php echo ($bj1["rgn_atpid"]); ?>">
								<li class="border_bottom clearfix">
									<div class="fl tips"><?php echo ($bj2d["dev_name"]); ?></div>
									<div class="ll content">
										<div class="fl bold"><?php echo ($bj2d["rgn_name"]); ?></div>
										<div class="fr text_right bold"><?php echo ($bj2d["alm_datetime"]); ?></div><br>
										<div class="fl bold"><?php echo ($bj2d["alm_content"]); ?></div>
									</div>
								</li>
							</a><?php endforeach; endif; ?>


				</ul>
				<div class="listfooter">
					<div><p>当日电能</p><p id="num2dydl"><?php if($list2d["ydl"] == ''): ?>0Kwh<?php else: echo ($list2d["ydl"]); ?>Kwh<?php endif; ?></p></div>
					<div><p>当日水能</p><p id="num2dysl"><?php if($list2d["ysl"] == ''): ?>0T<?php else: echo ($list2d["ysl"]); ?>T<?php endif; ?></p></div>
					<div><p>当日热能</p><p id="num2dynl"><?php if($list2d["ynl"] == ''): ?>0Kwh<?php else: echo ($list2d["ynl"]); ?>Kwh<?php endif; ?></p></div>
					<div><p>当日冷能</p><p id="num2dyll"><?php if($list2d["yll"] == ''): ?>0Kwh<?php else: echo ($list2d["yll"]); ?>Kwh<?php endif; ?></p></div>
				</div>
			</div>
		</div>

		<div class="energy_message6 energy_message">

				<?php if($alarmcount_bj2e != 0): ?><header style="background: #fc9900;cursor: pointer;"><p class="fl">2#E座（报警总数：<?php echo ($alarmcount_bj2e); ?>条）</p><span class="fr zhankai"><a style="color: white" href="/szny/index.php/Admin/Rg/indexparkoverviewshell?regionlevel=region&rgn_atpid=guid39E40DE8-E7B3-40D8-B8A8-E5C69AF1EBF5">更多</a></span></header>
					<?php else: ?>
					<header style="cursor: pointer;"><p class="fl">2#E座</p><span class="fr zhankai"><a style="color: white" href="/szny/index.php/Admin/Rg/indexparkoverviewshell?regionlevel=region&rgn_atpid=guid39E40DE8-E7B3-40D8-B8A8-E5C69AF1EBF5">更多</a></span></header><?php endif; ?>


			<div class="alarmlist border_bottom">
				<ul class="num2e">

						<?php if(is_array($bj2e)): foreach($bj2e as $key=>$bj2e): ?><a href="/szny/index.php/Admin/Rg/indexparkoverviewshell?regionlevel=region&rgn_atpid=guid39E40DE8-E7B3-40D8-B8A8-E5C69AF1EBF5&rgn_atpidcurrent=<?php echo ($bj1["rgn_atpid"]); ?>">
								<li class="border_bottom clearfix">
									<div class="fl tips"><?php echo ($bj2e["dev_name"]); ?></div>
									<div class="ll content">
										<div class="fl bold"><?php echo ($bj2e["rgn_name"]); ?></div>
										<div class="fr text_right bold"><?php echo ($bj2e["alm_datetime"]); ?></div><br>
										<div class="fl bold"><?php echo ($bj2e["alm_content"]); ?></div>
									</div>
								</li>
							</a><?php endforeach; endif; ?>


				</ul>
				<div class="listfooter">
					<div><p>当日电能</p><p id="num2eydl"><?php if($list2e["ydl"] == ''): ?>0Kwh<?php else: echo ($list2e["ydl"]); ?>Kwh<?php endif; ?></p></div>
					<div><p>当日水能</p><p id="num2eysl"><?php if($list2e["ysl"] == ''): ?>0T<?php else: echo ($list2e["ysl"]); ?>T<?php endif; ?></p></div>
					<div><p>当日热能</p><p id="num2eynl"><?php if($list2e["ynl"] == ''): ?>0Kwh<?php else: echo ($list2e["ynl"]); ?>Kwh<?php endif; ?></p></div>
					<div><p>当日冷能</p><p id="num2eyll"><?php if($list2e["yll"] == ''): ?>0Kwh<?php else: echo ($list2e["yll"]); ?>Kwh<?php endif; ?></p></div>
				</div>
			</div>
		</div>


		<div class="energy_message5 energy_message">

				<?php if($alarmcount_bj2f != 0): ?><header style="background: #fc9900;cursor: pointer;"><p class="fl">2#F座（报警总数：<?php echo ($alarmcount_bj2f); ?>条）</p><span class="fr zhankai"><a style="color: white" href="/szny/index.php/Admin/Rg/indexparkoverviewshell?regionlevel=region&rgn_atpid=guid75D5A56E-A723-4E16-AAF9-97E86195E0AF">更多</a></span></header>
					<?php else: ?>
					<header style="cursor: pointer;"><p class="fl">2#F座</p><span class="fr zhankai"><a style="color: white" href="/szny/index.php/Admin/Rg/indexparkoverviewshell?regionlevel=region&rgn_atpid=guid75D5A56E-A723-4E16-AAF9-97E86195E0AF">更多</a></span></header><?php endif; ?>


			<div class="alarmlist border_bottom">
				<ul class="num2f">

						<?php if(is_array($bj2f)): foreach($bj2f as $key=>$bj2f): ?><a href="/szny/index.php/Admin/Rg/indexparkoverviewshell?regionlevel=region&rgn_atpid=guid75D5A56E-A723-4E16-AAF9-97E86195E0AF&rgn_atpidcurrent=<?php echo ($bj1["rgn_atpid"]); ?>">
								<li class="border_bottom clearfix">
									<div class="fl tips"><?php echo ($bj2f["dev_name"]); ?></div>
									<div class="ll content">
										<div class="fl bold"><?php echo ($bj2f["rgn_name"]); ?></div>
										<div class="fr text_right bold"><?php echo ($bj2f["alm_datetime"]); ?></div><br>
										<div class="fl bold"><?php echo ($bj2f["alm_content"]); ?></div>
									</div>
								</li>
							</a><?php endforeach; endif; ?>


				</ul>
				<div class="listfooter">
					<div><p>当日电能</p><p id="num2fydl"><?php if($list2f["ydl"] == ''): ?>0Kwh<?php else: echo ($list2f["ydl"]); ?>Kwh<?php endif; ?></p></div>
					<div><p>当日水能</p><p id="num2fysl"><?php if($list2f["ysl"] == ''): ?>0T<?php else: echo ($list2f["ysl"]); ?>T<?php endif; ?></p></div>
					<div><p>当日热能</p><p id="num2fynl"><?php if($list2f["ynl"] == ''): ?>0Kwh<?php else: echo ($list2f["ynl"]); ?>Kwh<?php endif; ?></p></div>
					<div><p>当日冷能</p><p id="num2fyll"><?php if($list2f["yll"] == ''): ?>0Kwh<?php else: echo ($list2f["yll"]); ?>Kwh<?php endif; ?></p></div>
				</div>
			</div>
		</div>
		<div class="energy_message8 energy_message">

				<?php if($alarmcount_bj3 != 0): ?><header style="background: #fc9900;cursor: pointer;"><p class="fl">3#楼（报警总数：<?php echo ($alarmcount_bj3); ?>条）</p><span class="fr zhankai"><a style="color: white" href="/szny/index.php/Admin/Rg/indexparkoverviewshell?regionlevel=region&rgn_atpid=guidF5B91891-FC25-4448-84B9-0D7A544EFE6C">更多</a></span></header>
					<?php else: ?>
					<header style="cursor: pointer;"><p class="fl">3#楼</p><span class="fr zhankai"><a style="color: white" href="/szny/index.php/Admin/Rg/indexparkoverviewshell?regionlevel=region&rgn_atpid=guidF5B91891-FC25-4448-84B9-0D7A544EFE6C">更多</a></span></header><?php endif; ?>


			<div class="alarmlist border_bottom">
				<ul class="num3">

						<?php if(is_array($bj3)): foreach($bj3 as $key=>$bj3): ?><a href="/szny/index.php/Admin/Rg/indexparkoverviewshell?regionlevel=region&rgn_atpid=guidF5B91891-FC25-4448-84B9-0D7A544EFE6C&rgn_atpidcurrent=<?php echo ($bj1["rgn_atpid"]); ?>">
								<li class="border_bottom clearfix">
									<div class="fl tips"><?php echo ($bj3["dev_name"]); ?></div>
									<div class="ll content">
										<div class="fl bold"><?php echo ($bj3["rgn_name"]); ?></div>
										<div class="fr text_right bold"><?php echo ($bj3["alm_datetime"]); ?></div><br>
										<div class="fl bold"><?php echo ($bj3["alm_content"]); ?></div>
									</div>
								</li>
							</a><?php endforeach; endif; ?>


				</ul>
				<div class="listfooter">
					<div><p>当日电能</p><p id="num3ydl"><?php if($list3["ydl"] == ''): ?>0Kwh<?php else: echo ($list3["ydl"]); ?>Kwh<?php endif; ?></p></div>
					<div><p>当日水能</p><p id="num3ysl"><?php if($list3["ysl"] == ''): ?>0T<?php else: echo ($list3["ysl"]); ?>T<?php endif; ?></p></div>
					<div><p>当日热能</p><p id="num3ynl"><?php if($list3["ynl"] == ''): ?>0Kwh<?php else: echo ($list3["ynl"]); ?>Kwh<?php endif; ?></p></div>
					<div><p>当日冷能</p><p id="num3yll"><?php if($list3["yll"] == ''): ?>0Kwh<?php else: echo ($list3["yll"]); ?>Kwh<?php endif; ?></p></div>
				</div>
			</div>
		</div>
		<div class="energy_message9 energy_message">

				<?php if($alarmcount_bj4 != 0): ?><header style="background: #fc9900;cursor: pointer;"><p class="fl">4#楼（报警总数：<?php echo ($alarmcount_bj4); ?>条）</p><span class="fr zhankai"><a style="color: white" href="/szny/index.php/Admin/Rg/indexparkoverviewshell?regionlevel=region&rgn_atpid=guid8E6723F6-09D3-4CFF-B3AD-812A7F784201">更多</a></span></header>
					<?php else: ?>
					<header style="cursor: pointer;"><p class="fl">4#楼</p><span class="fr zhankai"><a style="color: white" href="/szny/index.php/Admin/Rg/indexparkoverviewshell?regionlevel=region&rgn_atpid=guid8E6723F6-09D3-4CFF-B3AD-812A7F784201">更多</a></span></header><?php endif; ?>


			<div class="alarmlist border_bottom">
				<ul class="num4">

						<?php if(is_array($bj4)): foreach($bj4 as $key=>$bj4): ?><a href="/szny/index.php/Admin/Rg/indexparkoverviewshell?regionlevel=region&rgn_atpid=guid8E6723F6-09D3-4CFF-B3AD-812A7F784201&rgn_atpidcurrent=<?php echo ($bj1["rgn_atpid"]); ?>">
								<li class="border_bottom clearfix">
									<div class="fl tips"><?php echo ($bj4["dev_name"]); ?></div>
									<div class="ll content">
										<div class="fl bold"><?php echo ($bj4["rgn_name"]); ?></div>
										<div class="fr text_right bold"><?php echo ($bj4["alm_datetime"]); ?></div><br>
										<div class="fl bold"><?php echo ($bj4["alm_content"]); ?></div>
									</div>
								</li>
							</a><?php endforeach; endif; ?>

				</ul>
				<div class="listfooter">
					<div><p>当日电能</p><p id="num4ydl"><?php if($list4["ydl"] == ''): ?>0Kwh<?php else: echo ($list4["ydl"]); ?>Kwh<?php endif; ?></p></div>
					<div><p>当日水能</p><p id="num4ysl"><?php if($list4["ysl"] == ''): ?>0T<?php else: echo ($list4["ysl"]); ?>T<?php endif; ?></p></div>
					<div><p>当日热能</p><p id="num4ynl"><?php if($list4["ynl"] == ''): ?>0Kwh<?php else: echo ($list4["ynl"]); ?>Kwh<?php endif; ?></p></div>
					<div><p>当日冷能</p><p id="num4yll"><?php if($list4["yll"] == ''): ?>0Kwh<?php else: echo ($list4["yll"]); ?>Kwh<?php endif; ?></p></div>
				</div>
			</div>
		</div>
		<div class="energy_message10 energy_message">

				<?php if($alarmcount_bj5 != 0): ?><header style="background: #fc9900;cursor: pointer;"><p class="fl">5#楼（报警总数：<?php echo ($alarmcount_bj5); ?>条）</p><span class="fr zhankai"><a style="color: white" href="/szny/index.php/Admin/Rg/indexparkoverviewshell?regionlevel=region&rgn_atpid=guidDDE6FF51-B4DD-42C1-962A-ED42D5120E88">更多</a></span></header>
					<?php else: ?>
					<header style="cursor: pointer;"><p class="fl">5#楼</p><span class="fr zhankai"><a style="color: white" href="/szny/index.php/Admin/Rg/indexparkoverviewshell?regionlevel=region&rgn_atpid=guidDDE6FF51-B4DD-42C1-962A-ED42D5120E88">更多</a></span></header><?php endif; ?>


			<div class="alarmlist border_bottom">
				<ul class="num5">


						<?php if(is_array($bj5)): foreach($bj5 as $key=>$bj5): ?><a href="/szny/index.php/Admin/Rg/indexparkoverviewshell?regionlevel=region&rgn_atpid=guidDDE6FF51-B4DD-42C1-962A-ED42D5120E88&rgn_atpidcurrent=<?php echo ($bj1["rgn_atpid"]); ?>">
								<li class="border_bottom clearfix">
									<div class="fl tips"><?php echo ($bj5["dev_name"]); ?></div>
									<div class="ll content">
										<div class="fl bold"><?php echo ($bj5["rgn_name"]); ?></div>
										<div class="fr text_right bold"><?php echo ($bj5["alm_datetime"]); ?></div><br>
										<div class="fl bold"><?php echo ($bj5["alm_content"]); ?></div>
									</div>
								</li>
							</a><?php endforeach; endif; ?>


				</ul>
				<div class="listfooter">
					<div><p>当日电能</p><p id="num5ydl"><?php if($list5["ydl"] == ''): ?>0Kwh<?php else: echo ($list5["ydl"]); ?>Kwh<?php endif; ?></p></div>
					<div><p>当日水能</p><p id="num5ysl"><?php if($list5["ysl"] == ''): ?>0T<?php else: echo ($list5["ysl"]); ?>T<?php endif; ?></p></div>
					<div><p>当日热能</p><p id="num5ynl"><?php if($list5["ynl"] == ''): ?>0Kwh<?php else: echo ($list5["ynl"]); ?>Kwh<?php endif; ?></p></div>
					<div><p>当日冷能</p><p id="num5yll"><?php if($list5["yll"] == ''): ?>0Kwh<?php else: echo ($list5["yll"]); ?>Kwh<?php endif; ?></p></div>
				</div>
			</div>
		</div>
		<div class="energy_message11 energy_message">

				<?php if($alarmcount_bj6 != 0): ?><header style="background: #fc9900;cursor: pointer;"><p class="fl">6#楼（报警总数：<?php echo ($alarmcount_bj6); ?>条）</p><span class="fr zhankai"><a style="color: white" href="/szny/index.php/Admin/Rg/indexparkoverviewshell?regionlevel=region&rgn_atpid=guidFEAFFDFB-4628-46D2-B39B-46F1EC76EF07">更多</a></span></header>
					<?php else: ?>
					<header style="cursor: pointer;"><p class="fl">6#楼</p><span class="fr zhankai"><a style="color: white" href="/szny/index.php/Admin/Rg/indexparkoverviewshell?regionlevel=region&rgn_atpid=guidFEAFFDFB-4628-46D2-B39B-46F1EC76EF07">更多</a></span></header><?php endif; ?>


			<div class="alarmlist border_bottom">
				<ul class="num6">

						<?php if(is_array($bj6)): foreach($bj6 as $key=>$bj6): ?><a href="/szny/index.php/Admin/Rg/indexparkoverviewshell?regionlevel=region&rgn_atpid=guidFEAFFDFB-4628-46D2-B39B-46F1EC76EF07&rgn_atpidcurrent=<?php echo ($bj1["rgn_atpid"]); ?>">
								<li class="border_bottom clearfix">
									<div class="fl tips"><?php echo ($bj6["dev_name"]); ?></div>
									<div class="ll content">
										<div class="fl bold"><?php echo ($bj6["rgn_name"]); ?></div>
										<div class="fr text_right bold"><?php echo ($bj6["alm_datetime"]); ?></div><br>
										<div class="fl bold"><?php echo ($bj6["alm_content"]); ?></div>
									</div>
								</li>
							</a><?php endforeach; endif; ?>


				</ul>
				<div class="listfooter">
					<div><p>当日电能</p><p id="num6ydl"><?php if($list6["ydl"] == ''): ?>0Kwh<?php else: echo ($list6["ydl"]); ?>Kwh<?php endif; ?></p></div>
					<div><p>当日水能</p><p id="num6ysl"><?php if($list6["ysl"] == ''): ?>0T<?php else: echo ($list6["ysl"]); ?>T<?php endif; ?></p></div>
					<div><p>当日热能</p><p id="num6ynl"><?php if($list6["ynl"] == ''): ?>0Kwh<?php else: echo ($list6["ynl"]); ?>Kwh<?php endif; ?></p></div>
					<div><p>当日冷能</p><p id="num6yll"><?php if($list6["yll"] == ''): ?>0Kwh<?php else: echo ($list6["yll"]); ?>Kwh<?php endif; ?></p></div>
				</div>
			</div>
		</div>
		<div class="energy_message12 energy_message">

				<?php if($alarmcount_bj7 != 0): ?><header style="background: #fc9900;cursor: pointer;"><p class="fl">7#楼（报警总数：<?php echo ($alarmcount_bj7); ?>条）</p><span class="fr zhankai"><a style="color: white" href="/szny/index.php/Admin/Rg/indexparkoverviewshell?regionlevel=region&rgn_atpid=guidC65AC6F2-6962-470C-9367-FF87BA1CD5CC">更多</a></span></header>
					<?php else: ?>
					<header style="cursor: pointer;"><p class="fl">7#楼</p><span class="fr zhankai"><a style="color: white" href="/szny/index.php/Admin/Rg/indexparkoverviewshell?regionlevel=region&rgn_atpid=guidC65AC6F2-6962-470C-9367-FF87BA1CD5CC">更多</a></span></header><?php endif; ?>


			<div class="alarmlist border_bottom">
				<ul class="num7">

						<?php if(is_array($bj7)): foreach($bj7 as $key=>$bj7): ?><a href="/szny/index.php/Admin/Rg/indexparkoverviewshell?regionlevel=region&rgn_atpid=guidC65AC6F2-6962-470C-9367-FF87BA1CD5CC&rgn_atpidcurrent=<?php echo ($bj1["rgn_atpid"]); ?>">
								<li class="border_bottom clearfix">
									<div class="fl tips"><?php echo ($bj7["dev_name"]); ?></div>
									<div class="ll content">
										<div class="fl bold"><?php echo ($bj7["rgn_name"]); ?></div>
										<div class="fr text_right bold"><?php echo ($bj7["alm_datetime"]); ?></div><br>
										<div class="fl bold"><?php echo ($bj7["alm_content"]); ?></div>
									</div>
								</li>
							</a><?php endforeach; endif; ?>


				</ul>
				<div class="listfooter">
					<div><p>当日电能</p><p id="num7ydl"><?php if($list7["ydl"] == ''): ?>0Kwh<?php else: echo ($list7["ydl"]); ?>Kwh<?php endif; ?></p></div>
					<div><p>当日水能</p><p id="num7ysl"><?php if($list7["ysl"] == ''): ?>0T<?php else: echo ($list7["ysl"]); ?>T<?php endif; ?></p></div>
					<div><p>当日热能</p><p id="num7ynl"><?php if($list7["ynl"] == ''): ?>0Kwh<?php else: echo ($list7["ynl"]); ?>Kwh<?php endif; ?></p></div>
					<div><p>当日冷能</p><p id="num7yll"><?php if($list7["yll"] == ''): ?>0Kwh<?php else: echo ($list7["yll"]); ?>Kwh<?php endif; ?></p></div>
				</div>
			</div>
		</div>
		<div class="energy_message13 energy_message">

				<?php if($alarmcount_bj8 != 0): ?><header style="background: #fc9900;cursor: pointer;"><p class="fl">8#楼（报警总数：<?php echo ($alarmcount_bj8); ?>条）</p><span class="fr zhankai"><a style="color: white" href="/szny/index.php/Admin/Rg/indexparkoverviewshell?regionlevel=region&rgn_atpid=guidB44A77BC-907D-42AC-812D-3E401E40B6CA">更多</a></span></header>
					<?php else: ?>
					<header style="cursor: pointer;"><p class="fl">8#楼</p><span class="fr zhankai"><a style="color: white" href="/szny/index.php/Admin/Rg/indexparkoverviewshell?regionlevel=region&rgn_atpid=guidB44A77BC-907D-42AC-812D-3E401E40B6CA">更多</a></span></header><?php endif; ?>


			<div class="alarmlist border_bottom">
				<ul class="num8">

						<?php if(is_array($bj8)): foreach($bj8 as $key=>$bj8): ?><a href="/szny/index.php/Admin/Rg/indexparkoverviewshell?regionlevel=region&rgn_atpid=guidB44A77BC-907D-42AC-812D-3E401E40B6CA&rgn_atpidcurrent=<?php echo ($bj1["rgn_atpid"]); ?>">
								<li class="border_bottom clearfix">
									<div class="fl tips"><?php echo ($bj8["dev_name"]); ?></div>
									<div class="ll content">
										<div class="fl bold"><?php echo ($bj8["rgn_name"]); ?></div>
										<div class="fr text_right bold"><?php echo ($bj8["alm_datetime"]); ?></div><br>
										<div class="fl bold"><?php echo ($bj8["alm_content"]); ?></div>
									</div>
								</li>
							</a><?php endforeach; endif; ?>


				</ul>
				<div class="listfooter">
					<div><p>当日电能</p><p id="num8ydl"><?php if($list8["ydl"] == ''): ?>0Kwh<?php else: echo ($list8["ydl"]); ?>Kwh<?php endif; ?></p></div>
					<div><p>当日水能</p><p id="num8ysl"><?php if($list8["ysl"] == ''): ?>0T<?php else: echo ($list8["ysl"]); ?>T<?php endif; ?></p></div>
					<div><p>当日热能</p><p id="num8ynl"><?php if($list8["ynl"] == ''): ?>0Kwh<?php else: echo ($list8["ynl"]); ?>Kwh<?php endif; ?></p></div>
					<div><p>当日冷能</p><p id="num8yll"><?php if($list8["yll"] == ''): ?>0Kwh<?php else: echo ($list8["yll"]); ?>Kwh<?php endif; ?></p></div>
				</div>
			</div>
		</div>
		<div class="energy_message14 energy_message">

				<?php if($alarmcount_bj9 != 0): ?><header style="background: #fc9900;cursor: pointer;"><p class="fl">9#楼（报警总数：<?php echo ($alarmcount_bj9); ?>条）</p><span class="fr zhankai"><a style="color: white" href="/szny/index.php/Admin/Rg/indexparkoverviewshell?regionlevel=region&rgn_atpid=guid0CCA3B48-E22B-4636-A0EC-1F0E81AE0F08">更多</a></span></header>
					<?php else: ?>
					<header style="cursor: pointer;"><p class="fl">9#楼</p><span class="fr zhankai"><a style="color: white" href="/szny/index.php/Admin/Rg/indexparkoverviewshell?regionlevel=region&rgn_atpid=guid0CCA3B48-E22B-4636-A0EC-1F0E81AE0F08">更多</a></span></header><?php endif; ?>

			<div class="alarmlist border_bottom">
				<ul class="num9">

						<?php if(is_array($bj9)): foreach($bj9 as $key=>$bj9): ?><a href="/szny/index.php/Admin/Rg/indexparkoverviewshell?regionlevel=region&rgn_atpid=guid0CCA3B48-E22B-4636-A0EC-1F0E81AE0F08&rgn_atpidcurrent=<?php echo ($bj1["rgn_atpid"]); ?>">
								<li class="border_bottom clearfix">
									<div class="fl tips"><?php echo ($bj9["dev_name"]); ?></div>
									<div class="ll content">
										<div class="fl bold"><?php echo ($bj9["rgn_name"]); ?></div>
										<div class="fr text_right bold"><?php echo ($bj9["alm_datetime"]); ?></div><br>
										<div class="fl bold"><?php echo ($bj9["alm_content"]); ?></div>
									</div>
								</li>
							</a><?php endforeach; endif; ?>


				</ul>
				<div class="listfooter">
					<div><p>当日电能</p><p id="num9ydl"><?php if($list9["ydl"] == ''): ?>0Kwh<?php else: echo ($list9["ydl"]); ?>Kwh<?php endif; ?></p></div>
					<div><p>当日水能</p><p id="num9ysl"><?php if($list9["ysl"] == ''): ?>0T<?php else: echo ($list9["ysl"]); ?>T<?php endif; ?></p></div>
					<div><p>当日热能</p><p id="num9ynl"><?php if($list9["ynl"] == ''): ?>0Kwh<?php else: echo ($list9["ynl"]); ?>Kwh<?php endif; ?></p></div>
					<div><p>当日冷能</p><p id="num9yll"><?php if($list9["yll"] == ''): ?>0Kwh<?php else: echo ($list9["yll"]); ?>Kwh<?php endif; ?></p></div>
				</div>
			</div>
		</div>
		<div class="energy_message15 energy_message">

				<?php if($alarmcount_bj10 != 0): ?><header style="background: #fc9900;cursor: pointer;"><p class="fl">10#楼（报警总数：<?php echo ($alarmcount_bj10); ?>条）</p><span class="fr zhankai"><a style="color: white" href="/szny/index.php/Admin/Rg/indexparkoverviewshell?regionlevel=region&rgn_atpid=guid3696CE0E-0616-4B32-8AB2-40AA8DB2E1D6">更多</a></span></header>
					<?php else: ?>
					<header style="cursor: pointer;"><p class="fl">10#楼</p><span class="fr zhankai"><a style="color: white" href="/szny/index.php/Admin/Rg/indexparkoverviewshell?regionlevel=region&rgn_atpid=guid3696CE0E-0616-4B32-8AB2-40AA8DB2E1D6">更多</a></span></header><?php endif; ?>


			<div class="alarmlist border_bottom">
				<ul class="num10">

						<?php if(is_array($bj10)): foreach($bj10 as $key=>$bj10): ?><a href="/szny/index.php/Admin/Rg/indexparkoverviewshell?regionlevel=region&rgn_atpid=guid3696CE0E-0616-4B32-8AB2-40AA8DB2E1D6&rgn_atpidcurrent=<?php echo ($bj1["rgn_atpid"]); ?>">
								<li class="border_bottom clearfix">
									<div class="fl tips"><?php echo ($bj10["dev_name"]); ?></div>
									<div class="ll content">
										<div class="fl bold"><?php echo ($bj10["rgn_name"]); ?></div>
										<div class="fr text_right bold"><?php echo ($bj10["alm_datetime"]); ?></div><br>
										<div class="fl bold"><?php echo ($bj10["alm_content"]); ?></div>
									</div>
								</li>
							</a><?php endforeach; endif; ?>


				</ul>
				<div class="listfooter">
					<div><p>当日电能</p><p id="num10ydl"><?php if($list10["ydl"] == ''): ?>0Kwh<?php else: echo ($list10["ydl"]); ?>Kwh<?php endif; ?></p></div>
					<div><p>当日水能</p><p id="num10ysl"><?php if($list10["ysl"] == ''): ?>0T<?php else: echo ($list10["ysl"]); ?>T<?php endif; ?></p></div>
					<div><p>当日热能</p><p id="num10ynl"><?php if($list10["ynl"] == ''): ?>0Kwh<?php else: echo ($list10["ynl"]); ?>Kwh<?php endif; ?></p></div>
					<div><p>当日冷能</p><p id="num10yll"><?php if($list10["yll"] == ''): ?>0Kwh<?php else: echo ($list10["yll"]); ?>Kwh<?php endif; ?></p></div>
				</div>
			</div>
		</div>
		<div class="energy_message16 energy_message">

				<?php if($alarmcount_bj11 != 0): ?><header style="background: #fc9900;cursor: pointer;"><p class="fl">11#楼（报警总数：<?php echo ($alarmcount_bj11); ?>条）</p><span class="fr zhankai"><a style="color: white" href="/szny/index.php/Admin/Rg/indexparkoverviewshell?regionlevel=region&rgn_atpid=guid1F1285F0-C495-46D7-969A-D3711B12EA28">更多</a></span></header>
					<?php else: ?>
					<header style="cursor: pointer;"><p class="fl">11#楼</p><span class="fr zhankai"><a style="color: white" href="/szny/index.php/Admin/Rg/indexparkoverviewshell?regionlevel=region&rgn_atpid=guid1F1285F0-C495-46D7-969A-D3711B12EA28">更多</a></span></header><?php endif; ?>


			<div class="alarmlist border_bottom">
				<ul class="num11">

						<?php if(is_array($bj11)): foreach($bj11 as $key=>$bj11): ?><a href="/szny/index.php/Admin/Rg/indexparkoverviewshell?regionlevel=region&rgn_atpid=guid1F1285F0-C495-46D7-969A-D3711B12EA28&rgn_atpidcurrent=<?php echo ($bj11["rgn_atpid"]); ?>">
								<li class="border_bottom clearfix">
									<div class="fl tips"><?php echo ($bj11["dev_name"]); ?></div>
									<div class="ll content">
										<div class="fl bold"><?php echo ($bj11["rgn_name"]); ?></div>
										<div class="fr text_right bold"><?php echo ($bj11["alm_datetime"]); ?></div><br>
										<div class="fl bold"><?php echo ($bj11["alm_content"]); ?></div>
									</div>
								</li>
							</a><?php endforeach; endif; ?>


				</ul>
				<div class="listfooter">
					<div><p>当日电能</p><p id="num11ydl"><?php if($list11["ydl"] == ''): ?>0Kwh<?php else: echo ($list11["ydl"]); ?>Kwh<?php endif; ?></p></div>
					<div><p>当日水能</p><p id="num11ysl"><?php if($list11["ysl"] == ''): ?>0T<?php else: echo ($list11["ysl"]); ?>T<?php endif; ?></p></div>
					<div><p>当日热能</p><p id="num11ynl"><?php if($list11["ynl"] == ''): ?>0Kwh<?php else: echo ($list11["ynl"]); ?>Kwh<?php endif; ?></p></div>
					<div><p>当日冷能</p><p id="num11yll"><?php if($list11["yll"] == ''): ?>0Kwh<?php else: echo ($list11["yll"]); ?>Kwh<?php endif; ?></p></div>
				</div>
			</div>
		</div>
	</div>

	<div class="total1" style="display: block">
		<header><p class="fl">园区能源状况&nbsp;&nbsp;<span id="updateinfo" style="font-size: 8px;"><?php echo '刷新时间:'.date('G:i:s').'(频率60秒)'; ?></span></p></header>



		<div style="padding-top: 10px;padding-left: 10px;;width:300px;height:160px;border-bottom: 1px solid #ccc;font-size: 14px;">
			<table border="1px" width="280px" align="center">
				<tr>
					<td align="center" width="100px"><b>类别</b></td>
					<td align="center"><b>本月消耗</b></td>
					<td align="center"><b>上月消耗</b></td>
				</tr>
				<tr>
					<td align="left" style="padding: 5px;"><i class="green"></i>电能(Kwh)</td>
					<td align="center"><p id="byydl"><?php echo ($byydl); ?></p></td>
					<td align="center"><p id="syydl"><?php echo ($syydl); ?></p></td>
				</tr>
				<tr>
					<td align="left" style="padding: 5px;"><i class="blue"></i>水能(T)</td>
					<td align="center"><p id="byysl"><?php echo ($byysl); ?></p></td>
					<td align="center"><p id="syysl"><?php echo ($syysl); ?></p></td>
				</tr>
				<tr>
					<td align="left" style="padding: 5px;"><i class="orange"></i>暖能(Kwh)</td>
					<td align="center"><p id="byynl"><?php echo ($byynl); ?></p></td>
					<td align="center"><p id="syynl"><?php echo ($syynl); ?></p></td>
				</tr>
				<tr>
					<td align="left" style="padding: 5px;"><i class="qing"></i>冷能(Kwh)</td>
					<td align="center"><p id="byyll"><?php echo ($byyll); ?></p></td>
					<td align="center"><p id="syyll"><?php echo ($syyll); ?></p></td>
				</tr>
			</table>
		</div>
		<div class="listfooter  border_top">
			<div><p>全年用电</p><p id="qnydl"><?php echo ($qnydl); ?></p>Kwh</div>
			<div><p>全年用水</p><p id="qnysl"><?php echo ($qnysl); ?></p>T</div>
			<div><p>全年用冷</p><p id="qnyll"><?php echo ($qnyll); ?></p>Kwh</div>
			<div><p>全年用暖</p><p id="qnynl"><?php echo ($qnynl); ?></p>Kwh</div>
		</div>
	</div>

<script src="/szny/Public/vendor/diy_component/yuanqu_page/js/jquery-1.7.2.js"></script>
<script src="/szny/Public/vendor/diy_component/yuanqu_page/js/highcharts.js"></script>
<script src="/szny/Public/vendor/diy_component/yuanqu_page/js/highcharts-more.js"></script>
<script>


setInterval(function(){
	// 数据对比
	$.ajax({
       url: '/szny/index.php/Admin/ParkoverviewGataindex/ajax',
       type: 'POST',
       data: {},
       async:false,
       success: function (data) {
		   if (data) {
			   newdata = JSON.parse(data);
			   $("#updateinfo").html("刷新时间:" + getNowFormatDate() + "(频率:60秒)");
			   $("#byydl").html(newdata['nenghao'].byydl);
			   $("#syydl").html(newdata['nenghao'].syydl);
			   $("#byysl").html(newdata['nenghao'].byysl);
			   $("#syysl").html(newdata['nenghao'].syysl);
			   $("#byynl").html(newdata['nenghao'].byynl);
			   $("#syynl").html(newdata['nenghao'].syynl);
			   $("#byyll").html(newdata['nenghao'].byyll);
			   $("#syyll").html(newdata['nenghao'].syyll);
			   $("#qnydl").html(newdata['nenghao'].qnydl);
			   $("#qnysl").html(newdata['nenghao'].qnysl);
			   $("#qnynl").html(newdata['nenghao'].qnynl);
			   $("#qnyll").html(newdata['nenghao'].qnyll);

			   // 1号楼
			   $(".num1").html("");
			   if (newdata['newarr1'].length != 0) {
				   var tstr = "";
				   newdata['newarr1'].forEach(function (value, index, array) {
					   tstr += "<a href='/szny/index.php/Admin/Rg/indexparkoverviewshell?rgn_atpid=" + newdata['newarr1'][index].rgn_atpid + "'><li class='border_bottom clearfix'>" +
							   "<div class='fl tips'>" + newdata['newarr1'][index].dev_name + "</div>" +
							   "<div class='ll content'>" +
							   "<div class='fl bold'>" + newdata['newarr1'][index].rgn_name + "</div>" +
							   "<div class='fr text_right bold'>" + newdata['newarr1'][index].alm_datetime + "</div><br>" +
							   "<div class='fl bold'>" + newdata['newarr1'][index].alm_content + "</div>" +
							   "</div>" +
							   "</li></a>";
				   });
				   $(".num1").html(tstr);
				   $(".energy_message7").find("header").css("background", "#fc9900");
				   $(".energy_message7").find("header").find("p").text("1#楼（报警总数："+ newdata['newarrdata1'].alarmcount +"条）");
			   }
			   else {
				   $(".energy_message7").find("header").css("background", "#0B3D85");
				   $(".energy_message7").find("header").find("p").text("1#楼");
			   }
			   $("#num1ydl").html(newdata['newarrdata1'].ydl1 + "Kwh");
			   $("#num1ysl").html(newdata['newarrdata1'].ysl1 + "T");
			   $("#num1ynl").html(newdata['newarrdata1'].ynl1 + "Kwh");
			   $("#num1yll").html(newdata['newarrdata1'].yll1 + "Kwh");

			   // 2a号楼
			   $(".num2a").html("");
			   if (newdata['newarr2a'].length != 0) {
				   var tstr = "";
				   newdata['newarr2a'].forEach(function (value, index, array) {
					   tstr += "<a href='/szny/index.php/Admin/Rg/indexparkoverviewshell?rgn_atpid=" + newdata['newarr2a'][index].rgn_atpid + "'><li class='border_bottom clearfix'>" +
							   "<div class='fl tips'>" + newdata['newarr2a'][index].dev_name + "</div>" +
							   "<div class='ll content'>" +
							   "<div class='fl bold'>" + newdata['newarr2a'][index].rgn_name + "</div>" +
							   "<div class='fr text_right bold'>" + newdata['newarr2a'][index].alm_datetime + "</div><br>" +
							   "<div class='fl bold'>" + newdata['newarr2a'][index].alm_content + "</div>" +
							   "</div>" +
							   "</li></a>";
				   });
				   $(".num2a").html(tstr);
				   $(".energy_message3").find("header").css("background", "#fc9900");
				   $(".energy_message3").find("header").find("p").text("2#A座（报警总数："+ newdata['newarrdata2a'].alarmcount +"条）");
			   }
			   else {
				   $(".energy_message3").find("header").css("background", "#0B3D85");
				   $(".energy_message3").find("header").find("p").text("2#A座");
			   }
			   $("#num2aydl").html(newdata['newarrdata2a'].ydl2a + "Kwh");
			   $("#num2aysl").html(newdata['newarrdata2a'].ysl2a + "T");
			   $("#num2aynl").html(newdata['newarrdata2a'].ynl2a + "Kwh");
			   $("#num2ayll").html(newdata['newarrdata2a'].yll2a + "Kwh");

			   // 2b号楼
			   $(".num2b").html("");
			   if (newdata['newarr2b'].length != 0) {
				   var tstr = "";
				   newdata['newarr2b'].forEach(function (value, index, array) {
					   tstr += "<a href='/szny/index.php/Admin/Rg/indexparkoverviewshell?rgn_atpid=" + newdata['newarr2b'][index].rgn_atpid + "'><li class='border_bottom clearfix'>" +
							   "<div class='fl tips'>" + newdata['newarr2b'][index].dev_name + "</div>" +
							   "<div class='ll content'>" +
							   "<div class='fl bold'>" + newdata['newarr2b'][index].rgn_name + "</div>" +
							   "<div class='fr text_right bold'>" + newdata['newarr2b'][index].alm_datetime + "</div><br>" +
							   "<div class='fl bold'>" + newdata['newarr2b'][index].alm_content + "</div>" +
							   "</div>" +
							   "</li></a>";
				   });
				   $(".num2b").html(tstr);
				   $(".energy_message2").find("header").css("background", "#fc9900");
				   $(".energy_message2").find("header").find("p").text("2#B座（报警总数："+ newdata['newarrdata2b'].alarmcount +"条）");
			   }
			   else {
				   $(".energy_message2").find("header").css("background", "#0B3D85");
				   $(".energy_message2").find("header").find("p").text("2#B座");
			   }
			   $("#num2bydl").html(newdata['newarrdata2b'].ydl2b + "Kwh");
			   $("#num2bysl").html(newdata['newarrdata2b'].ysl2b + "T");
			   $("#num2bynl").html(newdata['newarrdata2b'].ynl2b + "Kwh");
			   $("#num2byll").html(newdata['newarrdata2b'].yll2b + "Kwh");


			   // 2c号楼
			   $(".num2c").html("");
			   if (newdata['newarr2c'].length != 0) {
				   var tstr = "";
				   newdata['newarr2c'].forEach(function (value, index, array) {
					   tstr += "<a href='/szny/index.php/Admin/Rg/indexparkoverviewshell?rgn_atpid=" + newdata['newarr2c'][index].rgn_atpid + "'><li class='border_bottom clearfix'>" +
							   "<div class='fl tips'>" + newdata['newarr2c'][index].dev_name + "</div>" +
							   "<div class='ll content'>" +
							   "<div class='fl bold'>" + newdata['newarr2c'][index].rgn_name + "</div>" +
							   "<div class='fr text_right bold'>" + newdata['newarr2c'][index].alm_datetime + "</div><br>" +
							   "<div class='fl bold'>" + newdata['newarr2c'][index].alm_content + "</div>" +
							   "</div>" +
							   "</li></a>";
				   });
				   $(".num2c").html(tstr);
				   $(".energy_message4").find("header").css("background", "#fc9900");
				   $(".energy_message4").find("header").find("p").text("2#C座（报警总数："+ newdata['newarrdata2c'].alarmcount +"条）");
			   }
			   else {
				   $(".energy_message4").find("header").css("background", "#0B3D85");
				   $(".energy_message4").find("header").find("p").text("2#C座");
			   }
			   $("#num2cydl").html(newdata['newarrdata2c'].ydl2c + "Kwh");
			   $("#num2cysl").html(newdata['newarrdata2c'].ysl2c + "T");
			   $("#num2cynl").html(newdata['newarrdata2c'].ynl2c + "Kwh");
			   $("#num2cyll").html(newdata['newarrdata2c'].yll2c + "Kwh");

			   // 2d号楼
			   $(".num2d").html("");
			   if (newdata['newarr2d'].length != 0) {
				   var tstr = "";
				   newdata['newarr2d'].forEach(function (value, index, array) {
					   tstr += "<a href='/szny/index.php/Admin/Rg/indexparkoverviewshell?rgn_atpid=" + newdata['newarr2d'][index].rgn_atpid + "'><li class='border_bottom clearfix'>" +
							   "<div class='fl tips'>" + newdata['newarr2d'][index].dev_name + "</div>" +
							   "<div class='ll content'>" +
							   "<div class='fl bold'>" + newdata['newarr2d'][index].rgn_name + "</div>" +
							   "<div class='fr text_right bold'>" + newdata['newarr2d'][index].alm_datetime + "</div><br>" +
							   "<div class='fl bold'>" + newdata['newarr2d'][index].alm_content + "</div>" +
							   "</div>" +
							   "</li></a>";
				   });
				   $(".num2d").html(tstr);
				   $(".energy_message1").find("header").css("background", "#fc9900");
				   $(".energy_message1").find("header").find("p").text("2#D座（报警总数："+ newdata['newarrdata2d'].alarmcount +"条）");
			   }
			   else {
				   $(".energy_message1").find("header").css("background", "#0B3D85");
				   $(".energy_message1").find("header").find("p").text("2#D座");
			   }
			   $("#num2dydl").html(newdata['newarrdata2d'].ydl2d + "Kwh");
			   $("#num2dysl").html(newdata['newarrdata2d'].ysl2d + "T");
			   $("#num2dynl").html(newdata['newarrdata2d'].ynl2d + "Kwh");
			   $("#num2dyll").html(newdata['newarrdata2d'].yll2d + "Kwh");


			   // 2e号楼
			   $(".num2e").html("");
			   if (newdata['newarr2e'].length != 0) {
				   var tstr = "";
				   newdata['newarr2e'].forEach(function (value, index, array) {
					   tstr += "<a href='/szny/index.php/Admin/Rg/indexparkoverviewshell?rgn_atpid=" + newdata['newarr2e'][index].rgn_atpid + "'><li class='border_bottom clearfix'>" +
							   "<div class='fl tips'>" + newdata['newarr2e'][index].dev_name + "</div>" +
							   "<div class='ll content'>" +
							   "<div class='fl bold'>" + newdata['newarr2e'][index].rgn_name + "</div>" +
							   "<div class='fr text_right bold'>" + newdata['newarr2e'][index].alm_datetime + "</div><br>" +
							   "<div class='fl bold'>" + newdata['newarr2e'][index].alm_content + "</div>" +
							   "</div>" +
							   "</li></a>";
				   });
				   $(".num2e").html(tstr);
				   $(".energy_message6").find("header").css("background", "#fc9900");
				   $(".energy_message6").find("header").find("p").text("2#E楼（报警总数："+ newdata['newarrdata2e'].alarmcount +"条）");
			   }
			   else {
				   $(".energy_message6").find("header").css("background", "#0B3D85");
				   $(".energy_message6").find("header").find("p").text("2#E楼");
			   }
			   $("#num2eydl").html(newdata['newarrdata2e'].ydl2e + "Kwh");
			   $("#num2eysl").html(newdata['newarrdata2e'].ysl2e + "T");
			   $("#num2eynl").html(newdata['newarrdata2e'].ynl2e + "Kwh");
			   $("#num2eyll").html(newdata['newarrdata2e'].yll2e + "Kwh");


			   // 2f号楼
			   $(".num2f").html("");
			   if (newdata['newarr2f'].length != 0) {
				   var tstr = "";
				   newdata['newarr2f'].forEach(function (value, index, array) {
					   tstr += "<a href='/szny/index.php/Admin/Rg/indexparkoverviewshell?rgn_atpid=" + newdata['newarr2f'][index].rgn_atpid + "'><li class='border_bottom clearfix'>" +
							   "<div class='fl tips'>" + newdata['newarr2f'][index].dev_name + "</div>" +
							   "<div class='ll content'>" +
							   "<div class='fl bold'>" + newdata['newarr2f'][index].rgn_name + "</div>" +
							   "<div class='fr text_right bold'>" + newdata['newarr2f'][index].alm_datetime + "</div><br>" +
							   "<div class='fl bold'>" + newdata['newarr2f'][index].alm_content + "</div>" +
							   "</div>" +
							   "</li></a>";
				   });
				   $(".num2f").html(tstr);
				   $(".energy_message5").find("header").css("background", "#fc9900");
				   $(".energy_message5").find("header").find("p").text("2#F楼（报警总数："+ newdata['newarrdata2f'].alarmcount +"条）");
			   }
			   else {
				   $(".energy_message5").find("header").css("background", "#0B3D85");
				   $(".energy_message5").find("header").find("p").text("2#F楼");
			   }
			   $("#num2fydl").html(newdata['newarrdata2f'].ydl2f + "Kwh");
			   $("#num2fysl").html(newdata['newarrdata2f'].ysl2f + "T");
			   $("#num2fynl").html(newdata['newarrdata2f'].ynl2f + "Kwh");
			   $("#num2fyll").html(newdata['newarrdata2f'].yll2f + "Kwh");


			   // 3号楼
			   $(".num3").html("");
			   if (newdata['newarr3'].length != 0) {
				   var tstr = "";
				   newdata['newarr3'].forEach(function (value, index, array) {
					   tstr += "<a href='/szny/index.php/Admin/Rg/indexparkoverviewshell?rgn_atpid=" + newdata['newarr3'][index].rgn_atpid + "'><li class='border_bottom clearfix'>" +
							   "<div class='fl tips'>" + newdata['newarr3'][index].dev_name + "</div>" +
							   "<div class='ll content'>" +
							   "<div class='fl bold'>" + newdata['newarr3'][index].rgn_name + "</div>" +
							   "<div class='fr text_right bold'>" + newdata['newarr3'][index].alm_datetime + "</div><br>" +
							   "<div class='fl bold'>" + newdata['newarr3'][index].alm_content + "</div>" +
							   "</div>" +
							   "</li></a>";
				   });
				   $(".num3").html(tstr);
				   $(".energy_message8").find("header").css("background", "#fc9900");
				   $(".energy_message8").find("header").find("p").text("3#楼（报警总数："+ newdata['newarrdata3'].alarmcount +"条）");
			   }
			   else {
				   $(".energy_message8").find("header").css("background", "#0B3D85");
				   $(".energy_message8").find("header").find("p").text("3#楼");
			   }
			   $("#num3ydl").html(newdata['newarrdata3'].ydl3 + "Kwh");
			   $("#num3ysl").html(newdata['newarrdata3'].ysl3 + "T");
			   $("#num3ynl").html(newdata['newarrdata3'].ynl3 + "Kwh");
			   $("#num3yll").html(newdata['newarrdata3'].yll3 + "Kwh");

			   // 4号楼
			   $(".num4").html("");
			   if (newdata['newarr4'].length != 0) {
				   var tstr = "";
				   newdata['newarr4'].forEach(function (value, index, array) {
					   tstr += "<a href='/szny/index.php/Admin/Rg/indexparkoverviewshell?rgn_atpid=" + newdata['newarr4'][index].rgn_atpid + "'><li class='border_bottom clearfix'>" +
							   "<div class='fl tips'>" + newdata['newarr4'][index].dev_name + "</div>" +
							   "<div class='ll content'>" +
							   "<div class='fl bold'>" + newdata['newarr4'][index].rgn_name + "</div>" +
							   "<div class='fr text_right bold'>" + newdata['newarr4'][index].alm_datetime + "</div><br>" +
							   "<div class='fl bold'>" + newdata['newarr4'][index].alm_content + "</div>" +
							   "</div>" +
							   "</li></a>";
				   });
				   $(".num4").html(tstr);
				   $(".energy_message9").find("header").css("background", "#fc9900");
				   $(".energy_message9").find("header").find("p").text("4#楼（报警总数："+ newdata['newarrdata4'].alarmcount +"条）");
			   }
			   else {
				   $(".energy_message9").find("header").css("background", "#0B3D85");
				   $(".energy_message9").find("header").find("p").text("4#楼");
			   }
			   $("#num4ydl").html(newdata['newarrdata4'].ydl4 + "Kwh");
			   $("#num4ysl").html(newdata['newarrdata4'].ysl4 + "T");
			   $("#num4ynl").html(newdata['newarrdata4'].ynl4 + "Kwh");
			   $("#num4yll").html(newdata['newarrdata4'].yll4 + "Kwh");


			   // 5号楼
			   $(".num5").html("");
			   if (newdata['newarr5'].length != 0) {
				   var tstr = "";
				   newdata['newarr5'].forEach(function (value, index, array) {
					   tstr += "<a href='/szny/index.php/Admin/Rg/indexparkoverviewshell?rgn_atpid=" + newdata['newarr5'][index].rgn_atpid + "'><li class='border_bottom clearfix'>" +
							   "<div class='fl tips'>" + newdata['newarr5'][index].dev_name + "</div>" +
							   "<div class='ll content'>" +
							   "<div class='fl bold'>" + newdata['newarr5'][index].rgn_name + "</div>" +
							   "<div class='fr text_right bold'>" + newdata['newarr5'][index].alm_datetime + "</div><br>" +
							   "<div class='fl bold'>" + newdata['newarr5'][index].alm_content + "</div>" +
							   "</div>" +
							   "</li></a>";
				   });
				   $(".num5").html(tstr);
				   $(".energy_message10").find("header").css("background", "#fc9900");
				   $(".energy_message10").find("header").find("p").text("5#楼（报警总数："+ newdata['newarrdata5'].alarmcount +"条）");
			   }
			   else {
				   $(".energy_message10").find("header").css("background", "#0B3D85");
				   $(".energy_message10").find("header").find("p").text("5#楼");
			   }
			   $("#num5ydl").html(newdata['newarrdata5'].ydl5 + "Kwh");
			   $("#num5ysl").html(newdata['newarrdata5'].ysl5 + "T");
			   $("#num5ynl").html(newdata['newarrdata5'].ynl5 + "Kwh");
			   $("#num5yll").html(newdata['newarrdata5'].yll5 + "Kwh");


			   // 6号楼
			   $(".num6").html("");
			   if (newdata['newarr6'].length != 0) {
				   var tstr = "";
				   newdata['newarr6'].forEach(function (value, index, array) {
					   tstr += "<a href='/szny/index.php/Admin/Rg/indexparkoverviewshell?rgn_atpid=" + newdata['newarr6'][index].rgn_atpid + "'><li class='border_bottom clearfix'>" +
							   "<div class='fl tips'>" + newdata['newarr6'][index].dev_name + "</div>" +
							   "<div class='ll content'>" +
							   "<div class='fl bold'>" + newdata['newarr6'][index].rgn_name + "</div>" +
							   "<div class='fr text_right bold'>" + newdata['newarr6'][index].alm_datetime + "</div><br>" +
							   "<div class='fl bold'>" + newdata['newarr6'][index].alm_content + "</div>" +
							   "</div>" +
							   "</li></a>";
				   });
				   $(".num6").html(tstr);
				   $(".energy_message11").find("header").css("background", "#fc9900");
				   $(".energy_message11").find("header").find("p").text("6#楼（报警总数："+ newdata['newarrdata6'].alarmcount +"条）");
			   }
			   else {
				   $(".energy_message11").find("header").css("background", "#0B3D85");
				   $(".energy_message11").find("header").find("p").text("6#楼");
			   }
			   $("#num6ydl").html(newdata['newarrdata6'].ydl6 + "Kwh");
			   $("#num6ysl").html(newdata['newarrdata6'].ysl6 + "T");
			   $("#num6ynl").html(newdata['newarrdata6'].ynl6 + "Kwh");
			   $("#num6yll").html(newdata['newarrdata6'].yll6 + "Kwh");


			   // 7号楼
			   $(".num7").html("");
			   if (newdata['newarr7'].length != 0) {
				   var tstr = "";
				   newdata['newarr7'].forEach(function (value, index, array) {
					   tstr += "<a href='/szny/index.php/Admin/Rg/indexparkoverviewshell?rgn_atpid=" + newdata['newarr7'][index].rgn_atpid + "'><li class='border_bottom clearfix'>" +
							   "<div class='fl tips'>" + newdata['newarr7'][index].dev_name + "</div>" +
							   "<div class='ll content'>" +
							   "<div class='fl bold'>" + newdata['newarr7'][index].rgn_name + "</div>" +
							   "<div class='fr text_right bold'>" + newdata['newarr7'][index].alm_datetime + "</div><br>" +
							   "<div class='fl bold'>" + newdata['newarr7'][index].alm_content + "</div>" +
							   "</div>" +
							   "</li></a>";
				   });
				   $(".num7").html(tstr);
				   $(".energy_message12").find("header").css("background", "#fc9900");
				   $(".energy_message12").find("header").find("p").text("7#楼（报警总数："+ newdata['newarrdata7'].alarmcount +"条）");
			   }
			   else {
				   $(".energy_message12").find("header").css("background", "#0B3D85");
				   $(".energy_message12").find("header").find("p").text("7#楼");
			   }
			   $("#num7ydl").html(newdata['newarrdata7'].ydl7 + "Kwh");
			   $("#num7ysl").html(newdata['newarrdata7'].ysl7 + "T");
			   $("#num7ynl").html(newdata['newarrdata7'].ynl7 + "Kwh");
			   $("#num7yll").html(newdata['newarrdata7'].yll7 + "Kwh");


			   // 8号楼
			   $(".num8").html("");
			   if (newdata['newarr8'].length != 0) {
				   var tstr = "";
				   newdata['newarr8'].forEach(function (value, index, array) {
					   tstr += "<a href='/szny/index.php/Admin/Rg/indexparkoverviewshell?rgn_atpid=" + newdata['newarr8'][index].rgn_atpid + "'><li class='border_bottom clearfix'>" +
							   "<div class='fl tips'>" + newdata['newarr8'][index].dev_name + "</div>" +
							   "<div class='ll content'>" +
							   "<div class='fl bold'>" + newdata['newarr8'][index].rgn_name + "</div>" +
							   "<div class='fr text_right bold'>" + newdata['newarr8'][index].alm_datetime + "</div><br>" +
							   "<div class='fl bold'>" + newdata['newarr8'][index].alm_content + "</div>" +
							   "</div>" +
							   "</li></a>";
				   });
				   $(".num8").html(tstr);
				   $(".energy_message13").find("header").css("background", "#fc9900");
				   $(".energy_message13").find("header").find("p").text("8#楼（报警总数："+ newdata['newarrdata8'].alarmcount +"条）");
			   }
			   else {
				   $(".energy_message13").find("header").css("background", "#0B3D85");
				   $(".energy_message13").find("header").find("p").text("8#楼");
			   }
			   $("#num8ydl").html(newdata['newarrdata8'].ydl8 + "Kwh");
			   $("#num8ysl").html(newdata['newarrdata8'].ysl8 + "T");
			   $("#num8ynl").html(newdata['newarrdata8'].ynl8 + "Kwh");
			   $("#num8yll").html(newdata['newarrdata8'].yll8 + "Kwh");


			   // 9号楼
			   $(".num9").html("");
			   if (newdata['newarr9'].length != 0) {
				   var tstr = "";
				   newdata['newarr9'].forEach(function (value, index, array) {
					   tstr += "<a href='/szny/index.php/Admin/Rg/indexparkoverviewshell?rgn_atpid=" + newdata['newarr9'][index].rgn_atpid + "'><li class='border_bottom clearfix'>" +
							   "<div class='fl tips'>" + newdata['newarr9'][index].dev_name + "</div>" +
							   "<div class='ll content'>" +
							   "<div class='fl bold'>" + newdata['newarr9'][index].rgn_name + "</div>" +
							   "<div class='fr text_right bold'>" + newdata['newarr9'][index].alm_datetime + "</div><br>" +
							   "<div class='fl bold'>" + newdata['newarr9'][index].alm_content + "</div>" +
							   "</div>" +
							   "</li></a>";
				   });
				   $(".num9").html(tstr);
				   $(".energy_message14").find("header").css("background", "#fc9900");
				   $(".energy_message14").find("header").find("p").text("9#楼（报警总数："+ newdata['newarrdata9'].alarmcount +"条）");
			   }
			   else {
				   $(".energy_message14").find("header").css("background", "#0B3D85");
				   $(".energy_message14").find("header").find("p").text("9#楼");
			   }
			   $("#num9ydl").html(newdata['newarrdata9'].ydl9 + "Kwh");
			   $("#num9ysl").html(newdata['newarrdata9'].ysl9 + "T");
			   $("#num9ynl").html(newdata['newarrdata9'].ynl9 + "Kwh");
			   $("#num9yll").html(newdata['newarrdata9'].yll9 + "Kwh");


			   // 10号楼
			   $(".num10").html("");
			   if (newdata['newarr10'].length != 0) {
				   var tstr = "";
				   newdata['newarr10'].forEach(function (value, index, array) {
					   tstr += "<a href='/szny/index.php/Admin/Rg/indexparkoverviewshell?rgn_atpid=" + newdata['newarr10'][index].rgn_atpid + "'><li class='border_bottom clearfix'>" +
							   "<div class='fl tips'>" + newdata['newarr10'][index].dev_name + "</div>" +
							   "<div class='ll content'>" +
							   "<div class='fl bold'>" + newdata['newarr10'][index].rgn_name + "</div>" +
							   "<div class='fr text_right bold'>" + newdata['newarr10'][index].alm_datetime + "</div><br>" +
							   "<div class='fl bold'>" + newdata['newarr10'][index].alm_content + "</div>" +
							   "</div>" +
							   "</li></a>";
				   });
				   $(".num10").html(tstr);
				   $(".energy_message15").find("header").css("background", "#fc9900");
				   $(".energy_message15").find("header").find("p").text("10#楼（报警总数："+ newdata['newarrdata10'].alarmcount +"条）");
			   }
			   else {
				   $(".energy_message15").find("header").css("background", "#0B3D85");
				   $(".energy_message15").find("header").find("p").text("10#楼");
			   }
			   $("#num10ydl").html(newdata['newarrdata10'].ydl10 + "Kwh");
			   $("#num10ysl").html(newdata['newarrdata10'].ysl10 + "T");
			   $("#num10ynl").html(newdata['newarrdata10'].ynl10 + "Kwh");
			   $("#num10yll").html(newdata['newarrdata10'].yll10 + "Kwh");

			   // 11号楼
			   $(".num11").html("");
			   if (newdata['newarr11'].length != 0) {
				   var tstr = "";
				   newdata['newarr11'].forEach(function (value, index, array) {
					   tstr += "<a href='/szny/index.php/Admin/Rg/indexparkoverviewshell?rgn_atpid=" + newdata['newarr11'][index].rgn_atpid + "'><li class='border_bottom clearfix'>" +
							   "<div class='fl tips'>" + newdata['newarr11'][index].dev_name + "</div>" +
							   "<div class='ll content'>" +
							   "<div class='fl bold'>" + newdata['newarr11'][index].rgn_name + "</div>" +
							   "<div class='fr text_right bold'>" + newdata['newarr11'][index].alm_datetime + "</div><br>" +
							   "<div class='fl bold'>" + newdata['newarr11'][index].alm_content + "</div>" +
							   "</div>" +
							   "</li></a>";
				   });
				   $(".num11").html(tstr);
				   $(".energy_message16").find("header").css("background", "#fc9900");
				   $(".energy_message16").find("header").find("p").text("11#楼（报警总数："+ newdata['newarrdata11'].alarmcount +"条）");
			   }
			   else {
				   $(".energy_message16").find("header").css("background", "#0B3D85");
				   $(".energy_message16").find("header").find("p").text("11#楼");
			   }
			   $("#num11ydl").html(newdata['newarrdata11'].ydl11 + "Kwh");
			   $("#num11ysl").html(newdata['newarrdata11'].ysl11 + "T");
			   $("#num11ynl").html(newdata['newarrdata11'].ynl11 + "Kwh");
			   $("#num11yll").html(newdata['newarrdata11'].yll11 + "Kwh");

		   }
	   }
   });
},60*1000);

$(function() {
	// 房子2D
	$('.point1').on('mouseenter',function() {
		$('.point1').css('opacity',1).siblings('.onehouse').css('opacity',0);
		$('.unusual1').show().siblings('.unusual').hide();
		$('.energy_message1 .alarmlist').show().parent().siblings('.energy_message').children('.alarmlist').hide();
		// $('.energy_message1').css({'height':'265px'}).siblings('.energy_message').css({'height':'40px'});
		 $('.list-right').animate({scrollTop:($('header').height()+10)*4},20);
	});

	// 房子2B
	$('.point2').on('mouseenter',function() {
		$('.point2').css('opacity',1).siblings('.onehouse').css('opacity',0);
		$('.unusual2').show().siblings('.unusual').hide();
		$('.energy_message2 .alarmlist').show().parent().siblings('.energy_message').children('.alarmlist').hide();
		 $('.list-right').animate({scrollTop:($('header').height()+10)*2},20);
	});
		// 房子2A
	$('.point3').on('mouseenter',function() {
		$('.point3').css('opacity',1).siblings('.onehouse').css('opacity',0);
		$('.unusual3').show().siblings('.unusual').hide();
		$('.energy_message3 .alarmlist').show().parent().siblings('.energy_message').children('.alarmlist').hide();
		$('.list-right').animate({scrollTop:($('header').height()+10)*1},20);
	})
			// 房子2C
	$('.point4').on('mouseenter',function() {
		$('.point4').css('opacity',1).siblings('.onehouse').css('opacity',0);
		$('.unusual4').show().siblings('.unusual').hide();
		$('.energy_message4 .alarmlist').show().parent().siblings('.energy_message').children('.alarmlist').hide();
		$('.list-right').animate({scrollTop:($('header').height()+10)*3},20);
	})
			// 房子2F
	$('.point5').on('mouseenter',function() {
		$('.point5').css('opacity',1).siblings('.onehouse').css('opacity',0);
		$('.unusual5').show().siblings('.unusual').hide();
		$('.energy_message5 .alarmlist').show().parent().siblings('.energy_message').children('.alarmlist').hide();
		$('.list-right').animate({scrollTop:($('header').height()+10)*6},20);
	})
			// 房子2E
	$('.point6').on('mouseenter',function() {
		$('.point6').css('opacity',1).siblings('.onehouse').css('opacity',0);
		$('.unusual6').show().siblings('.unusual').hide();
		$('.energy_message6 .alarmlist').show().parent().siblings('.energy_message').children('.alarmlist').hide();
		$('.list-right').animate({scrollTop:($('header').height()+10)*5},20);
	})
				// 房子1
	$('.point7').on('mouseenter',function() {
		$('.point7').css('opacity',1).siblings('.onehouse').css('opacity',0);
		$('.unusual7').show().siblings('.unusual').hide();
		$('.energy_message7 .alarmlist').show().parent().siblings('.energy_message').children('.alarmlist').hide();
		$('.list-right').animate({scrollTop:($('header').height()+10)*0},20);
	})
				// 房子3
	$('.point8').on('mouseenter',function() {
		$('.point8').css('opacity',1).siblings('.onehouse').css('opacity',0);
		$('.unusual8').show().siblings('.unusual').hide();
		$('.energy_message8 .alarmlist').show().parent().siblings('.energy_message').children('.alarmlist').hide();
		$('.list-right').animate({scrollTop:($('header').height()+10)*7},20);
	})

	// 左边低楼
					// 房子9
	$('.point9').on('mouseenter',function() {
		$('.point9').css('opacity',1).siblings('.onehouse').css('opacity',0);
		$('.unusual9').show().siblings('.unusual').hide();
		$('.energy_message9 .alarmlist').show().parent().siblings('.energy_message').children('.alarmlist').hide();
		$('.list-right').animate({scrollTop:($('header').height()+10)*8},20);
	})
					// 房子10
	$('.point10').on('mouseenter',function() {
		$('.point10').css('opacity',1).siblings('.onehouse').css('opacity',0);
		$('.unusual10').show().siblings('.unusual').hide();
		$('.energy_message10 .alarmlist').show().parent().siblings('.energy_message').children('.alarmlist').hide();
		$('.list-right').animate({scrollTop:($('header').height()+10)*9},20);
	})
					// 房子11
	$('.point11').on('mouseenter',function() {
		$('.point11').css('opacity',1).siblings('.onehouse').css('opacity',0);
		$('.unusual11').show().siblings('.unusual').hide();
		$('.energy_message11 .alarmlist').show().parent().siblings('.energy_message').children('.alarmlist').hide();
		$('.list-right').animate({scrollTop:($('header').height()+10)*10},20);
	})
					// 房子12
	$('.point12').on('mouseenter',function() {
		$('.point12').css('opacity',1).siblings('.onehouse').css('opacity',0);
		$('.unusual12').show().siblings('.unusual').hide();
		$('.energy_message12 .alarmlist').show().parent().siblings('.energy_message').children('.alarmlist').hide();
		$('.list-right').animate({scrollTop:($('header').height()+10)*11},20);
	})

	// 右边低楼
					// 房子13
	$('.point13').on('mouseenter',function() {
		$('.point13').css('opacity',1).siblings('.onehouse').css('opacity',0);
		$('.unusual13').show().siblings('.unusual').hide();
		$('.energy_message13 .alarmlist').show().parent().siblings('.energy_message').children('.alarmlist').hide();
		$('.list-right').animate({scrollTop:($('header').height()+10)*12});
	})
					// 房子14
	$('.point14').on('mouseenter',function() {
		$('.point14').css('opacity',1).siblings('.onehouse').css('opacity',0);
		$('.unusual14').show().siblings('.unusual').hide();
		$('.energy_message14 .alarmlist').show().parent().siblings('.energy_message').children('.alarmlist').hide();
		$('.list-right').animate({scrollTop:($('header').height()+10)*13});
	})
					// 房子15
	$('.point15').on('mouseenter',function() {
		$('.point15').css('opacity',1).siblings('.onehouse').css('opacity',0);
		$('.unusual15').show().siblings('.unusual').hide();
		$('.energy_message15 .alarmlist').show().parent().siblings('.energy_message').children('.alarmlist').hide();
		$('.list-right').animate({scrollTop:($('header').height()+10)*14});
	})
					// 房子16
	$('.point16').on('mouseenter',function() {
		$('.point16').css('opacity',1).siblings('.onehouse').css('opacity',0);
		$('.unusual16').show().siblings('.unusual').hide();
		$('.energy_message16 .alarmlist').show().parent().siblings('.energy_message').children('.alarmlist').hide();
		$('.list-right').animate({scrollTop:($('header').height()+10)*15});
	})

	// 右侧手风琴
	$('.energy_message header').on('click', function() {
	    $(this).next('.alarmlist').toggle();
//		console.log($(this)['context'].innerText);
		// 1#楼 point7
		// 2#A座 point3
		// 2#B座 point2
		// 2#C座 point4
		// 2#D座 point1
		// 2#E座 point6
		// 2#F座 point5
		// 3#楼 point8
		// 4#楼 point9
		// 5#楼 point10
		// 6#楼 point11
		// 7#楼 point12
		// 8#楼 point13
		// 9#楼 point14
		// 10#楼 point15
		// 11#楼 point16


		// 2#D座 point1
		if($(this)['context'].innerText.indexOf("2#D座") >=0) {
			$('.point1').css('opacity',1).siblings('.onehouse').css('opacity',0);
			$('.unusual1').show().siblings('.unusual').hide();
		};
		// 2#B座 point2
		if($(this)['context'].innerText.indexOf("2#B座") >=0) {
			$('.point2').css('opacity',1).siblings('.onehouse').css('opacity',0);
			$('.unusual2').show().siblings('.unusual').hide();
		};
		// 2#A座 point3
		if($(this)['context'].innerText.indexOf("2#A座") >=0) {
			$('.point3').css('opacity',1).siblings('.onehouse').css('opacity',0);
			$('.unusual3').show().siblings('.unusual').hide();
		};
		// 2#C座 point4
		if($(this)['context'].innerText.indexOf("2#C座") >=0) {
			$('.point4').css('opacity',1).siblings('.onehouse').css('opacity',0);
			$('.unusual4').show().siblings('.unusual').hide();
		};
		// 2#F座 point5
		if($(this)['context'].innerText.indexOf("2#F座") >=0) {
			$('.point5').css('opacity',1).siblings('.onehouse').css('opacity',0);
			$('.unusual5').show().siblings('.unusual').hide();
		};
		// 2#E座 point6
		if($(this)['context'].innerText.indexOf("2#E座") >=0) {
			$('.point6').css('opacity',1).siblings('.onehouse').css('opacity',0);
			$('.unusual6').show().siblings('.unusual').hide();
		};
		// 1#楼 point7
		if($(this)['context'].innerText.indexOf("1#楼") >=0) {
			$('.point7').css('opacity',1).siblings('.onehouse').css('opacity',0);
			$('.unusual7').show().siblings('.unusual').hide();
		};
		// 3#楼 point8
		if($(this)['context'].innerText.indexOf("8#楼") >=0) {
			$('.point8').css('opacity',1).siblings('.onehouse').css('opacity',0);
			$('.unusual8').show().siblings('.unusual').hide();
		};
		// 4#楼 point9
		if($(this)['context'].innerText.indexOf("4#楼") >=0) {
			$('.point9').css('opacity',1).siblings('.onehouse').css('opacity',0);
			$('.unusual9').show().siblings('.unusual').hide();
		};
		// 5#楼 point10
		if($(this)['context'].innerText.indexOf("5#楼") >=0) {
			$('.point10').css('opacity',1).siblings('.onehouse').css('opacity',0);
			$('.unusual10').show().siblings('.unusual').hide();
		};
		// 6#楼 point11
		if($(this)['context'].innerText.indexOf("6#楼") >=0) {
			$('.point11').css('opacity',1).siblings('.onehouse').css('opacity',0);
			$('.unusual11').show().siblings('.unusual').hide();
		};
		// 7#楼 point12
		if($(this)['context'].innerText.indexOf("7#楼") >=0) {
			$('.point12').css('opacity',1).siblings('.onehouse').css('opacity',0);
			$('.unusual12').show().siblings('.unusual').hide();
		};
		// 8#楼 point13
		if($(this)['context'].innerText.indexOf("8#楼") >=0) {
			$('.point13').css('opacity',1).siblings('.onehouse').css('opacity',0);
			$('.unusual13').show().siblings('.unusual').hide();
		};
		// 9#楼 point14
		if($(this)['context'].innerText.indexOf("9#楼") >=0) {
			$('.point14').css('opacity',1).siblings('.onehouse').css('opacity',0);
			$('.unusual14').show().siblings('.unusual').hide();
		};
		// 10#楼 point15
		if($(this)['context'].innerText.indexOf("10#楼") >=0) {
			$('.point15').css('opacity',1).siblings('.onehouse').css('opacity',0);
			$('.unusual15').show().siblings('.unusual').hide();
		};
		// 11#楼 point16
		if($(this)['context'].innerText.indexOf("11#楼") >=0) {
			$('.point16').css('opacity',1).siblings('.onehouse').css('opacity',0);
			$('.unusual16').show().siblings('.unusual').hide();
		};
	});

	// 总数据展示
	$('.total1').click(function() {
		$('#main').toggle();
	});
})

function getNowFormatDate() {
	var date = new Date();
	var seperator1 = "-";
	var seperator2 = ":";
	var month = date.getMonth() + 1;
	var strDate = date.getDate();
	if (month >= 1 && month <= 9) {
		month = "0" + month;
	}
	if (strDate >= 0 && strDate <= 9) {
		strDate = "0" + strDate;
	}
	var thour = date.getHours();
	if (thour >= 0 && thour <= 9) {
		thour = "0" + thour;
	}
	var tminu = date.getMinutes();
	if (tminu >= 0 && tminu <= 9) {
		tminu = "0" + tminu;
	}
	var tsec = date.getSeconds();
	if (tsec >= 0 && tsec <= 9) {
		tsec = "0" + tsec;
	}
//	var currentdate = date.getFullYear() + seperator1 + month + seperator1 + strDate
//			+ " " + date.getHours() + seperator2 + date.getMinutes()
//			+ seperator2 + date.getSeconds();
	var currentdate = thour + seperator2 + tminu + seperator2 + tsec;
	return currentdate;
}
</script>
</body>
</html>