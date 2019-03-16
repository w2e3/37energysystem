<?php
namespace Admin\Controller;
use Think\Controller;
class ExpController extends BaseController
{
    public function hnwe01()
    {
        $time = date("YmdHis", time());
        $year = date("Y", time());
        $day = date("Y-m-d", time());

        $Model = M();
        $sql_select_year = "
SELECT
sum(t.d2y_syslaccu) yearshui,
sum(t.d2y_ynlaccu)+sum(t.d2y_yllaccu) yearlengnuan,
sum(t.d2y_dglaccu) yeardian
FROM szny_data2year t
where t.d2y_atpstatus is null and t.d2y_dt = '$year';
";
        $Result_year = $Model->query($sql_select_year);

        $sql_select_day = "
SELECT
sum(t.d2d_syslaccu) dayshui,
sum(t.d2d_ynlaccu)+sum(t.d2d_yllaccu) daylengnuan,
sum(t.d2d_dglaccu) daydian
FROM szny_data2day t
where t.d2d_atpstatus is null and t.d2d_dt = '$day';";
        $Result_day = $Model->query($sql_select_day);

        $retarray = array();
        $retarray['time'] = $time;
        if (count($Result_year) == 1) {
            $retarray['yeardian'] = intval($Result_year[0]['yeardian']);
            $retarray['yearshui'] = intval($Result_year[0]['yearshui']);
            $retarray['yearlengnuan'] = intval($Result_year[0]['yearlengnuan']);
        } else {
            $retarray['yeardian'] = 0;
            $retarray['yearshui'] = 0;
            $retarray['yearlengnuan'] = 0;
        }
        if (count($Result_day) == 1) {
            $retarray['daydian'] = intval($Result_day[0]['daydian']);
            $retarray['dayshui'] = intval($Result_day[0]['dayshui']);
            $retarray['daylengnuan'] = intval($Result_day[0]['daylengnuan']);
        } else {
            $retarray['daydian'] = 0;
            $retarray['dayshui'] = 0;
            $retarray['daylengnuan'] = 0;
        }
        echo json_encode($retarray);
    }


}