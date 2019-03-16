<?php
namespace Admin\Controller;

use Think\Controller;

class BaseController extends Controller
{
    public $ATPLocationName="";

    function _initialize()
    {
        $this->makeATPLocationName();
//        $this->logSys(session('emp_atpid'),"访问日志","访问页面：".$this->getPathInfoQueryString());
    }

    public function makeATPLocationName()
    {
        $regiontype = $_GET['regiontype'];
        $snname = $_GET['snname'];
        if ("rg" == $regiontype) {
            $this->ATPLocationName = "【园区漫游】";
        }
        if ("sn" == $regiontype) {
            if ('zljf' == $snname) {
                $this->ATPLocationName = "【专项能源】 / 【制冷机房】";
            }
            if ('pds' == $snname) {
                $this->ATPLocationName = "【专项能源】 / 【配电室】";
            }
            if ('cdz' == $snname) {
                $this->ATPLocationName = "【专项能源】 / 【充电桩】";
            }
            if ('glf' == $snname) {
                $this->ATPLocationName = "【专项能源】 / 【锅炉房】";
            }
            if ('tsg' == $snname) {
                $this->ATPLocationName = "【专项能源】 / 【图书馆】";
            }
            if ('yj' == $snname) {
                $this->ATPLocationName = "【专项能源】 / 【邮局】";
            }
            if ('whhdzj' == $snname) {
                $this->ATPLocationName = "【专项能源】 / 【文化活动中心】";
            }
        }

        $this->assign('ATPLocationName',$this->ATPLocationName);
    }


    function makeGuid()
    {
        if (function_exists('com_create_guid') === true) {
            return 'guid' . trim(com_create_guid(), '{}');
        }
        return 'guid' . sprintf('%04X%04X-%04X-%04X-%04X-%04X%04X%04X', mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(16384, 20479), mt_rand(32768, 49151), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535));
    }

    public function makeDeviceNo()
    {
        $Model = M();
        $sql_select = "select CONCAT('SBK',date_format(NOW(),'%Y%m%d'),LPAD(szny_nextval('devicecode'),4,0)) code;";
        $Result = $Model->query($sql_select);
        return $Result[0]['code'];
    }

    public function makeRepairlogNo()
    {
        $Model = M();
        $sql_select = "select CONCAT('RPR',date_format(NOW(),'%Y%m%d'),LPAD(szny_nextval('repairlogcode'),4,0)) code;";
        $Result = $Model->query($sql_select);
        return $Result[0]['code'];
    }

    function logSys($adminid = "", $type = "", $content = "")
    {
        $Model = M('log');
        $data['l_atpid'] = $this->makeGuid();
        $data['l_atpstatus'] = null;
        $data['l_atpcreatedatetime'] = date('Y-m-d H:i:s', time());
        $data['l_atpcreateuser'] = session('emp_account');
        $data['l_atplastmodifydatetime'] = date('Y-m-d H:i:s', time());
        $data['l_atplastmodifyuser'] = session('emp_account');
        $data['l_atpremark'] = null;
        $data['l_ip'] = get_client_ip();
        $data['l_category'] = $type;
        $data['l_content'] = $content;
        $data['l_datetime'] = date('Y-m-d H:i:s', time());
//        $data['l_userid'] = $userid;
        $data['l_empid'] = $adminid;

        $Model->add($data);
    }

    function getPathInfoQueryString()
    {
        return $_SERVER['PATH_INFO'] . '?' . $_SERVER['QUERY_STRING'];
    }

    function buildSqlLikeContain($condition)
    {
        return "%" . $condition . "%";
    }

    function buildSql($sql, $condition)
    {
        if ($this->containString($sql, " where ")) {
            return $sql . " and " . $condition;
        } else {
            return $sql . " where " . $condition;
        }
    }

    function filterSqlOrderCondition($input)
    {
        $subject = strtolower($input);
        $pattern = '/^[qwertyuiopasdfghjklzxcvbnm_0123456789]*$/';
        preg_match($pattern, $subject, $matches);
        if (preg_match($pattern, $subject, $matches) == 0) {
            echo "''";
        } else {
            echo $input;
        }
    }

    function containString($input, $splite)
    {
        $tmparray = explode($splite, $input);
        if (count($tmparray) > 1) {
            return true;
        } else {
            return false;
        }
    }

    public function  input_csv($handle)
    {
        $out = array();
        $n = 0;
        while ($data = fgetcsv($handle, 10000)) {
            $num = count($data);
            for ($i = 0; $i < $num; $i++) {
                $out[$n][$i] = iconv('gb2312', 'utf-8', $data[$i]);
            }
            $n++;
        }
        return $out;
    }

    /**
     * 返回指定园区节点下的所有位置点数组
     * @param $id
     * @return mixed
     */
//    function regionrecursive($id)
//    {
//        $Model = M();
//        $sql_select = "
//            call regionrecursive('$id');";
//        $Result = $Model->query($sql_select);
//        return $Result;
//    }
    function regionrecursive($id)
    {
        $Model = M('cacheregion');
        $data = $Model->where("ccergn_key='%s'", array($id))->find();
        
        return json_decode($data['ccergn_value'],true);
    }

    /**
     * 返回指定【专项能源】【用户】园区节点下的所有位置点数组
     * @param $regionid
     * @param $usersideid
     * @return mixed
     */
    function regionrecursiveuserside($regionid,$usersideid)
    {
        $Model = M();
        $sql_select = "
            call regionrecursiveuserside('$regionid','$usersideid');";
        $Result = $Model->query($sql_select);
        return $Result;
    }

    /**
     * 返回指定园区节点下的所有位置点数组，按园区名称排序
     * @param $id
     * @return mixed
     */
    function regionrecursive_orderbyrgn_name($id)
    {
        return regionrecursive($id);
//        $Model = M();
//        $sql_select = "
//            call regionrecursive_orderbyrgn_name('$id');
//            select * from regionrecursivetmptable order by rgn_name asc;";
//        $Result = $Model->query($sql_select);
//        return $Result;
    }

    function regionrecursivesync($id)
    {
        $Model = M();
        $sql_select_data = "select * from szny_region where rgn_atpstatus is null order by rgn_name asc";
        $result = $Model->query($sql_select_data);
        $result_return = array();
        $current_depth=0;
        foreach ($result as $k => &$v) {
            if ($id == $v['rgn_atpid']) {
                $v['id'] = $v['rgn_atpid'];
                $v['depth'] = $current_depth;
                array_push($result_return,$v);
                $this->regionrecursivecore($result,$result_return,$v['rgn_atpid'],$current_depth);
            }
        }
//        dump($result_return);
        return $result_return;
    }

    function regionrecursivecore($result,&$result_return,$id,$current_depth)
    {
//        echo $current_depth;
        $current_depth++;
        foreach ($result as $k => &$v) {
            if ($id == $v['rgn_pregionid']) {
                $v['id'] = $v['rgn_atpid'];
                $v['depth'] = $current_depth;
                array_push($result_return,$v);
                $this->regionrecursivecore($result,$result_return,$v['rgn_atpid'],$current_depth);
            }
        }
    }

    function get_session_all_region()
    {
        $Model = M();
        $sql_select_lastdatetime = "SELECT MAX(t.rgn_atplastmodifydatetime) lastdatetime FROM szny_region t WHERE t.rgn_atpstatus is null";
        $result_lastdatetime = $Model->query($sql_select_lastdatetime);
        if ($result_lastdatetime[0]['lastdatetime'] == $_SESSION['atp_session_all_region_lastdatetime']) {
            return $_SESSION['atp_session_all_region_data'];
        } else {
            $_SESSION['atp_session_all_region_lastdatetime'] = $result_lastdatetime[0]['lastdatetime'];
            $sql_select_data = "select * from szny_region where rgn_atpstatus is null order by rgn_name asc";
            $result_data = $Model->query($sql_select_data);
            $_SESSION['atp_session_all_region_data'] = $result_data;
            return $result_data;
        }
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
                $sql = "select * from szny_region t where t.rgn_atpstatus is null and t.rgn_atpid = '$rgn_atpid'";
                $list = M()->query($sql);
                if ($list[0]['rgn_category'] == '设备点') {
                    $res = $this->regionrecursive($rgn_atpid);
                } else {
                    if ($snname == 'zljf') {
                        $sql = "select rgn_atpid , rgn_deviceid from szny_region where rgn_atpstatus is null and rgn_buildstatus = '制冷机房' and  rgn_category = '设备点' and rgn_pregionid='$rgn_atpid'";
                    } elseif ($snname == 'pds') {
                        $sql = "select rgn_atpid , rgn_deviceid from szny_region where rgn_atpstatus is null and rgn_buildstatus = '配电室' and  rgn_category = '设备点' and rgn_pregionid='$rgn_atpid'";
                    } elseif ($snname == 'cdz') {
                        $sql = "select rgn_atpid, rgn_deviceid  from szny_region where rgn_atpstatus is null and rgn_buildstatus = '充电桩' and  rgn_category = '设备点' and rgn_pregionid='$rgn_atpid'";
                    } elseif ($snname == 'glf') {
                        $sql = "select rgn_atpid , rgn_deviceid from szny_region where rgn_atpstatus is null and rgn_buildstatus = '锅炉房' and  rgn_category = '设备点' and rgn_pregionid='$rgn_atpid'";
                    } elseif ($snname == 'tsg') {
                        $sql = "select rgn_atpid , rgn_deviceid from szny_region where rgn_atpstatus is null and rgn_buildstatus = '图书馆' and  rgn_category = '设备点' and rgn_pregionid='$rgn_atpid'";
                    } elseif ($snname == 'yj') {
                        $sql = "select rgn_atpid , rgn_deviceid from szny_region where rgn_atpstatus is null and rgn_buildstatus = '邮局' and  rgn_category = '设备点' and rgn_pregionid='$rgn_atpid'";
                    } elseif ($snname == 'whhdzj') {
                        $sql = "select rgn_atpid , rgn_deviceid from szny_region where rgn_atpstatus is null and rgn_buildstatus = '文化活动中心' and  rgn_category = '设备点' and rgn_pregionid='$rgn_atpid'";
                    }
                    $res = $Model->query($sql);
                }
            } else {
                if ($snname == 'zljf') {
                    $sql = "select rgn_atpid , rgn_deviceid from szny_region where rgn_atpstatus is null and rgn_buildstatus = '制冷机房' and  rgn_category = '设备点'";
                } elseif ($snname == 'pds') {
                    $sql = "select rgn_atpid , rgn_deviceid from szny_region where rgn_atpstatus is null and rgn_buildstatus = '配电室' and  rgn_category = '设备点'";
                } elseif ($snname == 'cdz') {
                    $sql = "select rgn_atpid , rgn_deviceid  from szny_region where rgn_atpstatus is null and rgn_buildstatus = '充电桩' and  rgn_category = '设备点'";
                } elseif ($snname == 'glf') {
                    $sql = "select rgn_atpid , rgn_deviceid from szny_region where rgn_atpstatus is null and rgn_buildstatus = '锅炉房' and  rgn_category = '设备点'";
                } elseif ($snname == 'tsg') {
                    $sql = "select rgn_atpid , rgn_deviceid from szny_region where rgn_atpstatus is null and rgn_buildstatus = '图书馆' and  rgn_category = '设备点'";
                } elseif ($snname == 'yj') {
                    $sql = "select rgn_atpid , rgn_deviceid from szny_region where rgn_atpstatus is null and rgn_buildstatus = '邮局' and  rgn_category = '设备点'";
                } elseif ($snname == 'whhdzj') {
                    $sql = "select rgn_atpid , rgn_deviceid from szny_region where rgn_atpstatus is null and rgn_buildstatus = '文化活动中心' and  rgn_category = '设备点'";
                }
                $res = $Model->query($sql);
            }
        }
        return $res;
    }

    /**
     * 获得园区树根节
     * @return mixed
     */
    public function  getRegionRoot($regiontype, $snname)
    {
        if ("rg" == $regiontype) {
            $Model = M();
            $sql_select_region = "select t.rgn_atpid from szny_region t where t.rgn_atpstatus is null and t.rgn_category = '园区'";
            $result_select_region = $Model->query($sql_select_region);
            return $result_select_region[0];
        }
        if ("sn" == $regiontype) {
            $Model = M('region');
            if ($snname == 'zljf') {
                return $Model->where("rgn_atpid='%s'", array("guid6B6AB76A-1D0B-481C-AF83-AB3BBE05515F"))->find();
            } elseif ($snname == 'pds') {
                return $Model->where("rgn_atpid='%s'", array("guidCA335990-3FA2-47DF-85A4-9197C8EFB812"))->find();
            } elseif ($snname == 'cdz') {
                return $Model->where("rgn_atpid='%s'", array("guid531F4788-C524-445B-BE27-CCCBBDCA26A1"))->find();
            } elseif ($snname == 'glf') {
                return $Model->where("rgn_atpid='%s'", array("guid1B32522F-C397-4F8D-8A75-67D045CFEECF"))->find();
            } elseif ($snname == 'tsg') {
                return $Model->where("rgn_atpid='%s'", array("guid26BF1DE6-9EE8-4363-9937-9B200329FBD9"))->find();
            } elseif ($snname == 'yj') {
                return $Model->where("rgn_atpid='%s'", array("guid272F003A-1EA6-4471-953A-CE0C29EAD6D5"))->find();
            } elseif ($snname == 'whhdzj') {
                return $Model->where("rgn_atpid='%s'", array("guid4EB4F8C7-AEC3-4DEB-88C9-C4BEDF18ABC1"))->find();
            }
        }
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
                    $tdata['icon'] = $this->makeICONPath()."/Public/vendor/zTree_v3/css/zTreeStyle/img/diy/park.png";
                    $tdata['open'] = true;
                } elseif ('楼' == $value_org['rgn_category']) {
                    $tdata['icon'] = $this->makeICONPath()."/Public/vendor/zTree_v3/css/zTreeStyle/img/diy/build.png";
                    if ('2#' == $value_org['rgn_codename']) {
                        $tdata['open'] = true;
                    }
                } elseif ('座' == $value_org['rgn_category']) {
                    $tdata['icon'] = $this->makeICONPath()."/Public/vendor/zTree_v3/css/zTreeStyle/img/diy/floor.png";
                } elseif ('单元' == $value_org['rgn_category']) {
                    $tdata['icon'] = $this->makeICONPath()."/Public/vendor/zTree_v3/css/zTreeStyle/img/diy/unit.png";
                } elseif ('层' == $value_org['rgn_category']) {
                    $tdata['icon'] = $this->makeICONPath()."/Public/vendor/zTree_v3/css/zTreeStyle/img/diy/storey.png";
                    $tdata['open'] = false;
                } elseif ('设备点' == $value_org['rgn_category']) {
                    if ('电能' == $value_org['et_name']) {
                        if (null == $value_org['rgn_deviceid']) {
                            $tdata['icon'] = $this->makeICONPath()."/Public/vendor/zTree_v3/css/zTreeStyle/img/diy/ele_meter_red.png";
                        } else {
                            $tdata['icon'] = $this->makeICONPath()."/Public/vendor/zTree_v3/css/zTreeStyle/img/diy/ele_meter.png";
                        }
                    } elseif ('水能' == $value_org['et_name']) {
                        if (null == $value_org['rgn_deviceid']) {
                            $tdata['icon'] = $this->makeICONPath()."/Public/vendor/zTree_v3/css/zTreeStyle/img/diy/water_meter_red.png";
                        } else {
                            $tdata['icon'] = $this->makeICONPath()."/Public/vendor/zTree_v3/css/zTreeStyle/img/diy/water_meter.png";
                        }
                    } elseif ('冷能' == $value_org['et_name']) {
                        if (null == $value_org['rgn_deviceid']) {
                            $tdata['icon'] = $this->makeICONPath()."/Public/vendor/zTree_v3/css/zTreeStyle/img/diy/coldhotmeter_red.png";
                        } else {
                            $tdata['icon'] = $this->makeICONPath()."/Public/vendor/zTree_v3/css/zTreeStyle/img/diy/coldhotmeter.png";
                        }
                    } elseif ('暖能' == $value_org['et_name']) {
                        if (null == $value_org['rgn_deviceid']) {
                            $tdata['icon'] = $this->makeICONPath()."/Public/vendor/zTree_v3/css/zTreeStyle/img/diy/coldhotmeter_red.png";
                        } else {
                            $tdata['icon'] = $this->makeICONPath()."/Public/vendor/zTree_v3/css/zTreeStyle/img/diy/coldhotmeter.png";
                        }
                    } else {
                        $tdata['icon'] = $this->makeICONPath()."/Public/vendor/zTree_v3/css/zTreeStyle/img/diy/energywater.png";
                    }
                } elseif ('专项能源' == $value_org['rgn_category']) {
                    $tdata['icon'] = $this->makeICONPath()."/Public/vendor/zTree_v3/css/zTreeStyle/img/diy/specialenergy.png";
                } elseif ('制冷机房' == $value_org['rgn_category']) {
                    $tdata['icon'] = $this->makeICONPath()."/Public/vendor/zTree_v3/css/zTreeStyle/img/diy/Refrigerationroom.png";
                } elseif ('配电室' == $value_org['rgn_category']) {
                    $tdata['icon'] = $this->makeICONPath()."/Public/vendor/zTree_v3/css/zTreeStyle/img/diy/Switchroom.png";
                } elseif ('充电桩' == $value_org['rgn_category']) {
                    $tdata['icon'] = $this->makeICONPath()."/Public/vendor/zTree_v3/css/zTreeStyle/img/diy/Chargestation.png";
                } elseif ('锅炉房' == $value_org['rgn_category']) {
                    $tdata['icon'] = $this->makeICONPath()."/Public/vendor/zTree_v3/css/zTreeStyle/img/diy/Boilerroom.png";
                } else {
                    $tdata['icon'] = $this->makeICONPath()."/Public/vendor/zTree_v3/css/zTreeStyle/img/diy/unit.png";
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
                        $tdata['icon'] = $this->makeICONPath()."/Public/vendor/zTree_v3/css/zTreeStyle/img/diy/park.png";
                    } elseif ('楼宇' == $value_org['rgn_category']) {
                        $tdata['icon'] = $this->makeICONPath()."/Public/vendor/zTree_v3/css/zTreeStyle/img/diy/build.png";
                    } elseif ('座' == $value_org['rgn_category']) {
                        $tdata['icon'] = $this->makeICONPath()."/Public/vendor/zTree_v3/css/zTreeStyle/img/diy/floor.png";
                    } elseif ('单元' == $value_org['rgn_category']) {
                        $tdata['icon'] = $this->makeICONPath()."/Public/vendor/zTree_v3/css/zTreeStyle/img/diy/unit.png";
                    } elseif ('楼层' == $value_org['rgn_category']) {
                        $tdata['icon'] = $this->makeICONPath()."/Public/vendor/zTree_v3/css/zTreeStyle/img/diy/storey.png";
                    } elseif ('位置点' == $value_org['rgn_category']) {
                        if ('电能' == $value_org['et_name']) {
                            $tdata['icon'] = $this->makeICONPath()."/Public/vendor/zTree_v3/css/zTreeStyle/img/diy/ele_meter.png";
                        } elseif ('水能' == $value_org['et_name']) {
                            $tdata['icon'] = $this->makeICONPath()."/Public/vendor/zTree_v3/css/zTreeStyle/img/diy/water_meter.png";
                        } elseif ('冷暖能' == $value_org['et_name']) {
                            $tdata['icon'] = $this->makeICONPath()."/Public/vendor/zTree_v3/css/zTreeStyle/img/diy/cold_hot_meter.png";
                        } else {
                            $tdata['icon'] = $this->makeICONPath()."/Public/vendor/zTree_v3/css/zTreeStyle/img/diy/energywater.png";
                        }
                    } elseif ('制冷机房' == $value_org['rgn_buildstatus']) {
                        $tdata['icon'] = $this->makeICONPath()."/Public/vendor/zTree_v3/css/zTreeStyle/img/diy/Refrigerationroom.png";
                    } elseif ('配电室' == $value_org['rgn_buildstatus']) {
                        $tdata['icon'] = $this->makeICONPath()."/Public/vendor/zTree_v3/css/zTreeStyle/img/diy/Switchroom.png";
                    } elseif ('充电桩' == $value_org['rgn_buildstatus']) {
                        $tdata['icon'] = $this->makeICONPath()."/Public/vendor/zTree_v3/css/zTreeStyle/img/diy/Chargestation.png";
                    } elseif ('锅炉房' == $value_org['rgn_buildstatus']) {
                        $tdata['icon'] = $this->makeICONPath()."/Public/vendor/zTree_v3/css/zTreeStyle/img/diy/Boilerroom.png";
                    } else {
                        $tdata['icon'] = $this->makeICONPath()."/Public/vendor/zTree_v3/css/zTreeStyle/img/diy/unit.png";
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


    public function makeICONPath()
    {
        $v = C()['ATPDEPLOYROOT'];
        if ($v == true) {
            return "";
        } else {
            return "/" . C()['ATPSITELOCATION'];
        }
    }



}