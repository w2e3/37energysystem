<?php
namespace Admin\Controller;
use Think\Controller;
class TwicedataspController extends BaseController
{
    public function index()
    {
        $this->display();
        $this->logSys(session('emp_atpid'), "访问日志", "访问页面：【审批中心】 / 【数据修改单审批】");
    }

    public function getData()
    {
        $queryparam = json_decode(file_get_contents("php://input"), true);
        $Model = M();
        $sql_select = "
				select
					t.*,t1.emp_name as startempname,t2.emp_name as agreeempname
				from szny_data2modify t
				left join szny_emp t1 on t1.emp_atpid=t.d2mdf_startempid
				left join szny_emp t2 on t2.emp_atpid=t.d2mdf_agreeempid
				";
        $sql_count = "
				select
					count(1) c
				from szny_data2modify t
				left join szny_emp t1 on t1.emp_atpid=t.d2mdf_startempid
				left join szny_emp t2 on t2.emp_atpid=t.d2mdf_agreeempid
				";
        $sql_select = $this->buildSql($sql_select, "t.d2mdf_atpstatus is null");
        $sql_count = $this->buildSql($sql_count, "t.d2mdf_atpstatus is null");
        $sql_select = $this->buildSql($sql_select, "t.d2mdf_agreestatus ='待审批'");
        $sql_count = $this->buildSql($sql_count, "t.d2mdf_agreestatus ='待审批'");

        //快捷搜索
//        if (null != $queryparam['search']) {
//            $searchcontent = trim($queryparam['search']);
//            $sql_select = $this->buildSql($sql_select, "t.d2mdf_name like '%" . $searchcontent . "%'");
//            $sql_count = $this->buildSql($sql_count, "t.d2mdf_name like '%" . $searchcontent . "%'");
//        }

        //排序
        if (null != $queryparam['sort']) {
            $sql_select = $sql_select . " order by " . $queryparam['sort'] . ' ' . $queryparam['sortOrder'] . ' ';
        } else {
            $sql_select = $sql_select . " order by t.d2mdf_startdt desc";
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
        $Count = $Model->query($sql_count);
        echo json_encode(array('total' => $Count[0]['c'], 'rows' => $Result));
    }

    public function shenpi()
    {
        $this->logSys(session('emp_atpid'), "访问日志", "访问页面：【园区漫游】 / 【示例:雇员管理】 / 【编辑】");
        $id = $_GET['d2mdf_atpid'];
        $Model = M();
        $sql_select = "
				select
					t.*,t1.emp_name as startempname,t2.emp_name as agreeempname
				from szny_data2modify t
				left join szny_emp t1 on t1.emp_atpid=t.d2mdf_startempid
				left join szny_emp t2 on t2.emp_atpid=t.d2mdf_agreeempid
				where t.d2mdf_atpstatus is null and t.d2mdf_atpid ='$id'
				";
        $Result = $Model->query($sql_select);
        $this->assign('data', $Result[0]);
        $this->display();
    }

    public function getXiangqingData()
    {
        $d2mdf_atpid = $_GET['d2mdf_atpid'];
        $where = "t.d2mdfd_data2modifyid = '$d2mdf_atpid'";
        $Model = M();
        $sql_select = "
                SELECT group_concat(CONCAT(t1.p_name,':',t.d2mdfd_newvalue,' ',t1.p_unit) separator '<br/>') info ,t.*,t2.*
                FROM `szny_data2modifydetail` t
                left join szny_param t1 on t.d2mdfd_paramid = t1.p_atpid
                left join szny_region t2 on t.d2mdfd_regionid = t2.rgn_atpid
                where t.d2mdfd_atpstatus is null and  $where
                group by t.d2mdfd_group
                order by t.d2mdfd_atpsort asc";
//        echo $sql_select;
        $Result = $Model->query($sql_select, $sql_select);
        echo json_encode(array('total' => count($Result), 'rows' => $Result));
    }

    public function submitpass()
    {
        //更新数据修改单状态
        $Model = M('data2modify');
        $d2mdf_atpid = I("post.d2mdf_atpid", "");
        $d2mdf_remark = I("post.d2mdf_remark", "");
        $d2mdf_agreebackinfo = I("post.d2mdf_agreebackinfo", "");
        $data = $Model->where("d2mdf_atpid='%s'", array($d2mdf_atpid))->find();
        $data['d2mdfd_atplastmodifydatetime'] = date("Y-m-d H:i:s", time());
        $data['d2mdfd_atplastmodifyuser'] = session('emp_account');
        $data['d2mdf_agreeempdt'] = date("Y-m-d H:i:s", time());
        $data['d2mdf_agreeempid'] = session('emp_atpid');
        $data['d2mdf_agreestatus'] = "已通过";
        $data['d2mdf_remark'] = $d2mdf_remark;
        $data['d2mdf_agreebackinfo'] = $d2mdf_agreebackinfo;
        $Model->where("d2mdf_atpid='%s'", $d2mdf_atpid)->save($data);

        //更新具体的二次数据值
        $Model = M();
        $sql_select = "
                SELECT 
                    group_concat(CONCAT('d2d_',t1.p_shortname,'avg','=''',t.d2mdfd_newvalue,''',','d2d_',t1.p_shortname,'min','=''',t.d2mdfd_newvalue,''',','d2d_',t1.p_shortname,'max','=''',t.d2mdfd_newvalue,''',','d2d_',t1.p_shortname,'accu','=''',t.d2mdfd_newvalue,'''') separator ',') info ,
                    t.*,
                    t2.*
                FROM `szny_data2modifydetail` t
                left join szny_param t1 on t.d2mdfd_paramid = t1.p_atpid
                left join szny_region t2 on t.d2mdfd_regionid = t2.rgn_atpid
                where t.d2mdfd_atpstatus is null and t.d2mdfd_data2modifyid = '$d2mdf_atpid'
                group by t.d2mdfd_group
                order by t.d2mdfd_atpsort asc ";
        echo $sql_select;
        $Result = $Model->query($sql_select);

        $newnowdatetime = date('Y-m-d H:i:s', time());
        foreach ($Result as $k => $v) {
            $new_atpid = $this->makeGuid();
            $new_dt = $v['d2mdfd_dt'];
            $new_deviceid = $v['rgn_deviceid'];
            $new_regionid = $v['rgn_atpid'];
            $new_content = $v['info'];
            $sql_select = "select count(1) c from szny_data2day t
                where t.d2d_atpstatus is null and t.d2d_dt = '$new_dt' and t.d2d_regionid='$new_regionid'";
            $RowResult = $Model->query($sql_select);
//            echo $sql_select;
//            dump($RowResult);
            if ($RowResult[0]['c'] != 0) {
                $sql_update = "
                update szny_data2day t
                set t.d2d_atplastmodifydatetime = '$newnowdatetime' , $new_content
                where t.d2d_dt = '$new_dt' and t.d2d_regionid='$new_regionid'";
//                echo $sql_update;
                $Model->execute($sql_update);
            } else {
                $sql_insert = "
                insert szny_data2day set
                d2d_atpid='$new_atpid',
                d2d_atpcreatedatetime='$newnowdatetime',
                d2d_atpcreateuser=null,
                d2d_atplastmodifydatetime='$newnowdatetime',
                d2d_atplastmodifyuser=null,
                d2d_atpstatus=null,
                d2d_atpsort=null,
                d2d_atpdotype=null,
                d2d_atpremark=null,
                d2d_dt='$new_dt',
                d2d_deviceid='$new_deviceid',
                d2d_regionid='$new_regionid',$new_content";
//                echo $sql_insert;
                $Model->execute($sql_insert);
            }
        }
    }

    public function submitback()
    {
        $Model = M('data2modify');
        $d2mdf_atpid = I("post.d2mdf_atpid", "");
        $d2mdf_remark = I("post.d2mdf_remark", "");
        $d2mdf_agreebackinfo = I("post.d2mdf_agreebackinfo", "");
        $data = $Model->where("d2mdf_atpid='%s'", array($d2mdf_atpid))->find();
        $data['d2mdfd_atplastmodifydatetime'] = date("Y-m-d H:i:s", time());
        $data['d2mdfd_atplastmodifyuser'] = session('emp_account');
        $data['d2mdf_agreeempdt'] = date("Y-m-d H:i:s", time());
        $data['d2mdf_agreeempid'] = session('emp_atpid');
        $data['d2mdf_agreestatus'] = "已打回";
        $data['d2mdf_remark'] = $d2mdf_remark;
        $data['d2mdf_agreebackinfo'] = $d2mdf_agreebackinfo;
        $Model->where("d2mdf_atpid='%s'", $d2mdf_atpid)->save($data);
    }
}