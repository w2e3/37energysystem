<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2014 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用入口文件

// 检测PHP环境
if(version_compare(PHP_VERSION,'5.3.0','<'))  die('require PHP > 5.3.0 !');

// 开启调试模式 建议开发阶段开启 部署阶段注释或者设为false
define('APP_DEBUG',true);
// 定义应用目录
define('APP_PATH','./Application/');
//绑定模块
//define('BIND_MODULE','Admin');
// 引入ThinkPHP入口文件

require './ThinkPHP/ThinkPHP.php';



//$wordTablePSDTemplate=" <tr style='height:22.45pt'>
//  <td width=\"6%%\" style='width:6.48%%;border:solid windowtext 1.0pt;border-top:
//  none;padding:0cm 5.4pt 0cm 5.4pt;height:22.45pt'>
//  <p class=MsoNormal align=center style='text-align:center'><span lang=EN-US>1</span></p>
//  </td>
//  <td width=\"11%%\" style='width:11.2%%;border-top:none;border-left:none;
//  border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
//  padding:0cm 5.4pt 0cm 5.4pt;height:22.45pt'>
//  <p class=MsoNormal align=center style='text-align:center'><span lang=EN-US>F00000001</span></p>
//  </td>
//  <td width=\"11%%\" style='width:11.94%%;border-top:none;border-left:none;
//  border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
//  padding:0cm 5.4pt 0cm 5.4pt;height:22.45pt'>
//  <p class=MsoNormal align=center style='text-align:center'><span lang=EN-US>C001</span></p>
//  </td>
//  <td width=\"14%%\" style='width:14.96%%;border-top:none;border-left:none;
//  border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
//  padding:0cm 5.4pt 0cm 5.4pt;height:22.45pt'>
//  <p class=MsoNormal align=center style='text-align:center'><span
//  style='font-family:宋体'>%s</span></p>
//  </td>
//  <td width=\"16%%\" style='width:16.3%%;border-top:none;border-left:none;
//  border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
//  padding:0cm 5.4pt 0cm 5.4pt;height:22.45pt'>
//  <p class=MsoNormal align=center style='text-align:center'><span
//  style='font-family:宋体'>塑料盒</span><span lang=EN-US>-</span><span
//  style='font-family:宋体'>球</span><span lang=EN-US>2</span></p>
//  </td>
//  <td width=\"6%%\" style='width:6.82%%;border-top:none;border-left:none;
//  border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
//  padding:0cm 5.4pt 0cm 5.4pt;height:22.45pt'>
//  <p class=MsoNormal align=center style='text-align:center'><span lang=EN-US>10</span></p>
//  </td>
//  <td width=\"8%%\" style='width:8.16%%;border-top:none;border-left:none;
//  border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
//  padding:0cm 5.4pt 0cm 5.4pt;height:22.45pt'>
//  <p class=MsoNormal align=center style='text-align:center'><span lang=EN-US>4.00</span></p>
//  </td>
//  <td width=\"9%%\" style='width:9.52%%;border-top:none;border-left:none;
//  border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
//  padding:0cm 5.4pt 0cm 5.4pt;height:22.45pt'>
//  <p class=MsoNormal align=center style='text-align:center'><span lang=EN-US>6.00</span></p>
//  </td>
//  <td width=\"14%%\" style='width:14.62%%;border-top:none;border-left:none;
//  border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
//  padding:0cm 5.4pt 0cm 5.4pt;height:22.45pt'>
//  <p class=MsoNormal align=center style='text-align:center'><span lang=EN-US>&nbsp;</span></p>
//  </td>
// </tr>";
//
//
//$num1 = 1112222;
//$num2 = 222;
//$txt = vsprintf($wordTablePSDTemplate,array($num1,$num2));
//echo $txt;



// 亲^_^ 后面不需要任何代码了 就是如此简单