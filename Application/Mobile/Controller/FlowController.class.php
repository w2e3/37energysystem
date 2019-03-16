<?php
namespace Mobile\Controller;
use Think\Controller;
class FlowController extends Controller
{
   public function  index()
   {
     $this->display('');
   }
   //维修单处理
   public function wxd()
   {
     $this->display('develop');
   }
  //维修单修改
  public function datachange()
  {
    $this->display('develop');
  }
  //入库审批
  public function instork()
  {
    $this->display('develop');
  }
  //出库审批
  public function outstork()
  {
    $this->display('develop');
  }
  //全部订单
  public function bill()
  {
    $this->display('develop');
  }
}