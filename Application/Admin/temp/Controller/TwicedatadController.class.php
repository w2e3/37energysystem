<?php
namespace Admin\Controller;
use Think\Controller;
class TwicedatadController extends BaseController
{
    public function index()
    {
        $this->logSys(session('emp_atpid'),"访问日志","访问页面：【数据管理】 / 【二次数据管理】 / 【日数据】");
        $Model = M();
        $sql_select ="
        select 
        * 
        from szny_region t
        left join szny_energytyperegion t1 on t.rgn_atpid = t1.etr_regionid
        left join szny_energytype t2 on t2.et_atpid = t1.etr_energytypeid
        where t.rgn_atpstatus is null and t1.etr_atpstatus is null and t2.et_atpstatus is null
        group by t.rgn_atpid
         order by t.rgn_name asc
        ";
        $data_org = $Model->query($sql_select);
//        dump($data_org);
        $treedatas = array();
        foreach ($data_org as $key_org => $value_org) {
            $tdata = array();
            $tdata['id'] = $value_org['rgn_atpid'];
            $tdata['pid'] = $value_org['rgn_pregionid'];
            $tdata['name'] = $value_org['rgn_name'];
            $tdata['open'] = true;
            if('园区' == $value_org['rgn_category']){
                $tdata['icon'] = $this->makeICONPath()."/Public/vendor/zTree_v3/css/zTreeStyle/img/diy/park.png";
                $tdata['type'] = '园区';
            }elseif ('楼' == $value_org['rgn_category']){
                $tdata['icon'] = $this->makeICONPath()."/Public/vendor/zTree_v3/css/zTreeStyle/img/diy/build.png";
                $tdata['type'] = '楼';
            }elseif ('座' == $value_org['rgn_category']){
                $tdata['icon'] = $this->makeICONPath()."/Public/vendor/zTree_v3/css/zTreeStyle/img/diy/floor.png";
                $tdata['type'] = '座';
            }elseif ('单元' == $value_org['rgn_category']){
                $tdata['icon'] = $this->makeICONPath()."/Public/vendor/zTree_v3/css/zTreeStyle/img/diy/unit.png";
                $tdata['type'] = '单元';
            }elseif ('层' == $value_org['rgn_category']){
                $tdata['icon'] = $this->makeICONPath()."/Public/vendor/zTree_v3/css/zTreeStyle/img/diy/storey.png";
                $tdata['type'] = '层';
                $tdata['open'] = false;
            }elseif ('设备点' == $value_org['rgn_category']){
                if ('电能' == $value_org['et_name']){
                    $tdata['icon'] = $this->makeICONPath()."/Public/vendor/zTree_v3/css/zTreeStyle/img/diy/ele_meter.png";
                }elseif ('水能' == $value_org['et_name']){
                    $tdata['icon'] = $this->makeICONPath()."/Public/vendor/zTree_v3/css/zTreeStyle/img/diy/water_meter.png";
                }elseif ('冷能' == $value_org['et_name']){
                    $tdata['icon'] = $this->makeICONPath()."/Public/vendor/zTree_v3/css/zTreeStyle/img/diy/coldhotmeter.png";
                }elseif ('暖能' == $value_org['et_name']){
                    $tdata['icon'] = $this->makeICONPath()."/Public/vendor/zTree_v3/css/zTreeStyle/img/diy/coldhotmeter.png";
                }
                else{
                    $tdata['icon'] = $this->makeICONPath()."/Public/vendor/zTree_v3/css/zTreeStyle/img/diy/energywater.png";
                }
                $tdata['type'] = '设备点';
            }elseif ('专项能源' == $value_org['rgn_category']){
                $tdata['icon'] = $this->makeICONPath()."/Public/vendor/zTree_v3/css/zTreeStyle/img/diy/specialenergy.png";
            }elseif ('制冷机房' == $value_org['rgn_category']){
                $tdata['icon'] = $this->makeICONPath()."/Public/vendor/zTree_v3/css/zTreeStyle/img/diy/Refrigerationroom.png";
            }elseif ('配电室' == $value_org['rgn_category']){
                $tdata['icon'] = $this->makeICONPath()."/Public/vendor/zTree_v3/css/zTreeStyle/img/diy/Switchroom.png";
            }elseif ('充电桩' == $value_org['rgn_category']){
                $tdata['icon'] = $this->makeICONPath()."/Public/vendor/zTree_v3/css/zTreeStyle/img/diy/Chargestation.png";
            }elseif ('锅炉房' == $value_org['rgn_category']){
                $tdata['icon'] = $this->makeICONPath()."/Public/vendor/zTree_v3/css/zTreeStyle/img/diy/Boilerroom.png";
            }
            else{
                $tdata['icon'] = $this->makeICONPath()."/Public/vendor/zTree_v3/css/zTreeStyle/img/diy/unit.png";
            }


            array_push($treedatas, $tdata);
        }
//        dump($treedatas);
        $this->assign('treedatas',json_encode($treedatas));
        $this->display();
    }
    function add(){
        $this->logSys(session('emp_atpid'),"访问日志","访问页面：【数据管理】 / 【二次数据管理】 / 【天数据】 / 【编辑】");
        $id = I('get.id');
        $Model = M();
        $sql_select = "select t.rgn_atpid,t.rgn_name from szny_region t left join szny_device t2 on t.rgn_deviceid=t2.dev_atpid where t2.dev_status='启用' and t2.dev_atpstatus is null";
        $Resultdata = $Model->query($sql_select);

        $this->assign('Resultdat', $Resultdata);



        $WhereConditionArray = array();
        $sql_select = "
                select
                 t.*,t1.dev_code,t2.rgn_name
                 from szny_data2day t
                 left join szny_device t1 on t1.dev_atpid=t.d2d_deviceid
                 left join szny_region t2 on t2.rgn_atpid=t.d2d_regionid
                ";
        $sql_select = $this->buildSql($sql_select, "t.d2d_atpstatus is null");
        $sql_select = $this->buildSql($sql_select, "t1.dev_atpstatus is null");
        $sql_select = $this->buildSql($sql_select, "t2.rgn_atpstatus is null");
        if($id){
            $sql_select = $this->buildSql($sql_select, "t.d2d_atpid='$id'");
        }else{
            //   $sql_select = $this->buildSql($sql_select, "t.data_regionid in('".$arr."')");
            //  $sql_count = $this->buildSql($sql_count, "t.data_regionid  in('".$arr."')");
        }


        $sql_select = $sql_select . " limit " . '0' . ', 1 ';
        $Result = $Model->query($sql_select, $WhereConditionArray);

        $arr=array();
        foreach($Result as $key=>$val){

            $position=array_keys($val);
            foreach($position as $positionkey=>$positionval){
                $substrstr=substr($positionval,4);

                if(stripos($substrstr,'avg')){
                    $shortname=substr($substrstr,0,stripos($substrstr,'avg'));
                    $param=$Model->query("select p_name from szny_param t where t.p_atpstatus is null and p_shortname='".$shortname."'");
                    $dataval = 'd2d_' . $substrstr;
                        $dataarr = array();
                        $dataarr['name'] = $param['0']['p_name'] . 'avg';
                        $dataarr['value'] = $dataval;
                     //   $dataarr['text'] = $val[$dataval];
                        array_push($arr, $dataarr);
                }elseif(stripos($substrstr,'min')){
                    $shortname=substr($substrstr,0,stripos($substrstr,'min'));
                    $param=$Model->query("select p_name from szny_param t where t.p_atpstatus is null and p_shortname='".$shortname."'");
                        $dataval = 'd2d_' . $substrstr;
                        if($val[$dataval]!= null)
                            $dataarr = array();
                        $dataarr['name'] = $param['0']['p_name'] . 'min';
                        $dataarr['value'] = $dataval;
                      //  $dataarr['text'] = $val[$dataval];
                        array_push($arr, $dataarr);
                }elseif(stripos($substrstr,'max')){
                    $shortname=substr($substrstr,0,stripos($substrstr,'max'));
                    $param=$Model->query("select p_name from szny_param t where t.p_atpstatus is null and p_shortname='".$shortname."'");
                    // $Result[$key][$substrstr]=$param['0']['p_name'];

                    $dataval = 'd2d_' . $substrstr;
                        $dataarr = array();
                        $dataarr['name'] = $param['0']['p_name'] . 'max';
                        $dataarr['value'] = $dataval;
                       // $dataarr['text'] = $val[$dataval];
                        array_push($arr, $dataarr);
                }elseif(stripos($substrstr,'accu')){
                    $param=$Model->query("select p_name from szny_param t where t.p_atpstatus is null and p_shortname='".$shortname."'");
                    // $Result[$key][$substrstr]=$param['0']['p_name'];

                    $dataval='d2d_'.$substrstr;
                        $dataarr=array();
                        $dataarr['name']=$param['0']['p_name'].'accu';
                        $dataarr['value']=$dataval;
                      //  $dataarr['text']=$val[$dataval];
                        array_push($arr,$dataarr);
                }
            }
            // $Result[$key]['arr']=$arr;
        }

        $this->assign('data',$arr);
        $this->assign('rgn_atpid',$id);
        $this->display();
    }
    public function  addsubmit(){
        $Model = M('data2day');
        $Model_data2modify=M("data2modify");
        $Model_data2modifydetail=M("data2modifydetail");
        $data = $Model->create();
//        //  $data2modifydetail=$Model_data2modifydetail->create();
//        //$data_data2modify=$Model_data2modify->create();
        $month=$Model->where("d2d_atpid='%s'",$_POST['d2d_atpid'])->find();

//        //插入二次数据纠正表
        $datadata2modify['d2mdf_atpid']=$this->makeGuid();
        $datadata2modify['d2mdf_atpcreatedatetime'] = date('Y-m-d H:i:s', time());
        $datadata2modify['d2mdf_atpcreateuser'] = I('session.u_account', '');
        $datadata2modify['d2mdf_atplastmodifydatetime'] = date('Y-m-d H:i:s', time());
        $datadata2modify['d2mdf_atplastmodifyuser'] = I('session.u_account', '');
        $datadata2modify['d2mdf_name']=$_POST['d2mdf_name'];
        $datadata2modify['d2mdf_desc']=$_POST['d2mdf_desc'];
        $datadata2modify['d2mdf_startempid']=I('session.emp_atpid', '');
        $datadata2modify['d2mdf_startdt']= date('Y-m-d H:i:s', time());
        $datadata2modify['d2mdf_agreestatus']='未审批';

        $Model_data2modify->add($datadata2modify);
        $keys=array_keys($data);
        foreach($keys as $key=>$val){
            if(!empty($val)){
                $data2modifydetaildata['d2mdfd_atpid']=$this->makeGuid();
                $data2modifydetaildata['d2mdfd_atpcreatedatetime'] = date('Y-m-d H:i:s', time());
                $data2modifydetaildata['d2mdfd_atpcreateuser'] = I('session.u_account', '');
                $data2modifydetaildata['d2mdfd_atplastmodifydatetime'] = date('Y-m-d H:i:s', time());
                $data2modifydetaildata['d2mdfd_atplastmodifyuser'] = I('session.u_account', '');
                $data2modifydetaildata['d2mdfd_data2modifyid'] = $datadata2modify['d2mdf_atpid'];
                $data2modifydetaildata['d2mdfd_data2dayid'] =$data['d2d_atpid'];
                $data2modifydetaildata['d2mdfd_param'] =$val;
                $data2modifydetaildata['d2mdfd_oldvalue'] = $month[$val];
                $data2modifydetaildata['d2mdfd_newvalue'] = $data[$val];
                $Model_data2modifydetail->add($data2modifydetaildata);
            }
        }

    }
    public function  submit(){
        $Model = M('');
        $Model_data2hour = M('data2hour');
        $data = $Model_data2hour->create();
        $sql_select = "select t2.dev_atpid from szny_region t left join szny_device t2 on t.rgn_deviceid=t2.dev_atpid where t2.dev_status='启用' and t2.dev_atpstatus is null and t.rgn_atpid='".$data['d2d_regionid']."' ";
        $Resultdata = $Model->query($sql_select);
        $data['d2d_deviceid']=$Resultdata['0']['dev_atpid'];
        if (null == $data['d2d_atpid']) {
            $data['d2d_atpid']=$this->makeGuid();
            $data['d2d_atpcreatedatetime'] = date('Y-m-d H:i:s', time());
            $data['d2d_atpcreateuser'] = I('session.u_account', '');
            $data['d2d_atplastmodifydatetime'] = date('Y-m-d H:i:s', time());
            $data['d2d_atplastmodifyuser'] = I('session.u_account', '');
            $data['d2d_dt'] =  date('Y-m-d H:00:00', time());;
            $Model_data2hour->add($data);
        }
    }
    public function edit(){
        $id = I('get.id');
        $Model=M("");
        $sql_select = "
select
  t.*,t2.rgn_name,t1.dev_code
from szny_data2year t
left join szny_device t1 on t1.dev_atpid = t.d2y_deviceid left join  szny_region t2 on t2.rgn_atpid=t.d2y_regionid where d2y_atpid= '".$id."'";
        $data2year=$Model->query($sql_select);
     if(empty($data2year['0']['d2y_atpid'])){
         $sql_select = "
select
  t.*,t2.rgn_name,t1.dev_code
from szny_data2month t
left join szny_device t1 on t1.dev_atpid = t.d2y_deviceid left join  szny_region t2 on t2.rgn_atpid=t.d2y_regionid where d2m_atpid= '".$id."'";
         $data2month=$Model->query($sql_select);
     }

        $this->display();
    }
    public function  tableindex(){

        $endtime = $_GET['endtime'];
        $starttime =$_GET['starttime'];
        $rgn_atpid = I('get.rgn_atpid');
        $Model = M();
        $colwhere = "";
        if ($rgn_atpid) {
            $colwhere="and t3.etr_regionid = '$rgn_atpid'";
        }
        $equipmentparameter = $Model->query("
                                select distinct t.p_name,t.p_shortname,t.p_unit from szny_param t
                                left join szny_energytyperegion t3 on t.p_energytypeid = t3.etr_energytypeid
                                where p_atpstatus is null $colwhere
                                order by t.p_name desc");
        $arr = array();
        foreach ($equipmentparameter as $parkey => $parval) {
            $dataarr = array();
            $dataarr['name'] = $parval['p_name']."-".$parval['p_unit'];
            $dataarr['value'] = "value_".$parval['p_shortname'];
            array_push($arr, $dataarr);
        }
        $this->assign('endtime',$endtime);
        $this->assign('starttime',$starttime);
        $this->assign('arr',$arr);
        $this->assign('rgn_atpid',$rgn_atpid);
        $this->display();
    }
    public function getData(){
        $regionid = I('get.rgn_atpid');
        $queryparam = json_decode(file_get_contents("php://input"), true);
        $Model = M();
        $endtime = $queryparam['endtime'];
        $starttime = $queryparam['starttime'];
        $WhereConditionArray = array();
        $sql_select = "
                select
                 t.*,t1.dev_code,t2.rgn_name
                 from szny_data2day t
                 left join szny_device t1 on t1.dev_atpid=t.d2d_deviceid
                 left join szny_region t2 on t2.rgn_atpid=t.d2d_regionid
                ";

        $sql_count = "
                select
                count(1) c
                from szny_data2day t
                left join szny_device t1 on t1.dev_atpid=t.d2d_deviceid
                left join szny_region t2 on t2.rgn_atpid=t.d2d_regionid";

        $sql_select = $this->buildSql($sql_select, "t.d2d_atpstatus is null");
        $sql_count = $this->buildSql($sql_count, "t.d2d_atpstatus is null");
        $sql_select = $this->buildSql($sql_select, "t1.dev_atpstatus is null");
        $sql_count = $this->buildSql($sql_count, "t1.dev_atpstatus is null");
        $sql_select = $this->buildSql($sql_select, "t2.rgn_atpstatus is null");
        $sql_count = $this->buildSql($sql_count, "t2.rgn_atpstatus is null");
        if($regionid){
            $sql_select = $this->buildSql($sql_select, "t.d2d_regionid='$regionid'");
            $sql_count = $this->buildSql($sql_count, "t.d2d_regionid ='$regionid'");
        }else{
         //   $sql_select = $this->buildSql($sql_select, "t.data_regionid in('".$arr."')");
          //  $sql_count = $this->buildSql($sql_count, "t.data_regionid  in('".$arr."')");
        }
        if($endtime && $starttime){
            $sql_select = $this->buildSql($sql_select, "t.d2d_dt>='".$starttime."' and t.d2d_dt<='".$endtime."'");
            $sql_count = $this->buildSql($sql_count, "t.d2d_dt>='".$starttime."' and t.d2d_dt<='".$endtime."'");
        }
        if (null != $queryparam['search']) {
            $searchcontent = trim($queryparam['search']);
            $sql_select = $this->buildSql($sql_select, "t2.rgn_name like '%s'");
            $sql_count = $this->buildSql($sql_count, "t2.rgn_name like '%s'");
            array_push($WhereConditionArray, $this->buildSqlLikeContain($searchcontent));
        }
        if (null != $queryparam['sort']) {
            $sql_select = $sql_select . " order by " . $queryparam['sort'] . ' ' . $queryparam['sortOrder'] . ' ';
        } else {
            $sql_select = $sql_select . " order by t.d2d_atpcreatedatetime desc ";
        }
        if (null != $queryparam['limit']) {

            if ('0' == $queryparam['offset']) {
                $sql_select = $sql_select . " limit " . '0' . ',' . $queryparam['limit'] . ' ';
            } else {
                $sql_select = $sql_select . " limit " . $queryparam['offset'] . ',' . $queryparam['limit'] . ' ';
            }
        }
        $Result = $Model->query($sql_select, $WhereConditionArray);
        $Count = $Model->query($sql_count, $WhereConditionArray);



        $sql_select_rel = "
select * from szny_param t where t.p_atpstatus is null
order by t.p_atpsort asc ";
        $Result_rel = $Model->query($sql_select_rel);
//        dump($Result_rel);
        foreach ($Result as $k => &$v) {
            foreach ($Result_rel as $rmk => $rmv) {
                if ("累计值" == $rmv['p_category']) {
                    $v['value_' . $rmv['p_shortname']] =
                        "累积:<font color='red'>" . $v['d2d_' . $rmv['p_shortname'] . "accu"] . "</font>";
                } else {
                    $v['value_' . $rmv['p_shortname']] =
                        "最小:<font color='red'>" . $v['d2d_' . $rmv['p_shortname'] . "min"] . "</font><br/>" .
                        "最大:<font color='red'>" . $v['d2d_' . $rmv['p_shortname'] . "max"] . "</font><br/>" .
                        "均值:<font color='red'>" . $v['d2d_' . $rmv['p_shortname'] . "avg"] . "</font><br/>";
                }
            }
        }


        echo json_encode(array('total' => $Count[0]['c'], 'rows' => $Result));
    }

}