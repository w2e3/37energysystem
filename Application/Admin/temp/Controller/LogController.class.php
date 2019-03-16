<?php
namespace Admin\Controller;
use Think\Controller;
class LogController extends BaseAuthController {

    public function index()
    {
        $this->logSys(session('emp_atpid'),"访问日志","访问页面：【系统管理】 / 【日志管理】");
        $this->display();
    }

    //获取所有数据
    public function getData(){
      $queryparam = json_decode(file_get_contents("php://input"), true);
        $Model = M();
        $sql_select = "
        select
          *
        from szny_log t
        left join szny_emp t1 on t.l_empid = t1.emp_atpid 
        ";
    $sql_count = "
        select
          count(1) c
          from szny_log t
        left join szny_emp t1 on t.l_empid = t1.emp_atpid 
         ";

        if (null != $queryparam['category'])
        {
            $searchcontent = trim($queryparam['category']);
            $sql_select = $this->buildSql($sql_select,"t.l_category = '".$searchcontent."'");
            $sql_count = $this->buildSql($sql_count,"t.l_category = '".$searchcontent."'");
        }

        //排序
        if (null != $queryparam['sort']) {
            $sql_select = $sql_select . " order by " . $queryparam['sort'] . ' ' . $queryparam['sortOrder'] . ' ';
        } else {
            $sql_select = $sql_select . " order by t.l_datetime desc ";
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
        echo json_encode(array('total' => $Count[0]['c'], 'rows' => $Result));
    }

}