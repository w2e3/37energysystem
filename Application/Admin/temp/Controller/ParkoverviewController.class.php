<?php
namespace Admin\Controller;

use Think\Controller;

class ParkoverviewController extends BaseController
{
    public function index()
    {
        $this->makeRegionCompareChart();
        $this->makeEnergyAndAlarm("list1", "bj1", 'guidBFE08660-A606-4CD1-BDE0-3720CD50CED4');
        $this->makeEnergyAndAlarm("list2a", "bj2a", 'guid077698E9-2942-430A-81E1-E54A98A3383C');
        $this->makeEnergyAndAlarm("list2b", "bj2b", 'guid5BAF01C0-E54E-4F2D-8419-09EA0507F4F2');
        $this->makeEnergyAndAlarm("list2c", "bj2c", 'guid3BD09081-28C0-4ECD-BC25-0EB0DDF949B2');
        $this->makeEnergyAndAlarm("list2d", "bj2d", 'guidF7E28F9A-E04C-4030-86E5-73A84A0B6CAD');
        $this->makeEnergyAndAlarm("list2e", "bj2e", 'guid39E40DE8-E7B3-40D8-B8A8-E5C69AF1EBF5');
        $this->makeEnergyAndAlarm("list2f", "bj2f", 'guid75D5A56E-A723-4E16-AAF9-97E86195E0AF');
        $this->makeEnergyAndAlarm("list3", "bj3", 'guidF5B91891-FC25-4448-84B9-0D7A544EFE6C');
        $this->makeEnergyAndAlarm("list4", "bj4", 'guid8E6723F6-09D3-4CFF-B3AD-812A7F784201');
        $this->makeEnergyAndAlarm("list5", "bj5", 'guidDDE6FF51-B4DD-42C1-962A-ED42D5120E88');
        $this->makeEnergyAndAlarm("list6", "bj6", 'guidFEAFFDFB-4628-46D2-B39B-46F1EC76EF07');
        $this->makeEnergyAndAlarm("list7", "bj7", 'guidC65AC6F2-6962-470C-9367-FF87BA1CD5CC');
        $this->makeEnergyAndAlarm("list8", "bj8", 'guidB44A77BC-907D-42AC-812D-3E401E40B6CA');
        $this->makeEnergyAndAlarm("list9", "bj9", 'guid0CCA3B48-E22B-4636-A0EC-1F0E81AE0F08');
        $this->makeEnergyAndAlarm("list10", "bj10", 'guid3696CE0E-0616-4B32-8AB2-40AA8DB2E1D6');
        $this->makeEnergyAndAlarm("list11", "bj11", 'guid1F1285F0-C495-46D7-969A-D3711B12EA28');
        //获得报警信息
//        $this->makeRegionCompareChartF2('guidBFE08660-A606-4CD1-BDE0-3720CD50CED4', "alarm_bj1");
//        $this->makeRegionCompareChartF2('guid077698E9-2942-430A-81E1-E54A98A3383C', "alarm_bj2a");
//        $this->makeRegionCompareChartF2('guid5BAF01C0-E54E-4F2D-8419-09EA0507F4F2', "alarm_bj2b");
//        $this->makeRegionCompareChartF2('guid3BD09081-28C0-4ECD-BC25-0EB0DDF949B2', "alarm_bj2c");
//        $this->makeRegionCompareChartF2('guidF7E28F9A-E04C-4030-86E5-73A84A0B6CAD', "alarm_bj2d");
//        $this->makeRegionCompareChartF2('guid39E40DE8-E7B3-40D8-B8A8-E5C69AF1EBF5', "alarm_bj2e");
//        $this->makeRegionCompareChartF2('guid75D5A56E-A723-4E16-AAF9-97E86195E0AF', "alarm_bj2f");
//        $this->makeRegionCompareChartF2('guidF5B91891-FC25-4448-84B9-0D7A544EFE6C', "alarm_bj3");
//        $this->makeRegionCompareChartF2('guid8E6723F6-09D3-4CFF-B3AD-812A7F784201', "alarm_bj4");
//        $this->makeRegionCompareChartF2('guidDDE6FF51-B4DD-42C1-962A-ED42D5120E88', "alarm_bj5");
//        $this->makeRegionCompareChartF2('guidFEAFFDFB-4628-46D2-B39B-46F1EC76EF07', "alarm_bj6");
//        $this->makeRegionCompareChartF2('guidC65AC6F2-6962-470C-9367-FF87BA1CD5CC', "alarm_bj7");
//        $this->makeRegionCompareChartF2('guidB44A77BC-907D-42AC-812D-3E401E40B6CA', "alarm_bj8");
//        $this->makeRegionCompareChartF2('guid0CCA3B48-E22B-4636-A0EC-1F0E81AE0F08', "alarm_bj9");
//        $this->makeRegionCompareChartF2('guid3696CE0E-0616-4B32-8AB2-40AA8DB2E1D6', "alarm_bj10");
//        $this->makeRegionCompareChartF2('guid1F1285F0-C495-46D7-969A-D3711B12EA28', "alarm_bj11");
        $this->display();
        $this->logSys(session('emp_atpid'), "访问日志", "访问页面：【园区概览】");
    }

    public function F1_ceng1F()
    {
        $this->makeRegionCompareChartF('guid3FF2D862-1E6E-400A-A9BB-278A072F1793');
//        $this->makeRegionCompareChartF('guid7007AC27-6A45-4C1A-894D-0F41EAC2DF49');

        $this->makeRegionCompareChartF2('guid3FF2D862-1E6E-400A-A9BB-278A072F1793', 'b1_flr_1');
        $this->makeRegionCompareChartF2('guid7007AC27-6A45-4C1A-894D-0F41EAC2DF49', 'b1_flr_2');
        $this->makeRegionCompareChartF2('guid7E36DAD8-2A4C-423F-A80C-5FB3D2630DED', 'b1_flr_3');
        $this->makeRegionCompareChartF2('guid99BB14E0-C216-4780-830B-CF896EBFFE7E', 'b1_flr_4');
        $this->makeRegionCompareChartF2('guid8DEB922A-DA0C-443E-A36E-7494A19D28E7', 'b1_flr_5');
        $this->makeRegionCompareChartF2('guidBD82C01A-DB01-4918-BDCF-8BE8BB6A9837', 'b1_flr_6');
        $this->makeRegionCompareChartF2('guid5F12DA1F-B476-476E-804D-78956D6EC1D5', 'b1_flr_7');
        $this->makeRegionCompareChartF2('guid481CB98D-885E-4316-AB13-0D4394AA3A95', 'b1_flr_8');

        $this->display();
    }

    public function F1_ceng2F()
    {
        $this->makeRegionCompareChartF('guid7007AC27-6A45-4C1A-894D-0F41EAC2DF49');
//        $this->makeRegionCompareChartF('guid7007AC27-6A45-4C1A-894D-0F41EAC2DF49');

        $this->makeRegionCompareChartF2('guid3FF2D862-1E6E-400A-A9BB-278A072F1793', 'b1_flr_1');
        $this->makeRegionCompareChartF2('guid7007AC27-6A45-4C1A-894D-0F41EAC2DF49', 'b1_flr_2');
        $this->makeRegionCompareChartF2('guid7E36DAD8-2A4C-423F-A80C-5FB3D2630DED', 'b1_flr_3');
        $this->makeRegionCompareChartF2('guid99BB14E0-C216-4780-830B-CF896EBFFE7E', 'b1_flr_4');
        $this->makeRegionCompareChartF2('guid8DEB922A-DA0C-443E-A36E-7494A19D28E7', 'b1_flr_5');
        $this->makeRegionCompareChartF2('guidBD82C01A-DB01-4918-BDCF-8BE8BB6A9837', 'b1_flr_6');
        $this->makeRegionCompareChartF2('guid5F12DA1F-B476-476E-804D-78956D6EC1D5', 'b1_flr_7');
        $this->makeRegionCompareChartF2('guid481CB98D-885E-4316-AB13-0D4394AA3A95', 'b1_flr_8');

        $this->display();
    }

    public function F1_ceng3F()
    {
        $this->makeRegionCompareChartF('guid7E36DAD8-2A4C-423F-A80C-5FB3D2630DED');
//        $this->makeRegionCompareChartF('guid7007AC27-6A45-4C1A-894D-0F41EAC2DF49');
        $this->makeRegionCompareChartF2('guid3FF2D862-1E6E-400A-A9BB-278A072F1793', 'b1_flr_1');
        $this->makeRegionCompareChartF2('guid7007AC27-6A45-4C1A-894D-0F41EAC2DF49', 'b1_flr_2');
        $this->makeRegionCompareChartF2('guid7E36DAD8-2A4C-423F-A80C-5FB3D2630DED', 'b1_flr_3');
        $this->makeRegionCompareChartF2('guid99BB14E0-C216-4780-830B-CF896EBFFE7E', 'b1_flr_4');
        $this->makeRegionCompareChartF2('guid8DEB922A-DA0C-443E-A36E-7494A19D28E7', 'b1_flr_5');
        $this->makeRegionCompareChartF2('guidBD82C01A-DB01-4918-BDCF-8BE8BB6A9837', 'b1_flr_6');
        $this->makeRegionCompareChartF2('guid5F12DA1F-B476-476E-804D-78956D6EC1D5', 'b1_flr_7');
        $this->makeRegionCompareChartF2('guid481CB98D-885E-4316-AB13-0D4394AA3A95', 'b1_flr_8');

        $this->display();
    }

    public function F1_ceng4F()
    {
        $this->makeRegionCompareChartF('guid99BB14E0-C216-4780-830B-CF896EBFFE7E');
//        $this->makeRegionCompareChartF('guid7007AC27-6A45-4C1A-894D-0F41EAC2DF49');
        $this->makeRegionCompareChartF2('guid3FF2D862-1E6E-400A-A9BB-278A072F1793', 'b1_flr_1');
        $this->makeRegionCompareChartF2('guid7007AC27-6A45-4C1A-894D-0F41EAC2DF49', 'b1_flr_2');
        $this->makeRegionCompareChartF2('guid7E36DAD8-2A4C-423F-A80C-5FB3D2630DED', 'b1_flr_3');
        $this->makeRegionCompareChartF2('guid99BB14E0-C216-4780-830B-CF896EBFFE7E', 'b1_flr_4');
        $this->makeRegionCompareChartF2('guid8DEB922A-DA0C-443E-A36E-7494A19D28E7', 'b1_flr_5');
        $this->makeRegionCompareChartF2('guidBD82C01A-DB01-4918-BDCF-8BE8BB6A9837', 'b1_flr_6');
        $this->makeRegionCompareChartF2('guid5F12DA1F-B476-476E-804D-78956D6EC1D5', 'b1_flr_7');
        $this->makeRegionCompareChartF2('guid481CB98D-885E-4316-AB13-0D4394AA3A95', 'b1_flr_8');

        $this->display();
    }

    public function F1_ceng5F()
    {
        $this->makeRegionCompareChartF('guid8DEB922A-DA0C-443E-A36E-7494A19D28E7');
//        $this->makeRegionCompareChartF('guid7007AC27-6A45-4C1A-894D-0F41EAC2DF49');
        $this->makeRegionCompareChartF2('guid3FF2D862-1E6E-400A-A9BB-278A072F1793', 'b1_flr_1');
        $this->makeRegionCompareChartF2('guid7007AC27-6A45-4C1A-894D-0F41EAC2DF49', 'b1_flr_2');
        $this->makeRegionCompareChartF2('guid7E36DAD8-2A4C-423F-A80C-5FB3D2630DED', 'b1_flr_3');
        $this->makeRegionCompareChartF2('guid99BB14E0-C216-4780-830B-CF896EBFFE7E', 'b1_flr_4');
        $this->makeRegionCompareChartF2('guid8DEB922A-DA0C-443E-A36E-7494A19D28E7', 'b1_flr_5');
        $this->makeRegionCompareChartF2('guidBD82C01A-DB01-4918-BDCF-8BE8BB6A9837', 'b1_flr_6');
        $this->makeRegionCompareChartF2('guid5F12DA1F-B476-476E-804D-78956D6EC1D5', 'b1_flr_7');
        $this->makeRegionCompareChartF2('guid481CB98D-885E-4316-AB13-0D4394AA3A95', 'b1_flr_8');

        $this->display();
    }

    public function F1_ceng6F()
    {
        $this->makeRegionCompareChartF('guidBD82C01A-DB01-4918-BDCF-8BE8BB6A9837');
//        $this->makeRegionCompareChartF('guid7007AC27-6A45-4C1A-894D-0F41EAC2DF49');
        $this->makeRegionCompareChartF2('guid3FF2D862-1E6E-400A-A9BB-278A072F1793', 'b1_flr_1');
        $this->makeRegionCompareChartF2('guid7007AC27-6A45-4C1A-894D-0F41EAC2DF49', 'b1_flr_2');
        $this->makeRegionCompareChartF2('guid7E36DAD8-2A4C-423F-A80C-5FB3D2630DED', 'b1_flr_3');
        $this->makeRegionCompareChartF2('guid99BB14E0-C216-4780-830B-CF896EBFFE7E', 'b1_flr_4');
        $this->makeRegionCompareChartF2('guid8DEB922A-DA0C-443E-A36E-7494A19D28E7', 'b1_flr_5');
        $this->makeRegionCompareChartF2('guidBD82C01A-DB01-4918-BDCF-8BE8BB6A9837', 'b1_flr_6');
        $this->makeRegionCompareChartF2('guid5F12DA1F-B476-476E-804D-78956D6EC1D5', 'b1_flr_7');
        $this->makeRegionCompareChartF2('guid481CB98D-885E-4316-AB13-0D4394AA3A95', 'b1_flr_8');

        $this->display();
    }

    public function F1_ceng7F()
    {
        $this->makeRegionCompareChartF('guid5F12DA1F-B476-476E-804D-78956D6EC1D5');
//        $this->makeRegionCompareChartF('guid7007AC27-6A45-4C1A-894D-0F41EAC2DF49');
        $this->makeRegionCompareChartF2('guid3FF2D862-1E6E-400A-A9BB-278A072F1793', 'b1_flr_1');
        $this->makeRegionCompareChartF2('guid7007AC27-6A45-4C1A-894D-0F41EAC2DF49', 'b1_flr_2');
        $this->makeRegionCompareChartF2('guid7E36DAD8-2A4C-423F-A80C-5FB3D2630DED', 'b1_flr_3');
        $this->makeRegionCompareChartF2('guid99BB14E0-C216-4780-830B-CF896EBFFE7E', 'b1_flr_4');
        $this->makeRegionCompareChartF2('guid8DEB922A-DA0C-443E-A36E-7494A19D28E7', 'b1_flr_5');
        $this->makeRegionCompareChartF2('guidBD82C01A-DB01-4918-BDCF-8BE8BB6A9837', 'b1_flr_6');
        $this->makeRegionCompareChartF2('guid5F12DA1F-B476-476E-804D-78956D6EC1D5', 'b1_flr_7');
        $this->makeRegionCompareChartF2('guid481CB98D-885E-4316-AB13-0D4394AA3A95', 'b1_flr_8');

        $this->display();
    }

    public function F1_ceng8F()
    {
        $this->makeRegionCompareChartF('guid481CB98D-885E-4316-AB13-0D4394AA3A95');
//        $this->makeRegionCompareChartF('guid7007AC27-6A45-4C1A-894D-0F41EAC2DF49');
        $this->makeRegionCompareChartF2('guid3FF2D862-1E6E-400A-A9BB-278A072F1793', 'b1_flr_1');
        $this->makeRegionCompareChartF2('guid7007AC27-6A45-4C1A-894D-0F41EAC2DF49', 'b1_flr_2');
        $this->makeRegionCompareChartF2('guid7E36DAD8-2A4C-423F-A80C-5FB3D2630DED', 'b1_flr_3');
        $this->makeRegionCompareChartF2('guid99BB14E0-C216-4780-830B-CF896EBFFE7E', 'b1_flr_4');
        $this->makeRegionCompareChartF2('guid8DEB922A-DA0C-443E-A36E-7494A19D28E7', 'b1_flr_5');
        $this->makeRegionCompareChartF2('guidBD82C01A-DB01-4918-BDCF-8BE8BB6A9837', 'b1_flr_6');
        $this->makeRegionCompareChartF2('guid5F12DA1F-B476-476E-804D-78956D6EC1D5', 'b1_flr_7');
        $this->makeRegionCompareChartF2('guid481CB98D-885E-4316-AB13-0D4394AA3A95', 'b1_flr_8');

        $this->display();
    }



    /**
     * 自动构造每楼的【能源】与【报警】信息
     * @param $loudata
     * @param $loubj
     * @param $regionid
     */
    public function makeEnergyAndAlarm($loudata, $loubj, $regionid)
    {
        $rgn_atpid1 = $regionid;
        $res1 = $this->regionrecursive($rgn_atpid1);
        foreach ($res1 as $key => $value) {
            $date1[] = "" . $value['rgn_atpid'] . "";
            $date_fh[] = "'" . $value['rgn_atpid'] . "'";
        }
        $endrgn_atpidsstrings1 = implode(',', $date1);
        $endrgn_atpidsstrings_fh = implode(',', $date_fh);
        $num1['d2d_regionid'] = array('in', $endrgn_atpidsstrings1);
        $num1['d2d_dt'] = date("Y-m-d",time());;
        $num1['d2d_atpstatus'] = array('EXP','IS NULL');
        $list1 = M('data2day')->field("SUM(d2d_dglaccu) as ydl,SUM(d2d_syslaccu) as ysl,SUM(d2d_ynlaccu) as ynl,SUM(d2d_yllaccu) as yll")
            ->where($num1)
            ->find();


        $bj1 = M('alarm')->query("
                SELECT t.*,t1.*,t2.*,t3.*,MIN(t.alm_datetime) mindate
                FROM szny_alarm t
                left join szny_device t1 on t.alm_deviceid=t1.dev_atpid
                left join szny_alarmconfig t2 on t.alm_alarmconfigid = t2.almc_atpid
                left join szny_region t3 on t2.almc_regionid = t3.rgn_atpid
                where t.alm_confirmstatus = '待确认' and t2.almc_regionid in ($endrgn_atpidsstrings_fh)
                group by t3.rgn_atpid,t.alm_deviceid,t.alm_alarmconfigid
                order by mindate asc
                LIMIT 3  ");
        $sql_select = "
            select
             sum(if( t2.alm_confirmstatus='待确认',1,0)) alarmcount
            from szny_region t
            left join szny_device t1 on t.rgn_atpid = t1.dev_regionid
            left join szny_alarm t2 on t.rgn_deviceid = t2.alm_deviceid
            where t.rgn_pregionid in ($endrgn_atpidsstrings_fh)
            order by t.rgn_name asc ";
        $newsbd = M()->query($sql_select);
        $this->assign("alarmcount_".$loubj, $newsbd[0]['alarmcount']);

        $this->assign($loubj, $bj1);
        $this->assign($loudata, $list1);
    }

    public function makeRegionCompareChart()
    {
        $year = date("Y", time());
        $month = date("Y-m", time());
        $monthf = date("Y-m", strtotime("-1 month"));
        //本年数据
        $whereyear['d2y_dt'] = $year;
        $yearcou = M('data2year')->field("SUM(d2y_dglaccu) as ydl,SUM(d2y_syslaccu) as ysl,SUM(d2y_ynlaccu) as ynl,SUM(d2y_yllaccu) as yll")->where($whereyear)->find();
        // 本月数据
        $wheremonth['d2m_dt'] = $month;
        $monthcou = M('data2month')->field("SUM(d2m_dglaccu) as ydl,SUM(d2m_syslaccu) as ysl,SUM(d2m_ynlaccu) as ynl,SUM(d2m_yllaccu) as yll")->where($wheremonth)->find();
        // 上月数据
        $wheremonthf['d2m_dt'] = $monthf;
        $monthcouf = M('data2month')->field("SUM(d2m_dglaccu) as ydl,SUM(d2m_syslaccu) as ysl,SUM(d2m_ynlaccu) as ynl,SUM(d2m_yllaccu) as yll")->where($wheremonthf)->find();

        $this->assign("qnydl", $yearcou['ydl']);
        $this->assign("qnysl", $yearcou['ysl']);
        $this->assign("qnynl", $yearcou['ynl']);
        $this->assign("qnyll", $yearcou['yll']);


        $this->assign("byydl", $monthcou['ydl']);
        $this->assign("byysl", $monthcou['ysl']);
        $this->assign("byynl", $monthcou['ynl']);
        $this->assign("byyll", $monthcou['yll']);

        $this->assign("syydl", $monthcouf['ydl']);
        $this->assign("syysl", $monthcouf['ysl']);
        $this->assign("syynl", $monthcouf['ynl']);
        $this->assign("syyll", $monthcouf['yll']);
    }


    public function makeRegionCompareChartF($rgn_id)
    {
        //获取园区范围
        $res = $this->regionrecursive($rgn_id);
        foreach ($res as $key => $value) {
            $date[] = "" . $value['rgn_atpid'] . "";
            $date_fh[] = "'" . $value['rgn_atpid'] . "'";
        }
        $endrgn_atpidsstrings = implode(',', $date);
        $endrgn_atpidsstrings_fh = implode(',', $date_fh);

        $Model = M();

        //获取位置点信息
        $sql_select = "
            select
             t.*,
             t1.*,
             sum(if( t2.alm_confirmstatus='待确认',1,0)) alarmcount
            from szny_region t
            left join szny_device t1 on t.rgn_atpid = t1.dev_regionid
            left join szny_alarm t2 on t.rgn_deviceid = t2.alm_deviceid
            where t.rgn_pregionid in ($endrgn_atpidsstrings_fh)
            group by t.rgn_atpid
            order by t.rgn_name asc ";
        $newsbd = $Model->query($sql_select);
//        foreach ($newsbd as $key => &$value) {
//            $value['alarmcount'] = $value['alarmcount']."";
//        }
        $this->assign("sbdstatus", $newsbd);
//dump($newsbd);

        //获取报警信息
        $wherebj['dev_regionid'] = array('in', $endrgn_atpidsstrings);
//        $bjdata = M('alarm')
//            ->join('szny_device on szny_alarm.alm_deviceid=szny_device.dev_atpid')
//            ->join('szny_region on szny_region.rgn_atpid = szny_device.dev_regionid')
//            ->join('szny_devicemodel on szny_device.dev_devicemodelid=szny_devicemodel.dm_atpid')
//            ->where($wherebj)
//            ->order("alm_datetime desc")
//            ->group("rgn_atpid")
//            ->limit(3)
//            ->select();
        $bjdata = M('alarm')->query("
                SELECT t.*,t1.*,t2.*,t3.*,MIN(t.alm_datetime) mindate
                FROM szny_alarm t
                left join szny_device t1 on t.alm_deviceid=t1.dev_atpid
                left join szny_alarmconfig t2 on t.alm_alarmconfigid = t2.almc_atpid
                left join szny_region t3 on t2.almc_regionid = t3.rgn_atpid
                where t.alm_confirmstatus = '待确认' and t2.almc_regionid in ($endrgn_atpidsstrings_fh)
                group by t3.rgn_atpid,t.alm_deviceid,t.alm_alarmconfigid
                order by mindate asc
                LIMIT 3  ");
        $this->assign("bjdata", $bjdata);

        //获取当天数据
        $whereday['d2d_regionid'] = array('in', $endrgn_atpidsstrings);
        $whereday['d2d_dt'] = date("Y-m-d",time());;
        $whereday['d2d_atpstatus'] = array('EXP','IS NULL');
        $dayused = M('data2day')
            ->field("SUM(d2d_dglaccu) as ydl,SUM(d2d_syslaccu) as ysl,SUM(d2d_ynlaccu) as ynl,SUM(d2d_yllaccu) as yll")
            ->where($whereday)
            ->find();
        $this->assign("dayused", $dayused);

        // 当月总体用量
        $month = date("Y-m", time());
        $wheremonth['d2m_dt'] = $month;
        $wheremonth['d2m_regionid'] = array('in', $endrgn_atpidsstrings);
        $yearcou = M('data2month')
            ->field("SUM(d2m_dglaccu) as ydl,SUM(d2m_syslaccu) as ysl,SUM(d2m_ynlaccu) as ynl,SUM(d2m_yllaccu) as yll")
            ->where($wheremonth)
            ->find();
        // 全年统计总和
        $yearcou['lnl'] = ($yearcou['ynl'] + $yearcou['yll']) . "";
        $zysl = $yearcou['ysl']+0;
        $zydl = $yearcou['ydl']+0;
        $zynl = $yearcou['ynl']+0;
        $zyll = $yearcou['yll']+0;
        $zlnl = $yearcou['lnl']+0;
        $this->assign("zysl", $zysl);
        $this->assign("zydl", $zydl);
        $this->assign("zynl", $zynl);
        $this->assign("zyll", $zyll);
        $this->assign("zlnl", $zlnl);

//        统计本月跟上月数据对比
        // 本月数据
        $month = date("Y-m", time());
        $monthf = date("Y-m", strtotime("-1 month"));
        $wheremonth['d2m_dt'] = $month;
        $wheremonth['d2m_regionid'] = array('in', $endrgn_atpidsstrings);
        $monthcou = M('data2month')->field("SUM(d2m_dglaccu) as ydl,SUM(d2m_syslaccu) as ysl,SUM(d2m_ynlaccu) as ynl,SUM(d2m_yllaccu) as yll")
            ->where($wheremonth)->find();
        $monthcou['lnl'] = $monthcou['ynl'] + $monthcou['yll'];
        if (empty($monthcou['ydl'])) {
            $monthcou['ydl'] = "0";
        }
        if (empty($monthcou['ysl'])) {
            $monthcou['ysl'] = "0";
        }
//        上月数据
        $wheremonthf['d2m_dt'] = $monthf;
        $wheremonthf['d2m_regionid'] = array('in', $endrgn_atpidsstrings);
        $monthcouf = M('data2month')->field("SUM(d2m_dglaccu) as ydl,SUM(d2m_syslaccu) as ysl,SUM(d2m_ynlaccu) as ynl,SUM(d2m_yllaccu) as yll")
            ->where($wheremonthf)->find();
        $monthcouf['lnl'] = $monthcouf['ynl'] + $monthcouf['yll'];
        if (empty($monthcouf['ydl'])) {
            $monthcouf['ydl'] = "0";
        }
        if (empty($monthcouf['ysl'])) {
            $monthcouf['ysl'] = "0";
        }
//        对比
        $duibi['ydl'] = $monthcou['ydl'] - $monthcouf['ydl'];
        $duibi['ysl'] = $monthcou['ysl'] - $monthcouf['ysl'];
        $duibi['lnl'] = $monthcou['lnl'] - $monthcouf['lnl'];
        $duibi['ydl%'] = number_format(($monthcou['ydl'] / $monthcouf['ydl'] - 1) * 100, 2);
        $duibi['ysl%'] = number_format(($monthcou['ysl'] / $monthcouf['ysl'] - 1) * 100, 2);
        $duibi['lnl%'] = number_format(($monthcou['lnl'] / $monthcouf['lnl'] - 1) * 100, 2);
        $this->assign("duibi", $duibi);

//        测试打印
//        dump($newsbd);
//        dump($bjdata);
//        dump($dayused);
//        dump($zysl);
//        dump($zydl);
//        dump($zynl);
//        dump($zyll);
//        dump($zlnl);
//        dump($duibi);
    }


    public function makeRegionCompareChartF2($rgn_id,$assignname)
    {
        //获取园区范围
        $res = $this->regionrecursive($rgn_id);
        foreach ($res as $key => $value) {
            $date_fh[] = "'" . $value['rgn_atpid'] . "'";
        }
        $endrgn_atpidsstrings_fh = implode(',', $date_fh);
        $Model = M();
        //获取位置点信息
        $sql_select = "
            select
             sum(if( t2.alm_confirmstatus='待确认',1,0)) alarmcount
            from szny_region t
            left join szny_device t1 on t.rgn_atpid = t1.dev_regionid
            left join szny_alarm t2 on t.rgn_deviceid = t2.alm_deviceid
            where t.rgn_pregionid in ($endrgn_atpidsstrings_fh)
            order by t.rgn_name asc ";
        $newsbd = $Model->query($sql_select);
        $this->assign($assignname, $newsbd[0]['alarmcount']);
//        dump($newsbd[0]['alarmcount']);
    }




}