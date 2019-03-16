<?php
namespace Admin\Controller;
use Think\Controller;
class ChangepasswordController extends BaseController {

    public function index()
    {
        $this->logSys(session('emp_atpid'),"访问日志","访问页面：【用户管理】 / 【修改密码】");
        $this->display();
    }

   public function submit()
    {
        $Model = M('emp');
        $data = $Model->create();
        $Model->where("emp_atpid='".session('emp_atpid')."'", array($data['emp_account']))->save($data);
    }

}