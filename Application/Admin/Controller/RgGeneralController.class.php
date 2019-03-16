<?php
namespace Admin\Controller;
use Think\Controller;
use Admin\BaseController;
class RgGeneralController extends BaseAuthController
{
    public function indexregionroot()
    {
        $rgn_atpid = I("get.rgn_atpid","");
        // dump($rgn_atpid);
        // echo $rgn_atpid;
        $this->assign('rgn_atpid',$rgn_atpid);
        $this->display();
    }

    public function regionrootshow(){
        $res = $this->getRegionDevicePoint(I("get.regiontype", ""), I("get.rgn_atpid", ""), I("get.snname", ""));


        $titname = $res[0]['rgn_name'];
        $this->assign('titname',$titname);
        $this->display();
    }

    public function indexregion()
    {
         $rgn_atpid = I("get.rgn_atpid","");
        // dump($rgn_atpid);
         // echo $rgn_atpid;
         $this->assign('rgn_atpid',$rgn_atpid);
         $this->display();
    }

    public function indexdevicepoint()
    {
        $Model = M();
        $rgn_atpid = I('get.rgn_atpid');//dump($rgn_atpid);
        $this->assign('rgn_atpid', $rgn_atpid);
        if ($rgn_atpid) {
            $res = $this->regionrecursive($rgn_atpid);
        } else {
            $sql = "select rgn_atpid from szny_region where rgn_atpstatus and rgn_category = '园区'";
            $result = $Model->query($sql);
            $res = $this->regionrecursive($result[0]['rgn_atpid']);
        }
        ////////////////////////////////////////
        $Model = M('devicemodel');
        $sql_select = "
        select
        * 
        from szny_devicemodel t 
        left join szny_device t1 on t1.dev_devicemodelid = t.dm_atpid
        left join szny_region t2 on t1.dev_regionid = t2.rgn_atpid where t.dm_atpstatus is null and t1.dev_atpstatus is null and t2.rgn_atpstatus is null and t2.rgn_atpid = '$rgn_atpid'";

        $sql_type = "select * from szny_alarm t3
        left join szny_device t1 on t1.dev_atpid = t3.alm_deviceid where t3.alm_confirmstatus = '待确认'and t1.dev_regionid = '$rgn_atpid'
        ";
        $sql_typea = "select * from szny_alarm t3
        left join szny_device t1 on t1.dev_atpid = t3.alm_deviceid where t3.alm_confirmstatus = '待处理'and t1.dev_regionid = '$rgn_atpid'
        ";
        $sql_typec = "select * from szny_alarm t3
        left join szny_device t1 on t1.dev_atpid = t3.alm_deviceid where t1.dev_regionid = '$rgn_atpid'";
        $type = $Model->query($sql_type);
        $typea = $Model->query($sql_typea);
        $countc = count($Model->query($sql_typec)); //总共报警数量
        $countd = count($type);  //待确认报警数量
        $counta = count($typea);  //待处理报警数量
        $Result = $Model->query($sql_select);
        // dump($Result);
        if (empty($type)) {
            $typecon = "正常";
        } else {
            $typecon = "异常";
        }
        $where['d2y_regionid'] = $rgn_atpid;
        $time = date("Y", time());
        $list = M('data2year')->field("SUM(d2y_dglaccu) as ydl,SUM(d2y_syslaccu) as ysl,SUM(d2y_ynlaccu) as ynl,SUM(d2y_yllaccu) as yll,d2y_regionid,d2y_dt")->where($where)->where("d2y_dt <= '$time'")->group("d2y_regionid")->find();
        $count = '';
        if (!empty($list['ydl'])) {
            $count = $list['ydl'] . 'Kwh';
        } elseif (!empty($list['ysl'])) {
            $count = $list['ysl'] . 'T';
        } elseif (!empty($list['ynl']) or !empty($list['yll'])) {
            $count = $list['ynl'] + $list['yll'] . 'Kwh';
        } else {
            $count = '暂无数据产生';
        }
        // echo "<pre>";
        // print_r($list);
        $this->assign("count", $count);
        $this->assign("counta", $counta);
        $this->assign("countc", $countc);
        $this->assign("countd", $countd);
        $this->assign("result", $Result);
        $this->assign("typecon", $typecon);

        $this->assign('dm_picture', $Result[0]['dm_picture']);
        $this->display();
    }






    public function regionshow(){
        $Model=M("");
        $rgn_atpid = I("get.rgn_atpid","");//dump($rgn_atpid);
        $this->assign('rgn_atpid',$rgn_atpid);
        // echo $rgn_atpid;
        if ($rgn_atpid){
            $res = $this->regionrecursive($rgn_atpid);
        }else{
            $sql = "select rgn_atpid from szny_region where rgn_atpstatus and rgn_category = '园区'";
            $result = $Model->query($sql);
            $res = $this->regionrecursive($result[0]['rgn_atpid']);
        }
        foreach ($res as $key => $value)
        {
            $date[] = "" . $value['rgn_atpid'] . "";
        }
        $titname = $res[0]['rgn_name'];
        $this->assign("titname",$titname);
        $endrgn_atpidsstrings = implode(',', $date);
        $where['d2d_regionid'] = array('in',$endrgn_atpidsstrings);
        $where1['d2m_regionid'] = array('in',$endrgn_atpidsstrings);
        $day = date('Y-m-d',time());
        $month = date('Y-m',time());
        $dayc = date('d',time());
        // echo $dayc;
        // 电量值
        $where['d2d_dt'] = $day;
        $where1['d2m_dt'] = $month;
        $Result['dgl'] = M('data2day')->where($where)->group("d2d_dt")->sum("d2d_dglaccu");
        $Result['ysl'] = M('data2day')->where($where)->group("d2d_dt")->sum("d2d_syslaccu");
        $Result['ynl'] = M('data2day')->where($where)->group("d2d_dt")->sum("d2d_ynlaccu");
        $Result['yll'] = M('data2day')->where($where)->group("d2d_dt")->sum("d2d_yllaccu");
        $Result['m_dgl'] = M('data2month')->where($where1)->group("d2m_dt")->sum("d2m_dglaccu");
        $Result['m_ysl'] = M('data2month')->where($where1)->group("d2m_dt")->sum("d2m_syslaccu");
        $Result['m_ynl'] = M('data2month')->where($where1)->group("d2m_dt")->sum("d2m_ynlaccu");
        $Result['m_yll'] = M('data2month')->where($where1)->group("d2m_dt")->sum("d2m_yllaccu");
        if ($Result['dgl'] == '') {$Result['dgl'] = "0";}
        if ($Result['ysl'] == '') {$Result['ysl'] = "0";}
        if ($Result['ynl'] == '') {$Result['ynl'] = "0";}
        if ($Result['yll'] == '') {$Result['yll'] = "0";}
        if ($Result['m_dgl'] == '') {
            $Result['m_dgl'] = "0";
            $Result['mc_dgl'] = "0";
        }else{
            $Result['mc_dgl'] = $Result['m_dgl'];
            $Result['m_dgl'] = number_format($Result['m_dgl']/$dayc,1);
        }
        if ($Result['m_ysl'] == '') {
            $Result['m_ysl'] = "0";
            $Result['mc_ysl'] = "0";
        }else{
            $Result['mc_ysl'] = $Result['m_ysl'];
            $Result['m_ysl'] = number_format($Result['m_ysl']/$dayc,1);
        }
        if ($Result['m_ynl'] == '') {
            $Result['m_ynl'] = "0";
            $Result['mc_ynl'] = "0";
        }else{
            $Result['mc_ynl'] = $Result['m_ynl'];
            $Result['m_ynl'] = number_format($Result['m_ynl']/$dayc,1);
        }
        if ($Result['m_yll'] == '') {
            $Result['mc_yll'] = "0";
            $Result['m_yll'] = "0";
        }else{
            $Result['mc_yll'] = $Result['m_yll'];
            $Result['m_yll'] = number_format($Result['m_yll']/$dayc,1);
        }
        $this->assign("Result",$Result);
        $this->display();
    }




    public function func_alarminfo(){
        $rgn_atpid = I('get.rgn_atpid');
        $this->assign('rgn_atpid',$rgn_atpid);
        $this->display();
    }

    public function getAlarmData()
    {
        $Model = M();
        $res = $this->getRegionDevicePoint(I("get.regiontype", ""), I("get.rgn_atpid", ""), I("get.snname", ""));
 
        foreach ($res as $key => $value) {
            $trgn_atpid[] = "'" . $value['rgn_atpid'] . "'";
        }
        $rgn_atpidlist = implode(',', $trgn_atpid);
        $queryparam = json_decode(file_get_contents("php://input"), true);

        $sql_select = "
                select
                    *
                from szny_alarm t
                left join szny_emp t2 on t.alm_empid = t2.emp_atpid
                left join szny_alarmconfig t5 on t5.almc_atpid = t.alm_alarmconfigid
                left join szny_region t3 on t5.almc_regionid = t3.rgn_atpid
                left join szny_device t1 on t3.rgn_deviceid = t1.dev_atpid
				";
        $sql_count = "
                select
                  count(*) c
                from szny_alarm t
                left join szny_emp t2 on t.alm_empid = t2.emp_atpid
                left join szny_alarmconfig t5 on t5.almc_atpid = t.alm_alarmconfigid
                left join szny_region t3 on t5.almc_regionid = t3.rgn_atpid
                left join szny_device t1 on t3.rgn_deviceid = t1.dev_atpid
				";
        $sql_select = $this->buildSql($sql_select, "t.alm_atpstatus is null");
        $sql_count = $this->buildSql($sql_count, "t.alm_atpstatus is null");
        $sql_select = $this->buildSql($sql_select, "t1.dev_atpstatus is null");
        $sql_count = $this->buildSql($sql_count, "t1.dev_atpstatus is null");
        $sql_select = $this->buildSql($sql_select, "t2.emp_atpstatus is null");
        $sql_count = $this->buildSql($sql_count, "t2.emp_atpstatus is null");
        $sql_select = $this->buildSql($sql_select, "t3.rgn_atpstatus is null");
        $sql_count = $this->buildSql($sql_count, "t3.rgn_atpstatus is null");
        $sql_select = $this->buildSql($sql_select, "t.alm_confirmstatus = '待确认'");
        $sql_count = $this->buildSql($sql_count, "t.alm_confirmstatus = '待确认'");
        $sql_select = $this->buildSql($sql_select, "t3.rgn_atpid in (" . $rgn_atpidlist . ")");
        $sql_count = $this->buildSql($sql_count, "t3.rgn_atpid in (" . $rgn_atpidlist . ")");
        //快捷搜索
        if (null != $queryparam['search']) {
            $searchcontent = trim($queryparam['search']);
            $sql_select = $this->buildSql($sql_select, "t3.rgn_name like '%" . $searchcontent . "%'");
            $sql_count = $this->buildSql($sql_count, "t3.rgn_name like '%" . $searchcontent . "%'");
        }
//        if (null != $queryparam['rgn_name']) {
//            $searchcontent = trim($queryparam['rgn_name']);
//            $sql_select = $this->buildSql($sql_select, "t3.rgn_name like '%" . $searchcontent . "%'");
//            $sql_count = $this->buildSql($sql_count, "t3.rgn_name like '%" . $searchcontent . "%'");
//        }
        if (null != $queryparam['alm_level']) {
            $searchcontent = trim($queryparam['alm_level']);
            $sql_select = $this->buildSql($sql_select, "t.alm_level like '%" . $searchcontent . "%'");
            $sql_count = $this->buildSql($sql_count, "t.alm_level like '%" . $searchcontent . "%'");
        }
        if (null != $queryparam['alm_content']) {
            $searchcontent = trim($queryparam['alm_content']);
            $sql_select = $this->buildSql($sql_select, "t.alm_content like '%" . $searchcontent . "%'");
            $sql_count = $this->buildSql($sql_count, "t.alm_content like '%" . $searchcontent . "%'");
        }
        if (null != $queryparam['alm_category']) {
            $searchcontent = trim($queryparam['alm_category']);
            $sql_select = $this->buildSql($sql_select, "t.alm_category like '%" . $searchcontent . "%'");
            $sql_count = $this->buildSql($sql_count, "t.alm_category like '%" . $searchcontent . "%'");
        }
        if (null != $queryparam['dev_name']) {
            $searchcontent = trim($queryparam['dev_name']);
            $sql_select = $this->buildSql($sql_select, "t1.dev_name like '%" . $searchcontent . "%'");
            $sql_count = $this->buildSql($sql_count, "t1.dev_name like '%" . $searchcontent . "%'");
        }
        if (null != $queryparam['almp_floor']) {
            $searchcontent = trim($queryparam['almp_floor']);
            $sql_select = $this->buildSql($sql_select, "t4.almp_floor >= '" . $searchcontent . "'");
            $sql_count = $this->buildSql($sql_count, "t4.almp_floor >= '" . $searchcontent . "'");
        }
        if (null != $queryparam['almp_upper']) {
            $searchcontent = trim($queryparam['almp_upper']);
            $sql_select = $this->buildSql($sql_select, "t4.almp_upper <= '" . $searchcontent . "'");
            $sql_count = $this->buildSql($sql_count, "t4.almp_upper <= '" . $searchcontent . "'");
        }
        if (null != $queryparam['alm_datetime_start']) {
            $searchcontent = trim($queryparam['alm_datetime_start']);
            $sql_select = $this->buildSql($sql_select, "t.alm_datetime >= '" . $searchcontent . "'");
            $sql_count = $this->buildSql($sql_count, "t.alm_datetime >= '" . $searchcontent . "'");
        }
        if (null != $queryparam['alm_datetime_end']) {
            $searchcontent = trim($queryparam['alm_datetime_end']);
            $sql_select = $this->buildSql($sql_select, "t.alm_datetime <= '" . $searchcontent . "'");
            $sql_count = $this->buildSql($sql_count, "t.alm_datetime <= '" . $searchcontent . "'");
        }
        //排序
        if (null != $queryparam['sort']) {
            $sql_select = $sql_select . " order by " . $queryparam['sort'] . ' ' . $queryparam['sortOrder'] . ' ';
        } else {
            $sql_select = $sql_select . " order by t.alm_datetime asc";
        }
        //自定义分页
        if (null != $queryparam['limit']) {
            if ('0' == $queryparam['offset']) {
                $sql_select = $sql_select . " limit " . '0' . ',' . $queryparam['limit'] . ' ';
            } else {
                $sql_select = $sql_select . " limit " . $queryparam['offset'] . ',' . $queryparam['limit'] . ' ';
            }
        }
        $Result = $Model->query($sql_select);
        $Count = $Model->query($sql_count);
        $alarmconfig_atpid = [];
        foreach ($Result as $k => $v) {
            array_push($alarmconfig_atpid, $v['almc_atpid']);
            $v['value_param'] = '';
        }
        $ModelParam = M();
        $sql_selectparam= "
				select
					*
				from szny_alarmparam t
				left join szny_devicemodelparam t1 on t.almp_paramid = t1.dmp_atpid
				where t.almp_atpstatus is null and t1.dmp_atpstatus is null
				and t.almp_alarmid in ('".implode("','",$alarmconfig_atpid)."')
				order by t1.dmp_atpcreatedatetime asc  ";
        $Result_rel = $ModelParam->query($sql_selectparam);
        foreach ($Result as $k => &$v) {
            foreach ($Result_rel as $rmk => $rmv) {
                if ($v['almc_atpid'] == $rmv['almp_alarmid']) {
                    if ($v['value_param'] != '') {
                        $v['value_param'] = $v['value_param'] . "<br/>" . $rmv['dmp_name'].":下限".$rmv['almp_floor']."---上限".$rmv['almp_upper'];
                    } else {
                        $v['value_param'] = $rmv['dmp_name'].":下限".$rmv['almp_floor']."---上限".$rmv['almp_upper'];
                    }
                }
            }
        }


        echo json_encode(array('total' => $Count[0]['c'], 'rows' => $Result));
    }

    public function func_energytrend(){
        $res=$this->getRegionDevicePoint(I("get.regiontype",""),I("get.rgn_atpid",""),I("get.snname",""));
/*
        SELECT SUM(d2d_dglaccu) as ydl,
SUM(d2d_syslaccu) as ysl,SUM(d2d_ynlaccu) as ynl,SUM(d2d_yllaccu) as yll,`d2d_dt`
FROM `szny_data2day`
 WHERE `d2d_regionid` IN ('guidE300531E-963D-44B2-A2A0-2C010102')
        AND `d2d_dt` BETWEEN '2018-10-15' AND '2018-11-14' GROUP BY d2d_dt ORDER BY d2d_dt desc*/

        foreach ($res as $key => $value)
        {
            $date[] = "" . $value['rgn_atpid'] . "";
        }

        $endrgn_atpidsstrings = implode(',', $date);

        // 30天日期
        for ($i=0; $i < 30; $i++) {
            $day30[$i]['ydl'] = "0";
            $day30[$i]['ysl'] = "0";
            $day30[$i]['ynl'] = "0";
            $day30[$i]['yll'] = "0";
            $day30[$i]['dt_m'] = date("m",strtotime("-$i day"));
            $day30[$i]['dt_d'] = date("d",strtotime("-$i day"));
            $day30[$i]['d2d_dt'] = date("Y-m-d",strtotime("-$i day"));
        }
        $strtime = date("Y-m-d",time());
        $endtime = date("Y-m-d",strtotime("-30 day"));
        $where30day['d2d_regionid'] = array('in',$endrgn_atpidsstrings);
        $where30day['d2d_dt'] = array('between',"$endtime,$strtime");
        $mod = M("data2day")
            ->field("SUM(d2d_dglaccu) as ydl,SUM(d2d_syslaccu) as ysl,SUM(d2d_ynlaccu) as ynl,SUM(d2d_yllaccu) as yll,d2d_dt")
            ->where($where30day)
            ->group("d2d_dt")
            ->order("d2d_dt desc")->select();

        // 30天日期
        foreach($day30 as $ka=>$va){
            foreach($mod as $kb=>$vb){
                if($va['d2d_dt'] == $vb['d2d_dt']){
                    // $day30[$ka]['dt'] = substr($vb['d2d_dt'], 5);
                    $day30[$ka]['d2d_dt'] = $vb['d2d_dt'];
                    $day30[$ka]['ydl'] = $vb['ydl'];
                    $day30[$ka]['ysl'] = $vb['ysl'];
                    $day30[$ka]['ynl'] = $vb['ynl'];
                    $day30[$ka]['yll'] = $vb['yll'];
                }
            }
        }


        //判断最近所在位置点的表信息
        $is_ysl=false;
        $is_ydl=false;
        $is_yll=false;
        $is_ynl=false;
        $is_active=null;
      //最早用的方法

//        $ysl = array();
//        $ydl = array();
//        $yll = array();
//        $ynl = array();
//        foreach ($day30 as $k=>$v)
//        {
//          $ysl[] = $v['ysl'];
//          $ydl[] = $v['ydl'];
//          $yll[] = $v['ynl'];
//          $ynl[] = $v['yll'];
//        }
//        if(array_sum($ysl)>0)
//        {
//          $is_ysl=true;
//        }
//        if(array_sum($ydl)>0)
//        {
//          $is_ydl=true;
//        }
//        if(array_sum($yll)>0)
//        {
//          $is_yll=true;
//        }
//        if(array_sum($ynl)>0)
//        {
//          $is_ynl=true;
//        }

        $dev_arr=array();
        foreach ($res as $k=>$v)
        {
           $dev_category=M('device')->where("dev_atpstatus is null and dev_atpid='%s'",array($v['rgn_deviceid']))->getField('dev_name');
           if($dev_category=='电表')
           {
             if(!in_array('电表',$dev_arr))
             {
               $dev_arr[]='电表';
             }
           }elseif($dev_category=='水表')
           {
             if(!in_array('水表',$dev_arr))
             {

               $dev_arr[]='水表';
             }
           }elseif($dev_category=='冷暖表')
           {
             if(!in_array('冷暖表',$dev_arr))
             {
               $dev_arr[]='冷暖表';
             }
           }
        }


      if(in_array('电表',$dev_arr))
      {
       $is_ydl=true;
      }
      if(in_array('水表',$dev_arr))
      {
        $is_ysl=true;
      }
      if(in_array('冷暖表',$dev_arr))
      {
        $is_ynl=true;
        $is_yll=true;
      }


      if(($is_ysl)&&($is_active==null))
      {
        $is_active='ysl';
      }
      if(($is_ydl)&&($is_active==null))
      {
        $is_active='ydl';
      }
      if(($is_ynl)&&($is_active==null))
      {
        $is_active='ynl';
      }
      if(($is_yll)&&($is_active==null))
      {
        $is_active='yll';
      }

//      dump($is_ysl);
//      dump($is_ydl);
//      dump($is_yll);
//      dump($is_ynl);
//      dump($is_active);
      $this->assign("day30",$day30);
      $this->assign('is_ysl',$is_ysl);
      $this->assign('is_ydl',$is_ydl);
      $this->assign('is_yll',$is_yll);
      $this->assign('is_ynl',$is_ynl);
      $this->assign('is_active',$is_active);
      $this->display();
    }

    public function func_regionrootenergychart()
    {
        $res = $this->getRegionDevicePoint(I("get.regiontype", ""), I("get.rgn_atpid", ""), I("get.snname", ""));
        foreach ($res as $key => $value) {
            $date[] = "" . $value['rgn_atpid'] . "";
        }
        $endrgn_atpidsstrings = implode(',', $date);
        $titname = $res[0]['rgn_name'];
        $day = date('Y-m-d', time());
        $month = date('Y-m', time());
        $year = date('Y', time());
        $dayc = date('d', time());
        $where['d2d_regionid'] = array('in', $endrgn_atpidsstrings);
        $where1['d2m_regionid'] = array('in', $endrgn_atpidsstrings);
        $where2['d2y_regionid'] = array('in', $endrgn_atpidsstrings);
        $where['d2d_dt'] = $day;
        $where1['d2m_dt'] = $month;
        $where2['d2y_dt'] = $year;
        //数据查询
        $Result['dgl'] = M('data2day')->where($where)->group("d2d_dt")->sum("d2d_dglaccu");
        $Result['ysl'] = M('data2day')->where($where)->group("d2d_dt")->sum("d2d_syslaccu");
        $Result['ynl'] = M('data2day')->where($where)->group("d2d_dt")->sum("d2d_ynlaccu");
        $Result['yll'] = M('data2day')->where($where)->group("d2d_dt")->sum("d2d_yllaccu");
        $Result['m_dgl'] = M('data2month')->where($where1)->group("d2m_dt")->sum("d2m_dglaccu");
        $Result['m_ysl'] = M('data2month')->where($where1)->group("d2m_dt")->sum("d2m_syslaccu");
        $Result['m_ynl'] = M('data2month')->where($where1)->group("d2m_dt")->sum("d2m_ynlaccu");
        $Result['m_yll'] = M('data2month')->where($where1)->group("d2m_dt")->sum("d2m_yllaccu");
        $Result['y_dgl'] = M('data2year')->where($where2)->group("d2y_dt")->sum("d2y_dglaccu");
        $Result['y_ysl'] = M('data2year')->where($where2)->group("d2y_dt")->sum("d2y_syslaccu");
        $Result['y_ynl'] = M('data2year')->where($where2)->group("d2y_dt")->sum("d2y_ynlaccu");
        $Result['y_yll'] = M('data2year')->where($where2)->group("d2y_dt")->sum("d2y_yllaccu");

        //格式化
        $Result['c_ysl']=$Result['m_ysl'];
        $Result['ysl']=number_format($Result['ysl'], 1);
        $Result['m_ysl']=number_format($Result['m_ysl'], 1);
        $Result['y_ysl']=number_format($Result['y_ysl'], 1);

        $Result['c_dgl']=$Result['m_dgl'];
        $Result['dgl']=number_format($Result['dgl'], 1);
        $Result['m_dgl']=number_format($Result['m_dgl'], 1);
        $Result['y_dgl']=number_format($Result['y_dgl'], 1);

        $Result['c_ynl']=$Result['m_ynl'];
        $Result['ynl']=number_format($Result['ynl'], 1);
        $Result['m_ynl']=number_format($Result['m_ynl'], 1);
        $Result['y_ynl']=number_format($Result['y_ynl'], 1);

        $Result['c_yll']=$Result['m_yll'];
        $Result['yll']=number_format($Result['yll'], 1);
        $Result['m_yll']=number_format($Result['m_yll'], 1);
        $Result['y_yll']=number_format($Result['y_yll'], 1);

      //查询当月的能源计划
      $month = date('Y-m', time());
      $month_start_time=date('Y-m', time()).'-01';
      $month_days=getDaysByMonth(strtotime($month_start_time));
      $month_end_time=date('Y-m', time()).'-'.$month_days;

      //查询在这段时间的能源计划值
       $day_sum=cal_totaldays($month_start_time,$month_end_time);

      $rgn_atpid=I("get.rgn_atpid", "");
      $month_enery_data=$this->getmonthEnergyPlan($month_start_time,$month_end_time,$rgn_atpid);
//      dump($month_enery_data);
      $Result['c_dgl_plan']=$month_enery_data['total_ydl']>0?$month_enery_data['total_ydl']:200000;
      $Result['c_ysl_plan']=$month_enery_data['total_ysl']>0?$month_enery_data['total_ysl']:200000;
      $Result['c_yll_plan']=$month_enery_data['total_yll']>0?$month_enery_data['total_yll']:200000;
      $Result['c_ynl_plan']=$month_enery_data['total_ynl']>0?$month_enery_data['total_ynl']:200000;

      $this->assign("Result", $Result);
      $this->display();
    }


    public function func_regionenergychart()
    {
        $res = $this->getRegionDevicePoint(I("get.regiontype", ""), I("get.rgn_atpid", ""), I("get.snname", ""));
        foreach ($res as $key => $value) {
            $date[] = "" . $value['rgn_atpid'] . "";
        }
        $endrgn_atpidsstrings = implode(',', $date);
        $titname = $res[0]['rgn_name'];
        $day = date('Y-m-d', time());
        $month = date('Y-m', time());
        $year = date('Y', time());
        $dayc = date('d', time());
        $where['d2d_regionid'] = array('in', $endrgn_atpidsstrings);
        $where1['d2m_regionid'] = array('in', $endrgn_atpidsstrings);
        $where2['d2y_regionid'] = array('in', $endrgn_atpidsstrings);
        $where['d2d_dt'] = $day;
        $where1['d2m_dt'] = $month;
        $where2['d2y_dt'] = $year;
        //数据查询
        $Result['dgl'] = M('data2day')->where($where)->group("d2d_dt")->sum("d2d_dglaccu");
        $Result['ysl'] = M('data2day')->where($where)->group("d2d_dt")->sum("d2d_syslaccu");
        $Result['ynl'] = M('data2day')->where($where)->group("d2d_dt")->sum("d2d_ynlaccu");
        $Result['yll'] = M('data2day')->where($where)->group("d2d_dt")->sum("d2d_yllaccu");
        $Result['m_dgl'] = M('data2month')->where($where1)->group("d2m_dt")->sum("d2m_dglaccu");
        $Result['m_ysl'] = M('data2month')->where($where1)->group("d2m_dt")->sum("d2m_syslaccu");
        $Result['m_ynl'] = M('data2month')->where($where1)->group("d2m_dt")->sum("d2m_ynlaccu");
        $Result['m_yll'] = M('data2month')->where($where1)->group("d2m_dt")->sum("d2m_yllaccu");
        $Result['y_dgl'] = M('data2year')->where($where2)->group("d2y_dt")->sum("d2y_dglaccu");
        $Result['y_ysl'] = M('data2year')->where($where2)->group("d2y_dt")->sum("d2y_syslaccu");
        $Result['y_ynl'] = M('data2year')->where($where2)->group("d2y_dt")->sum("d2y_ynlaccu");
        $Result['y_yll'] = M('data2year')->where($where2)->group("d2y_dt")->sum("d2y_yllaccu");

        //格式化
        $Result['c_ysl'] = $Result['m_ysl'] == null ? 0 : $Result['m_ysl'];
        $Result['ysl'] = number_format($Result['ysl'], 1);
        $Result['m_ysl'] = number_format($Result['m_ysl'], 1);
        $Result['y_ysl'] = number_format($Result['y_ysl'], 1);

        $Result['c_dgl'] = $Result['m_dgl'] == null ? 0 : $Result['m_dgl'];
        $Result['dgl'] = number_format($Result['dgl'], 1);
        $Result['m_dgl'] = number_format($Result['m_dgl'], 1);
        $Result['y_dgl'] = number_format($Result['y_dgl'], 1);

        $Result['c_ynl'] = $Result['m_ynl'] == null ? 0 : $Result['m_ynl'];
        $Result['ynl'] = number_format($Result['ynl'], 1);
        $Result['m_ynl'] = number_format($Result['m_ynl'], 1);
        $Result['y_ynl'] = number_format($Result['y_ynl'], 1);

        $Result['c_yll'] = $Result['m_yll'] == null ? 0 : $Result['m_yll'];
        $Result['yll'] = number_format($Result['yll'], 1);
        $Result['m_yll'] = number_format($Result['m_yll'], 1);
        $Result['y_yll'] = number_format($Result['y_yll'], 1);

      //查询当月的能源计划
      $month = date('Y-m', time());
      $month_start_time=date('Y-m', time()).'-01';
      $month_days=getDaysByMonth(strtotime($month_start_time));
      $month_end_time=date('Y-m', time()).'-'.$month_days;

      //查询在这段时间的能源计划值
      $day_sum=cal_totaldays($month_start_time,$month_end_time);

      $rgn_atpid=I("get.rgn_atpid", "");
      $month_enery_data=$this->getmonthEnergyPlan($month_start_time,$month_end_time,$rgn_atpid);
      $Result['c_dgl_plan']=$month_enery_data['total_ydl']>0?$month_enery_data['total_ydl']:200000;
      $Result['c_ysl_plan']=$month_enery_data['total_ysl']>0?$month_enery_data['total_ysl']:200000;
      $Result['c_yll_plan']=$month_enery_data['total_yll']>0?$month_enery_data['total_yll']:200000;
      $Result['c_ynl_plan']=$month_enery_data['total_ynl']>0?$month_enery_data['total_ynl']:200000;
      $this->assign("Result", $Result);

        $this->display();
    }

   function func_energycoastroot()
   {

     $res = $this->getRegionDevicePoint(I("get.regiontype", ""), I("get.rgn_atpid", ""), I("get.snname", ""));

     //本月能源花费
     $floor_arr_names=array();
     $floor_arr=array();
     $floor_arr_rgnid=array();
     $floor_s_arr=array();
     $floor_d_arr=array();
     $floor_n_arr=array();
     $floor_l_arr=array();

     foreach($res as $k=>$v)
     {
       if($v['rgn_category']=='楼')
       {
         $floor_arr_names[]=$v['rgn_name'];
         $temp=array();
         $temp['rgn_name']=$v['rgn_name'];
         $temp['rgn_atpid']=$v['rgn_atpid'];
         array_push($floor_arr,$temp);
       }
     }

     //按照楼层重新排序
     sort($floor_arr_names);
     for($i=0;$i<count($floor_arr_names);$i++)
     {
       foreach ($floor_arr as $k=>$v)
       {
         if($floor_arr_names[$i]==$v['rgn_name'])
         {
           $temp=array();
           array_push($floor_arr_rgnid,$v['rgn_atpid']);
           $reg_name=$v['rgn_name'];
           $floor_s_price=$this->cal_sdq_rgn($v['rgn_atpid'],'水');
           $floor_d_price=$this->cal_sdq_rgn($v['rgn_atpid'],'电');
           $floor_n_price=$this->cal_sdq_rgn($v['rgn_atpid'],'暖');
           $floor_l_price=$this->cal_sdq_rgn($v['rgn_atpid'],'冷');

           $temp=array('value'=>$floor_s_price,'name'=>$reg_name);
           array_push($floor_s_arr,$temp);
           $temp=array('value'=>$floor_d_price,'name'=>$reg_name);
           array_push($floor_d_arr,$temp);
           $temp=array('value'=>$floor_n_price,'name'=>$reg_name);
           array_push($floor_n_arr,$temp);
           $temp=array('value'=>$floor_l_price,'name'=>$reg_name);
           array_push($floor_l_arr,$temp);

         }
       }
     }
//     foreach ($floor_arr_rgnid as $k=>$v)
//     {
//       $floor_s_arr[]=$this->cal_sdq_rgn($v,'水');
//       $floor_d_arr[]=$this->cal_sdq_rgn($v,'电');
//       $floor_n_arr[]=$this->cal_sdq_rgn($v,'暖');
//       $floor_l_arr[]=$this->cal_sdq_rgn($v,'冷');
//     }

//      dump($floor_s_arr);
//      dump($floor_s_arr);
//      dump($floor_s_arr);
//      dump($floor_s_arr);
     $this->assign('floor_arr_names',json_encode($floor_arr_names));
     $this->assign('floor_s_arr',json_encode($floor_s_arr));
     $this->assign('floor_d_arr',json_encode($floor_d_arr));
     $this->assign('floor_n_arr',json_encode($floor_n_arr));
     $this->assign('floor_l_arr',json_encode($floor_l_arr));
     $this->display();
   }

  function func_energycoast()
  {
    //本月能源花费
    $energy_names=array();
    $energy_amounts=array();

    $floor_s=null;
    $floor_d=null;
    $floor_n=null;
    $floor_l=null;


    array_push($energy_names,'水');
    array_push($energy_names,'电');
    array_push($energy_names,'冷');
    array_push($energy_names,'暖');

//      dump($energy_names);

    $rgn_id=I("get.rgn_atpid", "");
    $floor_s=$this->cal_sdq_rgn($rgn_id,'水');
    $floor_d=$this->cal_sdq_rgn($rgn_id,'电');
    $floor_n=$this->cal_sdq_rgn($rgn_id,'暖');
    $floor_l=$this->cal_sdq_rgn($rgn_id,'冷');


//    array_push($energy_amounts,$floor_s);
//    array_push($energy_amounts,$floor_d);
//    array_push($energy_amounts,$floor_n);
//    array_push($energy_amounts,$floor_l);

    $temp=array();
    $temp=array('value'=>$floor_s,'name'=>'用水量');
    array_push($energy_amounts,$temp);
    $temp=array('value'=>$floor_d,'name'=>'用电量');
    array_push($energy_amounts,$temp);
    $temp=array('value'=>$floor_n,'name'=>'用暖量');
    array_push($energy_amounts,$temp);
    $temp=array('value'=>$floor_l,'name'=>'用冷量');
    array_push($energy_amounts,$temp);

    $this->assign('energy_names',json_encode($energy_names));
    $this->assign('energy_amounts',json_encode($energy_amounts));
    $this->display();
  }


    //计算楼层用水用电用冷量
   public function cal_sdq_rgn($rgn_atpid,$category)
   {
     //总量
     $toal_number=0;
     //总价格
     $toal_amount=0;
     $res = $this->getRegionDevicePoint("rg", $rgn_atpid,"");
     foreach ($res as $key => $value) {
       $date[] = "" . $value['rgn_atpid'] . "";
     }
     $endrgn_atpidsstrings = implode(',', $date);
     $month = date('Y-m', time());
     $where1['d2m_regionid'] = array('in', $endrgn_atpidsstrings);
     $where1['d2m_dt'] = $month;
     //数据查询
     if($category=='水')
     {
       $result = M('data2month')->where($where1)->group("d2m_dt")->sum("d2m_syslaccu");
       $toal_number=($result==null?0:$result);
     }elseif($category=='电')
     {
       $result = M('data2month')->where($where1)->group("d2m_dt")->sum("d2m_dglaccu");
       $toal_number=($result==null?0:$result);
     }elseif($category=='暖')
     {
       $result = M('data2month')->where($where1)->group("d2m_dt")->sum("d2m_ynlaccu");
       $toal_number=($result==null?0:$result);
     }elseif($category=='冷')
     {
       $result = M('data2month')->where($where1)->group("d2m_dt")->sum("d2m_yllaccu");
       $toal_number=($result==null?0:$result);
     }

     //$toal_amount=$this->cal_sdq_amount($toal_number,$category);.
     return $toal_number;
//     return 500;
   }
    //计算价格
   public function  cal_sdq_amount($total_number,$category)
   {
     //电价
     $d_price=M('config')->where("cfg_atpstatus is null and cfg_key='电价'")->getField('cfg_value');
     //水价
     $s_price=M('config')->where("cfg_atpstatus is null and cfg_key='水价'")->getField('cfg_value');

//     dump($d_price);
//     dump($s_price);
     $total_amount=0;
     if($category=='电')
     {
       $total_amount=$total_number*$d_price;
     }
     if($category=='水')
     {
       $total_amount=$total_number*$s_price;
     }
     if($category=='冷')
     {
       $total_amount=$total_number*$d_price;
     }
     if($category=='暖')
     {
       $total_amount=$total_number*$d_price;
     }

     return round($total_amount,2);
   }

    //获得能源计划在这段时间的值
    public function getmonthEnergyPlan($start_time,$end_time,$rgn_atpid)
    {
      $total_ydl=0;
      $total_ysl=0;
      $total_yll=0;
      $total_ynl=0;
      $in_monthdays=0;
      $energyplan_arr=M('energyplan')->where("ep_atpstatus is null and ep_regionid='%s'",array($rgn_atpid))->select();
      if(count($energyplan_arr)>0)
      {
        foreach ($energyplan_arr as $k=>$v)
        {
          $month_plan_arr=$this->getmonthplandays($v,$start_time,$end_time);
          if($month_plan_arr['toal_days']>0)
          {
            //水电能源计划值
            $ydl_plan_data=M('energyplandetail')->where("epd_atpstatus is null and epd_category='电' and epd_energyplanid='%s'",array($v['ep_atpid']))->find();
            $ysl_plan_data=M('energyplandetail')->where("epd_atpstatus is null and epd_category='水' and epd_energyplanid='%s'",array($v['ep_atpid']))->find();
            $yll_plan_data=M('energyplandetail')->where("epd_atpstatus is null and epd_category='冷' and epd_energyplanid='%s'",array($v['ep_atpid']))->find();
            $ynl_plan_data=M('energyplandetail')->where("epd_atpstatus is null and epd_category='暖' and epd_energyplanid='%s'",array($v['ep_atpid']))->find();
            if($month_plan_arr['energy_total_days']>0)
            {
              $total_ydl+=$ydl_plan_data['epd_requiredvalue']/$month_plan_arr['energy_total_days']*$month_plan_arr['toal_days'];
              $total_ysl+=$ysl_plan_data['epd_requiredvalue']/$month_plan_arr['energy_total_days']*$month_plan_arr['toal_days'];
              $total_yll+=$yll_plan_data['epd_requiredvalue']/$month_plan_arr['energy_total_days']*$month_plan_arr['toal_days'];
              $total_ynl+=$ynl_plan_data['epd_requiredvalue']/$month_plan_arr['energy_total_days']*$month_plan_arr['toal_days'];
            }
          }
        }
      }
      return array('total_ydl'=>intval($total_ydl),'total_ysl'=>intval($total_ysl),'total_yll'=>intval($total_yll),'total_ynl'=>intval($total_ynl));
    }

    //获得能源计划这段时间的天数
    public function getmonthplandays($data,$start_time,$end_time)
    {
      $toal_days=0;
      $energy_total_days=0;
      $energy_total_days=cal_totaldays($data['ep_startdatetime'],$data['ep_enddatetime']);

      if((strtotime($data['ep_startdatetime'])>=strtotime($start_time))&&(strtotime($data['ep_enddatetime'])<=strtotime($end_time)))
      {
        $toal_days=cal_totaldays($data['ep_startdatetime'],$data['ep_enddatetime']);
      }
      elseif((strtotime($data['ep_startdatetime'])<=strtotime($start_time))&&(strtotime($data['ep_enddatetime'])>=strtotime($end_time)))
      {
        $toal_days=cal_totaldays($start_time,$end_time);
      }
      elseif((strtotime($data['ep_startdatetime'])>=strtotime($start_time))&&(strtotime($data['ep_enddatetime'])>=strtotime($end_time)))
      {
        $toal_days=cal_totaldays($data['ep_startdatetime'],$end_time);
      }elseif((strtotime($data['ep_startdatetime'])<=strtotime($start_time))&&(strtotime($data['ep_enddatetime'])<=strtotime($end_time)))
      {
        $toal_days=cal_totaldays($start_time,$data['ep_enddatetime']);
      }

      return array('toal_days'=>$toal_days,'energy_total_days'=>$energy_total_days);
    }
}
