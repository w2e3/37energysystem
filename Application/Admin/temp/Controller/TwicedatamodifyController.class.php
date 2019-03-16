<?php
namespace Admin\Controller;
use Think\Controller;
use Admin\BaseController;
class TwicedatamodifyController extends BaseAuthController
{
    public function index()
    {
      $d2mdf_atpid=I('get.d2mdf_atpid',null);
      if($d2mdf_atpid!=null)
      {
        $data=M('data2modify')->where("d2mdf_atpstatus is null and d2mdf_atpid='%s'",array($d2mdf_atpid))->find();
        $this->assign('d2mdf_atpid',$d2mdf_atpid);
        $this->assign('data',$data);
      }else
      {
        //添加订单
        $Model = M('data2modify');
        $data = array();
        $data['d2mdf_atpid'] = $this->makeGuid();
        $data['d2mdf_atpcreatedatetime'] = date("Y-m-d H:i:s", time());
        $data['d2mdf_atpcreateuser'] = session('emp_account');
        $data['d2mdf_atplastmodifydatetime'] = date("Y-m-d H:i:s", time());
        $data['d2mdf_atplastmodifyuser'] = session('emp_account');
        $data['d2mdf_atpsort'] = time();
        $data['d2mdf_atpstatus'] = 'DEL';
        // $data['d2mdf_name'] = "";
        // $data['d2mdf_desc'] = "";
        // $data['d2mdf_datacategory'] = "日数据";
        // $data['d2mdf_startempid'] = "";
        // $data['d2mdf_startdt'] = "";
        // $data['d2mdf_agreeempid'] = "";
        // $data['d2mdf_agreeempdt'] = "";
        // $data['d2mdf_agreestatus'] = "待审批";
        // $data['d2mdf_agreebackinfo'] = "";
        // $data['d2mdf_remark'] = "";
        $Model->add($data);
        $this->assign('d2mdf_atpid', $data['d2mdf_atpid']);
      }



        $this->display();
    }

    public function edit()
    {
      $d2mdfd_group=I('get.d2mdfd_group',null);
      $energytype=I('get.energytype',null);

//      dump($d2mdfd_group);
      $d2mdfd_date=M('data2modifydetail')->where("d2mdfd_atpstatus is null and d2mdfd_group='%s'",array($d2mdfd_group))->select();
//      dump($d2mdfd_date);
      //判断能源类型
      $energytype=null;
      if(count($d2mdfd_date)>0)
      {
        $energytype=$this->getenergytype($d2mdfd_date[0]['d2mdfd_paramid']);
      }

      if($energytype=='电')
      {
        if(count($d2mdfd_date)>0)
        {
          $data = array();
          $data['d2mdfd_atpid_dgl']=null;
          $data['d2mdfd_atpid_df']=null;
          $data['d2mdfd_atpid_da']=null;
          $data['d2mdfd_paramid_dgl']=0;
          $data['d2mdfd_paramid_df']=0;
          $data['d2mdfd_paramid_da']=0;
          $data['d2mdfd_isedit']=true;
          foreach ($d2mdfd_date as $k=>$v)
          {
            if($v['d2mdfd_paramid']=='guidBCE5A090-142A-4D38-8133-BD489E5774BD')
            {
              $data['d2mdfd_atpid_dgl']=$v['d2mdfd_atpid'];
              $data['d2mdfd_paramid_dgl']=$v['d2mdfd_newvalue'];
              $data['d2mdfd_group']=$v['d2mdfd_group'];
              $data['d2mdfd_regionid']=$v['d2mdfd_regionid'];
              $data['d2mdfd_dt']=$v['d2mdfd_dt'];
            }
            elseif($v['d2mdfd_paramid']=='guid014A4D5E-DA0D-4B78-8E8D-AF65D3AFD346')
            {
              $data['d2mdfd_atpid_df']=$v['d2mdfd_atpid'];
              $data['d2mdfd_paramid_df']=$v['d2mdfd_newvalue'];
              $data['d2mdfd_group']=$v['d2mdfd_group'];
              $data['d2mdfd_regionid']=$v['d2mdfd_regionid'];
              $data['d2mdfd_dt']=$v['d2mdfd_dt'];
            }
            elseif($v['d2mdfd_paramid']=='guidD6492EA5-1586-4071-BF63-E3BEEA289CAC')
            {
              $data['d2mdfd_atpid_da']=$v['d2mdfd_atpid'];
              $data['d2mdfd_paramid_da']=$v['d2mdfd_newvalue'];
              $data['d2mdfd_group']=$v['d2mdfd_group'];
              $data['d2mdfd_regionid']=$v['d2mdfd_regionid'];
              $data['d2mdfd_dt']=$v['d2mdfd_dt'];
            }
          }

          $this->assign('data',$data);
        }
        $this->makeregion("电能");
        $this->display('adddian');
      }
      elseif ($energytype=='冷')
      {
        if(count($d2mdfd_date)>0)
        {
          $data = array();
          $data['d2mdfd_atpid_yll']=null;
          $data['d2mdfd_paramid_yll']=null;
          $data['d2mdfd_isedit']=true;
          foreach ($d2mdfd_date as $k=>$v)
          {
            if($v['d2mdfd_paramid']=='guidC4BA8B03-DADD-4E09-813E-A2DA8DC381FC')
            {
              $data['d2mdfd_atpid_yll']=$v['d2mdfd_atpid'];
              $data['d2mdfd_paramid_yll']=$v['d2mdfd_newvalue'];
              $data['d2mdfd_group']=$v['d2mdfd_group'];
              $data['d2mdfd_regionid']=$v['d2mdfd_regionid'];
              $data['d2mdfd_dt']=$v['d2mdfd_dt'];
            }
          }
          $this->assign('data',$data);
        }
        $this->makeregion("冷能");
        $this->display('addleng');
      }
      elseif ($energytype=='暖')
      {
        if(count($d2mdfd_date)>0)
        {
          $data = array();
          $data['d2mdfd_atpid_ynl']=null;
          $data['d2mdfd_paramid_ynl']=null;
          $data['d2mdfd_isedit']=true;
          foreach ($d2mdfd_date as $k=>$v)
          {
            if($v['d2mdfd_paramid']=='guidC4BA8B03-DADD-4E09-813E-A2DA8C3x1001')
            {
              $data['d2mdfd_atpid_ynl']=$v['d2mdfd_atpid'];
              $data['d2mdfd_paramid_ynl']=$v['d2mdfd_newvalue'];
              $data['d2mdfd_group']=$v['d2mdfd_group'];
              $data['d2mdfd_regionid']=$v['d2mdfd_regionid'];
              $data['d2mdfd_dt']=$v['d2mdfd_dt'];
            }
          }
          $this->assign('data',$data);
        }
        $this->makeregion("暖能");
        $this->display('addnuan');
      }
      elseif ($energytype=='水')
      {
        if(count($d2mdfd_date)>0)
        {
          $data = array();
          $data['d2mdfd_atpid_sysl']=null;
          $data['d2mdfd_paramid_sysl']=null;
          $data['d2mdfd_isedit']=true;
          foreach ($d2mdfd_date as $k=>$v)
          {
            if($v['d2mdfd_paramid']=='guid5A22BD7D-815D-4217-8494-9EF79EB1BCF1')
            {
              $data['d2mdfd_atpid_sysl']=$v['d2mdfd_atpid'];
              $data['d2mdfd_paramid_sysl']=$v['d2mdfd_newvalue'];
              $data['d2mdfd_group']=$v['d2mdfd_group'];
              $data['d2mdfd_regionid']=$v['d2mdfd_regionid'];
              $data['d2mdfd_dt']=$v['d2mdfd_dt'];
            }
          }
          $this->assign('data',$data);
        }
        $this->makeregion("水能");
        $this->display('addshui');
      }
    }
    public function adddian()
    {
        $this->makeregion("电能");
        $this->display();
    }

    public function addshui()
    {
        $this->makeregion("水能");
        $this->display();
    }

    public function addleng()
    {
        $this->makeregion("冷能");
        $this->display();
    }

    public function addnuan()
    {
        $this->makeregion("暖能");
        $this->display();
    }


    public function addsubmit()
    {
//      dump($_POST);
      //修改
      $d2mdfd_regionid = I("post.d2mdfd_regionid", "");
      $d2mdfd_dt = I("post.d2mdfd_dt", "");
      $energytype = I("post.energytype", "");
      //电
      $d2mdfd_atpid_dgl=I('post.d2mdfd_atpid_dgl',null);
      $d2mdfd_atpid_df=I('post.d2mdfd_atpid_df',null);
      $d2mdfd_atpid_da=I('post.d2mdfd_atpid_da',null);

      //冷
      $d2mdfd_atpid_yll=I('post.d2mdfd_atpid_yll',null);
      //暖
      $d2mdfd_atpid_ynl=I('post.d2mdfd_atpid_ynl',null);
      //水
      $d2mdfd_atpid_sysl=I('post.d2mdfd_atpid_sysl',null);


      $Model = M('data2modifydetail');
      $isedit=I('post.d2mdfd_isedit',null);
//      dump($_POST);
      if($isedit!=null)
      {
        if($energytype=='电')
        {
          if($d2mdfd_atpid_dgl!=null)
          {
            $data['d2mdfd_atplastmodifydatetime'] = date("Y-m-d H:i:s", time());
            $data['d2mdfd_atplastmodifyuser'] = session('emp_account');
            $data['d2mdfd_regionid'] = $d2mdfd_regionid;
            $data['d2mdfd_dt'] = $d2mdfd_dt;
            $data['d2mdfd_paramid'] = 'guidBCE5A090-142A-4D38-8133-BD489E5774BD';
            $data['d2mdfd_newvalue'] = I("post.d2mdfd_paramid_dgl", 0);
            $Model->where("d2mdfd_atpid='%s'",array($d2mdfd_atpid_dgl))->save($data);
          }
          if($d2mdfd_atpid_df!=null)
          {
            $data['d2mdfd_atplastmodifydatetime'] = date("Y-m-d H:i:s", time());
            $data['d2mdfd_atplastmodifyuser'] = session('emp_account');
            $data['d2mdfd_regionid'] = $d2mdfd_regionid;
            $data['d2mdfd_dt'] = $d2mdfd_dt;
            $data['d2mdfd_paramid'] = 'guid014A4D5E-DA0D-4B78-8E8D-AF65D3AFD346';
            $data['d2mdfd_newvalue'] = I("post.d2mdfd_paramid_df", 0);
            $Model->where("d2mdfd_atpid='%s'",array($d2mdfd_atpid_df))->save($data);
          }
          if($d2mdfd_atpid_da!=null)
          {
            $data['d2mdfd_atplastmodifydatetime'] = date("Y-m-d H:i:s", time());
            $data['d2mdfd_atplastmodifyuser'] = session('emp_account');
            $data['d2mdfd_regionid'] = $d2mdfd_regionid;
            $data['d2mdfd_dt'] = $d2mdfd_dt;
            $data['d2mdfd_paramid'] = 'guidD6492EA5-1586-4071-BF63-E3BEEA289CAC';
            $data['d2mdfd_newvalue'] = I("post.d2mdfd_paramid_da", 0);
            $Model->where("d2mdfd_atpid='%s'",array($d2mdfd_atpid_da))->save($data);
          }
        }elseif ($energytype=='冷')
        {
          $data['d2mdfd_atplastmodifydatetime'] = date("Y-m-d H:i:s", time());
          $data['d2mdfd_atplastmodifyuser'] = session('emp_account');
          $data['d2mdfd_regionid'] = $d2mdfd_regionid;
          $data['d2mdfd_dt'] = $d2mdfd_dt;
          $data['d2mdfd_paramid'] = 'guidC4BA8B03-DADD-4E09-813E-A2DA8DC381FC';
          $data['d2mdfd_newvalue'] = I("post.d2mdfd_paramid_yll", 0);
          $Model->where("d2mdfd_atpid='%s'",array($d2mdfd_atpid_yll))->save($data);
        }elseif ($energytype=='暖')
        {
          $data['d2mdfd_atplastmodifydatetime'] = date("Y-m-d H:i:s", time());
          $data['d2mdfd_atplastmodifyuser'] = session('emp_account');
          $data['d2mdfd_regionid'] = $d2mdfd_regionid;
          $data['d2mdfd_dt'] = $d2mdfd_dt;
          $data['d2mdfd_paramid'] = 'guidC4BA8B03-DADD-4E09-813E-A2DA8C3x1001';
          $data['d2mdfd_newvalue'] = I("post.d2mdfd_paramid_ynl", 0);
          $Model->where("d2mdfd_atpid='%s'",array($d2mdfd_atpid_ynl))->save($data);
        }elseif ($energytype=='水')
        {
          $data['d2mdfd_atplastmodifydatetime'] = date("Y-m-d H:i:s", time());
          $data['d2mdfd_atplastmodifyuser'] = session('emp_account');
          $data['d2mdfd_regionid'] = $d2mdfd_regionid;
          $data['d2mdfd_dt'] = $d2mdfd_dt;
          $data['d2mdfd_paramid'] = 'guid5A22BD7D-815D-4217-8494-9EF79EB1BCF1';
          $data['d2mdfd_newvalue'] = I("post.d2mdfd_paramid_sysl", 0);
          $Model->where("d2mdfd_atpid='%s'",array($d2mdfd_atpid_sysl))->save($data);
        }

      }else
      {
        $group_id = $this->makeGuid();
        $Model = M('data2modifydetail');
        $d2mdfd_regionid = I("post.d2mdfd_regionid", "");
        $d2mdfd_dt = I("post.d2mdfd_dt", "");
        $data2modifyid = I("post.data2modifyid", "");
        $energytype = I("post.energytype", "");
        if ("电" == $energytype) {
          $data_dgl = array();
          $data_dgl['d2mdfd_atpid'] = $this->makeGuid();
          $data_dgl['d2mdfd_atpcreatedatetime'] = date("Y-m-d H:i:s", time());
          $data_dgl['d2mdfd_atpcreateuser'] = session('emp_account');
          $data_dgl['d2mdfd_atplastmodifydatetime'] = date("Y-m-d H:i:s", time());
          $data_dgl['d2mdfd_atplastmodifyuser'] = session('emp_account');
          $data_dgl['d2mdfd_atpsort'] = time();
          $data_dgl['d2mdfd_atpstatus'] = null;
          $data_dgl['d2mdfd_data2modifyid'] = $data2modifyid;
          $data_dgl['d2mdfd_data2hourid'] = '';
          $data_dgl['d2mdfd_data2dayid'] = '';
          $data_dgl['d2mdfd_group'] = $group_id;
          $data_dgl['d2mdfd_dotype'] = '编辑';
          $data_dgl['d2mdfd_deviceid'] = '';
          $data_dgl['d2mdfd_regionid'] = $d2mdfd_regionid;
          $data_dgl['d2mdfd_dt'] = $d2mdfd_dt;
          $data_dgl['d2mdfd_paramid'] = 'guidBCE5A090-142A-4D38-8133-BD489E5774BD';
          $data_dgl['d2mdfd_oldvalue'] = null;
          $data_dgl['d2mdfd_newvalue'] = I("post.d2mdfd_paramid_dgl", "");
          $data_df = array();
          $data_df['d2mdfd_atpid'] = $this->makeGuid();
          $data_df['d2mdfd_atpcreatedatetime'] = date("Y-m-d H:i:s", time());
          $data_df['d2mdfd_atpcreateuser'] = session('emp_account');
          $data_df['d2mdfd_atplastmodifydatetime'] = date("Y-m-d H:i:s", time());
          $data_df['d2mdfd_atplastmodifyuser'] = session('emp_account');
          $data_df['d2mdfd_atpsort'] = time();
          $data_df['d2mdfd_atpstatus'] = null;
          $data_df['d2mdfd_data2modifyid'] = $data2modifyid;
          $data_df['d2mdfd_data2hourid'] = '';
          $data_df['d2mdfd_data2dayid'] = '';
          $data_df['d2mdfd_group'] = $group_id;
          $data_df['d2mdfd_dotype'] = '编辑';
          $data_df['d2mdfd_deviceid'] = '';
          $data_df['d2mdfd_regionid'] = $d2mdfd_regionid;
          $data_df['d2mdfd_dt'] = $d2mdfd_dt;
          $data_df['d2mdfd_paramid'] = 'guid014A4D5E-DA0D-4B78-8E8D-AF65D3AFD346';
          $data_df['d2mdfd_oldvalue'] = null;
          $data_df['d2mdfd_newvalue'] = I("post.d2mdfd_paramid_df", "");
          $data_da = array();
          $data_da['d2mdfd_atpid'] = $this->makeGuid();
          $data_da['d2mdfd_atpcreatedatetime'] = date("Y-m-d H:i:s", time());
          $data_da['d2mdfd_atpcreateuser'] = session('emp_account');
          $data_da['d2mdfd_atplastmodifydatetime'] = date("Y-m-d H:i:s", time());
          $data_da['d2mdfd_atplastmodifyuser'] = session('emp_account');
          $data_da['d2mdfd_atpsort'] = time();
          $data_da['d2mdfd_atpstatus'] = null;
          $data_da['d2mdfd_data2modifyid'] = $data2modifyid;
          $data_da['d2mdfd_data2hourid'] = '';
          $data_da['d2mdfd_data2dayid'] = '';
          $data_da['d2mdfd_group'] = $group_id;
          $data_da['d2mdfd_dotype'] = '编辑';
          $data_da['d2mdfd_deviceid'] = '';
          $data_da['d2mdfd_regionid'] = $d2mdfd_regionid;
          $data_da['d2mdfd_dt'] = $d2mdfd_dt;
          $data_da['d2mdfd_paramid'] = 'guidD6492EA5-1586-4071-BF63-E3BEEA289CAC';
          $data_da['d2mdfd_oldvalue'] = null;
          $data_da['d2mdfd_newvalue'] = I("post.d2mdfd_paramid_da", "");
          $Model->add($data_dgl);
          $Model->add($data_df);
          $Model->add($data_da);
          echo 1;
        }
        if ("水" == $energytype) {
          $data = array();
          $data['d2mdfd_atpid'] = $this->makeGuid();
          $data['d2mdfd_atpcreatedatetime'] = date("Y-m-d H:i:s", time());
          $data['d2mdfd_atpcreateuser'] = session('emp_account');
          $data['d2mdfd_atplastmodifydatetime'] = date("Y-m-d H:i:s", time());
          $data['d2mdfd_atplastmodifyuser'] = session('emp_account');
          $data['d2mdfd_atpsort'] = time();
          $data['d2mdfd_atpstatus'] = null;
          $data['d2mdfd_data2modifyid'] = $data2modifyid;
          $data['d2mdfd_data2hourid'] = '';
          $data['d2mdfd_data2dayid'] = '';
          $data['d2mdfd_group'] = $group_id;
          $data['d2mdfd_dotype'] = '编辑';
          $data['d2mdfd_deviceid'] = '';
          $data['d2mdfd_regionid'] = $d2mdfd_regionid;
          $data['d2mdfd_dt'] = $d2mdfd_dt;
          $data['d2mdfd_paramid'] = 'guid5A22BD7D-815D-4217-8494-9EF79EB1BCF1';
          $data['d2mdfd_oldvalue'] = null;
          $data['d2mdfd_newvalue'] = I("post.d2mdfd_paramid_sysl", "");
          $Model->add($data);
        }
        if ("冷" == $energytype) {
          $data = array();
          $data['d2mdfd_atpid'] = $this->makeGuid();
          $data['d2mdfd_atpcreatedatetime'] = date("Y-m-d H:i:s", time());
          $data['d2mdfd_atpcreateuser'] = session('emp_account');
          $data['d2mdfd_atplastmodifydatetime'] = date("Y-m-d H:i:s", time());
          $data['d2mdfd_atplastmodifyuser'] = session('emp_account');
          $data['d2mdfd_atpsort'] = time();
          $data['d2mdfd_atpstatus'] = null;
          $data['d2mdfd_data2modifyid'] = $data2modifyid;
          $data['d2mdfd_data2hourid'] = '';
          $data['d2mdfd_data2dayid'] = '';
          $data['d2mdfd_group'] = $group_id;
          $data['d2mdfd_dotype'] = '编辑';
          $data['d2mdfd_deviceid'] = '';
          $data['d2mdfd_regionid'] = $d2mdfd_regionid;
          $data['d2mdfd_dt'] = $d2mdfd_dt;
          $data['d2mdfd_paramid'] = 'guidC4BA8B03-DADD-4E09-813E-A2DA8DC381FC';
          $data['d2mdfd_oldvalue'] = null;
          $data['d2mdfd_newvalue'] = I("post.d2mdfd_paramid_yll", "");
          $Model->add($data);
        }
        if ("暖" == $energytype) {
          $data = array();
          $data['d2mdfd_atpid'] = $this->makeGuid();
          $data['d2mdfd_atpcreatedatetime'] = date("Y-m-d H:i:s", time());
          $data['d2mdfd_atpcreateuser'] = session('emp_account');
          $data['d2mdfd_atplastmodifydatetime'] = date("Y-m-d H:i:s", time());
          $data['d2mdfd_atplastmodifyuser'] = session('emp_account');
          $data['d2mdfd_atpsort'] = time();
          $data['d2mdfd_atpstatus'] = null;
          $data['d2mdfd_data2modifyid'] = $data2modifyid;
          $data['d2mdfd_data2hourid'] = '';
          $data['d2mdfd_data2dayid'] = '';
          $data['d2mdfd_group'] = $group_id;
          $data['d2mdfd_dotype'] = '编辑';
          $data['d2mdfd_deviceid'] = '';
          $data['d2mdfd_regionid'] = $d2mdfd_regionid;
          $data['d2mdfd_dt'] = $d2mdfd_dt;
          $data['d2mdfd_paramid'] = 'guidC4BA8B03-DADD-4E09-813E-A2DA8C3x1001';
          $data['d2mdfd_oldvalue'] = null;
          $data['d2mdfd_newvalue'] = I("post.d2mdfd_paramid_ynl", "");
          $Model->add($data);
        }
      }
    }


    public function getModifydetailData()
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

    public function submit()
    {
        $Model = M('data2modify');
        $d2mdf_atpid = $_POST['d2mdf_atpid'];
        $d2mdf_name = $_POST['d2mdf_name'];
        $d2mdf_desc = $_POST['d2mdf_desc'];
        $data = array();
//        $data['d2mdf_atpid'] = $this->makeGuid();
//        $data['d2mdf_atpcreatedatetime'] = date("Y-m-d H:i:s", time());
//        $data['d2mdf_atpcreateuser'] = session('emp_account');
//        $data['d2mdf_atplastmodifydatetime'] = date("Y-m-d H:i:s", time());
//        $data['d2mdf_atplastmodifyuser'] = session('emp_account');
//        $data['d2mdf_atpsort'] = time();
        $data['d2mdf_atpstatus'] = null;
        $data['d2mdf_name'] = $d2mdf_name;
        $data['d2mdf_desc'] = $d2mdf_desc;
        $data['d2mdf_datacategory'] = "日数据";
        $data['d2mdf_startempid'] = session('emp_atpid');
        $data['d2mdf_startdt'] = date("Y-m-d H:i:s", time());;
        $data['d2mdf_agreeempid'] = null;
        $data['d2mdf_agreeempdt'] = null;
        $data['d2mdf_agreestatus'] = "待审批";
//         $data['d2mdf_agreebackinfo'] = "";
//         $data['d2mdf_remark'] = "";
        $Model->where("d2mdf_atpid='%s'", array($d2mdf_atpid))->save($data);
    }

    public function del()
    {
        try {
            $ids = $_POST['ids'];
            $array = explode(',', $ids);
            $Model = M();
            foreach ($array as $id) {
                $Model->execute("update szny_data2modifydetail t set t.d2mdfd_atpstatus='DEL' where t.d2mdfd_group = '$id';");
            }
        } catch (\Exception $e) {
            echo "fail" . $e;
        }
    }

    public function makeregion($etname)
    {
        $rgn_atpid = I("get.rgn_atpid", "");
        $res = $this->getRegionDevicePoint('rg', $rgn_atpid, '');
        foreach ($res as $key => $value) {
            $date[] = "'" . $value['rgn_atpid'] . "'";
        }
        $endrgn_atpidsstrings = implode(',', $date);
        $Model = M();
        $sql_select = "
                    select
                        distinct t.*
                    from szny_region t
                    left join szny_device t1 on t1.dev_regionid = t.rgn_atpid
                    left join szny_devicemodel t2 on t1.dev_devicemodelid = t2.dm_atpid
                    left join szny_energytyperegion t3 on t3.etr_regionid = t.rgn_atpid
                    left join szny_energytype t4 on t3.etr_energytypeid = t4.et_atpid
                    where t.rgn_category = '设备点' and t4.et_name = '$etname'
                ";
        $sql_select = $this->buildSql($sql_select, "t.rgn_atpstatus is null");
        $sql_select = $this->buildSql($sql_select, "t.rgn_atpid in (" . $endrgn_atpidsstrings . ")");
        $sql_select = $sql_select . " order by t.rgn_name asc";
        $Result = $Model->query($sql_select);
        $this->assign('regionlist', $Result);
    }

    function getenergytype($d2mdfd_paramid)
    {
      $type=null;
//      dump($d2mdfd_paramid);
      if($d2mdfd_paramid=='guidBCE5A090-142A-4D38-8133-BD489E5774BD')
      {
      $type = '电';
      }
      elseif($d2mdfd_paramid=='guid014A4D5E-DA0D-4B78-8E8D-AF65D3AFD346')
      {
        $type = '电';
      }
      elseif($d2mdfd_paramid=='guidD6492EA5-1586-4071-BF63-E3BEEA289CAC')
      {
        $type = '电';
      }
      elseif($d2mdfd_paramid=='guid5A22BD7D-815D-4217-8494-9EF79EB1BCF1')
      {
        $type = '水';
      }
      elseif($d2mdfd_paramid=='guid5A22BD7D-815D-4217-8494-9EF79EB1BCF1')
      {
        $type = '冷';
      }elseif($d2mdfd_paramid=='guidC4BA8B03-DADD-4E09-813E-A2DA8C3x1001')
      {
        $type = '暖';
      }

      return $type;
    }

}