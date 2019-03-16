<?php
namespace Admin\Controller;
use Think\Controller;
use Admin\BaseController;
class UsersideController extends BaseAuthController
{
    public function index()
    {
        $bs = $_GET['bs'];
        if($bs=='zh'){
            $this->logSys(session('emp_atpid'),"访问日志","访问页面：【租户管理】 / 【租户管理】");
            $page = "租户管理";
        }elseif($bs=='yz'){
            $this->logSys(session('emp_atpid'),"访问日志","访问页面：【业主管理】 / 【业主管理】");
            $page = "业主管理";
        }
        $this->assign("bs",$bs);
        $this->assign("page",$page);
        $this->display();
    }

    public function add()
    {
        $bs = $_GET['bs'];
        $this->assign("bs",$bs);
        $this->display();
        $this->logSys(session('emp_atpid'),"访问日志","访问页面：【租户管理】 / 【租户管理】 / 【添加】");
    }

    public function edit()
    {
        $id = I('get.id','');
        $bs = $_GET['bs'];
        $this->assign("bs",$bs);
        if ($id) {
            $Model = M('userside');
            $data = $Model->where("us_atpid='%s'", array($id))->find();
            if ($data) {
                $this->assign('data', $data);
            }
        }
        $this->display("add");
        $this->logSys(session('emp_atpid'),"访问日志","访问页面：【租户管理】 / 【租户管理】 / 【编辑】");
    }

    public function del()
    {
        try {
            $ids = I('post.ids','');
            $array = explode(',', $ids);
            if ($array && count($array) > 0) {
                $Model = M("userside");
                foreach ($array as $id) {
                    $data = $Model->where("us_atpid='%s'", array($id))->find();
                    $data['us_atpstatus'] = 'DEL';
                    $data['us_atplastmodifydatetime'] = date('Y-m-d H:i:s', time());
                    $data['us_atplastmodifyuser'] = session('emp_account');
                    $Model->where("us_atpid='%s'", $id)->save($data);
                }
            }
        } catch (\Exception $e) {
            echo "fail" . $e;
        }
        $this->logSys(session('emp_atpid'),"访问日志","访问页面：【租户管理】 / 【租户管理】 / 【删除】");
    }

    public function submit(){
        $Model = M('userside');
        $data = $Model->create();
        if (null == $data['us_atpid']){
            //添加
            $data['us_atpid'] = $this->makeGuid();
            $data['us_atpcreatedatetime'] = date("Y-m-d H:i:s",time());
            $data['us_atpcreateuser'] = session('emp_account');
            $data['us_atplastmodifydatetime'] = date("Y-m-d H:i:s",time());
            $data['us_atplastmodifyuser'] = session('emp_account');
            if($data['us_category'] == 'yz'){
                $data['us_category'] = '业主';
            }elseif($data['us_category'] == 'zh'){
                $data['us_category'] = '租户';
            }
            $Model->add($data);
        }else{
            $data['us_atplastmodifydatetime'] = date('Y-m-d H:i:s', time());
            $data['us_atplastmodifyuser'] = session('emp_account');
            $Model->where("us_atpid='%s'", array($data['us_atpid']))->save($data);
        }
    }

    //获取所有数据
    public function getData(){
        $queryparam = json_decode(file_get_contents("php://input"), true);
        $Model = M('userside');
        $bs = I('get.bs','');
        $sql_select = "
                select
                    t.*
                from szny_userside t
                ";
        $sql_count = "
                select
                    count(1) c
                from szny_userside t
                ";
        $sql_select = $this->buildSql($sql_select, "t.us_atpstatus is null");
        $sql_count = $this->buildSql($sql_count, "t.us_atpstatus is null");
        if($bs == 'yz'){
            $sql_select = $this->buildSql($sql_select, "t.us_category  = '业主'");
            $sql_count = $this->buildSql($sql_count, "t.us_category  = '业主'");
        }elseif($bs == 'zh'){
            $sql_select = $this->buildSql($sql_select, "t.us_category  = '租户'");
            $sql_count = $this->buildSql($sql_count, "t.us_category  = '租户'");
        }

        //快捷搜索
        if (null != $queryparam['search']) {
            $searchcontent = trim($queryparam['search']);
            $sql_select = $this->buildSql($sql_select, "t.us_name like '%" . $searchcontent . "%'");
            $sql_count = $this->buildSql($sql_count, "t.us_name like '%" . $searchcontent . "%'");
        }
        //排序
        if (null != $queryparam['sort']) {
            $sql_select = $sql_select . " order by " . $queryparam['sort'] . ' ' . $queryparam['sortOrder'] . ' ';
        } else {
            $sql_select = $sql_select . " order by t.us_name desc";
        }

        //自定义分页
        if (null != $queryparam['limit']) {
            if ('0' == $queryparam['offset']) {
                $sql_select = $sql_select . " limit " . '0' . ',' . $queryparam['limit'] . ' ';
            } else {
                $sql_select = $sql_select . " limit " . $queryparam['offset'] . ',' . $queryparam['limit'] . ' ';
            }
        }
        $Result = $Model->query($sql_select);//dump($Result);
        foreach($Result as $key=>$val){
            $sql = "select count(*) as num from szny_usersideregion where usr_atpstatus is null and usr_usersideid = '".$val['us_atpid']."'";
            $data = $Model->query($sql);
            $Result[$key]['count']=$data['0']['num'];
        }
        $Count = $Model->query($sql_count);
        echo json_encode(array('total' => $Count[0]['c'], 'rows' => $Result));

    }
    public function Usersideinform(){

        $bs = $_GET['bs'];
        if($bs=='zh'){
            $this->logSys(session('emp_atpid'),"访问日志","访问页面：【租户管理】 / 【租户管理】");
            $page = "租户管理";
        }elseif($bs=='yz'){
            $this->logSys(session('emp_atpid'),"访问日志","访问页面：【业主管理】 / 【业主管理】");
            $page = "业主管理";
        }
        $this->assign("bs",$bs);
        $this->assign("page",$page);

        $usr_usersideid = I('get.id','');
        $Model = M();
        $sql = "select * from szny_usersideregion where usr_atpstatus is null and usr_usersideid = '$usr_usersideid'";
        $data = $Model->query($sql);
        $str = '';
        foreach($data as $key => $value){
            $str .= "'" .$value['usr_regionid'] ."'" . ',';
        }
        $str = substr($str,0,strlen($str)-1);
//        dump($str);die();
        $Mode = M();
        $sql_select = "
          select 
            * 
          from szny_region t 
          left join szny_energytyperegion t1 on t.rgn_atpid = t1.etr_regionid
          left join szny_energytype t2 on t2.et_atpid = t1.etr_energytypeid
          where t.rgn_atpstatus is null and t1.etr_atpstatus is null and t2.et_atpstatus is null and t.rgn_atpid in ($str)
          group by t.rgn_atpid
          order by t.rgn_name asc
          ";
        $Tree = $Mode->query($sql_select);
        $treedatas = array();
        foreach ($Tree as $key_org => $value_org) {
            $tdata = array();
            $tdata['id'] = $value_org['rgn_atpid'];
            $tdata['pid'] = $value_org['rgn_pregionid'];
            $tdata['name'] = $value_org['rgn_name'];
            $tdata['open'] = true;
            if('园区' == $value_org['rgn_category']){
                $tdata['icon'] = $this->makeICONPath()."/Public/vendor/zTree_v3/css/zTreeStyle/img/diy/park.png";
            }elseif ('楼' == $value_org['rgn_category']){
                $tdata['icon'] = $this->makeICONPath()."/Public/vendor/zTree_v3/css/zTreeStyle/img/diy/build.png";
            }elseif ('座' == $value_org['rgn_category']){
                $tdata['icon'] = $this->makeICONPath()."/Public/vendor/zTree_v3/css/zTreeStyle/img/diy/floor.png";
            }elseif ('单元' == $value_org['rgn_category']){
                $tdata['icon'] = $this->makeICONPath()."/Public/vendor/zTree_v3/css/zTreeStyle/img/diy/unit.png";
            }elseif ('层' == $value_org['rgn_category']){
                $tdata['icon'] = $this->makeICONPath()."/Public/vendor/zTree_v3/css/zTreeStyle/img/diy/storey.png";
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

            $tdata['type'] = '租户';
            array_push($treedatas, $tdata);
        }
        $this->assign('us_atpid',$usr_usersideid);
        $this->assign('treedatas',json_encode($treedatas));
        $this->display();
    }
    public function Usersidezhxx(){
        $rgn_atpid = I('get.rgn_atpid','');
        $Model = M();
        $us_atpid = I('get.us_atpid','');
        $user = M('userside')->find($us_atpid);
        $user['us_atpcreatedatetime'] = mb_substr($user['us_atpcreatedatetime'],0,11);
        if ($rgn_atpid){
            $list = M("region")->find($rgn_atpid);
            if ($list['rgn_category']=='设备点'){
                $res = $this->regionrecursive($rgn_atpid);
            }else{
                $res = $this->regionrecursiveuserside($rgn_atpid,$us_atpid);
            }
        }else{
            $res = M("usersideregion")->field('usr_regionid as rgn_atpid')->where("usr_atpstatus is null")->select();
        }

        foreach ($res as $key => $value)
        {
            $date[] = "'" . $value['rgn_atpid'] . "'";
        }
        $endrgn_atpidsstrings = implode(',', $date);
        $daytime = date("Y-m-d",time());
        $yeartime = date("Y",time());
        // dump($endrgn_atpidsstrings);
        // 统计今日数据
        $sql_select_day = "
            select
            t1.rgn_name,t.d2d_dt,sum(t.d2d_yllaccu) as d2d_yllaccu ,sum(t.d2d_ynlaccu) as d2d_ynlaccu ,sum(t.d2d_dglaccu) as d2d_dglaccu ,sum(t.d2d_syslaccu) as d2d_syslaccu
            from szny_data2day t
            left join szny_region t1 on t.d2d_regionid = t1.rgn_atpid
        ";
        $sql_select_day = $this->buildSql($sql_select_day, "t.d2d_atpstatus is null");
        $sql_select_day = $this->buildSql($sql_select_day, "t1.rgn_atpstatus is null");
        $sql_select_day = $this->buildSql($sql_select_day, "t.d2d_dt = '$daytime'");
        $sql_select_day = $this->buildSql($sql_select_day, "t.d2d_regionid in (" . $endrgn_atpidsstrings . ")");
        $dayaccu = $Model->query($sql_select_day);
//        dump($dayaccu);
        if(empty($dayaccu[0]['d2d_dt'])){
            $dayaccu[0]['d2d_yllaccu'] = '0';
            $dayaccu[0]['d2d_ynlaccu'] = '0';
            $dayaccu[0]['d2d_dglaccu'] = '0';
            $dayaccu[0]['d2d_syslaccu'] = '0';
        }
        // 统计今年数据
        $sql_select_year = "
            select
            t1.rgn_name,t.d2y_dt,sum(t.d2y_yllaccu) as d2y_yllaccu ,sum(t.d2y_ynlaccu) as d2y_ynlaccu ,sum(t.d2y_dglaccu) as d2y_dglaccu ,sum(t.d2y_syslaccu) as d2y_syslaccu
            from szny_data2year t
            left join szny_region t1 on t.d2y_regionid = t1.rgn_atpid
        ";
        $sql_select_year = $this->buildSql($sql_select_year, "t.d2y_atpstatus is null");
        $sql_select_year = $this->buildSql($sql_select_year, "t1.rgn_atpstatus is null");
        $sql_select_year = $this->buildSql($sql_select_year, "t.d2y_dt = '$yeartime'");
        $sql_select_year = $this->buildSql($sql_select_year, "t.d2y_regionid in (" . $endrgn_atpidsstrings . ")");
        $yaaraccu = $Model->query($sql_select_year);
        // 获取报警数量信息
        $sql_alarm = "
            select 
            count(*) count
            from szny_alarm t
            left join szny_device t1 on t.alm_deviceid = t1.dev_atpid
            left join szny_emp t2 on t.alm_empid = t2.emp_atpid
            left join szny_region t3 on t1.dev_regionid = t3.rgn_atpid
            left join szny_alarmconfig t5 on t5.almc_atpid = t.alm_alarmconfigid
        ";
        $sql_alarm = $this->buildSql($sql_alarm, "t.alm_atpstatus is null");
        $sql_alarm = $this->buildSql($sql_alarm, "t1.dev_atpstatus is null");
        $sql_alarm = $this->buildSql($sql_alarm, "t2.emp_atpstatus is null");
        $sql_alarm = $this->buildSql($sql_alarm, "t3.rgn_atpstatus is null");
//        $sql_alarm = $this->buildSql($sql_alarm, "t.alm_disposeresult is null");
        $sql_alarm = $this->buildSql($sql_alarm, "t3.rgn_atpid in (".$endrgn_atpidsstrings.")");

        $countalarm = $Model->query($sql_alarm);

        // 月份相差值 用于计算月平均用水
        $monthstr = date('Y01', strtotime(date("Ym")));
        $monthend = date('Ym', time());
        $monthcount = $monthend -$monthstr +1;;// 月份相差值
//        $statrtime = date("Y-m-01",time());
        $statrtime = date("Y-m",time());
        $endtime = date("Y-m-d",time());
        // 统计月平均数据
        $sql_select_month = "
            select
            t.d2d_dt,sum(t.d2d_yllaccu) as d2d_yllaccu ,sum(t.d2d_ynlaccu) as d2d_ynlaccu ,sum(t.d2d_dglaccu) as d2d_dglaccu ,sum(t.d2d_syslaccu) as d2d_syslaccu
            from szny_data2day t
        ";
        $sql_select_month = $this->buildSql($sql_select_month, "t.d2d_atpstatus is null");
        $sql_select_month = $this->buildSql($sql_select_month, "t.d2d_dt like '$statrtime%' ");
//        $sql_select_month = $this->buildSql($sql_select_month, "t.d2d_dt <= '$endtime' ");
        $sql_select_month = $this->buildSql($sql_select_month, "t.d2d_regionid in (" . $endrgn_atpidsstrings . ")");
        $monthaccu = $Model->query($sql_select_month);
//        dump($monthaccu);
        foreach ($monthaccu as $key => &$value) {
            $monthaccu[$key]['month_ysl'] = $monthaccu[$key]['d2d_syslaccu'];
            $monthaccu[$key]['month_ynl'] = $monthaccu[$key]['d2d_ynlaccu'];
            $monthaccu[$key]['month_yll'] = $monthaccu[$key]['d2d_yllaccu'];
            $monthaccu[$key]['month_ydl'] = $monthaccu[$key]['d2d_dglaccu'];
        }
        $this->assign('dayaccu',$dayaccu[0]);
        $this->assign('monthaccu',$monthaccu[0]);
        $this->assign('countalarm',$countalarm[0]);
        $this->assign('user',$user);
        $this->assign('bj',$bj);
        $this->assign('rgn_atpid',$rgn_atpid);
        $this->assign('us_atpid',$us_atpid);
        $this->display();
    }
    public function table_tenant(){
        $rgn_atpid = I('get.rgn_atpid','');
        $us_atpid = I('get.us_atpid','');
        $Model = M();
        $user = M('userside')->find($us_atpid);
        $where1['usr_usersideid'] = $us_atpid;
        if ($rgn_atpid){
            $list = M("region")->find($rgn_atpid);
            if ($list['rgn_category']=='设备点'){
                $res = $this->regionrecursive($rgn_atpid);
            }else{
                $res = $this->regionrecursiveuserside($rgn_atpid,$us_atpid);
            }
        }else{
            $res = M("usersideregion")->field('usr_regionid as rgn_atpid')->where($where1)->where("usr_atpstatus is null")->select();
        }

        foreach ($res as $key => $value)
        {
            $date[] = "'" . $value['rgn_atpid'] . "'";
        }
        $endrgn_atpidsstrings = implode(',', $date);
        $daytime = date("Y-m-d",time());
        $yeartime = date("Y",time());

        // 统计今日数据
        $sql_select_day = "
            select
            t1.rgn_name,t.d2d_dt,sum(t.d2d_yllaccu) as d2d_yllaccu ,sum(t.d2d_ynlaccu) as d2d_ynlaccu ,sum(t.d2d_dglaccu) as d2d_dglaccu ,sum(t.d2d_syslaccu) as d2d_syslaccu
            from szny_data2day t
            left join szny_region t1 on t.d2d_regionid = t1.rgn_atpid
        ";
        $sql_select_day = $this->buildSql($sql_select_day, "t.d2d_atpstatus is null");
        $sql_select_day = $this->buildSql($sql_select_day, "t1.rgn_atpstatus is null");
        $sql_select_day = $this->buildSql($sql_select_day, "t.d2d_dt = '$daytime'");
        $sql_select_day = $this->buildSql($sql_select_day, "t.d2d_regionid in (" . $endrgn_atpidsstrings . ")");
        $dayaccu = $Model->query($sql_select_day);
        if(empty($dayaccu[0]['d2d_dt'])){
            $dayaccu[0]['d2d_yllaccu'] = '0';
            $dayaccu[0]['d2d_ynlaccu'] = '0';
            $dayaccu[0]['d2d_dglaccu'] = '0';
            $dayaccu[0]['d2d_syslaccu'] = '0';
        }
        // 统计今年数据
        $sql_select_year = "
            select
            t1.rgn_name,t.d2y_dt,sum(t.d2y_yllaccu) as d2y_yllaccu ,sum(t.d2y_ynlaccu) as d2y_ynlaccu ,sum(t.d2y_dglaccu) as d2y_dglaccu ,sum(t.d2y_syslaccu) as d2y_syslaccu
            from szny_data2year t
            left join szny_region t1 on t.d2y_regionid = t1.rgn_atpid
        ";
        $sql_select_year = $this->buildSql($sql_select_year, "t.d2y_atpstatus is null");
        $sql_select_year = $this->buildSql($sql_select_year, "t1.rgn_atpstatus is null");
        $sql_select_year = $this->buildSql($sql_select_year, "t.d2y_dt = '$yeartime'");
        $sql_select_year = $this->buildSql($sql_select_year, "t.d2y_regionid in (" . $endrgn_atpidsstrings . ")");
        $yaaraccu = $Model->query($sql_select_year);

        // 月数据
        $monthtime = date("Y-m",time());
        // 统计月平均数据
        $sql_select_month = "
            select
            t.d2m_dt,sum(t.d2m_yllaccu) as d2m_yllaccu ,sum(t.d2m_ynlaccu) as d2m_ynlaccu ,sum(t.d2m_dglaccu) as d2m_dglaccu ,sum(t.d2m_syslaccu) as d2m_syslaccu
            from szny_data2month t
        ";
        $sql_select_month = $this->buildSql($sql_select_month, "t.d2m_atpstatus is null");
        $sql_select_month = $this->buildSql($sql_select_month, "t.d2m_dt = '$monthtime' ");
        $sql_select_month = $this->buildSql($sql_select_month, "t.d2m_regionid in (" . $endrgn_atpidsstrings . ")");
        $monthaccu = $Model->query($sql_select_month);
        $this->assign('dayaccu',$dayaccu[0]); // 日
        $this->assign('monthaccu',$monthaccu[0]); // 月
        $this->assign('yaaraccu',$yaaraccu[0]);  // 年
        $this->assign('rgn_atpid',$rgn_atpid);
        $this->assign('us_atpid',$us_atpid);
        $this->display("table-tenant");
    }
    public function yibiao_day(){
        $rgn_atpid = I('get.rgn_atpid','');
        $us_atpid = I('get.us_atpid','');
        $rgn_atpid = I('get.rgn_atpid','');
        $us_atpid = I('get.us_atpid','');
        $Model = M();
        $user = M('userside')->find($us_atpid);
        $where1['usr_usersideid'] = $us_atpid;
        if ($rgn_atpid){
            $list = M("region")->find($rgn_atpid);
            if ($list['rgn_category']=='设备点'){
                $res = $this->regionrecursive($rgn_atpid);
            }else{
                $res = $this->regionrecursiveuserside($rgn_atpid,$us_atpid);
            }
        }else{
            $res = M("usersideregion")->field('usr_regionid as rgn_atpid')->where($where1)->where("usr_atpstatus is null")->select();
        }
        foreach ($res as $key => $value)
        {
            $date[] = "'" . $value['rgn_atpid'] . "'";
        }
        $endrgn_atpidsstrings = implode(',', $date);
        $starttime = date("Y-m-d 00:00:00",time());
        $endtime = date("Y-m-d 23:00:00",time());
        $endtime = date("Y-m-d",strtotime("+1 day"));
        // dump($endtime);
        // 统计今日24小时数据
        $sql_select_day = "
            select
            t.d2h_dt,t.d2h_regionid,sum(t.d2h_dglaccu) as d2h_dglaccu,sum(t.d2h_syslaccu) as d2h_syslaccu,sum(t.d2h_yllaccu) as d2h_yllaccu,sum(t.d2h_ynlaccu) as d2h_ynlaccu
            from szny_data2hour t
        ";
        $sql_select_day = $this->buildSql($sql_select_day, "t.d2h_atpstatus is null");
        // $sql_select_day = $this->buildSql($sql_select_day, "t1.rgn_atpstatus is null");
        $sql_select_day = $this->buildSql($sql_select_day, "t.d2h_dt >= '$starttime'");
        $sql_select_day = $this->buildSql($sql_select_day, "t.d2h_dt <= '$endtime'");
        $sql_select_day = $this->buildSql($sql_select_day, "t.d2h_regionid in (" . $endrgn_atpidsstrings . ")");
        $sql_select_day = $sql_select_day . "group by t.d2h_dt";
        $sql_select_day = $sql_select_day . " order by t.d2h_dt asc";
//        echo $sql_select_day;
        $dayaccu = $Model->query($sql_select_day);
//        dump($dayaccu);
        // dump($dayaccu);
        $this->assign('dayaccu',$dayaccu);
        $this->assign('rgn_atpid',$rgn_atpid);
        $this->assign('us_atpid',$us_atpid);
        $this->assign('rgn_category',$rgn_category);
        $this->display("yibiao_day");
    }
    public function yibiao_month(){
        $rgn_atpid = I('get.rgn_atpid','');
        $us_atpid = I('get.us_atpid','');
        $Model= M();
        $user = M('userside')->find($us_atpid);
        $where1['usr_usersideid'] = $us_atpid;
        if ($rgn_atpid){
            $list = M("region")->find($rgn_atpid);
            if ($list['rgn_category']=='设备点'){
                $res = $this->regionrecursive($rgn_atpid);
            }else{
                $res = $this->regionrecursiveuserside($rgn_atpid,$us_atpid);
            }
        }else{
            $res = M("usersideregion")->field('usr_regionid as rgn_atpid')->where($where1)->where("usr_atpstatus is null")->select();
        }

        foreach ($res as $key => $value)
        {
            $date[] = "'" . $value['rgn_atpid'] . "'";
        }
        $endrgn_atpidsstrings = implode(',', $date);
        $starttime = date("Y-m-01",time());
        $endtime = date("Y-m-31",time());
        // dump($starttime);
        // 统计今日24小时数据
        $sql_select_month = "
            select
            t.d2d_dt,t.d2d_regionid,sum(t.d2d_dglaccu) as d2d_dglaccu,sum(t.d2d_syslaccu) as d2d_syslaccu,sum(t.d2d_yllaccu) as d2d_yllaccu,sum(t.d2d_ynlaccu) as d2d_ynlaccu
            from szny_data2day t
        ";
        $sql_select_month = $this->buildSql($sql_select_month, "t.d2d_atpstatus is null");
        $sql_select_month = $this->buildSql($sql_select_month, "t.d2d_dt >= '$starttime'");
        $sql_select_month = $this->buildSql($sql_select_month, "t.d2d_dt <= '$endtime'");
        $sql_select_month = $this->buildSql($sql_select_month, "t.d2d_regionid in (" . $endrgn_atpidsstrings . ")");
        $sql_select_month = $sql_select_month . "group by t.d2d_dt";
        $sql_select_month = $sql_select_month . " order by t.d2d_dt asc";
//        echo $sql_select_month;
        $monthaccu = $Model->query($sql_select_month);
//         dump($monthaccu);
        $this->assign('monthaccu',$monthaccu);
        $this->assign('rgn_atpid',$rgn_atpid);
        $this->assign('us_atpid',$us_atpid);
        $this->assign('rgn_category',$rgn_category);
        $this->display("yibiao_month");
    }
    public function yibiao_year(){
        $rgn_atpid = I('get.rgn_atpid','');
        $us_atpid = I('get.us_atpid','');
        $Model= M();
        $user = M('userside')->find($us_atpid);
        $where1['usr_usersideid'] = $us_atpid;
        if ($rgn_atpid){
            $list = M("region")->find($rgn_atpid);
            if ($list['rgn_category']=='设备点'){
                $res = $this->regionrecursive($rgn_atpid);
            }else{
                $res = $this->regionrecursiveuserside($rgn_atpid,$us_atpid);
            }
        }else{
            $res = M("usersideregion")->field('usr_regionid as rgn_atpid')->where($where1)->where("usr_atpstatus is null")->select();
        }

        foreach ($res as $key => $value)
        {
            $date[] = "'" . $value['rgn_atpid'] . "'";
        }
        $endrgn_atpidsstrings = implode(',', $date);
        $starttime = date("Y-01",time());
        $endtime = date("Y-12",time());
        // dump($starttime);
        // 统计今日24小时数据
        $sql_select_month = "
            select
            t.d2m_dt,t.d2m_regionid,sum(t.d2m_dglaccu) as d2m_dglaccu,sum(t.d2m_syslaccu) as d2m_syslaccu,sum(t.d2m_yllaccu) as d2m_yllaccu,sum(t.d2m_ynlaccu) as d2m_ynlaccu
            from szny_data2month t
        ";
        $sql_select_month = $this->buildSql($sql_select_month, "t.d2m_atpstatus is null");
        $sql_select_month = $this->buildSql($sql_select_month, "t.d2m_dt >= '$starttime'");
        $sql_select_month = $this->buildSql($sql_select_month, "t.d2m_dt <= '$endtime'");
        $sql_select_month = $this->buildSql($sql_select_month, "t.d2m_regionid in (" . $endrgn_atpidsstrings . ")");
        $sql_select_month = $sql_select_month . "group by t.d2m_dt";
        $sql_select_month = $sql_select_month . " order by t.d2m_dt asc";
        $yearaccu = $Model->query($sql_select_month);
        // dump($yearaccu);
        $this->assign('yearaccu',$yearaccu);
        $this->assign('rgn_atpid',$rgn_atpid);
        $this->assign('us_atpid',$us_atpid);
        $this->assign('rgn_category',$rgn_category);
        $this->display("yibiao_year");
    }
    public function Usersidepm()
    {
        $this->logSys(session('emp_atpid'),"访问日志","访问页面：【租户管理】 / 【租户管理】 / 【综合信息】 / 【报表及排名】");
        $rgn_atpid = I('get.rgn_atpid', '');
        $this->assign('rgn_atpid', $rgn_atpid);
        ////////////////////////////////////////////////
        $us_atpid = I('get.us_atpid', '');
        $this->assign('us_atpid', $us_atpid);
        ////////////////////////////////////////////////
        $start = I('get.start', '');
        $end = I('get.end', '');
        if (null != $start && null != $end) {
            $this->assign('start', $start);
            $this->assign('end', $end);
        } else {
            $lyear = date("Y", strtotime("-1 year"));
            $tyear = date("Y", time());
            $this->assign('start', $lyear);
            $this->assign('end', $tyear);
        }
        /////////////////////////////////////////////////
        $this->display();
    }
    //获取所有数据
    public function getDatabaobiao(){
        $rgn_atpid = I('get.rgn_atpid','');//dump($rgn_atpid);die();
        $start = I('get.start','');//dump($start);
        $end = I('get.end','');//dump($end);
        if(null == $start){
            $start = date('Y',strtotime('-1 year'));
            $end = date('Y',time());
        }
        //////////////////////////////////////////////
        $us_atpid = I('get.us_atpid','');//dump($us_atpid);
        $Model = M();
        if ($rgn_atpid){
            $sql_select_res = "
            select 
            * 
            from szny_region t 
            left join szny_usersideregion t1 on t1.usr_regionid = t.rgn_atpid
            left join szny_userside t2 on t1.usr_usersideid = t2.us_atpid
            where t.rgn_atpstatus is null and t1.usr_atpstatus is null and t2.us_atpstatus is null and t2.us_atpid = '$us_atpid'
            ";
            $Result_select_res = $Model->query($sql_select_res);
            $select_res = $this->regionrecursive($rgn_atpid);
            $res =array();
            foreach ($Result_select_res as $rsk => &$rsv){
                foreach ($select_res as $rk => $rv){
                    if ($rsv['rgn_atpid'] == $rv['rgn_atpid']){
                        array_push($res,$rsv['rgn_atpid']);
                    }
                }
            }
        }else{
            $sql_select_res = "
            select 
            * 
            from szny_region t 
            left join szny_usersideregion t1 on t1.usr_regionid = t.rgn_atpid
            left join szny_userside t2 on t1.usr_usersideid = t2.us_atpid
            where t.rgn_atpstatus is null and t1.usr_atpstatus is null and t2.us_atpstatus is null and t2.us_atpid = '$us_atpid'
            ";
            $Result_select_res = $Model->query($sql_select_res);
            $res = array();
            foreach ($Result_select_res as $rk => $rv){
                array_push($res,$rv['rgn_atpid']);
            }
        }
        $endrgn_atpidsstrings = "'".implode("','", $res)."'";
        $queryparam = json_decode(file_get_contents("php://input"), true);
        $Model = M();
        $sum = strlen($start);
        if (4 == $sum) {
            $sql_select = "
                select
                    t.d2y_dt,sum(t.d2y_ynlaccu) as d2y_ynlaccu,sum(t.d2y_yllaccu) as d2y_yllaccu,sum(t.d2y_dglaccu) as d2y_dglaccu ,sum(t.d2y_syslaccu) as d2y_syslaccu
                from szny_data2year t
                ";
            $sql_count = "
                select
                    t.d2y_dt,count(1) c
                from szny_data2year t
                ";
            $sql_select = $this->buildSql($sql_select, "t.d2y_atpstatus is null");
            $sql_count = $this->buildSql($sql_count, "t.d2y_atpstatus is null");
            $sql_select = $this->buildSql($sql_select, "t.d2y_dt between " . $start . " and " . $end . "");
            $sql_count = $this->buildSql($sql_count, "t.d2y_dt between " . $start . " and " . $end . "");
            $sql_select = $this->buildSql($sql_select, "t.d2y_regionid in (" . $endrgn_atpidsstrings . ")");
            $sql_count = $this->buildSql($sql_count, "t.d2y_regionid in (" . $endrgn_atpidsstrings . ") ");

            $sql_select = $sql_select . " group by t.d2y_dt";
            $sql_count = $sql_count . " group by t.d2y_dt";
            //排序
            if (null != $queryparam['sort']) {
                $sql_select = $sql_select . " order by " . $queryparam['sort'] . ' ' . $queryparam['sortOrder'] . ' ';
            } else {
                $sql_select = $sql_select . " order by t.d2y_dt desc";
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
            //dump($Result);echo($Model->_sql());
            foreach ($Result as $k => &$v) {
                $v['time'] = $v['d2y_dt'];
                if (null == $v['d2y_yllaccu'] || '' == $v['d2y_yllaccu']){
                    $v['yll'] = '0KW';
                }else{
                    $v['yll'] = $v['d2y_yllaccu'].'KW';
                }
                if (null == $v['d2y_ynlaccu'] || '' == $v['d2y_ynlaccu']){
                    $v['ynl'] = '0KW';
                }else{
                    $v['ynl'] = $v['d2y_ynlaccu'].'KW';
                }
                if (null == $v['d2y_syslaccu'] || '' == $v['d2y_syslaccu']){
                    $v['ysl'] = '0t';
                }else{
                    $v['ysl'] = $v['d2y_syslaccu'].'t';
                }
                if (null == $v['d2y_dglaccu'] || '' == $v['d2y_dglaccu']){
                    $v['dgl'] = '0KW';
                }else{
                    $v['dgl'] = $v['d2y_dglaccu'].'KW';
                }
            }
            $Count = $Model->query($sql_count);
            echo json_encode(array('total' => count($Count), 'rows' => $Result, 'category' => '年'));
        } else if (7 == $sum) {
            $Model = M();
            $sql_select = "
                select
                    t.d2m_dt,sum(t.d2m_yllaccu) as d2m_yllaccu ,sum(t.d2m_ynlaccu) as d2m_ynlaccu ,sum(t.d2m_dglaccu) as d2m_dglfaccu,sum(t.d2m_syslaccu) as d2m_syslaccu
                from szny_data2month t
                ";
            $sql_count = "
                select
                    t.d2m_dt,count(1) c
                from szny_data2month t
                ";
            $sql_select = $this->buildSql($sql_select, "t.d2m_atpstatus is null");
            $sql_count = $this->buildSql($sql_count, "t.d2m_atpstatus is null");
            $sql_select = $this->buildSql($sql_select, "t.d2m_dt between '" . $start . "'and '" . $end . "'");
            $sql_count = $this->buildSql($sql_count, "t.d2m_dt between '" . $start . "' and '" . $end . "'");
            $sql_select = $this->buildSql($sql_select, "t.d2m_regionid in (" . $endrgn_atpidsstrings . ")");
            $sql_count = $this->buildSql($sql_count, "t.d2m_regionid in (" . $endrgn_atpidsstrings . ") ");

            $sql_select = $sql_select . " group by t.d2m_dt";
            $sql_count = $sql_count . " group by t.d2m_dt";
            //排序
            if (null != $queryparam['sort']) {
                $sql_select = $sql_select . " order by " . $queryparam['sort'] . ' ' . $queryparam['sortOrder'] . ' ';
            } else {
                $sql_select = $sql_select . " order by t.d2m_dt desc";
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
            //dump($Result);echo($Model->_sql());
            foreach ($Result as $k => &$v) {
                $v['time'] = $v['d2m_dt'];
                $v['yll'] = $v['d2m_yllfaccu'];
                $v['ynl'] = $v['d2m_ynlaccu'];
                $v['ysl'] = $v['d2m_syslaccu'];
                $v['dgl'] = $v['d2m_dglaccu'];
            }
            $Count = $Model->query($sql_count);//dump($Count);
            echo json_encode(array('total' => count($Count), 'rows' => $Result, 'category' => '月'));
        } else if (10 == $sum) {
            $Model = M();
            $sql_select = "
                select
                    t.d2d_dt,sum(t.d2d_yllaccu) as d2d_yllaccu,sum(t.d2d_ynlaccu) as d2d_ynlaccu ,sum(t.d2d_dglaccu) as d2d_dglaccu,sum(t.d2d_syslaccu) as d2d_syslaccu
                from szny_data2day t
                ";
            $sql_count = "
                select
                    count(1) c
                from szny_data2day t
                ";
            $sql_select = $this->buildSql($sql_select, "t.d2d_atpstatus is null");
            $sql_count = $this->buildSql($sql_count, "t.d2d_atpstatus is null");
            $sql_select = $this->buildSql($sql_select, "t.d2d_dt between '" . $start . "' and '" . $end . "'");
            $sql_count = $this->buildSql($sql_count, "t.d2d_dt between '" . $start . "' and' " . $end . "'");
            $sql_select = $this->buildSql($sql_select, "t.d2d_regionid in (" . $endrgn_atpidsstrings . ")");
            $sql_count = $this->buildSql($sql_count, "t.d2d_regionid in (" . $endrgn_atpidsstrings . ") ");

            $sql_select = $sql_select . " group by t.d2d_dt";
            $sql_count = $sql_count . " group by t.d2d_dt";
            //排序
            if (null != $queryparam['sort']) {
                $sql_select = $sql_select . " order by " . $queryparam['sort'] . ' ' . $queryparam['sortOrder'] . ' ';
            } else {
                $sql_select = $sql_select . " order by t.d2d_dt desc";
            }

            //自定义分页
            if (null != $queryparam['limit']) {
                if ('0' == $queryparam['offset']) {
                    $sql_select = $sql_select . " limit " . '0' . ',' . $queryparam['limit'] . ' ';
                } else {
                    $sql_select = $sql_select . " limit " . $queryparam['offset'] . ',' . $queryparam['limit'] . ' ';
                }
            }

            $Result = $Model->query($sql_select);//dump($Result);echo($Model->_sql());
            foreach ($Result as $k => &$v) {
                $v['time'] = $v['d2d_dt'];
                $v['yll'] = $v['d2d_yllaccu'];
                $v['ynl'] = $v['d2d_ynlaccu'];
                $v['ysl'] = $v['d2d_syslaccu'];
                $v['dgl'] = $v['d2d_dglaccu'];
            }
            $Count = $Model->query($sql_count);
            echo json_encode(array('total' => count($Count), 'rows' => $Result, 'category' => '日'));
        }
    }
    public function Usersidereport(){
        $this->logSys(session('emp_atpid'),"访问日志","访问页面：【租户管理】 / 【租户管理】 / 【综合信息】 / 【分项报表】");
        $rgn_atpid = I('get.rgn_atpid', '');
        $this->assign('rgn_atpid', $rgn_atpid);
        $Model = M();
        $us_atpid = I('get.us_atpid', '');
        $this->assign('us_atpid', $us_atpid);
        $selsect_param = I('get.param', '');
        //dump($selsect_param);
        $this->assign('selectparam', $selsect_param);
        if(empty($selsect_param)){
            $sql_list = "select p_atpid from szny_param t where t.p_atpstatus is null and t.p_category = '累计值' order by t.p_name desc";
            $mod = $Model->query($sql_list);
            $date = [];
            foreach ($mod as $key => $value){
                $date[] = $value['p_atpid'];
            }
            $selsect_param = implode(',', $date);
        }
        // dump($selsect_param);
        $this->assign('selectparam', $selsect_param);
        $start = I('get.start', '');
        $end = I('get.end', '');
        if (null != $start && null != $end) {
            $this->assign('start', $start);
            $this->assign('end', $end);
        } else {
            $lyear = date("Y", strtotime("-1 year"));
            $tyear = date("Y", time());
            $this->assign('start', $lyear);
            $this->assign('end', $tyear);
        }
        $parammore = I('get.param','');
        if (null == $parammore){

            $sql = "select * from szny_param t where t.p_atpstatus is null and t.p_category = '累计值' order by t.p_name desc";
            $param = $Model->query($sql);
            foreach ($param as $k => &$v){
                // if ('用冷量' == $v['p_name']){
                $v['aux_selected'] = '是';
                // }
            }
            $this->assign('param',$param);
            /////////
            $columns = [];
            $columns[] =array_push($columns,array('field'=>'dgl','title'=>'电量值'));
            $columns[] =array_push($columns,array('field'=>'ysl','title'=>'用水量'));
            $columns[] =array_push($columns,array('field'=>'ynl','title'=>'用暖量'));
            $columns[] =array_push($columns,array('field'=>'yll','title'=>'用冷量'));
            unset($columns[1]);
            unset($columns[3]);
            unset($columns[5]);
            unset($columns[7]);
            //        dump($columns);die();
            $this->assign('columns',$columns);

        }else{
            $Model = M();
            $sql = "select * from szny_param t where t.p_atpstatus is null and t.p_category = '累计值' order by t.p_name desc";
            $param = $Model->query($sql);
            $parammores =  explode(',',$parammore);
            $endparammorestring = "'".implode("','",$parammores)."'";
            $sql_select_param = "
            select
            *
            from szny_param t
            where t.p_atpstatus is null and t.p_atpid in(".$endparammorestring.")  order by t.p_name desc
            ";
            $Result_param = $Model->query($sql_select_param);
            foreach ($param as $k => &$v) {
                foreach ($Result_param as $sk => $sv) {
                    if ($sv['p_atpid'] == $v['p_atpid']) {
                        $v['aux_selected'] = '是';
                        break;
                    }
                }
            }
            $this->assign('param',$param);
            if(null != is_array($parammores)){
                $columns = [];
                foreach($parammores as $value){
                    $Model = M();
                    $sql = "select * from szny_param t where t.p_atpstatus is null and t.p_atpid =" ."'".$value."'";
                    $data = $Model->query($sql);
                    if($data[0]['p_name'] == '用水量'){
                        $columns[] =array_push($columns,array('field'=>'ysl','title'=>'用水量'));
                    }elseif($data[0]['p_name'] == '用暖量'){
                        $columns[] =array_push($columns,array('field'=>'ynl','title'=>'用暖量'));
                    }elseif($data[0]['p_name'] == '用冷量'){
                        $columns[] =array_push($columns,array('field'=>'yll','title'=>'用冷量'));
                    }elseif($data[0]['p_name'] == '电量值'){
                        $columns[] =array_push($columns,array('field'=>'dgl','title'=>'电量值'));
                    }
                }
                foreach($columns as $key =>$value){
                    if(null == is_array($value)){
                        unset($columns[$key]);
                    }
                }
            }
            $this->assign('columns',$columns);
        }
        $this->display();
    }
    public function getDatareport(){
        $rgn_atpid = I("get.rgn_atpid","");
        $us_atpid = I('get.us_atpid','');
        $Model = M();
        if ($rgn_atpid){
            $sql_select_res = "
            select 
            * 
            from szny_region t 
            left join szny_usersideregion t1 on t1.usr_regionid = t.rgn_atpid
            left join szny_userside t2 on t1.usr_usersideid = t2.us_atpid
            where t.rgn_atpstatus is null and t1.usr_atpstatus is null and t2.us_atpstatus is null and t2.us_atpid = '$us_atpid'
            ";
            $Result_select_res = $Model->query($sql_select_res);
            $select_res = $this->regionrecursive($rgn_atpid);
            $res =array();
            foreach ($Result_select_res as $rsk => &$rsv){
                foreach ($select_res as $rk => $rv){
                    if ($rsv['rgn_atpid'] == $rv['rgn_atpid']){
                        array_push($res,$rsv['rgn_atpid']);
                    }
                }
            }
        }else{
            $sql_select_res = "
            select 
            * 
            from szny_region t 
            left join szny_usersideregion t1 on t1.usr_regionid = t.rgn_atpid
            left join szny_userside t2 on t1.usr_usersideid = t2.us_atpid
            where t.rgn_atpstatus is null and t1.usr_atpstatus is null and t2.us_atpstatus is null and t2.us_atpid = '$us_atpid'
            ";
            $Result_select_res = $Model->query($sql_select_res);
            $res = array();
            foreach ($Result_select_res as $rk => $rv){
                array_push($res,$rv['rgn_atpid']);
            }
        }

        $param = I('get.param','');
        // dump($param);
        if (null == $param){
            $sql_select_param = "select * from szny_param t where t.p_atpstatus is null";
            $data_select = $Model->query($sql_select_param);
            $selectparam = array();
            foreach ($data_select as $k => $v){
                array_push($selectparam,$v['p_atpid']);
            }
            $selectparam = implode(',',$selectparam);
            $selectparam = "'".$selectparam."'";
        }else{
            $selectparamarray = explode(',',$param);
            $selectparam = "'".implode("','",$selectparamarray)."'";
        }
        $sql_select_region = "
        select 
        t.etr_regionid
        from szny_energytyperegion t 
        left join szny_energytype t1 on t.etr_energytypeid = t1.et_atpid
        left join szny_param t2 on t2.p_energytypeid = t1.et_atpid
        where t.etr_atpstatus is null and t1.et_atpstatus is null and t2.p_atpstatus is null
        and t2.p_atpid in (".$selectparam.")
        ";
        $Result_region = $Model ->query($sql_select_region);
        $select_region = [];
        foreach ($Result_region as $k => $v){
            array_push($select_region,$v['etr_regionid']);
        }
        $endrgn_atpidsarray = array_intersect($res,$select_region);
        $endrgn_atpidsstrings = "'". implode("','", $endrgn_atpidsarray)."'" ;
        $start = I('get.start','');
        $end = I('get.end','');
        $queryparam = json_decode(file_get_contents("php://input"), true);
        if(null == $start){
            $start = date('Y',strtotime('-1 year'));
            $end = date('Y',time());
        }
        $select_param_strings = substr($selectparam,1,strlen($selectparam)-2);
        $param_select = explode("','",$select_param_strings);
        $select_param_array = [];
        foreach ($param_select as $v){
            $select_param = "select p_name from szny_param where p_atpid = '$v'";
            $Result_select_param = $Model->query($select_param);
            array_push($select_param_array,$Result_select_param[0]['p_name']);
        }
        $sum = strlen($start);
        //dump($sum);die();
        if (4 == $sum) {
            $sql_select = "
                select
                    t1.rgn_name,t.d2y_dt,sum(t.d2y_yllaccu) as d2y_yllaccu ,sum(t.d2y_ynlaccu) as d2y_ynlaccu ,sum(t.d2y_dglaccu) as d2y_dglaccu ,sum(t.d2y_syslaccu) as d2y_syslaccu
                from szny_data2year t
                left join szny_region t1 on t.d2y_regionid = t1.rgn_atpid
                ";
            $sql_count = "
                select
                    t.d2y_dt,count(1) c
                from szny_data2year t
                left join szny_region t1 on t.d2y_regionid = t1.rgn_atpid
                ";
            $sql_select = $this->buildSql($sql_select, "t.d2y_atpstatus is null");
            $sql_count = $this->buildSql($sql_count, "t.d2y_atpstatus is null");
            $sql_select = $this->buildSql($sql_select, "t1.rgn_atpstatus is null");
            $sql_count = $this->buildSql($sql_count, "t1.rgn_atpstatus is null");
            $sql_select = $this->buildSql($sql_select, "t.d2y_dt between " . $start . " and " . $end . "");
            $sql_count = $this->buildSql($sql_count, "t.d2y_dt between " . $start . " and " . $end . "");
            $sql_select = $this->buildSql($sql_select, "t.d2y_regionid in (" . $endrgn_atpidsstrings . ")");
            $sql_count = $this->buildSql($sql_count, "t.d2y_regionid in (" . $endrgn_atpidsstrings . ") ");

            $sql_select = $sql_select . " group by t.d2y_dt";
            $sql_count = $sql_count . " group by t.d2y_dt";
            //排序
            if (null != $queryparam['sort']) {
                $sql_select = $sql_select . " order by " . $queryparam['sort'] . ' ' . $queryparam['sortOrder'] . ' ';
            } else {
                $sql_select = $sql_select . " order by t.d2y_dt desc";
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
            foreach ($Result as $k => &$v) {
                $v['time'] = $v['d2y_dt'].'年';
                if (in_array('用冷量',$select_param_array)){
                    if (null == $v['d2y_yllaccu'] || '' == $v['d2y_yllaccu']){
                        $v['yll'] = '0KW';
                    }else{
                        $v['yll'] = $v['d2y_yllaccu'].'KW';
                    }
                }
                if (in_array('用暖量',$select_param_array)){
                    if (null == $v['d2y_ynlaccu'] || '' == $v['d2y_ynlaccu']){
                        $v['ynl'] = '0KW';
                    }else{
                        $v['ynl'] = $v['d2y_ynlaccu'].'KW';
                    }
                }
                if (in_array('用水量',$select_param_array)){
                    if (null == $v['d2y_syslaccu'] || '' == $v['d2y_syslaccu']){
                        $v['ysl'] = '0t';
                    }else{
                        $v['ysl'] = $v['d2y_syslaccu'].'t';
                    }
                }
                if (in_array('电量值',$select_param_array)){
                    if (null == $v['d2y_dglaccu'] || '' == $v['d2y_dglaccu']){
                        $v['dgl'] = '0KW';
                    }else{
                        $v['dgl'] = $v['d2y_dglaccu'].'KW';
                    }
                }
            }
            $Count = $Model->query($sql_count);
            echo json_encode(array('total' => count($Count), 'rows' => $Result, 'category' => '年'));
        } else if (7 == $sum) {
            $Model = M();
            $sql_select = "
                select
                    t1.rgn_name,t.d2m_dt,sum(t.d2m_yllaccu) as d2m_yllaccu ,sum(t.d2m_ynlaccu) as d2m_ynlaccu ,sum(t.d2m_dglaccu) as d2m_dglaccu,sum(t.d2m_syslaccu) as d2m_syslaccu
                from szny_data2month t
                left join szny_region t1 on t.d2m_regionid = t1.rgn_atpid
                ";
            $sql_count = "
                select
                    t.d2m_dt,count(1) c
                from szny_data2month t
                 left join szny_region t1 on t.d2m_regionid = t1.rgn_atpid
                ";
            $sql_select = $this->buildSql($sql_select, "t.d2m_atpstatus is null");
            $sql_count = $this->buildSql($sql_count, "t.d2m_atpstatus is null");
            $sql_select = $this->buildSql($sql_select, "t1.rgn_atpstatus is null");
            $sql_count = $this->buildSql($sql_count, "t1.rgn_atpstatus is null");
            $sql_select = $this->buildSql($sql_select, "t.d2m_dt between '" . $start . "'and '" . $end . "'");
            $sql_count = $this->buildSql($sql_count, "t.d2m_dt between '" . $start . "' and '" . $end . "'");
            $sql_select = $this->buildSql($sql_select, "t.d2m_regionid in (" . $endrgn_atpidsstrings . ")");
            $sql_count = $this->buildSql($sql_count, "t.d2m_regionid in (" . $endrgn_atpidsstrings . ") ");

            $sql_select = $sql_select . " group by t.d2m_dt";
            $sql_count = $sql_count . " group by t.d2m_dt";

            //排序
            if (null != $queryparam['sort']) {
                $sql_select = $sql_select . " order by " . $queryparam['sort'] . ' ' . $queryparam['sortOrder'] . ' ';
            } else {
                $sql_select = $sql_select . " order by t.d2m_dt desc";
            }

            //自定义分页
            if (null != $queryparam['limit']) {
                if ('0' == $queryparam['offset']) {
                    $sql_select = $sql_select . " limit " . '0' . ',' . $queryparam['limit'] . ' ';
                } else {
                    $sql_select = $sql_select . " limit " . $queryparam['offset'] . ',' . $queryparam['limit'] . ' ';
                }
            }
            $Result = $Model->query($sql_select);//dump($Result);echo($Model->_sql());
            foreach ($Result as $k => &$v) {
                $v['time'] = $v['d2m_dt'];
                if (in_array('用冷量',$select_param_array)){
                    if (null == $v['d2m_yllaccu'] || '' == $v['d2m_yllaccu']){
                        $v['yll'] = '0KW';
                    }else{
                        $v['yll'] = $v['d2m_yllaccu'].'KW';
                    }
                }
                if (in_array('用暖量',$select_param_array)){
                    if (null == $v['d2m_ynlaccu'] || '' == $v['d2m_ynlaccu']){
                        $v['ynl'] = '0KW';
                    }else{
                        $v['ynl'] = $v['d2m_ynlaccu'].'KW';
                    }
                }
                if (in_array('电量值',$select_param_array)){
                    if (null == $v['d2m_dglaccu'] || '' == $v['d2m_dglaccu']){
                        $v['dgl'] = '0KW';
                    }else{
                        $v['dgl'] = $v['d2m_dglaccu'].'KW';
                    }
                }
                if (in_array('用水量',$select_param_array)){
                    if (null == $v['d2m_syslaccu'] || '' == $v['d2m_syslaccu']){
                        $v['dgl'] = '0t';
                    }else{
                        $v['dgl'] = $v['d2m_syslaccu'].'t';
                    }
                }
            }
            $Count = $Model->query($sql_count);//dump($Count);
            echo json_encode(array('total' => count($Count), 'rows' => $Result,'category' => '月'));
        } else if (10 == $sum) {
            $Model = M();
            $sql_select = "
                select
                    t1.rgn_name,t.d2d_dt,sum(t.d2d_yllaccu) as d2d_yllaccu ,sum(t.d2d_ynlaccu) as d2d_ynlaccu ,sum(t.d2d_dglaccu) as d2d_dglaccu,sum(t.d2d_syslaccu) as d2d_syslaccu
                from szny_data2day t
                left join szny_region t1 on t.d2d_regionid = t1.rgn_atpid
                ";
            $sql_count = "
                select
                    count(1) c
                from szny_data2day t
                left join szny_region t1 on t.d2d_regionid = t1.rgn_atpid
                ";
            $sql_select = $this->buildSql($sql_select, "t.d2d_atpstatus is null");
            $sql_count = $this->buildSql($sql_count, "t.d2d_atpstatus is null");
            $sql_select = $this->buildSql($sql_select, "t1.rgn_atpstatus is null");
            $sql_count = $this->buildSql($sql_count, "t1.rgn_atpstatus is null");
            $sql_select = $this->buildSql($sql_select, "t.d2d_dt between '" . $start . "' and '" . $end . "'");
            $sql_count = $this->buildSql($sql_count, "t.d2d_dt between '" . $start . "' and' " . $end . "'");
            $sql_select = $this->buildSql($sql_select, "t.d2d_regionid in (" . $endrgn_atpidsstrings . ")");
            $sql_count = $this->buildSql($sql_count, "t.d2d_regionid in (" . $endrgn_atpidsstrings . ") ");
            $sql_select = $sql_select . " group by t.d2d_dt";
            $sql_count = $sql_count . " group by t.d2d_dt";

            //排序
            if (null != $queryparam['sort']) {
                $sql_select = $sql_select . " order by " . $queryparam['sort'] . ' ' . $queryparam['sortOrder'] . ' ';
            } else {
                $sql_select = $sql_select . " order by t.d2d_dt desc";
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
            //dump($Result);echo($Model->_sql());
            foreach ($Result as $k => &$v) {
                $v['time'] = $v['d2d_dt'];
                if (in_array('用冷量',$select_param_array)){
                    if (null == $v['d2d_yllaccu'] || '' == $v['d2d_yllaccu']){
                        $v['yll'] = '0KW';
                    }else{
                        $v['yll'] = $v['d2d_yllaccu'].'KW';
                    }
                }
                if (in_array('用暖量',$select_param_array)){
                    if (null == $v['d2d_ynlaccu'] || '' == $v['d2d_ynlaccu']){
                        $v['ynl'] = '0KW';
                    }else{
                        $v['ynl'] = $v['d2d_ynlaccu'].'KW';
                    }
                }
                if (in_array('电量值',$select_param_array)){
                    if (null == $v['d2d_dglaccu'] || '' == $v['d2d_dglaccu']){
                        $v['dgl'] = '0KW';
                    }else{
                        $v['dgl'] = $v['d2d_dglaccu'].'KW';
                    }
                }
                if (in_array('用水量',$select_param_array)){
                    if (null == $v['d2d_syslaccu'] || '' == $v['d2d_syslaccu']){
                        $v['ysl'] = '0KW';
                    }else{
                        $v['ysl'] = $v['d2d_syslaccu'].'KW';
                    }
                }
            }
            $Count = $Model->query($sql_count);
            //dump($Count);//dump($Model->_sql());
            echo json_encode(array('total' => count($Count), 'rows' => $Result,'category' => '日'));
        }
    }
    public function Usersidetbhb(){
        $this->logSys(session('emp_atpid'),"访问日志","访问页面：【租户管理】 / 【租户管理】 / 【综合信息】 / 【同比环比】");
        $rgn_atpid = I('get.rgn_atpid','');
        $us_atpid = I('get.us_atpid','');
        $this->assign('rgn_atpid',$rgn_atpid);
        $this->assign('us_atpid',$us_atpid);
        $Model=M();
        if ($rgn_atpid){
            $list = M("region")->find($rgn_atpid);
            if ($list['rgn_category']=='设备点'){
                $res = $this->regionrecursive($rgn_atpid);
            }else{
                $floorid = $this->regionrecursive($rgn_atpid);
                $sql = "select usr_regionid rgn_atpid 
                from szny_usersideregion t
                left join szny_region t1 on t.usr_regionid = t1.rgn_atpid
                where t.usr_atpstatus is null and t1.rgn_category='设备点' and usr_usersideid='$us_atpid'";
                $devid = $Model->query($sql);
                $res = array_intersect($devid,$floorid);
            }
        }else{
            $sql = "select usr_regionid rgn_atpid from szny_usersideregion where usr_atpstatus is null and usr_usersideid='$us_atpid'";
            $res = $Model->query($sql);
        }
        foreach ($res as $key => $value)
        {
            $date[] = "" . $value['rgn_atpid'] . "";
        }
        $ids = implode(',', $date);

        $this->assign("mode",$bs);
        $this->assign('ids',$ids);
        $start = I('get.start', '');
        $end = I('get.end', '');
        if (null != $start && null != $end) {
            $this->assign('start', $start);
            $this->assign('end', $end);
            $sum = strlen($start);
            if ( 4 == $sum){
                $columns = [];
                $columns[] =array('field'=>'本期值','title'=>'本期值');
                $columns[] =array('field'=>'上期值','title'=>'上期值');
                $columns[] =array('field'=>'同比','title'=>'同比');
                $this->assign('columns',$columns);
            }elseif(7 == $sum){
                $columns = [];
                $columns[] =array('field'=>'本期值','title'=>'本期值');
                $columns[] =array('field'=>'上期值','title'=>'上期值');
                $columns[] =array('field'=>'去年同期值','title'=>'去年同期值');
                $columns[] =array('field'=>'同比','title'=>'同比');
                $columns[] =array('field'=>'环比','title'=>'环比');
                $this->assign('columns',$columns);
            }
        } else {
            $lyear = date("Y", strtotime("-1 year"));
            $tyear = date("Y", time());
            $this->assign('start', $lyear);
            $this->assign('end', $tyear);
            $columns = [];
            $columns[] =array('field'=>'本期值','title'=>'本期值');
            $columns[] =array('field'=>'上期值','title'=>'上期值');
            $columns[] =array('field'=>'同比','title'=>'同比');
            $this->assign('columns',$columns);
        }
        $parammore = I('get.selectParam','');
        if (null == $parammore) {
            $Model = M();
            $sql = "select * from szny_param t where t.p_atpstatus is null and t.p_category = '累计值' order by t.p_name desc";
            $param = $Model->query($sql);
            foreach ($param as $k => &$v) {
                if ('电量值' == $v['p_name']) {
                    $v['aux_selected'] = '是';
                    $selectParam = $v['p_atpid'];
                }
            }
            $this->assign('param', $param);
            $this->assign('selectParam', $selectParam);
        }else{
            $Model = M();
            $sql = "select * from szny_param t where t.p_atpstatus is null and t.p_category = '累计值' order by t.p_name desc";
            $param = $Model->query($sql);
            $sql_select_param = "
            select
            *
            from szny_param t
            where t.p_atpstatus is null and t.p_atpid = '".$parammore."' order by t.p_name desc
            ";
            $Result_param = $Model->query($sql_select_param);
            foreach ($param as $k => &$v) {
                foreach ($Result_param as $sk => $sv) {
                    if ($sv['p_atpid'] == $v['p_atpid']) {
                        $v['aux_selected'] = '是';
                        $selectParam = $v['p_atpid'];
                        break;
                    }
                }
            }
            $this->assign('param',$param);
            $this->assign('selectParam', $selectParam);
        }
        $this->display();
    }
    public function getDatatbhb(){
        $start = I('get.start','');
        $end = I('get.end','');
        $ids = I('get.ids','');
        $bs = $_GET['mode'];
        $idarray = explode(',',$ids);
        $endstring = "'".implode("','",$idarray)."'";
        // dump($endstring);
        // echo $endstring;die();
        $sum = strlen($start);
        if (4 == $sum) {
            $queryparam = json_decode(file_get_contents("php://input"), true);
            $offset = $queryparam['offset'];
            $limit = $queryparam['limit'];
            $Model = M();
            $sql_select_region = "select t.rgn_atpid from szny_region t where t.rgn_atpstatus is null and t.rgn_atpid in (".$endstring.") order by rgn_name asc";
            $Result_region = $Model->query($sql_select_region);
            $sql_select_time = "select t.d2y_dt from szny_data2year t where t.d2y_atpstatus is null and t.d2y_dt between '$start' and '$end' group by t.d2y_dt order by t.d2y_dt desc";
            $Result_time = $Model->query($sql_select_time);
            $result = $this->combineArray($Result_region,$Result_time);
            /*******************************************************************************/
            $select_param_id = I('get.selectParam','');//dump($select_param_id);die();
            $Result_select_param = M('param')->where("p_atpid='%s'", array($select_param_id))->find();
            $select_param = $Result_select_param['p_name'];
            foreach ($result as $k => &$v){
                $res = $this->regionrecursive($v['rgn_atpid']);
                $res_name = M('region')->where("rgn_atpid ='%s'",$v['rgn_atpid'])->find();
                $v['rgn_name'] = $res_name['rgn_name'];
                $v['time'] = $v['d2y_dt'];
                $v['region_time'] = $res_name['rgn_name']."【". $v['d2y_dt']."】";
                $time = $v['d2y_dt'];
                $date = [];
                foreach ($res as $key => $value) {
                    $date[] = $value['rgn_atpid'];
                }
                $endrgn_atpidsstrings = "'" . implode("','", $date) . "'";
                $sql_select_sum_current_value = "
                select
                    t.d2y_dt,sum(t.d2y_yllaccu) as d2y_yllaccu ,sum(t.d2y_ynlaccu) as d2y_ynlaccu ,sum(t.d2y_dglaccu) as d2y_dglaccu ,sum(t.d2y_syslaccu) as d2y_syslaccu
                from szny_data2year t
                left join szny_region t1 on t.d2y_regionid = t1.rgn_atpid
                where t.d2y_atpstatus is null and t1.rgn_atpstatus is null and t.d2y_dt = '$time' and t.d2y_regionid in (" . $endrgn_atpidsstrings . ")
                ";
                $Result_sum_current_value = $Model->query($sql_select_sum_current_value);
                $last = $time -1;
                $sql_select_sum_last_value = "
                select
                    t.d2y_dt,sum(t.d2y_yllaccu) as d2y_yllaccu ,sum(t.d2y_ynlaccu) as d2y_ynlaccu ,sum(t.d2y_dglaccu) as d2y_dglaccu ,sum(t.d2y_syslaccu) as d2y_syslaccu
                from szny_data2year t
                left join szny_region t1 on t.d2y_regionid = t1.rgn_atpid
                where t.d2y_atpstatus is null and t1.rgn_atpstatus is null and t.d2y_dt = '$last' and t.d2y_regionid in (" . $endrgn_atpidsstrings . ")
                ";
                $Result_sum_last_value = $Model->query($sql_select_sum_last_value);
                foreach ($Result_sum_current_value as $rck => $rcv){
                    foreach ($Result_sum_last_value as $rlk => $rlv){
                        if ('用水量' == $select_param) {
                            $v['category'] = '用水量';
                            if (null == $rcv['d2y_syslaccu'] || '' == $rcv['d2y_syslaccu']) {
                                $v['本期值'] = '0KW';
                            }else{
                                $v['本期值'] =$rcv['d2y_syslaccu'].'t';
                            }
                            if (null == $rlv['d2y_syslaccu'] || '' == $rlv['d2y_syslaccu']) {
                                $v['上期值'] = '0KW';
                            }else{
                                $v['上期值'] =$rlv['d2y_syslaccu'].'t';
                            }
                            if (0 == $rlv['d2y_syslaccu']){
                                $v['同比'] = '无';
                            }else{
                                $v['同比'] = floor(($rcv['d2y_syslaccu']/$rlv['d2y_syslaccu'])*100).'%';
                            }
                        }
                        if ('电量值' == $select_param) {
                            $v['category'] = '电量值';
                            if (null == $rcv['d2y_dglaccu'] || '' == $rcv['d2y_dglaccu']) {
                                $v['本期值'] = '0KW';
                            }else{
                                $v['本期值'] =$rcv['d2y_dglaccu'].'KW';
                            }
                            if (null == $rlv['d2y_dglaccu'] || '' == $rlv['d2y_dglaccu']) {
                                $v['上期值'] = '0KW';
                            }else{
                                $v['上期值'] =$rlv['d2y_dglaccu'].'KW';
                            }
                            if (0 == $rlv['d2y_dglaccu']){
                                $v['同比'] = '无';
                            }else{
                                $v['同比'] = floor(($rcv['d2y_yllaccu']/$rlv['d2y_yllaccu'])*100).'%';
                            }
                        }
                        if ('用冷量' == $select_param) {
                            $v['category'] = '用冷量';
                            if (null == $rcv['d2y_yllaccu'] || '' == $rcv['d2y_yllaccu']) {
                                $v['本期值'] = '0KW';
                            }else{
                                $v['本期值'] =$rcv['d2y_yllaccu'].'KW';
                            }
                            if (null == $rlv['d2y_yllaccu'] || '' == $rlv['d2y_yllaccu']) {
                                $v['上期值'] = '0KW';
                            }else{
                                $v['上期值'] =$rlv['d2y_yllaccu'].'KW';
                            }
                            if (0 == $rlv['d2y_yllaccu']){
                                $v['同比'] = '无';
                            }else{
                                $v['同比'] = floor(($rcv['d2y_yllaccu']/$rlv['d2y_yllaccu'])*100).'%';
                            }
                        }
                        if ('用暖量' == $select_param) {
                            $v['category'] = '用暖量';
                            if (null == $rcv['d2y_ynlaccu'] || '' == $rcv['d2y_ynlaccu']) {
                                $v['本期值'] = '0KW';
                            }else{
                                $v['本期值'] =$rcv['d2y_ynlaccu'].'KW';
                            }
                            if (null == $rlv['d2y_ynlaccu'] || '' == $rlv['d2y_ynlaccu']) {
                                $v['上期值'] = '0KW';
                            }else{
                                $v['上期值'] =$rlv['d2y_ynlaccu'].'KW';
                            }
                            if (0 == $rlv['d2y_ynlaccu']){
                                $v['同比'] = '无';
                            }else{
                                $v['同比'] = floor(($rcv['d2y_ynlaccu']/$rlv['d2y_ynlaccu'])*100).'%';
                            }
                        }
                    }
                }
            }
            $serices_benqizhi = [];
            $serices_benqizhi['name'] = '本期值';
            $serices_benqizhi['stack'] = 1;
            $serices_benqizhi_data = [];
            foreach ($result as $rk => $rv){
                array_push($serices_benqizhi_data,(int)$rv['本期值']);
            }
            $serices_benqizhi['data'] = $serices_benqizhi_data;
            $serices_shangqizhi = [];
            $serices_shangqizhi['name'] = '上期值';
            $serices_shangqizhi['stack'] = 2;
            $serices_shangqizhi_data = [];
            foreach ($result as $rk => $rv){
                array_push($serices_shangqizhi_data,(int)$rv['上期值']);
            }
            $serices_shangqizhi['data'] = $serices_shangqizhi_data;
            $series = [];
            array_push($series,$serices_benqizhi);
            array_push($series,$serices_shangqizhi);
            foreach ($result as $k => &$v){
                $v['series'] = $series;
            }
            $Result = array_slice($result,$offset,$limit) ;
            echo json_encode(array('total' => count($result), 'rows' => $Result));
        }elseif (7 == $sum){
            $queryparam = json_decode(file_get_contents("php://input"), true);
            $offset = $queryparam['offset'];
            $limit = $queryparam['limit'];
            $Model = M();
            $sql_select_region = "select t.rgn_atpid from szny_region t where t.rgn_atpstatus is null and t.rgn_atpid in (".$endstring.") order by t.rgn_name asc";
            $Result_region = $Model->query($sql_select_region);
            $sql_select_time = "select t.d2m_dt from szny_data2month t where t.d2m_atpstatus is null and t.d2m_dt between '".$start."' and '".$end."' group by t.d2m_dt order by t.d2m_dt desc";
            $Result_time = $Model->query($sql_select_time);
            $result = $this->combineArray($Result_region,$Result_time);
            /*******************************************************************************/
            $select_param_id = I('get.selectParam','');//dump($select_param_id);die();
            $Result_select_param = M('param')->where("p_atpid='%s'", array($select_param_id))->find();
            $select_param = $Result_select_param['p_name'];
            foreach ($result as $k => &$v){
                $res = $this->regionrecursive($v['rgn_atpid']);
                $res_name = M('region')->where("rgn_atpid ='%s'",$v['rgn_atpid'])->find();
                $v['rgn_name'] = $res_name['rgn_name'];
                $v['time'] = $v['d2m_dt'];
                $v['region_time'] = $res_name['rgn_name']."【". $v['d2m_dt']."】";
                $time = $v['d2m_dt'];
                $date = [];
                foreach ($res as $key => $value) {
                    $date[] = $value['rgn_atpid'];
                }
                $endrgn_atpidsstrings = "'" . implode("','", $date) . "'";
                $sql_select_sum_current_value = "
                select
                    t.d2m_dt,sum(t.d2m_yllaccu) as d2m_yllaccu ,sum(t.d2m_ynlaccu) as d2m_ynlaccu ,sum(t.d2m_dglaccu) as d2m_dglaccu ,sum(t.d2m_syslaccu) as d2m_syslaccu
                from szny_data2month t
                left join szny_region t1 on t.d2m_regionid = t1.rgn_atpid
                where t.d2m_atpstatus is null and t1.rgn_atpstatus is null and t.d2m_dt = '".$time."' and t.d2m_regionid in (" . $endrgn_atpidsstrings . ")
                ";
                $Result_sum_current_value = $Model->query($sql_select_sum_current_value);
                $time  = strtotime($time);
                $last = date('Y-m', strtotime ("-1 years", $time));
                $last_month = date('Y-m', strtotime ("-1 months", $time));
                $sql_select_sum_last_value = "
                select
                    t.d2m_dt,sum(t.d2m_yllaccu) as d2m_yllaccu ,sum(t.d2m_ynlaccu) as d2m_ynlaccu ,sum(t.d2m_dglaccu) as d2m_dglaccu ,sum(t.d2m_syslaccu) as d2m_syslaccu
                from szny_data2month t
                left join szny_region t1 on t.d2m_regionid = t1.rgn_atpid
                where t.d2m_atpstatus is null and t1.rgn_atpstatus is null and t.d2m_dt = '".$last."' and t.d2m_regionid in (" . $endrgn_atpidsstrings . ")
                ";
                $Result_sum_last_value = $Model->query($sql_select_sum_last_value);
                $sql_select_sum_last_month_value = "
                select
                    t.d2m_dt,sum(t.d2m_yllaccu) as d2m_yllaccu ,sum(t.d2m_ynlaccu) as d2m_ynlaccu ,sum(t.d2m_dglaccu) as d2m_dglaccu ,sum(t.d2m_syslaccu) as d2m_syslaccu
                from szny_data2month t
                left join szny_region t1 on t.d2m_regionid = t1.rgn_atpid
                where t.d2m_atpstatus is null and t1.rgn_atpstatus is null and t.d2m_dt = '".$last_month."' and t.d2m_regionid in (" . $endrgn_atpidsstrings . ")
                ";
                $Result_sum_last_month_value = $Model->query($sql_select_sum_last_month_value);
                foreach ($Result_sum_current_value as $rck => $rcv){
                    foreach ($Result_sum_last_value as $rlk => $rlv){
                        foreach ($Result_sum_last_month_value as $rlmk => $rlmv){
                            if ('用水量' == $select_param) {
                                $v['category'] = '用水量';
                                if (null == $rcv['d2m_syslaccu'] || '' == $rcv['d2m_syslaccu']) {
                                    $v['本期值'] = '0t';
                                }else{
                                    $v['本期值'] =$rcv['d2m_syslaccu'].'t';
                                }
                                if (null == $rlv['d2m_syslaccu'] || '' == $rlv['d2m_syslaccu']) {
                                    $v['上期值'] = '0t';
                                }else{
                                    $v['上期值'] =$rlv['d2m_syslaccu'].'t';
                                }
                                if (null == $rlmv['d2m_syslaccu'] || '' == $rlmv['d2m_syslaccu']) {
                                    $v['去年同期值'] = '0t';
                                }else{
                                    $v['去年同期值'] =$rlmv['d2m_syslaccu'].'t';
                                }
                                if (0 == $rlv['d2m_syslaccu']){
                                    $v['同比'] = '无';
                                }else{
                                    $v['同比'] = floor(($rcv['d2m_syslaccu']/$rlv['d2m_syslaccu'])*100).'%';
                                }
                                if (0 == $rlmv['d2m_syslaccu']){
                                    $v['环比'] = '无';
                                }else{
                                    $v['环比'] = floor(($rcv['d2m_syslaccu']/$rlmv['d2m_syslaccu'])*100).'%';
                                }
                            }
                            if ('电量值' == $select_param) {
                                $v['category'] = '电量值';
                                if (null == $rcv['d2m_dglaccu'] || '' == $rcv['d2m_dglaccu']) {
                                    $v['本期值'] = '0KW';
                                }else{
                                    $v['本期值'] =$rcv['d2m_dglaccu'].'KW';
                                }
                                if (null == $rlv['d2m_dglaccu'] || '' == $rlv['d2m_dglaccu']) {
                                    $v['上期值'] = '0KW';
                                }else{
                                    $v['上期值'] =$rlv['d2m_dglaccu'].'KW';
                                }
                                if (null == $rlmv['d2m_dglaccu'] || '' == $rlmv['d2m_dglaccu']) {
                                    $v['去年同期值'] = '0KW';
                                }else{
                                    $v['去年同期值'] =$rlmv['d2m_dglaccu'].'KW';
                                }
                                if (0 == $rlv['d2m_dglaccu']){
                                    $v['同比'] = '无';
                                }else{
                                    $v['同比'] = floor(($rcv['d2m_dglaccu']/$rlv['d2m_dglaccu'])*100).'%';
                                }
                                if (0 == $rlmv['d2m_dglaccu']){
                                    $v['环比'] = '无';
                                }else{
                                    $v['环比'] = floor(($rcv['d2m_dglaccu']/$rlmv['d2m_dglaccu'])*100).'%';
                                }
                            }
                            if ('用冷量' == $select_param) {
                                $v['category'] = '用冷量';
                                if (null == $rcv['d2m_yllaccu'] || '' == $rcv['d2m_yllaccu']) {
                                    $v['本期值'] = '0KW';
                                }else{
                                    $v['本期值'] =$rcv['d2m_yllaccu'].'KW';
                                }
                                if (null == $rlv['d2m_yllaccu'] || '' == $rlv['d2m_yllaccu']) {
                                    $v['上期值'] = '0KW';
                                }else{
                                    $v['上期值'] =$rlv['d2m_yllaccu'].'KW';
                                }
                                if (null == $rlmv['d2m_yllaccu'] || '' == $rlmv['d2m_yllaccu']) {
                                    $v['去年同期值'] = '0KW';
                                }else{
                                    $v['去年同期值'] =$rlmv['d2m_yllaccu'].'KW';
                                }
                                if (0 == $rlv['d2m_yllaccu']){
                                    $v['同比'] = '无';
                                }else{
                                    $v['同比'] = floor(($rcv['d2m_yllaccu']/$rlv['d2m_yllaccu'])*100).'%';
                                }
                                if (0 == $rlmv['d2m_yllaccu']){
                                    $v['环比'] = '无';
                                }else{
                                    $v['环比'] = floor(($rcv['d2m_yllaccu']/$rlmv['d2m_yllaccu'])*100).'%';
                                }
                            }
                            if ('用暖量' == $select_param) {
                                $v['category'] = '用暖量';
                                if (null == $rcv['d2m_ynlaccu'] || '' == $rcv['d2m_ynlaccu']) {
                                    $v['本期值'] = '0KW';
                                }else{
                                    $v['本期值'] =$rcv['d2m_ynlaccu'].'KW';
                                }
                                if (null == $rlv['d2m_ynlaccu'] || '' == $rlv['d2m_ynlaccu']) {
                                    $v['上期值'] = '0KW';
                                }else{
                                    $v['上期值'] =$rlv['d2m_ynlaccu'].'KW';
                                }
                                if (null == $rlmv['d2m_ynlaccu'] || '' == $rlmv['d2m_ynlaccu']) {
                                    $v['去年同期值'] = '0KW';
                                }else{
                                    $v['去年同期值'] =$rlmv['d2m_ynlaccu'].'KW';
                                }
                                if (0 == $rlv['d2m_ynlaccu']){
                                    $v['同比'] = '无';
                                }else{
                                    $v['同比'] = floor(($rcv['d2m_ynlaccu']/$rlv['d2m_ynlaccu'])*100).'%';
                                }
                                if (0 == $rlmv['d2m_ynlaccu']){
                                    $v['环比'] = '无';
                                }else{
                                    $v['环比'] = floor(($rcv['d2m_ynlaccu']/$rlmv['d2m_ynlaccu'])*100).'%';
                                }
                            }
                        }
                    }
                }
            }
            $serices_benqizhi = [];
            $serices_benqizhi['name'] = '本期值';
            $serices_benqizhi['stack'] = 1;
            $serices_benqizhi_data = [];
            foreach ($result as $rk => $rv){
                array_push($serices_benqizhi_data,(int)$rv['本期值']);
            }
            $serices_benqizhi['data'] = $serices_benqizhi_data;
            $serices_shangqizhi = [];
            $serices_shangqizhi['name'] = '上期值';
            $serices_shangqizhi['stack'] = 2;
            $serices_shangqizhi_data = [];
            foreach ($result as $rk => $rv){
                array_push($serices_shangqizhi_data,(int)$rv['上期值']);
            }
            $serices_shangqizhi['data'] = $serices_shangqizhi_data;
            $serices_qunianzhi = [];
            $serices_qunianzhi['name'] = '去年同期值';
            $serices_qunianzhi['stack'] = 3;
            $serices_qunianzhi_data = [];
            foreach ($result as $rk => $rv){
                array_push($serices_qunianzhi_data,(int)$rv['去年同期值']);
            }
            $serices_qunianzhi['data'] = $serices_qunianzhi_data;
            $series = [];
            array_push($series,$serices_benqizhi);
            array_push($series,$serices_shangqizhi);
            array_push($series,$serices_qunianzhi);
            foreach ($result as $k => &$v){
                $v['series'] = $series;
            }
            $Result = array_slice($result,$offset,$limit) ;
            echo json_encode(array('total' => count($result), 'rows' => $Result));
        }
    }
    function combineArray($arr1,$arr2) {
        $result = array();
        foreach ($arr1 as $item1) {
            foreach ($arr2 as $item2) {
                $array = array_merge($item1,$item2);
                array_push($result,$array);
            }
        }
        return $result;
    }
}