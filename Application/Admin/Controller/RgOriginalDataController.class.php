<?php
namespace Admin\Controller;

use Think\Controller;

class RgOriginalDataController extends BaseAuthController
{
    public function Twicedatay()
    {
        $this->logSys(session('emp_atpid'), "访问日志", "访问页面：$this->ATPLocationName / 【历史采集数据】 / 【年数据】");
        $endtime = $_GET['endtime'];
        $starttime = $_GET['starttime'];
        $rgn_atpid = I('get.rgn_atpid');
        $Model = M();
        $res = $this->getRegionDevicePoint(I("get.regiontype", ""), I("get.rgn_atpid", ""), I("get.snname", ""));
        $sql_select="";
        foreach ($res as $key => $value) {
            $date[] = "'" . $value['rgn_atpid'] . "'";
        }
        $endrgn_atpidsstrings = implode(',', $date);
        if ($rgn_atpid) {
            $sql_select = $this->buildSql($sql_select, "t.d2y_regionid in (" . $endrgn_atpidsstrings . ")");
            $colwhere = "and t3.etr_regionid in (" . $endrgn_atpidsstrings . ")";
        }
        $equipmentparameter = $Model->query("
                                select distinct t.p_name,t.p_shortname,t.p_unit from szny_param t
                                left join szny_energytyperegion t3 on t.p_energytypeid = t3.etr_energytypeid
                                where p_atpstatus is null $colwhere
                                order by t.p_name desc");
        $arr = array();
        foreach ($equipmentparameter as $parkey => $parval) {
            $dataarr = array();
            $dataarr['name'] = $parval['p_name'] . "-" . $parval['p_unit'];
            $dataarr['value'] = "value_" . $parval['p_shortname'];
            array_push($arr, $dataarr);
        }
        $this->assign('endtime', $endtime);
        $this->assign('starttime', $starttime);
        $this->assign('arr', $arr);
        $this->assign('rgn_atpid', $rgn_atpid);
        $this->display();
    }

    public function  Twicedatad()
    {
        $this->logSys(session('emp_atpid'), "访问日志", "访问页面：$this->ATPLocationName / 【历史采集数据】 / 【天数据】");
        $endtime = $_GET['endtime'];
        $starttime = $_GET['starttime'];
        $rgn_atpid = I('get.rgn_atpid');
        $Model = M();
        $colwhere = "";
        $res = $this->getRegionDevicePoint(I("get.regiontype", ""), I("get.rgn_atpid", ""), I("get.snname", ""));
        $sql_select="";
        foreach ($res as $key => $value) {
            $date[] = "'" . $value['rgn_atpid'] . "'";
        }
        $endrgn_atpidsstrings = implode(',', $date);
        if ($rgn_atpid) {
            $sql_select = $this->buildSql($sql_select, "t.d2y_regionid in (" . $endrgn_atpidsstrings . ")");
            $colwhere = "and t3.etr_regionid in (" . $endrgn_atpidsstrings . ")";
        }
        // if ($rgn_atpid) {
        //     $colwhere="and t3.etr_regionid = '$rgn_atpid'";
        // }
        $equipmentparameter = $Model->query("
                                select distinct t.p_name,t.p_shortname,t.p_unit from szny_param t
                                left join szny_energytyperegion t3 on t.p_energytypeid = t3.etr_energytypeid
                                where p_atpstatus is null $colwhere
                                order by t.p_name desc");
        $arr = array();
        foreach ($equipmentparameter as $parkey => $parval) {
            $dataarr = array();
            $dataarr['name'] = $parval['p_name'] . "-" . $parval['p_unit'];
            $dataarr['value'] = "value_" . $parval['p_shortname'];
            array_push($arr, $dataarr);
        }
        $this->assign('endtime', $endtime);
        $this->assign('starttime', $starttime);
        $this->assign('arr', $arr);
        $this->assign('rgn_atpid', $rgn_atpid);
        $this->display();
    }

    public function  Twicedatah()
    {
        $this->logSys(session('emp_atpid'), "访问日志", "访问页面：$this->ATPLocationName / 【历史采集数据】 / 【时数据】");
        $endtime = $_GET['endtime'];
        $starttime = $_GET['starttime'];
        $rgn_atpid = I('get.rgn_atpid');
        $Model = M();
        $colwhere = "";
        $res = $this->getRegionDevicePoint(I("get.regiontype", ""), I("get.rgn_atpid", ""), I("get.snname", ""));
        $sql_select="";
        foreach ($res as $key => $value) {
            $date[] = "'" . $value['rgn_atpid'] . "'";
        }
        $endrgn_atpidsstrings = implode(',', $date);
        if ($rgn_atpid) {
            $sql_select = $this->buildSql($sql_select, "t.d2y_regionid in (" . $endrgn_atpidsstrings . ")");
            $colwhere = "and t3.etr_regionid in (" . $endrgn_atpidsstrings . ")";
        }
        // if ($rgn_atpid) {
        //     $colwhere="and t3.etr_regionid = '$rgn_atpid'";
        // }
        $equipmentparameter = $Model->query("
                                select distinct t.p_name,t.p_shortname,t.p_unit from szny_param t
                                left join szny_energytyperegion t3 on t.p_energytypeid = t3.etr_energytypeid
                                where p_atpstatus is null $colwhere
                                order by t.p_name desc");
        $arr = array();
        foreach ($equipmentparameter as $parkey => $parval) {
            $dataarr = array();
            $dataarr['name'] = $parval['p_name'] . "-" . $parval['p_unit'];
            $dataarr['value'] = "value_" . $parval['p_shortname'];
            array_push($arr, $dataarr);
        }
        $this->assign('endtime', $endtime);
        $this->assign('starttime', $starttime);
        $this->assign('arr', $arr);
        $this->assign('rgn_atpid', $rgn_atpid);
        $this->display();
    }

    public function  Twicedatam()
    {
        $this->logSys(session('emp_atpid'), "访问日志", "访问页面：$this->ATPLocationName / 【历史采集数据】 / 【月数据】");
        $endtime = $_GET['endtime'];
        $starttime = $_GET['starttime'];
        $rgn_atpid = I('get.rgn_atpid');
        $Model = M();
        $colwhere = "";
        $res = $this->getRegionDevicePoint(I("get.regiontype", ""), I("get.rgn_atpid", ""), I("get.snname", ""));
        $sql_select="";
        foreach ($res as $key => $value) {
            $date[] = "'" . $value['rgn_atpid'] . "'";
        }
        $endrgn_atpidsstrings = implode(',', $date);
        if ($rgn_atpid) {
            $sql_select = $this->buildSql($sql_select, "t.d2y_regionid in (" . $endrgn_atpidsstrings . ")");
            $colwhere = "and t3.etr_regionid in (" . $endrgn_atpidsstrings . ")";
        }
        // if ($rgn_atpid) {
        //     $colwhere="and t3.etr_regionid = '$rgn_atpid'";
        // }
        $equipmentparameter = $Model->query("
                                select distinct t.p_name,t.p_shortname,t.p_unit from szny_param t
                                left join szny_energytyperegion t3 on t.p_energytypeid = t3.etr_energytypeid
                                where p_atpstatus is null $colwhere
                                order by t.p_name desc");
        $arr = array();
        foreach ($equipmentparameter as $parkey => $parval) {
            $dataarr = array();
            $dataarr['name'] = $parval['p_name'] . "-" . $parval['p_unit'];
            $dataarr['value'] = "value_" . $parval['p_shortname'];
            array_push($arr, $dataarr);
        }
        $this->assign('endtime', $endtime);
        $this->assign('starttime', $starttime);
        $this->assign('arr', $arr);
        $this->assign('rgn_atpid', $rgn_atpid);
        $this->display();
    }

    public function getDatay()
    {
        $regionid = I('get.rgn_atpid');
        $queryparam = json_decode(file_get_contents("php://input"), true);
        $Model = M();
        $endtime = $queryparam['endtime'];
        $starttime = $queryparam['starttime'];
        $WhereConditionArray = array();
        $sql_select = "
                select
                 t.*,t1.dev_code,t2.rgn_name
                 from szny_data2year t
                 left join szny_device t1 on t1.dev_atpid=t.d2y_deviceid
                 left join szny_region t2 on t2.rgn_atpid=t.d2y_regionid
                ";

        $sql_count = "
                select
                count(1) c
                from szny_data2year t
                left join szny_device t1 on t1.dev_atpid=t.d2y_deviceid
                left join szny_region t2 on t2.rgn_atpid=t.d2y_regionid";

        $sql_select = $this->buildSql($sql_select, "t.d2y_atpstatus is null");
        $sql_count = $this->buildSql($sql_count, "t.d2y_atpstatus is null");
        $sql_select = $this->buildSql($sql_select, "t1.dev_atpstatus is null");
        $sql_count = $this->buildSql($sql_count, "t1.dev_atpstatus is null");
        $sql_select = $this->buildSql($sql_select, "t2.rgn_atpstatus is null");
        $sql_count = $this->buildSql($sql_count, "t2.rgn_atpstatus is null");
        $res = $this->getRegionDevicePoint(I("get.regiontype", ""), I("get.rgn_atpid", ""), I("get.snname", ""));
        foreach ($res as $key => $value) {
            $date[] = "'" . $value['rgn_atpid'] . "'";
        }
        $endrgn_atpidsstrings = implode(',', $date);
        // dump($endrgn_atpidsstrings);
        if ($regionid) {
            $sql_select = $this->buildSql($sql_select, "t.d2y_regionid in (" . $endrgn_atpidsstrings . ")");
            $sql_count = $this->buildSql($sql_count, "t.d2y_regionid in (" . $endrgn_atpidsstrings . ")");
        } else {
            //   $sql_select = $this->buildSql($sql_select, "t.data_regionid in('".$arr."')");
            //  $sql_count = $this->buildSql($sql_count, "t.data_regionid  in('".$arr."')");
        }

        if ($endtime && $starttime) {
            $sql_select = $this->buildSql($sql_select, "t.d2y_dt>='" . $starttime . "' and t.d2y_dt<='" . $endtime . "'");
            $sql_count = $this->buildSql($sql_count, "t.d2y_dt>='" . $starttime . "' and t.d2y_dt<='" . $endtime . "'");
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
            $sql_select = $sql_select . " order by t.d2y_atpcreatedatetime desc ";
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


        $sql_select_rel = "select * from szny_param t where t.p_atpstatus is null order by t.p_atpsort asc ";
        $Result_rel = $Model->query($sql_select_rel);
        foreach ($Result as $k => &$v) {
            foreach ($Result_rel as $rmk => $rmv) {

                if ("累计值" == $rmv['p_category']) {
                    $v['value_' . $rmv['p_shortname']] =
                        "累积:<font color='red'>" . $v['d2y_' . $rmv['p_shortname'] . "accu"] . "</font>";
                } else {
                    $v['value_' . $rmv['p_shortname']] =
                        "最小:<font color='red'>" . $v['d2y_' . $rmv['p_shortname'] . "min"] . "</font><br/>" .
                        "最大:<font color='red'>" . $v['d2y_' . $rmv['p_shortname'] . "max"] . "</font><br/>" .
                        "均值:<font color='red'>" . $v['d2y_' . $rmv['p_shortname'] . "avg"] . "</font><br/>";
                }

            }
        }
        echo json_encode(array('total' => $Count[0]['c'], 'rows' => $Result));
    }

    public function getDatad()
    {
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
        $res = $this->getRegionDevicePoint(I("get.regiontype", ""), I("get.rgn_atpid", ""), I("get.snname", ""));
        foreach ($res as $key => $value) {
            $date[] = "'" . $value['rgn_atpid'] . "'";
        }
        $endrgn_atpidsstrings = implode(',', $date);
        // dump($endrgn_atpidsstrings);
        if ($regionid) {
            $sql_select = $this->buildSql($sql_select, "t.d2d_regionid in (" . $endrgn_atpidsstrings . ")");
            $sql_count = $this->buildSql($sql_count, "t.d2d_regionid in (" . $endrgn_atpidsstrings . ")");
        }
        if ($endtime && $starttime) {
            $sql_select = $this->buildSql($sql_select, "t.d2d_dt>='" . $starttime . "' and t.d2d_dt<='" . $endtime . "'");
            $sql_count = $this->buildSql($sql_count, "t.d2d_dt>='" . $starttime . "' and t.d2d_dt<='" . $endtime . "'");
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

    public function getDatah()
    {
        $regionid = I('get.rgn_atpid');
        $queryparam = json_decode(file_get_contents("php://input"), true);
        $Model = M();
//       $Result_tree = $this->regionrecursive("guid1A15CA6C-E3D2-4779-BF6B-F6C2D4706C9D");
//        foreach($Result_tree as $key=>$val){
//            $arr .=$val['id'].',';
//        }
        $endtime = $queryparam['endtime'];
        $starttime = $queryparam['starttime'];
        $WhereConditionArray = array();
        $sql_select = "
                select
                 t.*,t1.dev_code,t2.rgn_name
                 from szny_data2hour t
                 left join szny_device t1 on t1.dev_atpid=t.d2h_deviceid
                 left join szny_region t2 on t2.rgn_atpid=t.d2h_regionid
                ";

        $sql_count = "
                select
                count(1) c
                from szny_data2hour t
                left join szny_device t1 on t1.dev_atpid=t.d2h_deviceid
                left join szny_region t2 on t2.rgn_atpid=t.d2h_regionid";

        $sql_select = $this->buildSql($sql_select, "t.d2h_atpstatus is null");
        $sql_count = $this->buildSql($sql_count, "t.d2h_atpstatus is null");
        $sql_select = $this->buildSql($sql_select, "t1.dev_atpstatus is null");
        $sql_count = $this->buildSql($sql_count, "t1.dev_atpstatus is null");
        $sql_select = $this->buildSql($sql_select, "t2.rgn_atpstatus is null");
        $sql_count = $this->buildSql($sql_count, "t2.rgn_atpstatus is null");
        $res = $this->getRegionDevicePoint(I("get.regiontype", ""), I("get.rgn_atpid", ""), I("get.snname", ""));
        foreach ($res as $key => $value) {
            $date[] = "'" . $value['rgn_atpid'] . "'";
        }
        $endrgn_atpidsstrings = implode(',', $date);
        // dump($endrgn_atpidsstrings);
        if ($regionid) {
            $sql_select = $this->buildSql($sql_select, "t.d2h_regionid in (" . $endrgn_atpidsstrings . ")");
            $sql_count = $this->buildSql($sql_count, "t.d2h_regionid in (" . $endrgn_atpidsstrings . ")");
        }

        if ($endtime && $starttime) {
            $sql_select = $this->buildSql($sql_select, "t.d2h_dt>='" . $starttime . "' and t.d2h_dt<='" . $endtime . "'");
            $sql_count = $this->buildSql($sql_count, "t.d2h_dt>='" . $starttime . "' and t.d2h_dt<='" . $endtime . "'");
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
            $sql_select = $sql_select . " order by t.d2h_atpcreatedatetime desc ";
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
                        "累积:<font color='red'>" . $v['d2h_' . $rmv['p_shortname'] . "accu"] . "</font>";
                } else {
                    $v['value_' . $rmv['p_shortname']] =
                        "最小:<font color='red'>" . $v['d2h_' . $rmv['p_shortname'] . "min"] . "</font><br/>" .
                        "最大:<font color='red'>" . $v['d2h_' . $rmv['p_shortname'] . "max"] . "</font><br/>" .
                        "均值:<font color='red'>" . $v['d2h_' . $rmv['p_shortname'] . "avg"] . "</font><br/>";
                }
            }
        }


        echo json_encode(array('total' => $Count[0]['c'], 'rows' => $Result));
    }

    public function getDatam()
    {
        $regionid = I('get.rgn_atpid');
        $queryparam = json_decode(file_get_contents("php://input"), true);
        $Model = M();
//       $Result_tree = $this->regionrecursive("guid1A15CA6C-E3D2-4779-BF6B-F6C2D4706C9D");
//        foreach($Result_tree as $key=>$val){
//            $arr .=$val['id'].',';
//        }
        $endtime = $queryparam['endtime'];

        $starttime = $queryparam['starttime'];
        $WhereConditionArray = array();
        $sql_select = "
                select
                 t.*,t1.dev_code,t2.rgn_name
                 from szny_data2month t
                 left join szny_device t1 on t1.dev_atpid=t.d2m_deviceid
                 left join szny_region t2 on t2.rgn_atpid=t.d2m_regionid
                ";

        $sql_count = "
                select
                count(1) c
                from szny_data2month t
                left join szny_device t1 on t1.dev_atpid=t.d2m_deviceid
                left join szny_region t2 on t2.rgn_atpid=t.d2m_regionid";

        $sql_select = $this->buildSql($sql_select, "t.d2m_atpstatus is null");
        $sql_count = $this->buildSql($sql_count, "t.d2m_atpstatus is null");
        $sql_select = $this->buildSql($sql_select, "t1.dev_atpstatus is null");
        $sql_count = $this->buildSql($sql_count, "t1.dev_atpstatus is null");
        $sql_select = $this->buildSql($sql_select, "t2.rgn_atpstatus is null");
        $sql_count = $this->buildSql($sql_count, "t2.rgn_atpstatus is null");
        $res = $this->getRegionDevicePoint(I("get.regiontype", ""), I("get.rgn_atpid", ""), I("get.snname", ""));
        foreach ($res as $key => $value) {
            $date[] = "'" . $value['rgn_atpid'] . "'";
        }
        $endrgn_atpidsstrings = implode(',', $date);
        // dump($endrgn_atpidsstrings);
        if ($regionid) {
            $sql_select = $this->buildSql($sql_select, "t.d2m_regionid in (" . $endrgn_atpidsstrings . ")");
            $sql_count = $this->buildSql($sql_count, "t.d2m_regionid in (" . $endrgn_atpidsstrings . ")");
        }

        if ($endtime && $starttime) {
            $sql_select = $this->buildSql($sql_select, "t.d2m_dt>='" . $starttime . "' and t.d2m_dt<='" . $endtime . "'");
            $sql_count = $this->buildSql($sql_count, "t.d2m_dt>='" . $starttime . "' and t.d2m_dt<='" . $endtime . "'");
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
            $sql_select = $sql_select . " order by t.d2m_atpcreatedatetime desc ";
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
                        "累积:<font color='red'>" . $v['d2m_' . $rmv['p_shortname'] . "accu"] . "</font>";
                } else {
                    $v['value_' . $rmv['p_shortname']] =
                        "最小:<font color='red'>" . $v['d2m_' . $rmv['p_shortname'] . "min"] . "</font><br/>" .
                        "最大:<font color='red'>" . $v['d2m_' . $rmv['p_shortname'] . "max"] . "</font><br/>" .
                        "均值:<font color='red'>" . $v['d2m_' . $rmv['p_shortname'] . "avg"] . "</font><br/>";
                }
            }
        }


        echo json_encode(array('total' => $Count[0]['c'], 'rows' => $Result));
    }
}