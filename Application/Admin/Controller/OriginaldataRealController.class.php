<?php
namespace Admin\Controller;
use Think\Controller;
class OriginaldataRealController extends BaseAuthController
{
    public function index()
    {
        $this->logSys(session('emp_atpid'),"访问日志","访问页面：【数据管理】 / 【实时原始数据管理】");
        $id = I('get.regionid');
        $Model = M();
        //取设备参数
        $colwhere = "";
        if ($id) {
            $colwhere="and t3.etr_regionid = '$id'";
        }
        $equipmentparameter = $Model->query("
                        select distinct t.dmp_name,t.dmp_shortname from szny_devicemodelparam t
                        left join szny_energytypemodel t1 on t.dmp_devicemodelid = t1.etm_devicemodelid
                        left join szny_energytyperegion t3 on t1.etm_energytypeid = t3.etr_energytypeid
                        where t.dmp_atpstatus is null and t1.etm_atpstatus is null and t3.etr_atpstatus is null $colwhere
                        order by t.dmp_atpcreatedatetime asc");
        $arr = array();
        $arr_i=0;
        foreach ($equipmentparameter as $parkey => $parval) {
            $dataarr = array();
            $dataarr['name'] = $parval['dmp_name'];
            $dataarr['value'] = $parval['dmp_shortname'];
            if($arr_i==0)
            {
                $dataarr['legendselected'] = "true";
            }
            else
            {
                $dataarr['legendselected'] = "false";
            }
            $arr_i++;
            array_push($arr, $dataarr);
        }
        $this->assign('rgn_atpid', $id);
        $this->assign('arr', $arr);
        $this->assginDataInit();

        $Model = M('region');
        $data = $Model->where("rgn_atpid='%s'", array($id))->find();
        $this->assign('rgndata', $data);
        $this->display();
    }
    public function getData()
    {
        $regionid = I('get.regionid');
        $queryparam = json_decode(file_get_contents("php://input"), true);
        $endtime = $queryparam['endtime'];
        $starttime = $queryparam['starttime'];
        $Model = M();
      /*  $Result_tree = $this->regionrecursive("guid1A15CA6C-E3D2-4779-BF6B-F6C2D4706C9D");
        foreach($Result_tree as $key=>$val){
           $arr .=$val['id'].',';
        }
  */
        $WhereConditionArray = array();
        $sql_select = "
                select
                 t.*,t1.dev_code,t1.dev_acquisition,t2.rgn_name
                 from szny_data t
                 left join szny_device t1 on t1.dev_atpid=t.data_deviceid
                 left join szny_region t2 on t2.rgn_atpid=t.data_regionid
                ";
        $sql_count = "
                select
                count(1) c
                from szny_data t
                left join szny_device t1 on t1.dev_atpid=t.data_deviceid
                left join szny_region t2 on t2.rgn_atpid=t.data_regionid";

        $sql_select = $this->buildSql($sql_select, "t.data_atpstatus is null");
        $sql_count = $this->buildSql($sql_count, "t.data_atpstatus is null");
        $sql_select = $this->buildSql($sql_select, "t1.dev_atpstatus is null");
        $sql_count = $this->buildSql($sql_count, "t1.dev_atpstatus is null");
        $sql_select = $this->buildSql($sql_select, "t2.rgn_atpstatus is null");
        $sql_count = $this->buildSql($sql_count, "t2.rgn_atpstatus is null");
        $sql_select = $this->buildSql($sql_select, "t.data_regionid='$regionid'");
        $sql_count = $this->buildSql($sql_count, "t.data_regionid ='$regionid'");
        if($endtime && $starttime){
            $sql_select = $this->buildSql($sql_select, "t.data_dt>='".$starttime."' and t.data_dt<='".$endtime."'");
            $sql_count = $this->buildSql($sql_count, "t.data_dt>='".$starttime."' and t.data_dt<='".$endtime."'");
        }
        if (null != $queryparam['sort']) {
            $sql_select = $sql_select . " order by " . $queryparam['sort'] . ' ' . $queryparam['sortOrder'] . ' ';
        } else {
            $sql_select = $sql_select . " order by t.data_dt desc ";
        }
        if (null != $queryparam['limit']) {

            if ('0' == $queryparam['offset']) {
                $sql_select = $sql_select . " limit " . '0' . ',' . $queryparam['limit'] . ' ';
            } else {
                $sql_select = $sql_select . " limit " . $queryparam['offset'] . ',' . $queryparam['limit'] . ' ';
            }
        }
        $Result = $Model->query($sql_select, $WhereConditionArray);
        //  $this->assign('arr',$arr);
        $Count = $Model->query($sql_count, $WhereConditionArray);
//        $_SESSION['tdate']=null;
        echo json_encode(array('total' => $Count[0]['c'], 'rows' => $Result));
    }

    public function assginDataInit()
    {
        $regionid = I('get.regionid');
        $Model = M();
        $WhereConditionArray = array();
        $sql_select = "
                select
                 t.*,t1.dev_code,t1.dev_acquisition,t2.rgn_name
                 from szny_data t
                 left join szny_device t1 on t1.dev_atpid=t.data_deviceid
                 left join szny_region t2 on t2.rgn_atpid=t.data_regionid
                ";
        $sql_select = $this->buildSql($sql_select, "t.data_atpstatus is null");
        $sql_select = $this->buildSql($sql_select, "t1.dev_atpstatus is null");
        $sql_select = $this->buildSql($sql_select, "t2.rgn_atpstatus is null");
        $sql_select = $this->buildSql($sql_select, "t.data_regionid='$regionid'");
        $sql_select = $sql_select . " order by t.data_dt desc ";
        $sql_select = $sql_select . " limit 0 , 10 ";
        $Result = $Model->query($sql_select, $WhereConditionArray);
        $dataColumnDef = $this->getColumnDef();
        $data = [];
        foreach ($Result as $k => $v)
        {
            $tdata = array();
            $tdata['name']=$v['data_dt'];
//            $tdata['value']=$v['data_dgl'];
            foreach ($dataColumnDef as $kk => $vv)
            {
                $tdata[$vv['value']]=$v['data_'.$vv['value']];
            }
//            $tdata['dgl']=rand(500,1000);
//            $tdata['df']=rand(500,1000);
//            $tdata['da']=rand(500,1000);
            array_push($data, $tdata);
        }
//        dump($data);
//        echo json_encode($data);
//        dump($data);
//        echo $sql_select;
        $this->assign("initdata",json_encode($data));
    }



    public function getNowData()
    {
        $regionid = I('get.regionid');
        $Model = M();
        $WhereConditionArray = array();
        $sql_select = "
                select
                 t.*,t1.dev_code,t1.dev_acquisition,t2.rgn_name
                 from szny_data t
                 left join szny_device t1 on t1.dev_atpid=t.data_deviceid
                 left join szny_region t2 on t2.rgn_atpid=t.data_regionid
                ";
        $sql_select = $this->buildSql($sql_select, "t.data_atpstatus is null");
        $sql_select = $this->buildSql($sql_select, "t1.dev_atpstatus is null");
        $sql_select = $this->buildSql($sql_select, "t2.rgn_atpstatus is null");
        $sql_select = $this->buildSql($sql_select, "t.data_regionid='$regionid'");
        $sql_select = $sql_select . " order by t.data_dt desc ";
        $sql_select = $sql_select . " limit 0 , 10 ";
        $Result = $Model->query($sql_select, $WhereConditionArray);
        $dataColumnDef = $this->getColumnDef();
        $data = [];
        foreach ($Result as $k => $v) {
            $tdata = array();
            $tdata['name']=$v['data_dt'];

            foreach ($dataColumnDef as $kk => $vv)
            {
                $tdata[$vv['value']]=$v['data_'.$vv['value']];
            }

//            $tdate = $_SESSION['date'];
//            if (null == $tdate) {
//                $tdate = 1;
//            }
//            $tdate = $tdate+1;
//            $tdata['name'] = date('Y-m-d H:i:s',strtotime("+$tdate day"));
//            $_SESSION['date'] = $tdate;


//            $tdate = $_SESSION['tdate'];
//            if (null == $tdate) {
//                $tdate = 1;
//            }
//            $tdate=$tdate+1;
//            $tdata['name'] =  date('Y-m-d H:i:s',strtotime("+$tdate day"));
//            $_SESSION['tdate'] = $tdate;

//            $tdata['value']=$v['data_dgl'];
//            $tdata['value'] = rand(1, 1000);
//            $tdata['dgl']=rand(1, 100000);
//            $tdata['df']=rand(1, 100000);
//            $tdata['da']=rand(1, 100000);
//            $tdata['dgl']=$v['data_dgl'];
//            $tdata['df']=$v['data_df'];
//            $tdata['da']=$v['data_da'];
            array_push($data, $tdata);
        }
//        dump($data);
//        echo json_encode($data);
//        dump($data);
//        echo $sql_select;
        echo json_encode($data);
    }

    public function getColumnDef()
    {
        $id = I('get.regionid');
        $Model = M();
        //取设备参数
        $colwhere = "";
        if ($id) {
            $colwhere="and t3.etr_regionid = '$id'";
        }
        $equipmentparameter = $Model->query("
                        select distinct t.dmp_name,t.dmp_shortname from szny_devicemodelparam t
                        left join szny_energytypemodel t1 on t.dmp_devicemodelid = t1.etm_devicemodelid
                        left join szny_energytyperegion t3 on t1.etm_energytypeid = t3.etr_energytypeid
                        where t.dmp_atpstatus is null and t1.etm_atpstatus is null and t3.etr_atpstatus is null $colwhere
                        order by t.dmp_atpcreatedatetime asc");
        $arr = array();
        foreach ($equipmentparameter as $parkey => $parval) {
            $dataarr = array();
            $dataarr['name'] = $parval['dmp_name'];
            $dataarr['value'] = $parval['dmp_shortname'];
            array_push($arr, $dataarr);
        }
        return $arr;
    }



    public function export()
    {
        $regionid = I('get.regionid');
        $range_sql = "";
        $endtime = $_GET['endtime'];
        $starttime = $_GET['starttime'];
        if($endtime && $starttime){
            $range_sql = " and t.data_dt>='".$starttime."' and t.data_dt<='".$endtime."'";
        }

        $dataColumnDef = $this->getColumnDef();
        $diy_sql = "";
        $diy_sql1 = "";
        $diy_sql1array = array();
        $diy_sql2 = "";
        $diy_sql2array = array();

        array_push($diy_sql1array, "'位置点' rgn_name");
        array_push($diy_sql1array, "'设备卡编号' dev_code");
        array_push($diy_sql1array, "'采集号' dev_acquisition");
        array_push($diy_sql1array, "'时间' data_dt");
        foreach ($dataColumnDef as $kk => $vv) {
            array_push($diy_sql1array, "'" . $vv['name'] . "' data_" . $vv['value']);
        }
        $diy_sql1 = implode($diy_sql1array,',');
        $diy_sql1 = "select " . $diy_sql1 . " union all (";

        array_push($diy_sql2array, "t2.rgn_name");
        array_push($diy_sql2array, "t1.dev_code");
        array_push($diy_sql2array, "t1.dev_acquisition");
        array_push($diy_sql2array, "t.data_dt");
        foreach ($dataColumnDef as $kk => $vv) {
            array_push($diy_sql2array, "t.data_" . $vv['value']);
        }
        $diy_sql2 = implode($diy_sql2array,',');

        $diy_sql = $diy_sql1 . "select
$diy_sql2
from szny_data t
left join szny_device t1 on t1.dev_atpid=t.data_deviceid
left join szny_region t2 on t2.rgn_atpid=t.data_regionid
where t.data_atpstatus is null
and t1.dev_atpstatus is null
and t2.rgn_atpstatus is null
and t.data_regionid='$regionid' $range_sql
order by t.data_dt desc )";









        $Model = M();
        $sql_select = $diy_sql;
        $Result = $Model->query($sql_select);
        foreach ($Result as $i => $row) {
            foreach ($row as $j => $v) {
                $row[$j] = iconv('utf-8', 'gb2312', $v);
            }
            $Result[$i] = $row;
        }
        header('Content-Type: text/csv;');
        header('Content-Disposition: attachment; filename=export.csv');
        $output = fopen('php://output', 'w');
        foreach($Result as $row)
        {
            fputcsv($output, $row);
        }
        exit();


    }




}