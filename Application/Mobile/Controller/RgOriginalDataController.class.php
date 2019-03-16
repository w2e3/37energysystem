<?php
namespace Mobile\Controller;
use Think\Controller;
class RgOriginalDataController extends BaseAuthController
{
  public function index()
  {

  }
    public function get_Twicedatay_data($regiontype,$rgn_atpid,$snname,$starttime,$endtime)
    {

        $Model = M();
        $res=$this->getRegionDevicePoint($regiontype,$rgn_atpid,$snname);
        $data=array();
        $sql_select="";
        foreach ($res as $key => $value) {
            $date[] = "'" . $value['rgn_atpid'] . "'";
        }
        $endrgn_atpidsstrings = implode(',', $date);
        if ($rgn_atpid) {
            $sql_select = $this->buildSql($sql_select, "t.d2y_regionid in (" . $endrgn_atpidsstrings . ")");
            $colwhere = "and t3.etr_regionid in (" . $endrgn_atpidsstrings . ")";
        }
        $equipmentparameter = $Model->query("
                                select distinct t.p_name,t.p_shortname,t.p_unit from szny_param t
                                left join szny_energytyperegion t3 on t.p_energytypeid = t3.etr_energytypeid
                                where p_atpstatus is null $colwhere
                                order by t.p_name desc");
        $arr = array();
        foreach ($equipmentparameter as $parkey => $parval) {
            $dataarr = array();
            $dataarr['name'] = $parval['p_name'] . "-" . $parval['p_unit'];
            $dataarr['value'] = "value_" . $parval['p_shortname'];
            array_push($arr, $dataarr);
        }
        $this->assign('endtime', $endtime);
        $this->assign('starttime', $starttime);
        $this->assign('arr', $arr);
        $this->assign('rgn_atpid', $rgn_atpid);
        $this->display();
    }


}