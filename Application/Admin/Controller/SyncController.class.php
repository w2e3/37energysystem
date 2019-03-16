<?php
namespace Admin\Controller;

use Think\Controller;

class SyncController extends BaseController
{
    public function updateregion()
    {
        set_time_limit(0);

        // Crontab配置
        // 一分钟触发一次
        // */60 * * * * root date >> /root/SznySyncUpdateRegion.txt ; curl -v "http://27.115.71.211:9000/szny2/index.php/Admin/Sync/updateregion" >> /root/SznySyncUpdateRegion.txt ; echo -e "\n" >> /root/SznySyncUpdateRegion.txt
        $Model = M('cacheregion');
        $sql_select_rgnlastdatetime = "SELECT MAX(t.rgn_atplastmodifydatetime) lastdatetime FROM szny_region t WHERE t.rgn_atpstatus is null";
        $result_rgnlastdatetime = $Model->query($sql_select_rgnlastdatetime);
        $sql_select_cfglastdatetime = "select * from szny_config where cfg_atpid = 'guidE6AAB665-0BF3-4266-B011-575FA9928888'";
        $result_cfglastdatetime = $Model->query($sql_select_cfglastdatetime);

        if ($result_rgnlastdatetime[0]['lastdatetime'] != $result_cfglastdatetime[0]['cfg_value']) {
            $lasttime = $result_rgnlastdatetime[0]['lastdatetime'];
            $Model->execute("update szny_config set cfg_value = '$lasttime' where cfg_atpid = 'guidE6AAB665-0BF3-4266-B011-575FA9928888'");
            $Model->execute("delete from szny_cacheregion");
            $sql_select_data = "select * from szny_region where rgn_atpstatus is null order by rgn_name asc";
            $result_data = $Model->query($sql_select_data);
            foreach ($result_data as $k => &$v) {
                $t_array = $this->regionrecursivesync($v['rgn_atpid']);
                $t_json = json_encode($t_array);
//            $t_array2 = json_decode($t_json);
                $dat['ccergn_atpid'] = $this->makeGuid();
                $dat['ccergn_atpcreatedatetime'] = date("Y-m-d H:i:s", time());
                $dat['ccergn_atplastmodifydatetime'] = date("Y-m-d H:i:s", time());
                $dat['ccergn_key'] = $v['rgn_atpid'];
                $dat['ccergn_value'] = $t_json;
                $Model->add($dat);
            }
            echo "OK update";
        } else {
            echo "OK no update";
        }
    }
}