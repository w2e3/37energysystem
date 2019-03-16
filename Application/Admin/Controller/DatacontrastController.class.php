<?php
namespace Admin\Controller;
use Think\Controller;
use Admin\BaseController;
class DatacontrastController extends BaseAuthController
{
    public function index()
    {
        $Model = M();
        $sql_select ="
        select 
        * 
        from szny_region t
        left join szny_energytyperegion t1 on t.rgn_atpid = t1.etr_regionid
        left join szny_energytype t2 on t2.et_atpid = t1.etr_energytypeid
        where t.rgn_atpstatus is null and t1.etr_atpstatus is null and t2.et_atpstatus is null
        group by t.rgn_atpid
         order by t.rgn_name asc
        ";
        $data_org = $Model->query($sql_select);
        $treedatas = array();
        foreach ($data_org as $key_org => $value_org) {
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
                $tdata['open'] = false;
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
            $tdata['type'] = $value_org['rgn_category'];
            array_push($treedatas, $tdata);
        }
        $this->assign('treedatas',json_encode($treedatas));
        $this->display();
        $this->logSys(session('emp_atpid'),"访问日志","访问页面->[数据对比】");
    }

    public function getIds(){
        $ids = I('post.ids','');
        $this->assign('ids',$ids);
//        $array = explode(',', $ids);
//        if ($array && count($array) > 0) {
//            $Model = M("region");
//            foreach ($array as $id) {
//                $data = $Model->where("rgn_atpid='%s'", array($id))->find();
//            }
//        }
    }


}