<?php

namespace Mobile\Controller;

class LoginController extends BaseController
{
  function _initialize()
  {

  }
  public function index()
  {
    $this->display();
  }

  public function dologin()
  {

    $res = false;
    $emp['emp_account'] = ['EQ', I('param.emp_account', '')];
    $emp['emp_password'] = ['EQ', I('param.emp_password', '')];
    $emp['emp_atpstatus'] = ['EXP', "is null"];

    $result =  M('emp')->where($emp)->find();

    $arr = [];
    if (count($result) == true) {
      $res = true;
      session('emp_atpid', $result['emp_atpid']);
      session('emp_account', $result['emp_account']);
      session('emp_name', $result['emp_name']);
      session('emp_role', $result['emp_role']);
      session('ip', get_client_ip());

      $arr['emp_atpid'] = $result['emp_atpid'];
      $arr['emp_account'] = $result['emp_account'];
      $arr['emp_name'] = $result['emp_name'];
      $arr['emp_role'] = $result['emp_role'];
      $arr['ip'] = get_client_ip();
      $arr['logintime'] = time();
    }
    print  json_encode(['result' => $res,'data' => $arr]);
  }


  public function logout()
  {
    session(null);
    $this->redirect('/Mobile/Login/index');
  }

  public function setseesion()
  {
  $emp_atpid=$_POST['emp_atpid'];
  $emp_account=$_POST['emp_account'];
  $emp_name=$_POST['emp_name'];
  $emp_role=$_POST['emp_role'];
  $ip=$_POST['ip'];

  session("emp_atpid",$emp_atpid);
  session("emp_account",$emp_account);
  session("emp_name",'$emp_name');
  session("emp_role",'$emp_role');
  session("ip",$ip);
  print json_encode(array('res'=>true));
  }
}