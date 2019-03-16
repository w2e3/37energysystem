<?php
namespace Mobile\Controller;
use Think\Controller;
class IndexController extends BaseAuthController
{
    public function index()
    {
//      获取园区节点
      $rgn_atpid=I('get.rgn_atpid','');
      $regiontype=I('get.regiontype','');
      $snname=I('get.snname','');
      $pre_gn_atpid=I('get.pre_rgn_atpid','');

      //获得园区节点的select_option
      $this->assign('rgn_atpid',$rgn_atpid);
      $this->get_region_list($pre_gn_atpid,$regiontype,$snname);
      $this->display('index');
    }


    public function get_region_list($rgn_atpid,$regiontype,$snname)
    {
      $rgn_arr=array();

      if(($regiontype==null)||($regiontype=='rg'))
      {
        $garden_arr=M('region')->where("rgn_atpstatus is null and rgn_category='园区'")->order("rgn_name asc")->find();
        array_push($rgn_arr,$garden_arr);
        $floor_arr=M('region')->where("rgn_atpstatus is null and rgn_category='楼'")->order("rgn_name asc")->select();
        foreach ($floor_arr as $k=>$v)
        {
          array_push($rgn_arr,$v);
          $layer_arr=array();
          $layer_arr=M('region')->where("rgn_atpstatus is null and rgn_category='层' and rgn_pregionid='%s'",array($v['rgn_atpid']))->order("rgn_name asc")->select();
          foreach ($layer_arr as $k1=>$v1)
          {

            array_push($rgn_arr,$v1);
          }
        }
      }
      elseif ($regiontype=='sn')
      {
          $dev_arr=$this->getRegionDevicePoint($regiontype,$rgn_atpid,$snname);
          if(count($dev_arr)>0)
          {
            foreach ($dev_arr as $k=>$v)
            {
              $temp=M('region')->where("rgn_atpstatus is null and rgn_atpid='%s'",array($v['rgn_atpid']))->find();
              array_push($rgn_arr,$temp);
            }
          }
      }
      $this->assign('rgn_arr',$rgn_arr);
    }

  //regiontype:rg,sn
  //snname
  /**
   * 获得园区位置点数组
   * @param $regiontype rg,sn
   * @param $rgn_atpid
   * @param $snname zljf、pds、cdz、glf、tsg、yj、whhdzj
   * @return array
   */
  public function  getRegionDevicePoint($regiontype, $rgn_atpid, $snname)
  {
    $Model = M();
    $res = null;
    if ("rg" == $regiontype) {
      if ($rgn_atpid) {
        $res = $this->regionrecursive($rgn_atpid);
      } else {
        $sql = "select rgn_atpid from szny_region where rgn_category = '园区'";
        $result = $Model->query($sql);
        $res = $this->regionrecursive($result[0]['rgn_atpid']);
      }
    }
    if ("sn" == $regiontype) {
      if ($rgn_atpid) {
        $list = M("region")->find($rgn_atpid);
        if ($list['rgn_category'] == '设备点') {
          $res = $this->regionrecursive($rgn_atpid);
        } else {
          if ($snname == 'zljf') {
            $sql = "select rgn_atpid from szny_region where rgn_atpstatus is null and rgn_buildstatus = '制冷机房' and  rgn_category = '设备点' and rgn_pregionid='$rgn_atpid'";
          } elseif ($snname == 'pds') {
            $sql = "select rgn_atpid from szny_region where rgn_atpstatus is null and rgn_buildstatus = '配电室' and  rgn_category = '设备点' and rgn_pregionid='$rgn_atpid'";
          } elseif ($snname == 'cdz') {
            $sql = "select rgn_atpid from szny_region where rgn_atpstatus is null and rgn_buildstatus = '充电桩' and  rgn_category = '设备点' and rgn_pregionid='$rgn_atpid'";
          } elseif ($snname == 'glf') {
            $sql = "select rgn_atpid from szny_region where rgn_atpstatus is null and rgn_buildstatus = '锅炉房' and  rgn_category = '设备点' and rgn_pregionid='$rgn_atpid'";
          } elseif ($snname == 'tsg') {
            $sql = "select rgn_atpid from szny_region where rgn_atpstatus is null and rgn_buildstatus = '图书馆' and  rgn_category = '设备点' and rgn_pregionid='$rgn_atpid'";
          } elseif ($snname == 'yj') {
            $sql = "select rgn_atpid from szny_region where rgn_atpstatus is null and rgn_buildstatus = '邮局' and  rgn_category = '设备点' and rgn_pregionid='$rgn_atpid'";
          } elseif ($snname == 'whhdzj') {
            $sql = "select rgn_atpid from szny_region where rgn_atpstatus is null and rgn_buildstatus = '文化活动中心' and  rgn_category = '设备点' and rgn_pregionid='$rgn_atpid'";
          }
          $res = $Model->query($sql);
        }
      } else {
        if ($snname == 'zljf') {
          $sql = "select rgn_atpid from szny_region where rgn_atpstatus is null and rgn_buildstatus = '制冷机房' and  rgn_category = '设备点'";
        } elseif ($snname == 'pds') {
          $sql = "select rgn_atpid from szny_region where rgn_atpstatus is null and rgn_buildstatus = '配电室' and  rgn_category = '设备点'";
        } elseif ($snname == 'cdz') {
          $sql = "select rgn_atpid from szny_region where rgn_atpstatus is null and rgn_buildstatus = '充电桩' and  rgn_category = '设备点'";
        } elseif ($snname == 'glf') {
          $sql = "select rgn_atpid from szny_region where rgn_atpstatus is null and rgn_buildstatus = '锅炉房' and  rgn_category = '设备点'";
        } elseif ($snname == 'tsg') {
          $sql = "select rgn_atpid from szny_region where rgn_atpstatus is null and rgn_buildstatus = '图书馆' and  rgn_category = '设备点'";
        } elseif ($snname == 'yj') {
          $sql = "select rgn_atpid from szny_region where rgn_atpstatus is null and rgn_buildstatus = '邮局' and  rgn_category = '设备点'";
        } elseif ($snname == 'whhdzj') {
          $sql = "select rgn_atpid from szny_region where rgn_atpstatus is null and rgn_buildstatus = '文化活动中心' and  rgn_category = '设备点'";
        }
        $res = $Model->query($sql);
      }
    }
    return $res;
  }
  /**
   * 获取园区树
   * @param $regiontype rg,sn
   * @param $snname zljf、pds、cdz、glf、tsg、yj、whhdzj
   * @return array
   */
  public function  getRegionTree($regiontype, $snname)
  {
    $Model = M();
    $treedatas = array();
    if ("rg" == $regiontype) {
      $sql_select = "
                select
                *
                from szny_region t
                left join szny_energytyperegion t1 on t.rgn_atpid = t1.etr_regionid
                left join szny_energytype t2 on t2.et_atpid = t1.etr_energytypeid
                where t.rgn_atpstatus is null and t1.etr_atpstatus is null and t2.et_atpstatus is null
                group by t.rgn_atpid
                order by t.rgn_name asc";
      $data_org = $Model->query($sql_select);
//            $tid = "guid1A15CA6C-E3D2-4779-BF6B-F6C2D4706C9D";//根节点高亮
      foreach ($data_org as $key_org => $value_org) {
        $tdata = array();
        $tdata['id'] = $value_org['rgn_atpid'];
        $tdata['pid'] = $value_org['rgn_pregionid'];
//                if ($value_org['rgn_atpid'] == $tid) {
//                    $tdata['name'] = "<span style='background:#feeabf'>" . $value_org['rgn_name'] . "</span>";
//                } else {
//                    $tdata['name'] = $value_org['rgn_name'];
//                }
        $tdata['name'] = $value_org['rgn_name'];
        if ('园区' == $value_org['rgn_category']) {
          $tdata['icon'] = "/" . C()['ATPSITELOCATION'] . "/Public/vendor/zTree_v3/css/zTreeStyle/img/diy/park.png";
          $tdata['open'] = true;
        } elseif ('楼' == $value_org['rgn_category']) {
          $tdata['icon'] = "/" . C()['ATPSITELOCATION'] . "/Public/vendor/zTree_v3/css/zTreeStyle/img/diy/build.png";
          if ('2#' == $value_org['rgn_codename']) {
            $tdata['open'] = true;
          }
        } elseif ('座' == $value_org['rgn_category']) {
          $tdata['icon'] = "/" . C()['ATPSITELOCATION'] . "/Public/vendor/zTree_v3/css/zTreeStyle/img/diy/floor.png";
        } elseif ('单元' == $value_org['rgn_category']) {
          $tdata['icon'] = "/" . C()['ATPSITELOCATION'] . "/Public/vendor/zTree_v3/css/zTreeStyle/img/diy/unit.png";
        } elseif ('层' == $value_org['rgn_category']) {
          $tdata['icon'] = "/" . C()['ATPSITELOCATION'] . "/Public/vendor/zTree_v3/css/zTreeStyle/img/diy/storey.png";
          $tdata['open'] = false;
        } elseif ('设备点' == $value_org['rgn_category']) {
          if ('电能' == $value_org['et_name']) {
            if (null == $value_org['rgn_deviceid']) {
              $tdata['icon'] = "/" . C()['ATPSITELOCATION'] . "/Public/vendor/zTree_v3/css/zTreeStyle/img/diy/ele_meter_red.png";
            } else {
              $tdata['icon'] = "/" . C()['ATPSITELOCATION'] . "/Public/vendor/zTree_v3/css/zTreeStyle/img/diy/ele_meter.png";
            }
          } elseif ('水能' == $value_org['et_name']) {
            if (null == $value_org['rgn_deviceid']) {
              $tdata['icon'] = "/" . C()['ATPSITELOCATION'] . "/Public/vendor/zTree_v3/css/zTreeStyle/img/diy/water_meter_red.png";
            } else {
              $tdata['icon'] = "/" . C()['ATPSITELOCATION'] . "/Public/vendor/zTree_v3/css/zTreeStyle/img/diy/water_meter.png";
            }
          } elseif ('冷能' == $value_org['et_name']) {
            if (null == $value_org['rgn_deviceid']) {
              $tdata['icon'] = "/" . C()['ATPSITELOCATION'] . "/Public/vendor/zTree_v3/css/zTreeStyle/img/diy/coldhotmeter_red.png";
            } else {
              $tdata['icon'] = "/" . C()['ATPSITELOCATION'] . "/Public/vendor/zTree_v3/css/zTreeStyle/img/diy/coldhotmeter.png";
            }
          } elseif ('暖能' == $value_org['et_name']) {
            if (null == $value_org['rgn_deviceid']) {
              $tdata['icon'] = "/" . C()['ATPSITELOCATION'] . "/Public/vendor/zTree_v3/css/zTreeStyle/img/diy/coldhotmeter_red.png";
            } else {
              $tdata['icon'] = "/" . C()['ATPSITELOCATION'] . "/Public/vendor/zTree_v3/css/zTreeStyle/img/diy/coldhotmeter.png";
            }
          } else {
            $tdata['icon'] = "/" . C()['ATPSITELOCATION'] . "/Public/vendor/zTree_v3/css/zTreeStyle/img/diy/energywater.png";
          }
        } elseif ('专项能源' == $value_org['rgn_category']) {
          $tdata['icon'] = "/" . C()['ATPSITELOCATION'] . "/Public/vendor/zTree_v3/css/zTreeStyle/img/diy/specialenergy.png";
        } elseif ('制冷机房' == $value_org['rgn_category']) {
          $tdata['icon'] = "/" . C()['ATPSITELOCATION'] . "/Public/vendor/zTree_v3/css/zTreeStyle/img/diy/Refrigerationroom.png";
        } elseif ('配电室' == $value_org['rgn_category']) {
          $tdata['icon'] = "/" . C()['ATPSITELOCATION'] . "/Public/vendor/zTree_v3/css/zTreeStyle/img/diy/Switchroom.png";
        } elseif ('充电桩' == $value_org['rgn_category']) {
          $tdata['icon'] = "/" . C()['ATPSITELOCATION'] . "/Public/vendor/zTree_v3/css/zTreeStyle/img/diy/Chargestation.png";
        } elseif ('锅炉房' == $value_org['rgn_category']) {
          $tdata['icon'] = "/" . C()['ATPSITELOCATION'] . "/Public/vendor/zTree_v3/css/zTreeStyle/img/diy/Boilerroom.png";
        } else {
          $tdata['icon'] = "/" . C()['ATPSITELOCATION'] . "/Public/vendor/zTree_v3/css/zTreeStyle/img/diy/unit.png";
        }
        if ('设备点' == $value_org['rgn_category']) {
          $tdata['type'] = '设备点';
        } elseif('园区' == $value_org['rgn_category']) {
          $tdata['type'] = '园区根';
        } else{
          $tdata['type'] = '园区';
        }
        array_push($treedatas, $tdata);
      }
    }
    if ("sn" == $regiontype) {
      {
        if ($snname == 'zljf') {
          $sql = "select * from szny_region where rgn_atpstatus is null and rgn_buildstatus = '制冷机房' order by rgn_name asc ";
        } elseif ($snname == 'pds') {
          $sql = "select * from szny_region where rgn_atpstatus is null and rgn_buildstatus = '配电室' order by rgn_name asc ";
        } elseif ($snname == 'cdz') {
          $sql = "select * from szny_region where rgn_atpstatus is null and rgn_buildstatus = '充电桩' order by rgn_name asc ";
        } elseif ($snname == 'glf') {
          $sql = "select * from szny_region where rgn_atpstatus is null and rgn_buildstatus = '锅炉房' order by rgn_name asc ";
        } elseif ($snname == 'tsg') {
          $sql = "select * from szny_region where rgn_atpstatus is null and rgn_buildstatus = '图书馆' order by rgn_name asc ";
        } elseif ($snname == 'yj') {
          $sql = "select * from szny_region where rgn_atpstatus is null and rgn_buildstatus = '邮局' order by rgn_name asc ";
        } elseif ($snname == 'whhdzj') {
          $sql = "select * from szny_region where rgn_atpstatus is null and rgn_buildstatus = '文化活动中心' order by rgn_name asc ";
        }
        $result = $Model->query($sql);
        foreach ($result as $key_org => $value_org) {
          $tdata = array();
          $tdata['id'] = $value_org['rgn_atpid'];
          $tdata['pid'] = $value_org['rgn_pregionid'];
          $tdata['name'] = $value_org['rgn_name'];
          $tdata['open'] = true;
          if ('园区' == $value_org['rgn_category']) {
            $tdata['icon'] = "/" . C()['ATPSITELOCATION'] . "/Public/vendor/zTree_v3/css/zTreeStyle/img/diy/park.png";
          } elseif ('楼宇' == $value_org['rgn_category']) {
            $tdata['icon'] = "/" . C()['ATPSITELOCATION'] . "/Public/vendor/zTree_v3/css/zTreeStyle/img/diy/build.png";
          } elseif ('座' == $value_org['rgn_category']) {
            $tdata['icon'] = "/" . C()['ATPSITELOCATION'] . "/Public/vendor/zTree_v3/css/zTreeStyle/img/diy/floor.png";
          } elseif ('单元' == $value_org['rgn_category']) {
            $tdata['icon'] = "/" . C()['ATPSITELOCATION'] . "/Public/vendor/zTree_v3/css/zTreeStyle/img/diy/unit.png";
          } elseif ('楼层' == $value_org['rgn_category']) {
            $tdata['icon'] = "/" . C()['ATPSITELOCATION'] . "/Public/vendor/zTree_v3/css/zTreeStyle/img/diy/storey.png";
          } elseif ('位置点' == $value_org['rgn_category']) {
            if ('电能' == $value_org['et_name']) {
              $tdata['icon'] = "/" . C()['ATPSITELOCATION'] . "/Public/vendor/zTree_v3/css/zTreeStyle/img/diy/ele_meter.png";
            } elseif ('水能' == $value_org['et_name']) {
              $tdata['icon'] = "/" . C()['ATPSITELOCATION'] . "/Public/vendor/zTree_v3/css/zTreeStyle/img/diy/water_meter.png";
            } elseif ('冷暖能' == $value_org['et_name']) {
              $tdata['icon'] = "/" . C()['ATPSITELOCATION'] . "/Public/vendor/zTree_v3/css/zTreeStyle/img/diy/cold_hot_meter.png";
            } else {
              $tdata['icon'] = "/" . C()['ATPSITELOCATION'] . "/Public/vendor/zTree_v3/css/zTreeStyle/img/diy/energywater.png";
            }
          } elseif ('制冷机房' == $value_org['rgn_buildstatus']) {
            $tdata['icon'] = "/" . C()['ATPSITELOCATION'] . "/Public/vendor/zTree_v3/css/zTreeStyle/img/diy/Refrigerationroom.png";
          } elseif ('配电室' == $value_org['rgn_buildstatus']) {
            $tdata['icon'] = "/" . C()['ATPSITELOCATION'] . "/Public/vendor/zTree_v3/css/zTreeStyle/img/diy/Switchroom.png";
          } elseif ('充电桩' == $value_org['rgn_buildstatus']) {
            $tdata['icon'] = "/" . C()['ATPSITELOCATION'] . "/Public/vendor/zTree_v3/css/zTreeStyle/img/diy/Chargestation.png";
          } elseif ('锅炉房' == $value_org['rgn_buildstatus']) {
            $tdata['icon'] = "/" . C()['ATPSITELOCATION'] . "/Public/vendor/zTree_v3/css/zTreeStyle/img/diy/Boilerroom.png";
          } else {
            $tdata['icon'] = "/" . C()['ATPSITELOCATION'] . "/Public/vendor/zTree_v3/css/zTreeStyle/img/diy/unit.png";
          }
          if ('设备点' == $value_org['rgn_category']) {
            $tdata['type'] = '设备点';
          } elseif('园区' == $value_org['rgn_category']) {
            $tdata['type'] = '园区根';
          } else{
            $tdata['type'] = '园区';
          }
          array_push($treedatas, $tdata);
        }
      }
    }
    return $treedatas;
  }
}