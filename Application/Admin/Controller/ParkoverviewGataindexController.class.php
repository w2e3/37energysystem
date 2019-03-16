<?php
namespace Admin\Controller;
use Think\Controller;
class ParkoverviewGataindexController extends BaseController{
    public function ajax(){
        $tdata = $this->makeRegionCompareChart1();
//        $duibi = $this->makeRegionCompareChart2();
        $newarr1 = $this->makeEnergyAndAlarm1('guidBFE08660-A606-4CD1-BDE0-3720CD50CED4','1');
        $newarr2a = $this->makeEnergyAndAlarm1('guid077698E9-2942-430A-81E1-E54A98A3383C','2a');
        $newarr2b = $this->makeEnergyAndAlarm1('guid5BAF01C0-E54E-4F2D-8419-09EA0507F4F2','2b');
        $newarr2c = $this->makeEnergyAndAlarm1('guid3BD09081-28C0-4ECD-BC25-0EB0DDF949B2','2c');
        $newarr2d = $this->makeEnergyAndAlarm1('guidF7E28F9A-E04C-4030-86E5-73A84A0B6CAD','2d');
        $newarr2e = $this->makeEnergyAndAlarm1('guid39E40DE8-E7B3-40D8-B8A8-E5C69AF1EBF5','2e');
        $newarr2f = $this->makeEnergyAndAlarm1('guid75D5A56E-A723-4E16-AAF9-97E86195E0AF','2f');
        $newarr3 = $this->makeEnergyAndAlarm1('guidF5B91891-FC25-4448-84B9-0D7A544EFE6C','3');
        $newarr4 = $this->makeEnergyAndAlarm1('guid8E6723F6-09D3-4CFF-B3AD-812A7F784201','4');
        $newarr5 = $this->makeEnergyAndAlarm1('guidDDE6FF51-B4DD-42C1-962A-ED42D5120E88','5');
        $newarr6 = $this->makeEnergyAndAlarm1('guidFEAFFDFB-4628-46D2-B39B-46F1EC76EF07','6');
        $newarr7 = $this->makeEnergyAndAlarm1('guidC65AC6F2-6962-470C-9367-FF87BA1CD5CC','7');
        $newarr8 = $this->makeEnergyAndAlarm1('guidB44A77BC-907D-42AC-812D-3E401E40B6CA','8');
        $newarr9 = $this->makeEnergyAndAlarm1('guid0CCA3B48-E22B-4636-A0EC-1F0E81AE0F08','9');
        $newarr10 = $this->makeEnergyAndAlarm1('guid3696CE0E-0616-4B32-8AB2-40AA8DB2E1D6','10');
        $newarr11 = $this->makeEnergyAndAlarm1('guid1F1285F0-C495-46D7-969A-D3711B12EA28','11');
        $newarrdata1 = $this->makeEnergyAndAlarm2('guidBFE08660-A606-4CD1-BDE0-3720CD50CED4','1');
        $newarrdata2a = $this->makeEnergyAndAlarm2('guid077698E9-2942-430A-81E1-E54A98A3383C','2a');
        $newarrdata2b = $this->makeEnergyAndAlarm2('guid5BAF01C0-E54E-4F2D-8419-09EA0507F4F2','2b');
        $newarrdata2c = $this->makeEnergyAndAlarm2('guid3BD09081-28C0-4ECD-BC25-0EB0DDF949B2','2c');
        $newarrdata2d = $this->makeEnergyAndAlarm2('guidF7E28F9A-E04C-4030-86E5-73A84A0B6CAD','2d');
        $newarrdata2e = $this->makeEnergyAndAlarm2('guid39E40DE8-E7B3-40D8-B8A8-E5C69AF1EBF5','2e');
        $newarrdata2f = $this->makeEnergyAndAlarm2('guid75D5A56E-A723-4E16-AAF9-97E86195E0AF','2f');
        $newarrdata3 = $this->makeEnergyAndAlarm2('guidF5B91891-FC25-4448-84B9-0D7A544EFE6C','3');
        $newarrdata4 = $this->makeEnergyAndAlarm2('guid8E6723F6-09D3-4CFF-B3AD-812A7F784201','4');
        $newarrdata5 = $this->makeEnergyAndAlarm2('guidDDE6FF51-B4DD-42C1-962A-ED42D5120E88','5');
        $newarrdata6 = $this->makeEnergyAndAlarm2('guidFEAFFDFB-4628-46D2-B39B-46F1EC76EF07','6');
        $newarrdata7 = $this->makeEnergyAndAlarm2('guidC65AC6F2-6962-470C-9367-FF87BA1CD5CC','7');
        $newarrdata8 = $this->makeEnergyAndAlarm2('guidB44A77BC-907D-42AC-812D-3E401E40B6CA','8');
        $newarrdata9 = $this->makeEnergyAndAlarm2('guid0CCA3B48-E22B-4636-A0EC-1F0E81AE0F08','9');
        $newarrdata10 = $this->makeEnergyAndAlarm2('guid3696CE0E-0616-4B32-8AB2-40AA8DB2E1D6','10');
        $newarrdata11 = $this->makeEnergyAndAlarm2('guid1F1285F0-C495-46D7-969A-D3711B12EA28','11');
        echo json_encode(array(
                            'nenghao' => $tdata,
                            'newarr1' => $newarr1,
                            'newarr2a' => $newarr2a,
                            'newarr2b' => $newarr2b,
                            'newarr2c' => $newarr2c,
                            'newarr2d' => $newarr2d,
                            'newarr2e' => $newarr2e,
                            'newarr2f' => $newarr2f,
                            'newarr3' => $newarr3,
                            'newarr4' => $newarr4,
                            'newarr5' => $newarr5,
                            'newarr6' => $newarr6,
                            'newarr7' => $newarr7,
                            'newarr8' => $newarr8,
                            'newarr9' => $newarr9,
                            'newarr10' => $newarr10,
                            'newarr11' => $newarr11,
                            'newarrdata1' => $newarrdata1,
                            'newarrdata2a' => $newarrdata2a,
                            'newarrdata2b' => $newarrdata2b,
                            'newarrdata2c' => $newarrdata2c,
                            'newarrdata2d' => $newarrdata2d,
                            'newarrdata2e' => $newarrdata2e,
                            'newarrdata2f' => $newarrdata2f,
                            'newarrdata3' => $newarrdata3,
                            'newarrdata4' => $newarrdata4,
                            'newarrdata5' => $newarrdata5,
                            'newarrdata6' => $newarrdata6,
                            'newarrdata7' => $newarrdata7,
                            'newarrdata8' => $newarrdata8,
                            'newarrdata9' => $newarrdata9,
                            'newarrdata10' => $newarrdata10,
                            'newarrdata11' => $newarrdata11
        ));
    }

    /**
     * 自动构造每楼的【能源】与【报警】信息
     * @param $loudata
     * @param $loubj
     * @param $regionid
     */
    public function makeEnergyAndAlarm1($regionid,$louhao)
    {          
        $rgn_atpid1 = $regionid;
        $res1 = $this->regionrecursive($rgn_atpid1);
        foreach ($res1 as $key => $value) {
            $date_fh[] = "'" . $value['rgn_atpid'] . "'";
        }
        $endrgn_atpidsstrings_fh = implode(',', $date_fh);
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
        return $bj1;
    }

    public function makeEnergyAndAlarm2($regionid,$louhao)
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
        $bj1w['dev_regionid'] = array('in', $endrgn_atpidsstrings1);
        $bj1w['alm_confirmstatus'] = '待确认';
        $list1 = M('data2day')
            ->field("SUM(d2d_dglaccu) as ydl$louhao,SUM(d2d_syslaccu) as ysl$louhao,SUM(d2d_ynlaccu) as ynl$louhao,SUM(d2d_yllaccu) as yll$louhao")
            ->where($num1)
            ->find();
        $list1["ynl$louhao"]=$list1["ynl$louhao"]/1000;
        $list1["yll$louhao"]=$list1["yll$louhao"]/1000;

        if($list1["ydl$louhao"]==null) {
            $list1["ydl$louhao"] = 0;
        }
        if($list1["ysl$louhao"]==null) {
            $list1["ysl$louhao"] = 0;
        }
        if($list1["ynl$louhao"]==null) {
            $list1["ynl$louhao"] = 0;
        }
        if($list1["yll$louhao"]==null) {
            $list1["yll$louhao"] = 0;
        }

        $sql_select = "
            select
             sum(if( t2.alm_confirmstatus='待确认',1,0)) alarmcount
            from szny_region t
            left join szny_device t1 on t.rgn_atpid = t1.dev_regionid
            left join szny_alarm t2 on t.rgn_deviceid = t2.alm_deviceid
            where t.rgn_pregionid in ($endrgn_atpidsstrings_fh)
            order by t.rgn_name asc ";
        $newsbd = M()->query($sql_select);
        $list1['alarmcount'] = $newsbd[0]['alarmcount'];
        return $list1;
    }

    public function makeRegionCompareChart1()
    {
        $tdata = array();
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

        $tdata["qnydl"]=$yearcou['ydl']?$yearcou['ydl']:'0.00';
        $tdata["qnysl"]=$yearcou['ysl']?$yearcou['ysl']:'0.00';
        $tdata["qnynl"]=$yearcou['ynl']?$yearcou['ynl']:'0.00';
        $tdata["qnyll"]=$yearcou['yll']?$yearcou['yll']:'0.00';
        $tdata["byydl"]=$monthcou['ydl']?$monthcou['ydl']:'0.00';
        $tdata["byysl"]=$monthcou['ysl']?$monthcou['ysl']:'0.00';
        $tdata["byynl"]=$monthcou['ynl']?$monthcou['ynl']:'0.00';
        $tdata["byyll"]=$monthcou['yll']?$monthcou['yll']:'0.00';
        $tdata["syydl"]=$monthcouf['ydl']?$monthcouf['ydl']:'0.00';
        $tdata["syysl"]=$monthcouf['ysl']?$monthcouf['ysl']:'0.00';
        $tdata["syynl"]=$monthcouf['ynl']?$monthcouf['ynl']:'0.00';
        $tdata["syyll"]=$monthcouf['yll']?$monthcouf['yll']:'0.00';
        return $tdata;
    }


}
