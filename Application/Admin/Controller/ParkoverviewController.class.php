<?php
namespace Admin\Controller;

use Think\Controller;

class ParkoverviewController extends BaseController
{
    public function index()
    {
        $this->makeRegionCompareChart();
        $this->makeEnergyAndAlarm("list1", "bj1", 'guidBFE08660-A606-4CD1-BDE0-3720CD50CED4');
        $this->makeEnergyAndAlarm("list2a", "bj2a", 'guid077698E9-2942-430A-81E1-E54A98A3383C');
        $this->makeEnergyAndAlarm("list2b", "bj2b", 'guid5BAF01C0-E54E-4F2D-8419-09EA0507F4F2');
        $this->makeEnergyAndAlarm("list2c", "bj2c", 'guid3BD09081-28C0-4ECD-BC25-0EB0DDF949B2');
        $this->makeEnergyAndAlarm("list2d", "bj2d", 'guidF7E28F9A-E04C-4030-86E5-73A84A0B6CAD');
        $this->makeEnergyAndAlarm("list2e", "bj2e", 'guid39E40DE8-E7B3-40D8-B8A8-E5C69AF1EBF5');
        $this->makeEnergyAndAlarm("list2f", "bj2f", 'guid75D5A56E-A723-4E16-AAF9-97E86195E0AF');
        $this->makeEnergyAndAlarm("list3", "bj3", 'guidF5B91891-FC25-4448-84B9-0D7A544EFE6C');
        $this->makeEnergyAndAlarm("list4", "bj4", 'guid8E6723F6-09D3-4CFF-B3AD-812A7F784201');
        $this->makeEnergyAndAlarm("list5", "bj5", 'guidDDE6FF51-B4DD-42C1-962A-ED42D5120E88');
        $this->makeEnergyAndAlarm("list6", "bj6", 'guidFEAFFDFB-4628-46D2-B39B-46F1EC76EF07');
        $this->makeEnergyAndAlarm("list7", "bj7", 'guidC65AC6F2-6962-470C-9367-FF87BA1CD5CC');
        $this->makeEnergyAndAlarm("list8", "bj8", 'guidB44A77BC-907D-42AC-812D-3E401E40B6CA');
        $this->makeEnergyAndAlarm("list9", "bj9", 'guid0CCA3B48-E22B-4636-A0EC-1F0E81AE0F08');
        $this->makeEnergyAndAlarm("list10", "bj10", 'guid3696CE0E-0616-4B32-8AB2-40AA8DB2E1D6');
        $this->makeEnergyAndAlarm("list11", "bj11", 'guid1F1285F0-C495-46D7-969A-D3711B12EA28');
        //获得报警信息
        $this->makeRegionCompareChartF2('guidBFE08660-A606-4CD1-BDE0-3720CD50CED4', "alarm_bj1");
        $this->makeRegionCompareChartF2('guid077698E9-2942-430A-81E1-E54A98A3383C', "alarm_bj2a");
       $this->makeRegionCompareChartF2('guid5BAF01C0-E54E-4F2D-8419-09EA0507F4F2', "alarm_bj2b");
        $this->makeRegionCompareChartF2('guid3BD09081-28C0-4ECD-BC25-0EB0DDF949B2', "alarm_bj2c");
        $this->makeRegionCompareChartF2('guidF7E28F9A-E04C-4030-86E5-73A84A0B6CAD', "alarm_bj2d");
        $this->makeRegionCompareChartF2('guid39E40DE8-E7B3-40D8-B8A8-E5C69AF1EBF5', "alarm_bj2e");
        $this->makeRegionCompareChartF2('guid75D5A56E-A723-4E16-AAF9-97E86195E0AF', "alarm_bj2f");
        $this->makeRegionCompareChartF2('guidF5B91891-FC25-4448-84B9-0D7A544EFE6C', "alarm_bj3");
        $this->makeRegionCompareChartF2('guid8E6723F6-09D3-4CFF-B3AD-812A7F784201', "alarm_bj4");
        $this->makeRegionCompareChartF2('guidDDE6FF51-B4DD-42C1-962A-ED42D5120E88', "alarm_bj5");
        $this->makeRegionCompareChartF2('guidFEAFFDFB-4628-46D2-B39B-46F1EC76EF07', "alarm_bj6");
        $this->makeRegionCompareChartF2('guidC65AC6F2-6962-470C-9367-FF87BA1CD5CC', "alarm_bj7");
       $this->makeRegionCompareChartF2('guidB44A77BC-907D-42AC-812D-3E401E40B6CA', "alarm_bj8");
        $this->makeRegionCompareChartF2('guid0CCA3B48-E22B-4636-A0EC-1F0E81AE0F08', "alarm_bj9");
        $this->makeRegionCompareChartF2('guid3696CE0E-0616-4B32-8AB2-40AA8DB2E1D6', "alarm_bj10");
        $this->makeRegionCompareChartF2('guid1F1285F0-C495-46D7-969A-D3711B12EA28', "alarm_bj11");
        $this->display();
        $this->logSys(session('emp_atpid'), "访问日志", "访问页面：【园区概览】");
    }

    public function F1_ceng1F()
    {
        //获取一层的所有采集点信息和是否报警  本层的所有报警数据  本日本月用量 全年用量还有跟上月的数据对比
        $this->makeRegionCompareChartF('guid3FF2D862-1E6E-400A-A9BB-278A072F1793');
//        $this->makeRegionCompareChartF('guid7007AC27-6A45-4C1A-894D-0F41EAC2DF49');
        //获取1#每一层的报警数量
        $this->makeRegionCompareChartF2('guid3FF2D862-1E6E-400A-A9BB-278A072F1793', 'b1_flr_1');
        $this->makeRegionCompareChartF2('guid7007AC27-6A45-4C1A-894D-0F41EAC2DF49', 'b1_flr_2');
        $this->makeRegionCompareChartF2('guid7E36DAD8-2A4C-423F-A80C-5FB3D2630DED', 'b1_flr_3');
        $this->makeRegionCompareChartF2('guid99BB14E0-C216-4780-830B-CF896EBFFE7E', 'b1_flr_4');
        $this->makeRegionCompareChartF2('guid8DEB922A-DA0C-443E-A36E-7494A19D28E7', 'b1_flr_5');
        $this->makeRegionCompareChartF2('guidBD82C01A-DB01-4918-BDCF-8BE8BB6A9837', 'b1_flr_6');
        $this->makeRegionCompareChartF2('guid5F12DA1F-B476-476E-804D-78956D6EC1D5', 'b1_flr_7');
        $this->makeRegionCompareChartF2('guid481CB98D-885E-4316-AB13-0D4394AA3A95', 'b1_flr_8');
        $currentid= $_GET['rgn_atpidcurrent']?$_GET['rgn_atpidcurrent']:false;
        $this->assign('currentid',$currentid);
        $this->display();
    }

    public function F1_ceng2F()
    {
        $this->makeRegionCompareChartF('guid7007AC27-6A45-4C1A-894D-0F41EAC2DF49');
//        $this->makeRegionCompareChartF('guid7007AC27-6A45-4C1A-894D-0F41EAC2DF49');

        $this->makeRegionCompareChartF2('guid3FF2D862-1E6E-400A-A9BB-278A072F1793', 'b1_flr_1');
        $this->makeRegionCompareChartF2('guid7007AC27-6A45-4C1A-894D-0F41EAC2DF49', 'b1_flr_2');
        $this->makeRegionCompareChartF2('guid7E36DAD8-2A4C-423F-A80C-5FB3D2630DED', 'b1_flr_3');
        $this->makeRegionCompareChartF2('guid99BB14E0-C216-4780-830B-CF896EBFFE7E', 'b1_flr_4');
        $this->makeRegionCompareChartF2('guid8DEB922A-DA0C-443E-A36E-7494A19D28E7', 'b1_flr_5');
        $this->makeRegionCompareChartF2('guidBD82C01A-DB01-4918-BDCF-8BE8BB6A9837', 'b1_flr_6');
        $this->makeRegionCompareChartF2('guid5F12DA1F-B476-476E-804D-78956D6EC1D5', 'b1_flr_7');
        $this->makeRegionCompareChartF2('guid481CB98D-885E-4316-AB13-0D4394AA3A95', 'b1_flr_8');
        $currentid= $_GET['rgn_atpidcurrent']?$_GET['rgn_atpidcurrent']:false;
        $this->assign('currentid',$currentid);
        $this->display();
    }

    public function F1_ceng3F()
    {
        $this->makeRegionCompareChartF('guid7E36DAD8-2A4C-423F-A80C-5FB3D2630DED');
//        $this->makeRegionCompareChartF('guid7007AC27-6A45-4C1A-894D-0F41EAC2DF49');
        $this->makeRegionCompareChartF2('guid3FF2D862-1E6E-400A-A9BB-278A072F1793', 'b1_flr_1');
        $this->makeRegionCompareChartF2('guid7007AC27-6A45-4C1A-894D-0F41EAC2DF49', 'b1_flr_2');
        $this->makeRegionCompareChartF2('guid7E36DAD8-2A4C-423F-A80C-5FB3D2630DED', 'b1_flr_3');
        $this->makeRegionCompareChartF2('guid99BB14E0-C216-4780-830B-CF896EBFFE7E', 'b1_flr_4');
        $this->makeRegionCompareChartF2('guid8DEB922A-DA0C-443E-A36E-7494A19D28E7', 'b1_flr_5');
        $this->makeRegionCompareChartF2('guidBD82C01A-DB01-4918-BDCF-8BE8BB6A9837', 'b1_flr_6');
        $this->makeRegionCompareChartF2('guid5F12DA1F-B476-476E-804D-78956D6EC1D5', 'b1_flr_7');
        $this->makeRegionCompareChartF2('guid481CB98D-885E-4316-AB13-0D4394AA3A95', 'b1_flr_8');
        $currentid= $_GET['rgn_atpidcurrent']?$_GET['rgn_atpidcurrent']:false;
        $this->assign('currentid',$currentid);
        $this->display();
    }

    public function F1_ceng4F()
    {
        $this->makeRegionCompareChartF('guid99BB14E0-C216-4780-830B-CF896EBFFE7E');
//        $this->makeRegionCompareChartF('guid7007AC27-6A45-4C1A-894D-0F41EAC2DF49');
        $this->makeRegionCompareChartF2('guid3FF2D862-1E6E-400A-A9BB-278A072F1793', 'b1_flr_1');
        $this->makeRegionCompareChartF2('guid7007AC27-6A45-4C1A-894D-0F41EAC2DF49', 'b1_flr_2');
        $this->makeRegionCompareChartF2('guid7E36DAD8-2A4C-423F-A80C-5FB3D2630DED', 'b1_flr_3');
        $this->makeRegionCompareChartF2('guid99BB14E0-C216-4780-830B-CF896EBFFE7E', 'b1_flr_4');
        $this->makeRegionCompareChartF2('guid8DEB922A-DA0C-443E-A36E-7494A19D28E7', 'b1_flr_5');
        $this->makeRegionCompareChartF2('guidBD82C01A-DB01-4918-BDCF-8BE8BB6A9837', 'b1_flr_6');
        $this->makeRegionCompareChartF2('guid5F12DA1F-B476-476E-804D-78956D6EC1D5', 'b1_flr_7');
        $this->makeRegionCompareChartF2('guid481CB98D-885E-4316-AB13-0D4394AA3A95', 'b1_flr_8');
        $currentid= $_GET['rgn_atpidcurrent']?$_GET['rgn_atpidcurrent']:false;
        $this->assign('currentid',$currentid);
        $this->display();
    }

    public function F1_ceng5F()
    {
        $this->makeRegionCompareChartF('guid8DEB922A-DA0C-443E-A36E-7494A19D28E7');
//        $this->makeRegionCompareChartF('guid7007AC27-6A45-4C1A-894D-0F41EAC2DF49');
        $this->makeRegionCompareChartF2('guid3FF2D862-1E6E-400A-A9BB-278A072F1793', 'b1_flr_1');
        $this->makeRegionCompareChartF2('guid7007AC27-6A45-4C1A-894D-0F41EAC2DF49', 'b1_flr_2');
        $this->makeRegionCompareChartF2('guid7E36DAD8-2A4C-423F-A80C-5FB3D2630DED', 'b1_flr_3');
        $this->makeRegionCompareChartF2('guid99BB14E0-C216-4780-830B-CF896EBFFE7E', 'b1_flr_4');
        $this->makeRegionCompareChartF2('guid8DEB922A-DA0C-443E-A36E-7494A19D28E7', 'b1_flr_5');
        $this->makeRegionCompareChartF2('guidBD82C01A-DB01-4918-BDCF-8BE8BB6A9837', 'b1_flr_6');
        $this->makeRegionCompareChartF2('guid5F12DA1F-B476-476E-804D-78956D6EC1D5', 'b1_flr_7');
        $this->makeRegionCompareChartF2('guid481CB98D-885E-4316-AB13-0D4394AA3A95', 'b1_flr_8');
        $currentid= $_GET['rgn_atpidcurrent']?$_GET['rgn_atpidcurrent']:false;
        $this->assign('currentid',$currentid);
        $this->display();
    }

    public function F1_ceng6F()
    {
        $this->makeRegionCompareChartF('guidBD82C01A-DB01-4918-BDCF-8BE8BB6A9837');
//        $this->makeRegionCompareChartF('guid7007AC27-6A45-4C1A-894D-0F41EAC2DF49');
        $this->makeRegionCompareChartF2('guid3FF2D862-1E6E-400A-A9BB-278A072F1793', 'b1_flr_1');
        $this->makeRegionCompareChartF2('guid7007AC27-6A45-4C1A-894D-0F41EAC2DF49', 'b1_flr_2');
        $this->makeRegionCompareChartF2('guid7E36DAD8-2A4C-423F-A80C-5FB3D2630DED', 'b1_flr_3');
        $this->makeRegionCompareChartF2('guid99BB14E0-C216-4780-830B-CF896EBFFE7E', 'b1_flr_4');
        $this->makeRegionCompareChartF2('guid8DEB922A-DA0C-443E-A36E-7494A19D28E7', 'b1_flr_5');
        $this->makeRegionCompareChartF2('guidBD82C01A-DB01-4918-BDCF-8BE8BB6A9837', 'b1_flr_6');
        $this->makeRegionCompareChartF2('guid5F12DA1F-B476-476E-804D-78956D6EC1D5', 'b1_flr_7');
        $this->makeRegionCompareChartF2('guid481CB98D-885E-4316-AB13-0D4394AA3A95', 'b1_flr_8');
        $currentid= $_GET['rgn_atpidcurrent']?$_GET['rgn_atpidcurrent']:false;
        $this->assign('currentid',$currentid);
        $this->display();
    }

    public function F1_ceng7F()
    {
        $this->makeRegionCompareChartF('guid5F12DA1F-B476-476E-804D-78956D6EC1D5');
//        $this->makeRegionCompareChartF('guid7007AC27-6A45-4C1A-894D-0F41EAC2DF49');
        $this->makeRegionCompareChartF2('guid3FF2D862-1E6E-400A-A9BB-278A072F1793', 'b1_flr_1');
        $this->makeRegionCompareChartF2('guid7007AC27-6A45-4C1A-894D-0F41EAC2DF49', 'b1_flr_2');
        $this->makeRegionCompareChartF2('guid7E36DAD8-2A4C-423F-A80C-5FB3D2630DED', 'b1_flr_3');
        $this->makeRegionCompareChartF2('guid99BB14E0-C216-4780-830B-CF896EBFFE7E', 'b1_flr_4');
        $this->makeRegionCompareChartF2('guid8DEB922A-DA0C-443E-A36E-7494A19D28E7', 'b1_flr_5');
        $this->makeRegionCompareChartF2('guidBD82C01A-DB01-4918-BDCF-8BE8BB6A9837', 'b1_flr_6');
        $this->makeRegionCompareChartF2('guid5F12DA1F-B476-476E-804D-78956D6EC1D5', 'b1_flr_7');
        $this->makeRegionCompareChartF2('guid481CB98D-885E-4316-AB13-0D4394AA3A95', 'b1_flr_8');
        $currentid= $_GET['rgn_atpidcurrent']?$_GET['rgn_atpidcurrent']:false;
        $this->assign('currentid',$currentid);
        $this->display();
    }

    public function F1_ceng8F()
    {
        $this->makeRegionCompareChartF('guid481CB98D-885E-4316-AB13-0D4394AA3A95');
//        $this->makeRegionCompareChartF('guid7007AC27-6A45-4C1A-894D-0F41EAC2DF49');
        $this->makeRegionCompareChartF2('guid3FF2D862-1E6E-400A-A9BB-278A072F1793', 'b1_flr_1');
        $this->makeRegionCompareChartF2('guid7007AC27-6A45-4C1A-894D-0F41EAC2DF49', 'b1_flr_2');
        $this->makeRegionCompareChartF2('guid7E36DAD8-2A4C-423F-A80C-5FB3D2630DED', 'b1_flr_3');
        $this->makeRegionCompareChartF2('guid99BB14E0-C216-4780-830B-CF896EBFFE7E', 'b1_flr_4');
        $this->makeRegionCompareChartF2('guid8DEB922A-DA0C-443E-A36E-7494A19D28E7', 'b1_flr_5');
        $this->makeRegionCompareChartF2('guidBD82C01A-DB01-4918-BDCF-8BE8BB6A9837', 'b1_flr_6');
        $this->makeRegionCompareChartF2('guid5F12DA1F-B476-476E-804D-78956D6EC1D5', 'b1_flr_7');
        $this->makeRegionCompareChartF2('guid481CB98D-885E-4316-AB13-0D4394AA3A95', 'b1_flr_8');
        $currentid= $_GET['rgn_atpidcurrent']?$_GET['rgn_atpidcurrent']:false;
        $this->assign('currentid',$currentid);
        $this->display();
    }


    //2a
    public function F2a_ceng1F()
    {
        $this->makeRegionCompareChartF('guid9B4BB812-A1D6-4056-80D8-FF6D11104F3E');
//        $this->makeRegionCompareChartF('guid7007AC27-6A45-4C1A-894D-0F41EAC2DF49');
        $this->makeRegionCompareChartF2('guid9B4BB812-A1D6-4056-80D8-FF6D11104F3E', 'b2a_flr_1');
        $this->makeRegionCompareChartF2('guid0EA5DF81-36CC-4603-B4D8-D9A9875B5068', 'b2a_flr_2');
        $this->makeRegionCompareChartF2('guid36B761C6-CDEF-41AD-9CE6-8D17627657FE', 'b2a_flr_3');
        $this->makeRegionCompareChartF2('guid4338ED41-4C1A-4B35-9B9E-6D99B4A7DED7', 'b2a_flr_4');
        $this->makeRegionCompareChartF2('guid0A930945-3989-4613-B6D5-53064AFAB9F9', 'b2a_flr_5');
        $this->makeRegionCompareChartF2('guid47EB34F2-A06A-4972-B6C8-0D39F68C859A', 'b2a_flr_6');
        $this->makeRegionCompareChartF2('guidA29B4EBE-4D80-4935-9FBA-8AD2A82D41C0', 'b2a_flr_7');
        $this->makeRegionCompareChartF2('guidA9270E91-F72D-4445-88A8-7464788B1D11', 'b2a_flr_8');
        $this->makeRegionCompareChartF2('guidC193BA2A-294B-415F-8D6C-9315934A41C3', 'b2a_flr_9');
        $this->makeRegionCompareChartF2('guidF75B1AEC-9DE9-4C48-913B-8B3CDD3B8DAC', 'b2a_flr_10');

        $currentid= $_GET['rgn_atpidcurrent']?$_GET['rgn_atpidcurrent']:false;
        $this->assign('currentid',$currentid);
        $this->display();
    }
    public function F2a_ceng2F()
    {
        $this->makeRegionCompareChartF('guid0EA5DF81-36CC-4603-B4D8-D9A9875B5068');
//        $this->makeRegionCompareChartF('guid7007AC27-6A45-4C1A-894D-0F41EAC2DF49');
        $this->makeRegionCompareChartF2('guid9B4BB812-A1D6-4056-80D8-FF6D11104F3E', 'b2a_flr_1');
        $this->makeRegionCompareChartF2('guid0EA5DF81-36CC-4603-B4D8-D9A9875B5068', 'b2a_flr_2');
        $this->makeRegionCompareChartF2('guid36B761C6-CDEF-41AD-9CE6-8D17627657FE', 'b2a_flr_3');
        $this->makeRegionCompareChartF2('guid4338ED41-4C1A-4B35-9B9E-6D99B4A7DED7', 'b2a_flr_4');
        $this->makeRegionCompareChartF2('guid0A930945-3989-4613-B6D5-53064AFAB9F9', 'b2a_flr_5');
        $this->makeRegionCompareChartF2('guid47EB34F2-A06A-4972-B6C8-0D39F68C859A', 'b2a_flr_6');
        $this->makeRegionCompareChartF2('guidA29B4EBE-4D80-4935-9FBA-8AD2A82D41C0', 'b2a_flr_7');
        $this->makeRegionCompareChartF2('guidA9270E91-F72D-4445-88A8-7464788B1D11', 'b2a_flr_8');
        $this->makeRegionCompareChartF2('guidC193BA2A-294B-415F-8D6C-9315934A41C3', 'b2a_flr_9');
        $this->makeRegionCompareChartF2('guidF75B1AEC-9DE9-4C48-913B-8B3CDD3B8DAC', 'b2a_flr_10');

        $currentid= $_GET['rgn_atpidcurrent']?$_GET['rgn_atpidcurrent']:false;
        $this->assign('currentid',$currentid);
        $this->display();
    }
    public function F2a_ceng3F()
    {
        $this->makeRegionCompareChartF('guid36B761C6-CDEF-41AD-9CE6-8D17627657FE');
//        $this->makeRegionCompareChartF('guid7007AC27-6A45-4C1A-894D-0F41EAC2DF49');
        $this->makeRegionCompareChartF2('guid9B4BB812-A1D6-4056-80D8-FF6D11104F3E', 'b2a_flr_1');
        $this->makeRegionCompareChartF2('guid0EA5DF81-36CC-4603-B4D8-D9A9875B5068', 'b2a_flr_2');
        $this->makeRegionCompareChartF2('guid36B761C6-CDEF-41AD-9CE6-8D17627657FE', 'b2a_flr_3');
        $this->makeRegionCompareChartF2('guid4338ED41-4C1A-4B35-9B9E-6D99B4A7DED7', 'b2a_flr_4');
        $this->makeRegionCompareChartF2('guid0A930945-3989-4613-B6D5-53064AFAB9F9', 'b2a_flr_5');
        $this->makeRegionCompareChartF2('guid47EB34F2-A06A-4972-B6C8-0D39F68C859A', 'b2a_flr_6');
        $this->makeRegionCompareChartF2('guidA29B4EBE-4D80-4935-9FBA-8AD2A82D41C0', 'b2a_flr_7');
        $this->makeRegionCompareChartF2('guidA9270E91-F72D-4445-88A8-7464788B1D11', 'b2a_flr_8');
        $this->makeRegionCompareChartF2('guidC193BA2A-294B-415F-8D6C-9315934A41C3', 'b2a_flr_9');
        $this->makeRegionCompareChartF2('guidF75B1AEC-9DE9-4C48-913B-8B3CDD3B8DAC', 'b2a_flr_10');

        $currentid= $_GET['rgn_atpidcurrent']?$_GET['rgn_atpidcurrent']:false;
        $this->assign('currentid',$currentid);
        $this->display();
    }
    public function F2a_ceng4F()
    {
        $this->makeRegionCompareChartF('guid4338ED41-4C1A-4B35-9B9E-6D99B4A7DED7');
//        $this->makeRegionCompareChartF('guid7007AC27-6A45-4C1A-894D-0F41EAC2DF49');
        $this->makeRegionCompareChartF2('guid9B4BB812-A1D6-4056-80D8-FF6D11104F3E', 'b2a_flr_1');
        $this->makeRegionCompareChartF2('guid0EA5DF81-36CC-4603-B4D8-D9A9875B5068', 'b2a_flr_2');
        $this->makeRegionCompareChartF2('guid36B761C6-CDEF-41AD-9CE6-8D17627657FE', 'b2a_flr_3');
        $this->makeRegionCompareChartF2('guid4338ED41-4C1A-4B35-9B9E-6D99B4A7DED7', 'b2a_flr_4');
        $this->makeRegionCompareChartF2('guid0A930945-3989-4613-B6D5-53064AFAB9F9', 'b2a_flr_5');
        $this->makeRegionCompareChartF2('guid47EB34F2-A06A-4972-B6C8-0D39F68C859A', 'b2a_flr_6');
        $this->makeRegionCompareChartF2('guidA29B4EBE-4D80-4935-9FBA-8AD2A82D41C0', 'b2a_flr_7');
        $this->makeRegionCompareChartF2('guidA9270E91-F72D-4445-88A8-7464788B1D11', 'b2a_flr_8');
        $this->makeRegionCompareChartF2('guidC193BA2A-294B-415F-8D6C-9315934A41C3', 'b2a_flr_9');
        $this->makeRegionCompareChartF2('guidF75B1AEC-9DE9-4C48-913B-8B3CDD3B8DAC', 'b2a_flr_10');

        $currentid= $_GET['rgn_atpidcurrent']?$_GET['rgn_atpidcurrent']:false;
        $this->assign('currentid',$currentid);
        $this->display();
    }
    public function F2a_ceng5F()
    {
        $this->makeRegionCompareChartF('guid0A930945-3989-4613-B6D5-53064AFAB9F9');
//        $this->makeRegionCompareChartF('guid7007AC27-6A45-4C1A-894D-0F41EAC2DF49');
        $this->makeRegionCompareChartF2('guid9B4BB812-A1D6-4056-80D8-FF6D11104F3E', 'b2a_flr_1');
        $this->makeRegionCompareChartF2('guid0EA5DF81-36CC-4603-B4D8-D9A9875B5068', 'b2a_flr_2');
        $this->makeRegionCompareChartF2('guid36B761C6-CDEF-41AD-9CE6-8D17627657FE', 'b2a_flr_3');
        $this->makeRegionCompareChartF2('guid4338ED41-4C1A-4B35-9B9E-6D99B4A7DED7', 'b2a_flr_4');
        $this->makeRegionCompareChartF2('guid0A930945-3989-4613-B6D5-53064AFAB9F9', 'b2a_flr_5');
        $this->makeRegionCompareChartF2('guid47EB34F2-A06A-4972-B6C8-0D39F68C859A', 'b2a_flr_6');
        $this->makeRegionCompareChartF2('guidA29B4EBE-4D80-4935-9FBA-8AD2A82D41C0', 'b2a_flr_7');
        $this->makeRegionCompareChartF2('guidA9270E91-F72D-4445-88A8-7464788B1D11', 'b2a_flr_8');
        $this->makeRegionCompareChartF2('guidC193BA2A-294B-415F-8D6C-9315934A41C3', 'b2a_flr_9');
        $this->makeRegionCompareChartF2('guidF75B1AEC-9DE9-4C48-913B-8B3CDD3B8DAC', 'b2a_flr_10');

        $currentid= $_GET['rgn_atpidcurrent']?$_GET['rgn_atpidcurrent']:false;
        $this->assign('currentid',$currentid);
        $this->display();
    }
    public function F2a_ceng6F()
    {
        $this->makeRegionCompareChartF('guid47EB34F2-A06A-4972-B6C8-0D39F68C859A');
//        $this->makeRegionCompareChartF('guid7007AC27-6A45-4C1A-894D-0F41EAC2DF49');
        $this->makeRegionCompareChartF2('guid9B4BB812-A1D6-4056-80D8-FF6D11104F3E', 'b2a_flr_1');
        $this->makeRegionCompareChartF2('guid0EA5DF81-36CC-4603-B4D8-D9A9875B5068', 'b2a_flr_2');
        $this->makeRegionCompareChartF2('guid36B761C6-CDEF-41AD-9CE6-8D17627657FE', 'b2a_flr_3');
        $this->makeRegionCompareChartF2('guid4338ED41-4C1A-4B35-9B9E-6D99B4A7DED7', 'b2a_flr_4');
        $this->makeRegionCompareChartF2('guid0A930945-3989-4613-B6D5-53064AFAB9F9', 'b2a_flr_5');
        $this->makeRegionCompareChartF2('guid47EB34F2-A06A-4972-B6C8-0D39F68C859A', 'b2a_flr_6');
        $this->makeRegionCompareChartF2('guidA29B4EBE-4D80-4935-9FBA-8AD2A82D41C0', 'b2a_flr_7');
        $this->makeRegionCompareChartF2('guidA9270E91-F72D-4445-88A8-7464788B1D11', 'b2a_flr_8');
        $this->makeRegionCompareChartF2('guidC193BA2A-294B-415F-8D6C-9315934A41C3', 'b2a_flr_9');
        $this->makeRegionCompareChartF2('guidF75B1AEC-9DE9-4C48-913B-8B3CDD3B8DAC', 'b2a_flr_10');

        $currentid= $_GET['rgn_atpidcurrent']?$_GET['rgn_atpidcurrent']:false;
        $this->assign('currentid',$currentid);
        $this->display();
    }
    public function F2a_ceng7F()
    {
        $this->makeRegionCompareChartF('guidA29B4EBE-4D80-4935-9FBA-8AD2A82D41C0');
//        $this->makeRegionCompareChartF('guid7007AC27-6A45-4C1A-894D-0F41EAC2DF49');
        $this->makeRegionCompareChartF2('guid9B4BB812-A1D6-4056-80D8-FF6D11104F3E', 'b2a_flr_1');
        $this->makeRegionCompareChartF2('guid0EA5DF81-36CC-4603-B4D8-D9A9875B5068', 'b2a_flr_2');
        $this->makeRegionCompareChartF2('guid36B761C6-CDEF-41AD-9CE6-8D17627657FE', 'b2a_flr_3');
        $this->makeRegionCompareChartF2('guid4338ED41-4C1A-4B35-9B9E-6D99B4A7DED7', 'b2a_flr_4');
        $this->makeRegionCompareChartF2('guid0A930945-3989-4613-B6D5-53064AFAB9F9', 'b2a_flr_5');
        $this->makeRegionCompareChartF2('guid47EB34F2-A06A-4972-B6C8-0D39F68C859A', 'b2a_flr_6');
        $this->makeRegionCompareChartF2('guidA29B4EBE-4D80-4935-9FBA-8AD2A82D41C0', 'b2a_flr_7');
        $this->makeRegionCompareChartF2('guidA9270E91-F72D-4445-88A8-7464788B1D11', 'b2a_flr_8');
        $this->makeRegionCompareChartF2('guidC193BA2A-294B-415F-8D6C-9315934A41C3', 'b2a_flr_9');
        $this->makeRegionCompareChartF2('guidF75B1AEC-9DE9-4C48-913B-8B3CDD3B8DAC', 'b2a_flr_10');

        $currentid= $_GET['rgn_atpidcurrent']?$_GET['rgn_atpidcurrent']:false;
        $this->assign('currentid',$currentid);
        $this->display();
    }
    public function F2a_ceng8F()
    {
        $this->makeRegionCompareChartF('guidA9270E91-F72D-4445-88A8-7464788B1D11');
//        $this->makeRegionCompareChartF('guid7007AC27-6A45-4C1A-894D-0F41EAC2DF49');
        $this->makeRegionCompareChartF2('guid9B4BB812-A1D6-4056-80D8-FF6D11104F3E', 'b2a_flr_1');
        $this->makeRegionCompareChartF2('guid0EA5DF81-36CC-4603-B4D8-D9A9875B5068', 'b2a_flr_2');
        $this->makeRegionCompareChartF2('guid36B761C6-CDEF-41AD-9CE6-8D17627657FE', 'b2a_flr_3');
        $this->makeRegionCompareChartF2('guid4338ED41-4C1A-4B35-9B9E-6D99B4A7DED7', 'b2a_flr_4');
        $this->makeRegionCompareChartF2('guid0A930945-3989-4613-B6D5-53064AFAB9F9', 'b2a_flr_5');
        $this->makeRegionCompareChartF2('guid47EB34F2-A06A-4972-B6C8-0D39F68C859A', 'b2a_flr_6');
        $this->makeRegionCompareChartF2('guidA29B4EBE-4D80-4935-9FBA-8AD2A82D41C0', 'b2a_flr_7');
        $this->makeRegionCompareChartF2('guidA9270E91-F72D-4445-88A8-7464788B1D11', 'b2a_flr_8');
        $this->makeRegionCompareChartF2('guidC193BA2A-294B-415F-8D6C-9315934A41C3', 'b2a_flr_9');
        $this->makeRegionCompareChartF2('guidF75B1AEC-9DE9-4C48-913B-8B3CDD3B8DAC', 'b2a_flr_10');

        $currentid= $_GET['rgn_atpidcurrent']?$_GET['rgn_atpidcurrent']:false;
        $this->assign('currentid',$currentid);
        $this->display();
    }
    public function F2a_ceng9F()
    {
        $this->makeRegionCompareChartF('guidC193BA2A-294B-415F-8D6C-9315934A41C3');
//        $this->makeRegionCompareChartF('guid7007AC27-6A45-4C1A-894D-0F41EAC2DF49');
        $this->makeRegionCompareChartF2('guid9B4BB812-A1D6-4056-80D8-FF6D11104F3E', 'b2a_flr_1');
        $this->makeRegionCompareChartF2('guid0EA5DF81-36CC-4603-B4D8-D9A9875B5068', 'b2a_flr_2');
        $this->makeRegionCompareChartF2('guid36B761C6-CDEF-41AD-9CE6-8D17627657FE', 'b2a_flr_3');
        $this->makeRegionCompareChartF2('guid4338ED41-4C1A-4B35-9B9E-6D99B4A7DED7', 'b2a_flr_4');
        $this->makeRegionCompareChartF2('guid0A930945-3989-4613-B6D5-53064AFAB9F9', 'b2a_flr_5');
        $this->makeRegionCompareChartF2('guid47EB34F2-A06A-4972-B6C8-0D39F68C859A', 'b2a_flr_6');
        $this->makeRegionCompareChartF2('guidA29B4EBE-4D80-4935-9FBA-8AD2A82D41C0', 'b2a_flr_7');
        $this->makeRegionCompareChartF2('guidA9270E91-F72D-4445-88A8-7464788B1D11', 'b2a_flr_8');
        $this->makeRegionCompareChartF2('guidC193BA2A-294B-415F-8D6C-9315934A41C3', 'b2a_flr_9');
        $this->makeRegionCompareChartF2('guidF75B1AEC-9DE9-4C48-913B-8B3CDD3B8DAC', 'b2a_flr_10');

        $currentid= $_GET['rgn_atpidcurrent']?$_GET['rgn_atpidcurrent']:false;
        $this->assign('currentid',$currentid);
        $this->display();
    }
    public function F2a_ceng10F()
    {
        $this->makeRegionCompareChartF('guidF75B1AEC-9DE9-4C48-913B-8B3CDD3B8DAC');
//        $this->makeRegionCompareChartF('guid7007AC27-6A45-4C1A-894D-0F41EAC2DF49');
        $this->makeRegionCompareChartF2('guid9B4BB812-A1D6-4056-80D8-FF6D11104F3E', 'b2a_flr_1');
        $this->makeRegionCompareChartF2('guid0EA5DF81-36CC-4603-B4D8-D9A9875B5068', 'b2a_flr_2');
        $this->makeRegionCompareChartF2('guid36B761C6-CDEF-41AD-9CE6-8D17627657FE', 'b2a_flr_3');
        $this->makeRegionCompareChartF2('guid4338ED41-4C1A-4B35-9B9E-6D99B4A7DED7', 'b2a_flr_4');
        $this->makeRegionCompareChartF2('guid0A930945-3989-4613-B6D5-53064AFAB9F9', 'b2a_flr_5');
        $this->makeRegionCompareChartF2('guid47EB34F2-A06A-4972-B6C8-0D39F68C859A', 'b2a_flr_6');
        $this->makeRegionCompareChartF2('guidA29B4EBE-4D80-4935-9FBA-8AD2A82D41C0', 'b2a_flr_7');
        $this->makeRegionCompareChartF2('guidA9270E91-F72D-4445-88A8-7464788B1D11', 'b2a_flr_8');
        $this->makeRegionCompareChartF2('guidC193BA2A-294B-415F-8D6C-9315934A41C3', 'b2a_flr_9');
        $this->makeRegionCompareChartF2('guidF75B1AEC-9DE9-4C48-913B-8B3CDD3B8DAC', 'b2a_flr_10');

        $currentid= $_GET['rgn_atpidcurrent']?$_GET['rgn_atpidcurrent']:false;
        $this->assign('currentid',$currentid);
        $this->display();
    }



    //2b
    public function F2b_ceng1F()
    {
        $this->makeRegionCompareChartF('guidFB65B509-0008-4F0A-9B10-C86C06858351');
//        $this->makeRegionCompareChartF('guid7007AC27-6A45-4C1A-894D-0F41EAC2DF49');
        $this->makeRegionCompareChartF2('guidFB65B509-0008-4F0A-9B10-C86C06858351', 'b2b_flr_1');
        $this->makeRegionCompareChartF2('guid82BA8292-E108-4BE4-B034-09AA443B9B60', 'b2b_flr_2');
        $this->makeRegionCompareChartF2('guid23157729-7085-4968-972F-B72CB94146EE', 'b2b_flr_3');
        $this->makeRegionCompareChartF2('guidA0D6E775-8AF0-4D9C-B879-990A18DE76AF', 'b2b_flr_4');
        $this->makeRegionCompareChartF2('guidCCDFA873-5E22-46C7-99CD-837827B9FD16', 'b2b_flr_5');
        $this->makeRegionCompareChartF2('guid52E02F13-26CB-4DE8-A2C2-3AF864AD4E29', 'b2b_flr_6');
        $this->makeRegionCompareChartF2('guid2556D3D2-ADA7-4348-B88E-6F88E5354302', 'b2b_flr_7');
        $this->makeRegionCompareChartF2('guidE8652970-FC44-4708-846B-304BCAF64E60', 'b2b_flr_8');
        $this->makeRegionCompareChartF2('guidC68CB772-933A-48FA-88AD-30BE719D6053', 'b2b_flr_9');
        $this->makeRegionCompareChartF2('guidE3CA4793-D808-4F48-8102-EF3DA0616099', 'b2b_flr_10');

        $currentid= $_GET['rgn_atpidcurrent']?$_GET['rgn_atpidcurrent']:false;
        $this->assign('currentid',$currentid);
        $this->display();
    }
    public function F2b_ceng2F()
    {
        $this->makeRegionCompareChartF('guid82BA8292-E108-4BE4-B034-09AA443B9B60');
//        $this->makeRegionCompareChartF('guid7007AC27-6A45-4C1A-894D-0F41EAC2DF49');
        $this->makeRegionCompareChartF2('guidFB65B509-0008-4F0A-9B10-C86C06858351', 'b2b_flr_1');
        $this->makeRegionCompareChartF2('guid82BA8292-E108-4BE4-B034-09AA443B9B60', 'b2b_flr_2');
        $this->makeRegionCompareChartF2('guid23157729-7085-4968-972F-B72CB94146EE', 'b2b_flr_3');
        $this->makeRegionCompareChartF2('guidA0D6E775-8AF0-4D9C-B879-990A18DE76AF', 'b2b_flr_4');
        $this->makeRegionCompareChartF2('guidCCDFA873-5E22-46C7-99CD-837827B9FD16', 'b2b_flr_5');
        $this->makeRegionCompareChartF2('guid52E02F13-26CB-4DE8-A2C2-3AF864AD4E29', 'b2b_flr_6');
        $this->makeRegionCompareChartF2('guid2556D3D2-ADA7-4348-B88E-6F88E5354302', 'b2b_flr_7');
        $this->makeRegionCompareChartF2('guidE8652970-FC44-4708-846B-304BCAF64E60', 'b2b_flr_8');
        $this->makeRegionCompareChartF2('guidC68CB772-933A-48FA-88AD-30BE719D6053', 'b2b_flr_9');
        $this->makeRegionCompareChartF2('guidE3CA4793-D808-4F48-8102-EF3DA0616099', 'b2b_flr_10');

        $currentid= $_GET['rgn_atpidcurrent']?$_GET['rgn_atpidcurrent']:false;
        $this->assign('currentid',$currentid);
        $this->display();
    }
    public function F2b_ceng3F()
    {
        $this->makeRegionCompareChartF('guid23157729-7085-4968-972F-B72CB94146EE');
//        $this->makeRegionCompareChartF('guid7007AC27-6A45-4C1A-894D-0F41EAC2DF49');
        $this->makeRegionCompareChartF2('guidFB65B509-0008-4F0A-9B10-C86C06858351', 'b2b_flr_1');
        $this->makeRegionCompareChartF2('guid82BA8292-E108-4BE4-B034-09AA443B9B60', 'b2b_flr_2');
        $this->makeRegionCompareChartF2('guid23157729-7085-4968-972F-B72CB94146EE', 'b2b_flr_3');
        $this->makeRegionCompareChartF2('guidA0D6E775-8AF0-4D9C-B879-990A18DE76AF', 'b2b_flr_4');
        $this->makeRegionCompareChartF2('guidCCDFA873-5E22-46C7-99CD-837827B9FD16', 'b2b_flr_5');
        $this->makeRegionCompareChartF2('guid52E02F13-26CB-4DE8-A2C2-3AF864AD4E29', 'b2b_flr_6');
        $this->makeRegionCompareChartF2('guid2556D3D2-ADA7-4348-B88E-6F88E5354302', 'b2b_flr_7');
        $this->makeRegionCompareChartF2('guidE8652970-FC44-4708-846B-304BCAF64E60', 'b2b_flr_8');
        $this->makeRegionCompareChartF2('guidC68CB772-933A-48FA-88AD-30BE719D6053', 'b2b_flr_9');
        $this->makeRegionCompareChartF2('guidE3CA4793-D808-4F48-8102-EF3DA0616099', 'b2b_flr_10');

        $currentid= $_GET['rgn_atpidcurrent']?$_GET['rgn_atpidcurrent']:false;
        $this->assign('currentid',$currentid);
        $this->display();
    }
    public function F2b_ceng4F()
    {
        $this->makeRegionCompareChartF('guidA0D6E775-8AF0-4D9C-B879-990A18DE76AF');
//        $this->makeRegionCompareChartF('guid7007AC27-6A45-4C1A-894D-0F41EAC2DF49');
        $this->makeRegionCompareChartF2('guidFB65B509-0008-4F0A-9B10-C86C06858351', 'b2b_flr_1');
        $this->makeRegionCompareChartF2('guid82BA8292-E108-4BE4-B034-09AA443B9B60', 'b2b_flr_2');
        $this->makeRegionCompareChartF2('guid23157729-7085-4968-972F-B72CB94146EE', 'b2b_flr_3');
        $this->makeRegionCompareChartF2('guidA0D6E775-8AF0-4D9C-B879-990A18DE76AF', 'b2b_flr_4');
        $this->makeRegionCompareChartF2('guidCCDFA873-5E22-46C7-99CD-837827B9FD16', 'b2b_flr_5');
        $this->makeRegionCompareChartF2('guid52E02F13-26CB-4DE8-A2C2-3AF864AD4E29', 'b2b_flr_6');
        $this->makeRegionCompareChartF2('guid2556D3D2-ADA7-4348-B88E-6F88E5354302', 'b2b_flr_7');
        $this->makeRegionCompareChartF2('guidE8652970-FC44-4708-846B-304BCAF64E60', 'b2b_flr_8');
        $this->makeRegionCompareChartF2('guidC68CB772-933A-48FA-88AD-30BE719D6053', 'b2b_flr_9');
        $this->makeRegionCompareChartF2('guidE3CA4793-D808-4F48-8102-EF3DA0616099', 'b2b_flr_10');

        $currentid= $_GET['rgn_atpidcurrent']?$_GET['rgn_atpidcurrent']:false;
        $this->assign('currentid',$currentid);
        $this->display();
    }
    public function F2b_ceng5F()
    {
        $this->makeRegionCompareChartF('guidCCDFA873-5E22-46C7-99CD-837827B9FD16');
//     $this->makeRegionCompareChartF2('guidFB65B509-0008-4F0A-9B10-C86C06858351', 'b2b_flr_1');
        $this->makeRegionCompareChartF2('guid82BA8292-E108-4BE4-B034-09AA443B9B60', 'b2b_flr_2');
        $this->makeRegionCompareChartF2('guid23157729-7085-4968-972F-B72CB94146EE', 'b2b_flr_3');
        $this->makeRegionCompareChartF2('guidA0D6E775-8AF0-4D9C-B879-990A18DE76AF', 'b2b_flr_4');
        $this->makeRegionCompareChartF2('guidCCDFA873-5E22-46C7-99CD-837827B9FD16', 'b2b_flr_5');
        $this->makeRegionCompareChartF2('guid52E02F13-26CB-4DE8-A2C2-3AF864AD4E29', 'b2b_flr_6');
        $this->makeRegionCompareChartF2('guid2556D3D2-ADA7-4348-B88E-6F88E5354302', 'b2b_flr_7');
        $this->makeRegionCompareChartF2('guidE8652970-FC44-4708-846B-304BCAF64E60', 'b2b_flr_8');
        $this->makeRegionCompareChartF2('guidC68CB772-933A-48FA-88AD-30BE719D6053', 'b2b_flr_9');
        $this->makeRegionCompareChartF2('guidE3CA4793-D808-4F48-8102-EF3DA0616099', 'b2b_flr_10');

        $currentid= $_GET['rgn_atpidcurrent']?$_GET['rgn_atpidcurrent']:false;
        $this->assign('currentid',$currentid);
        $this->display();
    }
    public function F2b_ceng6F()
    {
        $this->makeRegionCompareChartF('guid52E02F13-26CB-4DE8-A2C2-3AF864AD4E29');
//        $this->makeRegionCompareChartF('guid7007AC27-6A45-4C1A-894D-0F41EAC2DF49');
        $this->makeRegionCompareChartF2('guidFB65B509-0008-4F0A-9B10-C86C06858351', 'b2b_flr_1');
        $this->makeRegionCompareChartF2('guid82BA8292-E108-4BE4-B034-09AA443B9B60', 'b2b_flr_2');
        $this->makeRegionCompareChartF2('guid23157729-7085-4968-972F-B72CB94146EE', 'b2b_flr_3');
        $this->makeRegionCompareChartF2('guidA0D6E775-8AF0-4D9C-B879-990A18DE76AF', 'b2b_flr_4');
        $this->makeRegionCompareChartF2('guidCCDFA873-5E22-46C7-99CD-837827B9FD16', 'b2b_flr_5');
        $this->makeRegionCompareChartF2('guid52E02F13-26CB-4DE8-A2C2-3AF864AD4E29', 'b2b_flr_6');
        $this->makeRegionCompareChartF2('guid2556D3D2-ADA7-4348-B88E-6F88E5354302', 'b2b_flr_7');
        $this->makeRegionCompareChartF2('guidE8652970-FC44-4708-846B-304BCAF64E60', 'b2b_flr_8');
        $this->makeRegionCompareChartF2('guidC68CB772-933A-48FA-88AD-30BE719D6053', 'b2b_flr_9');
        $this->makeRegionCompareChartF2('guidE3CA4793-D808-4F48-8102-EF3DA0616099', 'b2b_flr_10');

        $currentid= $_GET['rgn_atpidcurrent']?$_GET['rgn_atpidcurrent']:false;
        $this->assign('currentid',$currentid);
        $this->display();
    }
    public function F2b_ceng7F()
    {
        $this->makeRegionCompareChartF('guid2556D3D2-ADA7-4348-B88E-6F88E5354302');
//        $this->makeRegionCompareChartF('guid7007AC27-6A45-4C1A-894D-0F41EAC2DF49');
        $this->makeRegionCompareChartF2('guidFB65B509-0008-4F0A-9B10-C86C06858351', 'b2b_flr_1');
        $this->makeRegionCompareChartF2('guid82BA8292-E108-4BE4-B034-09AA443B9B60', 'b2b_flr_2');
        $this->makeRegionCompareChartF2('guid23157729-7085-4968-972F-B72CB94146EE', 'b2b_flr_3');
        $this->makeRegionCompareChartF2('guidA0D6E775-8AF0-4D9C-B879-990A18DE76AF', 'b2b_flr_4');
        $this->makeRegionCompareChartF2('guidCCDFA873-5E22-46C7-99CD-837827B9FD16', 'b2b_flr_5');
        $this->makeRegionCompareChartF2('guid52E02F13-26CB-4DE8-A2C2-3AF864AD4E29', 'b2b_flr_6');
        $this->makeRegionCompareChartF2('guid2556D3D2-ADA7-4348-B88E-6F88E5354302', 'b2b_flr_7');
        $this->makeRegionCompareChartF2('guidE8652970-FC44-4708-846B-304BCAF64E60', 'b2b_flr_8');
        $this->makeRegionCompareChartF2('guidC68CB772-933A-48FA-88AD-30BE719D6053', 'b2b_flr_9');
        $this->makeRegionCompareChartF2('guidE3CA4793-D808-4F48-8102-EF3DA0616099', 'b2b_flr_10');

        $currentid= $_GET['rgn_atpidcurrent']?$_GET['rgn_atpidcurrent']:false;
        $this->assign('currentid',$currentid);
        $this->display();
    }
    public function F2b_ceng8F()
    {
        $this->makeRegionCompareChartF('guidE8652970-FC44-4708-846B-304BCAF64E60');
//        $this->makeRegionCompareChartF('guid7007AC27-6A45-4C1A-894D-0F41EAC2DF49');
        $this->makeRegionCompareChartF2('guidFB65B509-0008-4F0A-9B10-C86C06858351', 'b2b_flr_1');
        $this->makeRegionCompareChartF2('guid82BA8292-E108-4BE4-B034-09AA443B9B60', 'b2b_flr_2');
        $this->makeRegionCompareChartF2('guid23157729-7085-4968-972F-B72CB94146EE', 'b2b_flr_3');
        $this->makeRegionCompareChartF2('guidA0D6E775-8AF0-4D9C-B879-990A18DE76AF', 'b2b_flr_4');
        $this->makeRegionCompareChartF2('guidCCDFA873-5E22-46C7-99CD-837827B9FD16', 'b2b_flr_5');
        $this->makeRegionCompareChartF2('guid52E02F13-26CB-4DE8-A2C2-3AF864AD4E29', 'b2b_flr_6');
        $this->makeRegionCompareChartF2('guid2556D3D2-ADA7-4348-B88E-6F88E5354302', 'b2b_flr_7');
        $this->makeRegionCompareChartF2('guidE8652970-FC44-4708-846B-304BCAF64E60', 'b2b_flr_8');
        $this->makeRegionCompareChartF2('guidC68CB772-933A-48FA-88AD-30BE719D6053', 'b2b_flr_9');
        $this->makeRegionCompareChartF2('guidE3CA4793-D808-4F48-8102-EF3DA0616099', 'b2b_flr_10');

        $currentid= $_GET['rgn_atpidcurrent']?$_GET['rgn_atpidcurrent']:false;
        $this->assign('currentid',$currentid);
        $this->display();
    }
    public function F2b_ceng9F()
    {
        $this->makeRegionCompareChartF('guidC68CB772-933A-48FA-88AD-30BE719D6053');
//        $this->makeRegionCompareChartF('guid7007AC27-6A45-4C1A-894D-0F41EAC2DF49');
        $this->makeRegionCompareChartF2('guidFB65B509-0008-4F0A-9B10-C86C06858351', 'b2b_flr_1');
        $this->makeRegionCompareChartF2('guid82BA8292-E108-4BE4-B034-09AA443B9B60', 'b2b_flr_2');
        $this->makeRegionCompareChartF2('guid23157729-7085-4968-972F-B72CB94146EE', 'b2b_flr_3');
        $this->makeRegionCompareChartF2('guidA0D6E775-8AF0-4D9C-B879-990A18DE76AF', 'b2b_flr_4');
        $this->makeRegionCompareChartF2('guidCCDFA873-5E22-46C7-99CD-837827B9FD16', 'b2b_flr_5');
        $this->makeRegionCompareChartF2('guid52E02F13-26CB-4DE8-A2C2-3AF864AD4E29', 'b2b_flr_6');
        $this->makeRegionCompareChartF2('guid2556D3D2-ADA7-4348-B88E-6F88E5354302', 'b2b_flr_7');
        $this->makeRegionCompareChartF2('guidE8652970-FC44-4708-846B-304BCAF64E60', 'b2b_flr_8');
        $this->makeRegionCompareChartF2('guidC68CB772-933A-48FA-88AD-30BE719D6053', 'b2b_flr_9');
        $this->makeRegionCompareChartF2('guidE3CA4793-D808-4F48-8102-EF3DA0616099', 'b2b_flr_10');

        $currentid= $_GET['rgn_atpidcurrent']?$_GET['rgn_atpidcurrent']:false;
        $this->assign('currentid',$currentid);
        $this->display();
    }
    public function F2b_ceng10F()
    {
        $this->makeRegionCompareChartF('guidE3CA4793-D808-4F48-8102-EF3DA0616099');
//        $this->makeRegionCompareChartF('guid7007AC27-6A45-4C1A-894D-0F41EAC2DF49');
        $this->makeRegionCompareChartF2('guidFB65B509-0008-4F0A-9B10-C86C06858351', 'b2b_flr_1');
        $this->makeRegionCompareChartF2('guid82BA8292-E108-4BE4-B034-09AA443B9B60', 'b2b_flr_2');
        $this->makeRegionCompareChartF2('guid23157729-7085-4968-972F-B72CB94146EE', 'b2b_flr_3');
        $this->makeRegionCompareChartF2('guidA0D6E775-8AF0-4D9C-B879-990A18DE76AF', 'b2b_flr_4');
        $this->makeRegionCompareChartF2('guidCCDFA873-5E22-46C7-99CD-837827B9FD16', 'b2b_flr_5');
        $this->makeRegionCompareChartF2('guid52E02F13-26CB-4DE8-A2C2-3AF864AD4E29', 'b2b_flr_6');
        $this->makeRegionCompareChartF2('guid2556D3D2-ADA7-4348-B88E-6F88E5354302', 'b2b_flr_7');
        $this->makeRegionCompareChartF2('guidE8652970-FC44-4708-846B-304BCAF64E60', 'b2b_flr_8');
        $this->makeRegionCompareChartF2('guidC68CB772-933A-48FA-88AD-30BE719D6053', 'b2b_flr_9');
        $this->makeRegionCompareChartF2('guidE3CA4793-D808-4F48-8102-EF3DA0616099', 'b2b_flr_10');

        $currentid= $_GET['rgn_atpidcurrent']?$_GET['rgn_atpidcurrent']:false;
        $this->assign('currentid',$currentid);
        $this->display();
    }


    //2c
    public function F2c_ceng1F()
    {
        $this->makeRegionCompareChartF('guid6B6AB76A-1D0B-481C-AF83-AB3BBE05515F');
//        $this->makeRegionCompareChartF('guid7007AC27-6A45-4C1A-894D-0F41EAC2DF49');
        $this->makeRegionCompareChartF2('guid6B6AB76A-1D0B-481C-AF83-AB3BBE05515F', 'b2c_flr_1');
        $this->makeRegionCompareChartF2('guid25A2379A-668A-49DE-8F8D-46663CEB5E6A', 'b2c_flr_2');
        $this->makeRegionCompareChartF2('guidAE172084-79D5-4112-9970-87B320424B57', 'b2c_flr_3');
        $this->makeRegionCompareChartF2('guid6C23D55A-2A4D-4D71-B2AB-4F29AF987224', 'b2c_flr_4');
        $this->makeRegionCompareChartF2('guid95827E32-A224-4A49-93E4-CA71E365E273', 'b2c_flr_5');
        $this->makeRegionCompareChartF2('guidF46FA1C2-90BD-4AC2-9780-207E7AEF006B', 'b2c_flr_6');
        $this->makeRegionCompareChartF2('guid1E0BB620-A0E9-41ED-AE34-29031826B11D', 'b2c_flr_7');
        $this->makeRegionCompareChartF2('guidB3796831-AAC8-42BF-90E0-4BC0E54B64E5', 'b2c_flr_8');
        $this->makeRegionCompareChartF2('guidA16C8E3C-BB4A-4C68-A864-B003BD85D8FA', 'b2c_flr_9');
        $this->makeRegionCompareChartF2('guidD665B15B-853C-49FA-8D8D-F3ABBDE69DEE', 'b2c_flr_10');
        $this->makeRegionCompareChartF2('guid20A09CAC-F314-43E5-86F3-24A40BFE03E5', 'b2c_flr_11');
        $this->makeRegionCompareChartF2('guidF8ABD205-7DBB-4FB5-BDC3-35E6F5BDA6E1', 'b2c_flr_12');
        $this->makeRegionCompareChartF2('guidA2E8462E-A18B-4FEB-906F-51083C1716F9', 'b2c_flr_13');

        $currentid= $_GET['rgn_atpidcurrent']?$_GET['rgn_atpidcurrent']:false;
        $this->assign('currentid',$currentid);
        $this->display();
    }
    public function F2c_ceng2F()
    {
        $this->makeRegionCompareChartF('guid25A2379A-668A-49DE-8F8D-46663CEB5E6A');
//        $this->makeRegionCompareChartF('guid7007AC27-6A45-4C1A-894D-0F41EAC2DF49');
        $this->makeRegionCompareChartF2('guid6B6AB76A-1D0B-481C-AF83-AB3BBE05515F', 'b2c_flr_1');
        $this->makeRegionCompareChartF2('guid25A2379A-668A-49DE-8F8D-46663CEB5E6A', 'b2c_flr_2');
        $this->makeRegionCompareChartF2('guidAE172084-79D5-4112-9970-87B320424B57', 'b2c_flr_3');
        $this->makeRegionCompareChartF2('guid6C23D55A-2A4D-4D71-B2AB-4F29AF987224', 'b2c_flr_4');
        $this->makeRegionCompareChartF2('guid95827E32-A224-4A49-93E4-CA71E365E273', 'b2c_flr_5');
        $this->makeRegionCompareChartF2('guidF46FA1C2-90BD-4AC2-9780-207E7AEF006B', 'b2c_flr_6');
        $this->makeRegionCompareChartF2('guid1E0BB620-A0E9-41ED-AE34-29031826B11D', 'b2c_flr_7');
        $this->makeRegionCompareChartF2('guidB3796831-AAC8-42BF-90E0-4BC0E54B64E5', 'b2c_flr_8');
        $this->makeRegionCompareChartF2('guidA16C8E3C-BB4A-4C68-A864-B003BD85D8FA', 'b2c_flr_9');
        $this->makeRegionCompareChartF2('guidD665B15B-853C-49FA-8D8D-F3ABBDE69DEE', 'b2c_flr_10');
        $this->makeRegionCompareChartF2('guid20A09CAC-F314-43E5-86F3-24A40BFE03E5', 'b2c_flr_11');
        $this->makeRegionCompareChartF2('guidF8ABD205-7DBB-4FB5-BDC3-35E6F5BDA6E1', 'b2c_flr_12');
        $this->makeRegionCompareChartF2('guidA2E8462E-A18B-4FEB-906F-51083C1716F9', 'b2c_flr_13');

        $currentid= $_GET['rgn_atpidcurrent']?$_GET['rgn_atpidcurrent']:false;
        $this->assign('currentid',$currentid);
        $this->display();
    }
    public function F2c_ceng3F()
    {
        $this->makeRegionCompareChartF('guidAE172084-79D5-4112-9970-87B320424B57');
//        $this->makeRegionCompareChartF('guid7007AC27-6A45-4C1A-894D-0F41EAC2DF49');
        $this->makeRegionCompareChartF2('guid6B6AB76A-1D0B-481C-AF83-AB3BBE05515F', 'b2c_flr_1');
        $this->makeRegionCompareChartF2('guid25A2379A-668A-49DE-8F8D-46663CEB5E6A', 'b2c_flr_2');
        $this->makeRegionCompareChartF2('guidAE172084-79D5-4112-9970-87B320424B57', 'b2c_flr_3');
        $this->makeRegionCompareChartF2('guid6C23D55A-2A4D-4D71-B2AB-4F29AF987224', 'b2c_flr_4');
        $this->makeRegionCompareChartF2('guid95827E32-A224-4A49-93E4-CA71E365E273', 'b2c_flr_5');
        $this->makeRegionCompareChartF2('guidF46FA1C2-90BD-4AC2-9780-207E7AEF006B', 'b2c_flr_6');
        $this->makeRegionCompareChartF2('guid1E0BB620-A0E9-41ED-AE34-29031826B11D', 'b2c_flr_7');
        $this->makeRegionCompareChartF2('guidB3796831-AAC8-42BF-90E0-4BC0E54B64E5', 'b2c_flr_8');
        $this->makeRegionCompareChartF2('guidA16C8E3C-BB4A-4C68-A864-B003BD85D8FA', 'b2c_flr_9');
        $this->makeRegionCompareChartF2('guidD665B15B-853C-49FA-8D8D-F3ABBDE69DEE', 'b2c_flr_10');
        $this->makeRegionCompareChartF2('guid20A09CAC-F314-43E5-86F3-24A40BFE03E5', 'b2c_flr_11');
        $this->makeRegionCompareChartF2('guidF8ABD205-7DBB-4FB5-BDC3-35E6F5BDA6E1', 'b2c_flr_12');
        $this->makeRegionCompareChartF2('guidA2E8462E-A18B-4FEB-906F-51083C1716F9', 'b2c_flr_13');

        $currentid= $_GET['rgn_atpidcurrent']?$_GET['rgn_atpidcurrent']:false;
        $this->assign('currentid',$currentid);
        $this->display();
    }
    public function F2c_ceng4F()
    {
        $this->makeRegionCompareChartF('guid6C23D55A-2A4D-4D71-B2AB-4F29AF987224');
//        $this->makeRegionCompareChartF('guid7007AC27-6A45-4C1A-894D-0F41EAC2DF49');
        $this->makeRegionCompareChartF2('guid6B6AB76A-1D0B-481C-AF83-AB3BBE05515F', 'b2c_flr_1');
        $this->makeRegionCompareChartF2('guid25A2379A-668A-49DE-8F8D-46663CEB5E6A', 'b2c_flr_2');
        $this->makeRegionCompareChartF2('guidAE172084-79D5-4112-9970-87B320424B57', 'b2c_flr_3');
        $this->makeRegionCompareChartF2('guid6C23D55A-2A4D-4D71-B2AB-4F29AF987224', 'b2c_flr_4');
        $this->makeRegionCompareChartF2('guid95827E32-A224-4A49-93E4-CA71E365E273', 'b2c_flr_5');
        $this->makeRegionCompareChartF2('guidF46FA1C2-90BD-4AC2-9780-207E7AEF006B', 'b2c_flr_6');
        $this->makeRegionCompareChartF2('guid1E0BB620-A0E9-41ED-AE34-29031826B11D', 'b2c_flr_7');
        $this->makeRegionCompareChartF2('guidB3796831-AAC8-42BF-90E0-4BC0E54B64E5', 'b2c_flr_8');
        $this->makeRegionCompareChartF2('guidA16C8E3C-BB4A-4C68-A864-B003BD85D8FA', 'b2c_flr_9');
        $this->makeRegionCompareChartF2('guidD665B15B-853C-49FA-8D8D-F3ABBDE69DEE', 'b2c_flr_10');
        $this->makeRegionCompareChartF2('guid20A09CAC-F314-43E5-86F3-24A40BFE03E5', 'b2c_flr_11');
        $this->makeRegionCompareChartF2('guidF8ABD205-7DBB-4FB5-BDC3-35E6F5BDA6E1', 'b2c_flr_12');
        $this->makeRegionCompareChartF2('guidA2E8462E-A18B-4FEB-906F-51083C1716F9', 'b2c_flr_13');

        $currentid= $_GET['rgn_atpidcurrent']?$_GET['rgn_atpidcurrent']:false;
        $this->assign('currentid',$currentid);
        $this->display();
    }
    public function F2c_ceng5F()
    {
        $this->makeRegionCompareChartF('guid95827E32-A224-4A49-93E4-CA71E365E273');
//     $this->makeRegionCompareChartF2('guidFB65B509-0008-4F0A-9B10-C86C06858351', 'b2b_flr_1');
        $this->makeRegionCompareChartF2('guid6B6AB76A-1D0B-481C-AF83-AB3BBE05515F', 'b2c_flr_1');
        $this->makeRegionCompareChartF2('guid25A2379A-668A-49DE-8F8D-46663CEB5E6A', 'b2c_flr_2');
        $this->makeRegionCompareChartF2('guidAE172084-79D5-4112-9970-87B320424B57', 'b2c_flr_3');
        $this->makeRegionCompareChartF2('guid6C23D55A-2A4D-4D71-B2AB-4F29AF987224', 'b2c_flr_4');
        $this->makeRegionCompareChartF2('guid95827E32-A224-4A49-93E4-CA71E365E273', 'b2c_flr_5');
        $this->makeRegionCompareChartF2('guidF46FA1C2-90BD-4AC2-9780-207E7AEF006B', 'b2c_flr_6');
        $this->makeRegionCompareChartF2('guid1E0BB620-A0E9-41ED-AE34-29031826B11D', 'b2c_flr_7');
        $this->makeRegionCompareChartF2('guidB3796831-AAC8-42BF-90E0-4BC0E54B64E5', 'b2c_flr_8');
        $this->makeRegionCompareChartF2('guidA16C8E3C-BB4A-4C68-A864-B003BD85D8FA', 'b2c_flr_9');
        $this->makeRegionCompareChartF2('guidD665B15B-853C-49FA-8D8D-F3ABBDE69DEE', 'b2c_flr_10');
        $this->makeRegionCompareChartF2('guid20A09CAC-F314-43E5-86F3-24A40BFE03E5', 'b2c_flr_11');
        $this->makeRegionCompareChartF2('guidF8ABD205-7DBB-4FB5-BDC3-35E6F5BDA6E1', 'b2c_flr_12');
        $this->makeRegionCompareChartF2('guidA2E8462E-A18B-4FEB-906F-51083C1716F9', 'b2c_flr_13');

        $currentid= $_GET['rgn_atpidcurrent']?$_GET['rgn_atpidcurrent']:false;
        $this->assign('currentid',$currentid);
        $this->display();
    }
    public function F2c_ceng6F()
    {
        $this->makeRegionCompareChartF('guidF46FA1C2-90BD-4AC2-9780-207E7AEF006B');
//        $this->makeRegionCompareChartF('guid7007AC27-6A45-4C1A-894D-0F41EAC2DF49');
        $this->makeRegionCompareChartF2('guid6B6AB76A-1D0B-481C-AF83-AB3BBE05515F', 'b2c_flr_1');
        $this->makeRegionCompareChartF2('guid25A2379A-668A-49DE-8F8D-46663CEB5E6A', 'b2c_flr_2');
        $this->makeRegionCompareChartF2('guidAE172084-79D5-4112-9970-87B320424B57', 'b2c_flr_3');
        $this->makeRegionCompareChartF2('guid6C23D55A-2A4D-4D71-B2AB-4F29AF987224', 'b2c_flr_4');
        $this->makeRegionCompareChartF2('guid95827E32-A224-4A49-93E4-CA71E365E273', 'b2c_flr_5');
        $this->makeRegionCompareChartF2('guidF46FA1C2-90BD-4AC2-9780-207E7AEF006B', 'b2c_flr_6');
        $this->makeRegionCompareChartF2('guid1E0BB620-A0E9-41ED-AE34-29031826B11D', 'b2c_flr_7');
        $this->makeRegionCompareChartF2('guidB3796831-AAC8-42BF-90E0-4BC0E54B64E5', 'b2c_flr_8');
        $this->makeRegionCompareChartF2('guidA16C8E3C-BB4A-4C68-A864-B003BD85D8FA', 'b2c_flr_9');
        $this->makeRegionCompareChartF2('guidD665B15B-853C-49FA-8D8D-F3ABBDE69DEE', 'b2c_flr_10');
        $this->makeRegionCompareChartF2('guid20A09CAC-F314-43E5-86F3-24A40BFE03E5', 'b2c_flr_11');
        $this->makeRegionCompareChartF2('guidF8ABD205-7DBB-4FB5-BDC3-35E6F5BDA6E1', 'b2c_flr_12');
        $this->makeRegionCompareChartF2('guidA2E8462E-A18B-4FEB-906F-51083C1716F9', 'b2c_flr_13');

        $currentid= $_GET['rgn_atpidcurrent']?$_GET['rgn_atpidcurrent']:false;
        $this->assign('currentid',$currentid);
        $this->display();
    }
    public function F2c_ceng7F()
    {
        $this->makeRegionCompareChartF('guid1E0BB620-A0E9-41ED-AE34-29031826B11D');
//        $this->makeRegionCompareChartF('guid7007AC27-6A45-4C1A-894D-0F41EAC2DF49');
        $this->makeRegionCompareChartF2('guid6B6AB76A-1D0B-481C-AF83-AB3BBE05515F', 'b2c_flr_1');
        $this->makeRegionCompareChartF2('guid25A2379A-668A-49DE-8F8D-46663CEB5E6A', 'b2c_flr_2');
        $this->makeRegionCompareChartF2('guidAE172084-79D5-4112-9970-87B320424B57', 'b2c_flr_3');
        $this->makeRegionCompareChartF2('guid6C23D55A-2A4D-4D71-B2AB-4F29AF987224', 'b2c_flr_4');
        $this->makeRegionCompareChartF2('guid95827E32-A224-4A49-93E4-CA71E365E273', 'b2c_flr_5');
        $this->makeRegionCompareChartF2('guidF46FA1C2-90BD-4AC2-9780-207E7AEF006B', 'b2c_flr_6');
        $this->makeRegionCompareChartF2('guid1E0BB620-A0E9-41ED-AE34-29031826B11D', 'b2c_flr_7');
        $this->makeRegionCompareChartF2('guidB3796831-AAC8-42BF-90E0-4BC0E54B64E5', 'b2c_flr_8');
        $this->makeRegionCompareChartF2('guidA16C8E3C-BB4A-4C68-A864-B003BD85D8FA', 'b2c_flr_9');
        $this->makeRegionCompareChartF2('guidD665B15B-853C-49FA-8D8D-F3ABBDE69DEE', 'b2c_flr_10');
        $this->makeRegionCompareChartF2('guid20A09CAC-F314-43E5-86F3-24A40BFE03E5', 'b2c_flr_11');
        $this->makeRegionCompareChartF2('guidF8ABD205-7DBB-4FB5-BDC3-35E6F5BDA6E1', 'b2c_flr_12');
        $this->makeRegionCompareChartF2('guidA2E8462E-A18B-4FEB-906F-51083C1716F9', 'b2c_flr_13');

        $currentid= $_GET['rgn_atpidcurrent']?$_GET['rgn_atpidcurrent']:false;
        $this->assign('currentid',$currentid);
        $this->display();
    }
    public function F2c_ceng8F()
    {
        $this->makeRegionCompareChartF('guidB3796831-AAC8-42BF-90E0-4BC0E54B64E5');
//        $this->makeRegionCompareChartF('guid7007AC27-6A45-4C1A-894D-0F41EAC2DF49');
        $this->makeRegionCompareChartF2('guid6B6AB76A-1D0B-481C-AF83-AB3BBE05515F', 'b2c_flr_1');
        $this->makeRegionCompareChartF2('guid25A2379A-668A-49DE-8F8D-46663CEB5E6A', 'b2c_flr_2');
        $this->makeRegionCompareChartF2('guidAE172084-79D5-4112-9970-87B320424B57', 'b2c_flr_3');
        $this->makeRegionCompareChartF2('guid6C23D55A-2A4D-4D71-B2AB-4F29AF987224', 'b2c_flr_4');
        $this->makeRegionCompareChartF2('guid95827E32-A224-4A49-93E4-CA71E365E273', 'b2c_flr_5');
        $this->makeRegionCompareChartF2('guidF46FA1C2-90BD-4AC2-9780-207E7AEF006B', 'b2c_flr_6');
        $this->makeRegionCompareChartF2('guid1E0BB620-A0E9-41ED-AE34-29031826B11D', 'b2c_flr_7');
        $this->makeRegionCompareChartF2('guidB3796831-AAC8-42BF-90E0-4BC0E54B64E5', 'b2c_flr_8');
        $this->makeRegionCompareChartF2('guidA16C8E3C-BB4A-4C68-A864-B003BD85D8FA', 'b2c_flr_9');
        $this->makeRegionCompareChartF2('guidD665B15B-853C-49FA-8D8D-F3ABBDE69DEE', 'b2c_flr_10');
        $this->makeRegionCompareChartF2('guid20A09CAC-F314-43E5-86F3-24A40BFE03E5', 'b2c_flr_11');
        $this->makeRegionCompareChartF2('guidF8ABD205-7DBB-4FB5-BDC3-35E6F5BDA6E1', 'b2c_flr_12');
        $this->makeRegionCompareChartF2('guidA2E8462E-A18B-4FEB-906F-51083C1716F9', 'b2c_flr_13');

        $currentid= $_GET['rgn_atpidcurrent']?$_GET['rgn_atpidcurrent']:false;
        $this->assign('currentid',$currentid);
        $this->display();
    }
    public function F2c_ceng9F()
    {
        $this->makeRegionCompareChartF('guidA16C8E3C-BB4A-4C68-A864-B003BD85D8FA');
//   $this->makeRegionCompareChartF2('guid6B6AB76A-1D0B-481C-AF83-AB3BBE05515F', 'b2c_flr_1');
        $this->makeRegionCompareChartF2('guid25A2379A-668A-49DE-8F8D-46663CEB5E6A', 'b2c_flr_2');
        $this->makeRegionCompareChartF2('guidAE172084-79D5-4112-9970-87B320424B57', 'b2c_flr_3');
        $this->makeRegionCompareChartF2('guid6C23D55A-2A4D-4D71-B2AB-4F29AF987224', 'b2c_flr_4');
        $this->makeRegionCompareChartF2('guid95827E32-A224-4A49-93E4-CA71E365E273', 'b2c_flr_5');
        $this->makeRegionCompareChartF2('guidF46FA1C2-90BD-4AC2-9780-207E7AEF006B', 'b2c_flr_6');
        $this->makeRegionCompareChartF2('guid1E0BB620-A0E9-41ED-AE34-29031826B11D', 'b2c_flr_7');
        $this->makeRegionCompareChartF2('guidB3796831-AAC8-42BF-90E0-4BC0E54B64E5', 'b2c_flr_8');
        $this->makeRegionCompareChartF2('guidA16C8E3C-BB4A-4C68-A864-B003BD85D8FA', 'b2c_flr_9');
        $this->makeRegionCompareChartF2('guidD665B15B-853C-49FA-8D8D-F3ABBDE69DEE', 'b2c_flr_10');
        $this->makeRegionCompareChartF2('guid20A09CAC-F314-43E5-86F3-24A40BFE03E5', 'b2c_flr_11');
        $this->makeRegionCompareChartF2('guidF8ABD205-7DBB-4FB5-BDC3-35E6F5BDA6E1', 'b2c_flr_12');
        $this->makeRegionCompareChartF2('guidA2E8462E-A18B-4FEB-906F-51083C1716F9', 'b2c_flr_13');

        $currentid= $_GET['rgn_atpidcurrent']?$_GET['rgn_atpidcurrent']:false;
        $this->assign('currentid',$currentid);
        $this->display();
    }
    public function F2c_ceng10F()
    {
        $this->makeRegionCompareChartF('guidD665B15B-853C-49FA-8D8D-F3ABBDE69DEE');
//     $this->makeRegionCompareChartF2('guid6B6AB76A-1D0B-481C-AF83-AB3BBE05515F', 'b2c_flr_1');
        $this->makeRegionCompareChartF2('guid25A2379A-668A-49DE-8F8D-46663CEB5E6A', 'b2c_flr_2');
        $this->makeRegionCompareChartF2('guidAE172084-79D5-4112-9970-87B320424B57', 'b2c_flr_3');
        $this->makeRegionCompareChartF2('guid6C23D55A-2A4D-4D71-B2AB-4F29AF987224', 'b2c_flr_4');
        $this->makeRegionCompareChartF2('guid95827E32-A224-4A49-93E4-CA71E365E273', 'b2c_flr_5');
        $this->makeRegionCompareChartF2('guidF46FA1C2-90BD-4AC2-9780-207E7AEF006B', 'b2c_flr_6');
        $this->makeRegionCompareChartF2('guid1E0BB620-A0E9-41ED-AE34-29031826B11D', 'b2c_flr_7');
        $this->makeRegionCompareChartF2('guidB3796831-AAC8-42BF-90E0-4BC0E54B64E5', 'b2c_flr_8');
        $this->makeRegionCompareChartF2('guidA16C8E3C-BB4A-4C68-A864-B003BD85D8FA', 'b2c_flr_9');
        $this->makeRegionCompareChartF2('guidD665B15B-853C-49FA-8D8D-F3ABBDE69DEE', 'b2c_flr_10');
        $this->makeRegionCompareChartF2('guid20A09CAC-F314-43E5-86F3-24A40BFE03E5', 'b2c_flr_11');
        $this->makeRegionCompareChartF2('guidF8ABD205-7DBB-4FB5-BDC3-35E6F5BDA6E1', 'b2c_flr_12');
        $this->makeRegionCompareChartF2('guidA2E8462E-A18B-4FEB-906F-51083C1716F9', 'b2c_flr_13');

        $currentid= $_GET['rgn_atpidcurrent']?$_GET['rgn_atpidcurrent']:false;
        $this->assign('currentid',$currentid);
        $this->display();
    }

    public function F2c_ceng11F()
    {
        $this->makeRegionCompareChartF('guid20A09CAC-F314-43E5-86F3-24A40BFE03E5');
//        $this->makeRegionCompareChartF('guid7007AC27-6A45-4C1A-894D-0F41EAC2DF49');
        $this->makeRegionCompareChartF2('guid6B6AB76A-1D0B-481C-AF83-AB3BBE05515F', 'b2c_flr_1');
        $this->makeRegionCompareChartF2('guid25A2379A-668A-49DE-8F8D-46663CEB5E6A', 'b2c_flr_2');
        $this->makeRegionCompareChartF2('guidAE172084-79D5-4112-9970-87B320424B57', 'b2c_flr_3');
        $this->makeRegionCompareChartF2('guid6C23D55A-2A4D-4D71-B2AB-4F29AF987224', 'b2c_flr_4');
        $this->makeRegionCompareChartF2('guid95827E32-A224-4A49-93E4-CA71E365E273', 'b2c_flr_5');
        $this->makeRegionCompareChartF2('guidF46FA1C2-90BD-4AC2-9780-207E7AEF006B', 'b2c_flr_6');
        $this->makeRegionCompareChartF2('guid1E0BB620-A0E9-41ED-AE34-29031826B11D', 'b2c_flr_7');
        $this->makeRegionCompareChartF2('guidB3796831-AAC8-42BF-90E0-4BC0E54B64E5', 'b2c_flr_8');
        $this->makeRegionCompareChartF2('guidA16C8E3C-BB4A-4C68-A864-B003BD85D8FA', 'b2c_flr_9');
        $this->makeRegionCompareChartF2('guidD665B15B-853C-49FA-8D8D-F3ABBDE69DEE', 'b2c_flr_10');
        $this->makeRegionCompareChartF2('guid20A09CAC-F314-43E5-86F3-24A40BFE03E5', 'b2c_flr_11');
        $this->makeRegionCompareChartF2('guidF8ABD205-7DBB-4FB5-BDC3-35E6F5BDA6E1', 'b2c_flr_12');
        $this->makeRegionCompareChartF2('guidA2E8462E-A18B-4FEB-906F-51083C1716F9', 'b2c_flr_13');

        $currentid= $_GET['rgn_atpidcurrent']?$_GET['rgn_atpidcurrent']:false;
        $this->assign('currentid',$currentid);
        $this->display();
    }

    public function F2c_ceng12F()
    {
        $this->makeRegionCompareChartF('guidF8ABD205-7DBB-4FB5-BDC3-35E6F5BDA6E1');
//        $this->makeRegionCompareChartF('guid7007AC27-6A45-4C1A-894D-0F41EAC2DF49');
        $this->makeRegionCompareChartF2('guid6B6AB76A-1D0B-481C-AF83-AB3BBE05515F', 'b2c_flr_1');
        $this->makeRegionCompareChartF2('guid25A2379A-668A-49DE-8F8D-46663CEB5E6A', 'b2c_flr_2');
        $this->makeRegionCompareChartF2('guidAE172084-79D5-4112-9970-87B320424B57', 'b2c_flr_3');
        $this->makeRegionCompareChartF2('guid6C23D55A-2A4D-4D71-B2AB-4F29AF987224', 'b2c_flr_4');
        $this->makeRegionCompareChartF2('guid95827E32-A224-4A49-93E4-CA71E365E273', 'b2c_flr_5');
        $this->makeRegionCompareChartF2('guidF46FA1C2-90BD-4AC2-9780-207E7AEF006B', 'b2c_flr_6');
        $this->makeRegionCompareChartF2('guid1E0BB620-A0E9-41ED-AE34-29031826B11D', 'b2c_flr_7');
        $this->makeRegionCompareChartF2('guidB3796831-AAC8-42BF-90E0-4BC0E54B64E5', 'b2c_flr_8');
        $this->makeRegionCompareChartF2('guidA16C8E3C-BB4A-4C68-A864-B003BD85D8FA', 'b2c_flr_9');
        $this->makeRegionCompareChartF2('guidD665B15B-853C-49FA-8D8D-F3ABBDE69DEE', 'b2c_flr_10');
        $this->makeRegionCompareChartF2('guid20A09CAC-F314-43E5-86F3-24A40BFE03E5', 'b2c_flr_11');
        $this->makeRegionCompareChartF2('guidF8ABD205-7DBB-4FB5-BDC3-35E6F5BDA6E1', 'b2c_flr_12');
        $this->makeRegionCompareChartF2('guidA2E8462E-A18B-4FEB-906F-51083C1716F9', 'b2c_flr_13');

        $currentid= $_GET['rgn_atpidcurrent']?$_GET['rgn_atpidcurrent']:false;
        $this->assign('currentid',$currentid);
        $this->display();
    }

    public function F2c_ceng13F()
    {
        $this->makeRegionCompareChartF('guidA2E8462E-A18B-4FEB-906F-51083C1716F9');
//    $this->makeRegionCompareChartF2('guid6B6AB76A-1D0B-481C-AF83-AB3BBE05515F', 'b2c_flr_1');
        $this->makeRegionCompareChartF2('guid25A2379A-668A-49DE-8F8D-46663CEB5E6A', 'b2c_flr_2');
        $this->makeRegionCompareChartF2('guidAE172084-79D5-4112-9970-87B320424B57', 'b2c_flr_3');
        $this->makeRegionCompareChartF2('guid6C23D55A-2A4D-4D71-B2AB-4F29AF987224', 'b2c_flr_4');
        $this->makeRegionCompareChartF2('guid95827E32-A224-4A49-93E4-CA71E365E273', 'b2c_flr_5');
        $this->makeRegionCompareChartF2('guidF46FA1C2-90BD-4AC2-9780-207E7AEF006B', 'b2c_flr_6');
        $this->makeRegionCompareChartF2('guid1E0BB620-A0E9-41ED-AE34-29031826B11D', 'b2c_flr_7');
        $this->makeRegionCompareChartF2('guidB3796831-AAC8-42BF-90E0-4BC0E54B64E5', 'b2c_flr_8');
        $this->makeRegionCompareChartF2('guidA16C8E3C-BB4A-4C68-A864-B003BD85D8FA', 'b2c_flr_9');
        $this->makeRegionCompareChartF2('guidD665B15B-853C-49FA-8D8D-F3ABBDE69DEE', 'b2c_flr_10');
        $this->makeRegionCompareChartF2('guid20A09CAC-F314-43E5-86F3-24A40BFE03E5', 'b2c_flr_11');
        $this->makeRegionCompareChartF2('guidF8ABD205-7DBB-4FB5-BDC3-35E6F5BDA6E1', 'b2c_flr_12');
        $this->makeRegionCompareChartF2('guidA2E8462E-A18B-4FEB-906F-51083C1716F9', 'b2c_flr_13');

        $currentid= $_GET['rgn_atpidcurrent']?$_GET['rgn_atpidcurrent']:false;
        $this->assign('currentid',$currentid);
        $this->display();
    }

    //2d

    public function F2d_ceng1F()
    {
        $this->makeRegionCompareChartF('guidD471BC27-85B0-4E38-A408-B9AFE6DB267C');
//        $this->makeRegionCompareChartF('guid7007AC27-6A45-4C1A-894D-0F41EAC2DF49');
        $this->makeRegionCompareChartF2('guidD471BC27-85B0-4E38-A408-B9AFE6DB267C', 'b2d_flr_1');
        $this->makeRegionCompareChartF2('guid6CDB325F-458A-4E4E-ABF6-BAEEBC116273', 'b2d_flr_2');
        $this->makeRegionCompareChartF2('guidA3C107AF-AB84-432E-A5D7-ECF4547B7F46', 'b2d_flr_3');
        $this->makeRegionCompareChartF2('guidB5A029FD-E7E3-44C3-815A-31C728238F01', 'b2d_flr_4');
        $this->makeRegionCompareChartF2('guid22DA729D-A282-4ADF-A6D3-C5B823855569', 'b2d_flr_5');
        $this->makeRegionCompareChartF2('guidF62A9B01-DC6B-46C8-8C2A-3F325A92AD53', 'b2d_flr_6');
        $this->makeRegionCompareChartF2('guid0B52D431-23C3-4916-B5A0-6CA3986294D3', 'b2d_flr_7');
        $this->makeRegionCompareChartF2('guid7D97D89E-8649-4162-8469-9C6F1ADA9BF1', 'b2d_flr_8');
        $this->makeRegionCompareChartF2('guid84D6D793-7AC6-40BB-ACFC-FB6B7680B9DB', 'b2d_flr_9');
        $this->makeRegionCompareChartF2('guidD7CEAC81-5E4A-4A3A-9C50-4D377A5082BD', 'b2d_flr_10');
        $this->makeRegionCompareChartF2('guidB0C345F6-B146-4BF5-9CCD-914747E4A966', 'b2d_flr_11');
        $this->makeRegionCompareChartF2('guidBAB98582-C86E-49D0-B23D-57B04F0F058B', 'b2d_flr_12');
        $this->makeRegionCompareChartF2('guid3F2D1714-FF0E-4BB7-9160-FA06C93A53E2', 'b2d_flr_13');

        $currentid= $_GET['rgn_atpidcurrent']?$_GET['rgn_atpidcurrent']:false;
        $this->assign('currentid',$currentid);
        $this->display();
    }
    public function F2d_ceng2F()
    {
        $this->makeRegionCompareChartF('guid6CDB325F-458A-4E4E-ABF6-BAEEBC116273');
//        $this->makeRegionCompareChartF('guid7007AC27-6A45-4C1A-894D-0F41EAC2DF49');
        $this->makeRegionCompareChartF2('guidD471BC27-85B0-4E38-A408-B9AFE6DB267C', 'b2d_flr_1');
        $this->makeRegionCompareChartF2('guid6CDB325F-458A-4E4E-ABF6-BAEEBC116273', 'b2d_flr_2');
        $this->makeRegionCompareChartF2('guidA3C107AF-AB84-432E-A5D7-ECF4547B7F46', 'b2d_flr_3');
        $this->makeRegionCompareChartF2('guidB5A029FD-E7E3-44C3-815A-31C728238F01', 'b2d_flr_4');
        $this->makeRegionCompareChartF2('guid22DA729D-A282-4ADF-A6D3-C5B823855569', 'b2d_flr_5');
        $this->makeRegionCompareChartF2('guidF62A9B01-DC6B-46C8-8C2A-3F325A92AD53', 'b2d_flr_6');
        $this->makeRegionCompareChartF2('guid0B52D431-23C3-4916-B5A0-6CA3986294D3', 'b2d_flr_7');
        $this->makeRegionCompareChartF2('guid7D97D89E-8649-4162-8469-9C6F1ADA9BF1', 'b2d_flr_8');
        $this->makeRegionCompareChartF2('guid84D6D793-7AC6-40BB-ACFC-FB6B7680B9DB', 'b2d_flr_9');
        $this->makeRegionCompareChartF2('guidD7CEAC81-5E4A-4A3A-9C50-4D377A5082BD', 'b2d_flr_10');
        $this->makeRegionCompareChartF2('guidB0C345F6-B146-4BF5-9CCD-914747E4A966', 'b2d_flr_11');
        $this->makeRegionCompareChartF2('guidBAB98582-C86E-49D0-B23D-57B04F0F058B', 'b2d_flr_12');
        $this->makeRegionCompareChartF2('guid3F2D1714-FF0E-4BB7-9160-FA06C93A53E2', 'b2d_flr_13');

        $currentid= $_GET['rgn_atpidcurrent']?$_GET['rgn_atpidcurrent']:false;
        $this->assign('currentid',$currentid);
        $this->display();
    }
    public function F2d_ceng3F()
    {
        $this->makeRegionCompareChartF('guidA3C107AF-AB84-432E-A5D7-ECF4547B7F46');
//        $this->makeRegionCompareChartF('guid7007AC27-6A45-4C1A-894D-0F41EAC2DF49');
        $this->makeRegionCompareChartF2('guidD471BC27-85B0-4E38-A408-B9AFE6DB267C', 'b2d_flr_1');
        $this->makeRegionCompareChartF2('guid6CDB325F-458A-4E4E-ABF6-BAEEBC116273', 'b2d_flr_2');
        $this->makeRegionCompareChartF2('guidA3C107AF-AB84-432E-A5D7-ECF4547B7F46', 'b2d_flr_3');
        $this->makeRegionCompareChartF2('guidB5A029FD-E7E3-44C3-815A-31C728238F01', 'b2d_flr_4');
        $this->makeRegionCompareChartF2('guid22DA729D-A282-4ADF-A6D3-C5B823855569', 'b2d_flr_5');
        $this->makeRegionCompareChartF2('guidF62A9B01-DC6B-46C8-8C2A-3F325A92AD53', 'b2d_flr_6');
        $this->makeRegionCompareChartF2('guid0B52D431-23C3-4916-B5A0-6CA3986294D3', 'b2d_flr_7');
        $this->makeRegionCompareChartF2('guid7D97D89E-8649-4162-8469-9C6F1ADA9BF1', 'b2d_flr_8');
        $this->makeRegionCompareChartF2('guid84D6D793-7AC6-40BB-ACFC-FB6B7680B9DB', 'b2d_flr_9');
        $this->makeRegionCompareChartF2('guidD7CEAC81-5E4A-4A3A-9C50-4D377A5082BD', 'b2d_flr_10');
        $this->makeRegionCompareChartF2('guidB0C345F6-B146-4BF5-9CCD-914747E4A966', 'b2d_flr_11');
        $this->makeRegionCompareChartF2('guidBAB98582-C86E-49D0-B23D-57B04F0F058B', 'b2d_flr_12');
        $this->makeRegionCompareChartF2('guid3F2D1714-FF0E-4BB7-9160-FA06C93A53E2', 'b2d_flr_13');

        $currentid= $_GET['rgn_atpidcurrent']?$_GET['rgn_atpidcurrent']:false;
        $this->assign('currentid',$currentid);
        $this->display();
    }
    public function F2d_ceng4F()
    {
        $this->makeRegionCompareChartF('guidB5A029FD-E7E3-44C3-815A-31C728238F01');
//        $this->makeRegionCompareChartF('guid7007AC27-6A45-4C1A-894D-0F41EAC2DF49');
        $this->makeRegionCompareChartF2('guidD471BC27-85B0-4E38-A408-B9AFE6DB267C', 'b2d_flr_1');
        $this->makeRegionCompareChartF2('guid6CDB325F-458A-4E4E-ABF6-BAEEBC116273', 'b2d_flr_2');
        $this->makeRegionCompareChartF2('guidA3C107AF-AB84-432E-A5D7-ECF4547B7F46', 'b2d_flr_3');
        $this->makeRegionCompareChartF2('guidB5A029FD-E7E3-44C3-815A-31C728238F01', 'b2d_flr_4');
        $this->makeRegionCompareChartF2('guid22DA729D-A282-4ADF-A6D3-C5B823855569', 'b2d_flr_5');
        $this->makeRegionCompareChartF2('guidF62A9B01-DC6B-46C8-8C2A-3F325A92AD53', 'b2d_flr_6');
        $this->makeRegionCompareChartF2('guid0B52D431-23C3-4916-B5A0-6CA3986294D3', 'b2d_flr_7');
        $this->makeRegionCompareChartF2('guid7D97D89E-8649-4162-8469-9C6F1ADA9BF1', 'b2d_flr_8');
        $this->makeRegionCompareChartF2('guid84D6D793-7AC6-40BB-ACFC-FB6B7680B9DB', 'b2d_flr_9');
        $this->makeRegionCompareChartF2('guidD7CEAC81-5E4A-4A3A-9C50-4D377A5082BD', 'b2d_flr_10');
        $this->makeRegionCompareChartF2('guidB0C345F6-B146-4BF5-9CCD-914747E4A966', 'b2d_flr_11');
        $this->makeRegionCompareChartF2('guidBAB98582-C86E-49D0-B23D-57B04F0F058B', 'b2d_flr_12');
        $this->makeRegionCompareChartF2('guid3F2D1714-FF0E-4BB7-9160-FA06C93A53E2', 'b2d_flr_13');

        $currentid= $_GET['rgn_atpidcurrent']?$_GET['rgn_atpidcurrent']:false;
        $this->assign('currentid',$currentid);
        $this->display();
    }
    public function F2d_ceng5F()
    {
        $this->makeRegionCompareChartF('guid22DA729D-A282-4ADF-A6D3-C5B823855569');
//     $this->makeRegionCompareChartF2('guidFB65B509-0008-4F0A-9B10-C86C06858351', 'b2b_flr_1');
        $this->makeRegionCompareChartF2('guidD471BC27-85B0-4E38-A408-B9AFE6DB267C', 'b2d_flr_1');
        $this->makeRegionCompareChartF2('guid6CDB325F-458A-4E4E-ABF6-BAEEBC116273', 'b2d_flr_2');
        $this->makeRegionCompareChartF2('guidA3C107AF-AB84-432E-A5D7-ECF4547B7F46', 'b2d_flr_3');
        $this->makeRegionCompareChartF2('guidB5A029FD-E7E3-44C3-815A-31C728238F01', 'b2d_flr_4');
        $this->makeRegionCompareChartF2('guid22DA729D-A282-4ADF-A6D3-C5B823855569', 'b2d_flr_5');
        $this->makeRegionCompareChartF2('guidF62A9B01-DC6B-46C8-8C2A-3F325A92AD53', 'b2d_flr_6');
        $this->makeRegionCompareChartF2('guid0B52D431-23C3-4916-B5A0-6CA3986294D3', 'b2d_flr_7');
        $this->makeRegionCompareChartF2('guid7D97D89E-8649-4162-8469-9C6F1ADA9BF1', 'b2d_flr_8');
        $this->makeRegionCompareChartF2('guid84D6D793-7AC6-40BB-ACFC-FB6B7680B9DB', 'b2d_flr_9');
        $this->makeRegionCompareChartF2('guidD7CEAC81-5E4A-4A3A-9C50-4D377A5082BD', 'b2d_flr_10');
        $this->makeRegionCompareChartF2('guidB0C345F6-B146-4BF5-9CCD-914747E4A966', 'b2d_flr_11');
        $this->makeRegionCompareChartF2('guidBAB98582-C86E-49D0-B23D-57B04F0F058B', 'b2d_flr_12');
        $this->makeRegionCompareChartF2('guid3F2D1714-FF0E-4BB7-9160-FA06C93A53E2', 'b2d_flr_13');

        $currentid= $_GET['rgn_atpidcurrent']?$_GET['rgn_atpidcurrent']:false;
        $this->assign('currentid',$currentid);
        $this->display();
    }
    public function F2d_ceng6F()
    {
        $this->makeRegionCompareChartF('guidF62A9B01-DC6B-46C8-8C2A-3F325A92AD53');
//        $this->makeRegionCompareChartF('guid7007AC27-6A45-4C1A-894D-0F41EAC2DF49');
        $this->makeRegionCompareChartF2('guidD471BC27-85B0-4E38-A408-B9AFE6DB267C', 'b2d_flr_1');
        $this->makeRegionCompareChartF2('guid6CDB325F-458A-4E4E-ABF6-BAEEBC116273', 'b2d_flr_2');
        $this->makeRegionCompareChartF2('guidA3C107AF-AB84-432E-A5D7-ECF4547B7F46', 'b2d_flr_3');
        $this->makeRegionCompareChartF2('guidB5A029FD-E7E3-44C3-815A-31C728238F01', 'b2d_flr_4');
        $this->makeRegionCompareChartF2('guid22DA729D-A282-4ADF-A6D3-C5B823855569', 'b2d_flr_5');
        $this->makeRegionCompareChartF2('guidF62A9B01-DC6B-46C8-8C2A-3F325A92AD53', 'b2d_flr_6');
        $this->makeRegionCompareChartF2('guid0B52D431-23C3-4916-B5A0-6CA3986294D3', 'b2d_flr_7');
        $this->makeRegionCompareChartF2('guid7D97D89E-8649-4162-8469-9C6F1ADA9BF1', 'b2d_flr_8');
        $this->makeRegionCompareChartF2('guid84D6D793-7AC6-40BB-ACFC-FB6B7680B9DB', 'b2d_flr_9');
        $this->makeRegionCompareChartF2('guidD7CEAC81-5E4A-4A3A-9C50-4D377A5082BD', 'b2d_flr_10');
        $this->makeRegionCompareChartF2('guidB0C345F6-B146-4BF5-9CCD-914747E4A966', 'b2d_flr_11');
        $this->makeRegionCompareChartF2('guidBAB98582-C86E-49D0-B23D-57B04F0F058B', 'b2d_flr_12');
        $this->makeRegionCompareChartF2('guid3F2D1714-FF0E-4BB7-9160-FA06C93A53E2', 'b2d_flr_13');

        $currentid= $_GET['rgn_atpidcurrent']?$_GET['rgn_atpidcurrent']:false;
        $this->assign('currentid',$currentid);
        $this->display();
    }
    public function F2d_ceng7F()
    {
        $this->makeRegionCompareChartF('guid0B52D431-23C3-4916-B5A0-6CA3986294D3');
// $this->makeRegionCompareChartF2('guidD471BC27-85B0-4E38-A408-B9AFE6DB267C', 'b2d_flr_1');
        $this->makeRegionCompareChartF2('guid6CDB325F-458A-4E4E-ABF6-BAEEBC116273', 'b2d_flr_2');
        $this->makeRegionCompareChartF2('guidA3C107AF-AB84-432E-A5D7-ECF4547B7F46', 'b2d_flr_3');
        $this->makeRegionCompareChartF2('guidB5A029FD-E7E3-44C3-815A-31C728238F01', 'b2d_flr_4');
        $this->makeRegionCompareChartF2('guid22DA729D-A282-4ADF-A6D3-C5B823855569', 'b2d_flr_5');
        $this->makeRegionCompareChartF2('guidF62A9B01-DC6B-46C8-8C2A-3F325A92AD53', 'b2d_flr_6');
        $this->makeRegionCompareChartF2('guid0B52D431-23C3-4916-B5A0-6CA3986294D3', 'b2d_flr_7');
        $this->makeRegionCompareChartF2('guid7D97D89E-8649-4162-8469-9C6F1ADA9BF1', 'b2d_flr_8');
        $this->makeRegionCompareChartF2('guid84D6D793-7AC6-40BB-ACFC-FB6B7680B9DB', 'b2d_flr_9');
        $this->makeRegionCompareChartF2('guidD7CEAC81-5E4A-4A3A-9C50-4D377A5082BD', 'b2d_flr_10');
        $this->makeRegionCompareChartF2('guidB0C345F6-B146-4BF5-9CCD-914747E4A966', 'b2d_flr_11');
        $this->makeRegionCompareChartF2('guidBAB98582-C86E-49D0-B23D-57B04F0F058B', 'b2d_flr_12');
        $this->makeRegionCompareChartF2('guid3F2D1714-FF0E-4BB7-9160-FA06C93A53E2', 'b2d_flr_13');

        $currentid= $_GET['rgn_atpidcurrent']?$_GET['rgn_atpidcurrent']:false;
        $this->assign('currentid',$currentid);
        $this->display();
    }
    public function F2d_ceng8F()
    {
        $this->makeRegionCompareChartF('guid7D97D89E-8649-4162-8469-9C6F1ADA9BF1');
//        $this->makeRegionCompareChartF('guid7007AC27-6A45-4C1A-894D-0F41EAC2DF49');
        $this->makeRegionCompareChartF2('guidD471BC27-85B0-4E38-A408-B9AFE6DB267C', 'b2d_flr_1');
        $this->makeRegionCompareChartF2('guid6CDB325F-458A-4E4E-ABF6-BAEEBC116273', 'b2d_flr_2');
        $this->makeRegionCompareChartF2('guidA3C107AF-AB84-432E-A5D7-ECF4547B7F46', 'b2d_flr_3');
        $this->makeRegionCompareChartF2('guidB5A029FD-E7E3-44C3-815A-31C728238F01', 'b2d_flr_4');
        $this->makeRegionCompareChartF2('guid22DA729D-A282-4ADF-A6D3-C5B823855569', 'b2d_flr_5');
        $this->makeRegionCompareChartF2('guidF62A9B01-DC6B-46C8-8C2A-3F325A92AD53', 'b2d_flr_6');
        $this->makeRegionCompareChartF2('guid0B52D431-23C3-4916-B5A0-6CA3986294D3', 'b2d_flr_7');
        $this->makeRegionCompareChartF2('guid7D97D89E-8649-4162-8469-9C6F1ADA9BF1', 'b2d_flr_8');
        $this->makeRegionCompareChartF2('guid84D6D793-7AC6-40BB-ACFC-FB6B7680B9DB', 'b2d_flr_9');
        $this->makeRegionCompareChartF2('guidD7CEAC81-5E4A-4A3A-9C50-4D377A5082BD', 'b2d_flr_10');
        $this->makeRegionCompareChartF2('guidB0C345F6-B146-4BF5-9CCD-914747E4A966', 'b2d_flr_11');
        $this->makeRegionCompareChartF2('guidBAB98582-C86E-49D0-B23D-57B04F0F058B', 'b2d_flr_12');
        $this->makeRegionCompareChartF2('guid3F2D1714-FF0E-4BB7-9160-FA06C93A53E2', 'b2d_flr_13');

        $currentid= $_GET['rgn_atpidcurrent']?$_GET['rgn_atpidcurrent']:false;
        $this->assign('currentid',$currentid);
        $this->display();
    }
    public function F2d_ceng9F()
    {
        $this->makeRegionCompareChartF('guid84D6D793-7AC6-40BB-ACFC-FB6B7680B9DB');
//   $this->makeRegionCompareChartF2('guid6B6AB76A-1D0B-481C-AF83-AB3BBE05515F', 'b2c_flr_1');
        $this->makeRegionCompareChartF2('guidD471BC27-85B0-4E38-A408-B9AFE6DB267C', 'b2d_flr_1');
        $this->makeRegionCompareChartF2('guid6CDB325F-458A-4E4E-ABF6-BAEEBC116273', 'b2d_flr_2');
        $this->makeRegionCompareChartF2('guidA3C107AF-AB84-432E-A5D7-ECF4547B7F46', 'b2d_flr_3');
        $this->makeRegionCompareChartF2('guidB5A029FD-E7E3-44C3-815A-31C728238F01', 'b2d_flr_4');
        $this->makeRegionCompareChartF2('guid22DA729D-A282-4ADF-A6D3-C5B823855569', 'b2d_flr_5');
        $this->makeRegionCompareChartF2('guidF62A9B01-DC6B-46C8-8C2A-3F325A92AD53', 'b2d_flr_6');
        $this->makeRegionCompareChartF2('guid0B52D431-23C3-4916-B5A0-6CA3986294D3', 'b2d_flr_7');
        $this->makeRegionCompareChartF2('guid7D97D89E-8649-4162-8469-9C6F1ADA9BF1', 'b2d_flr_8');
        $this->makeRegionCompareChartF2('guid84D6D793-7AC6-40BB-ACFC-FB6B7680B9DB', 'b2d_flr_9');
        $this->makeRegionCompareChartF2('guidD7CEAC81-5E4A-4A3A-9C50-4D377A5082BD', 'b2d_flr_10');
        $this->makeRegionCompareChartF2('guidB0C345F6-B146-4BF5-9CCD-914747E4A966', 'b2d_flr_11');
        $this->makeRegionCompareChartF2('guidBAB98582-C86E-49D0-B23D-57B04F0F058B', 'b2d_flr_12');
        $this->makeRegionCompareChartF2('guid3F2D1714-FF0E-4BB7-9160-FA06C93A53E2', 'b2d_flr_13');

        $currentid= $_GET['rgn_atpidcurrent']?$_GET['rgn_atpidcurrent']:false;
        $this->assign('currentid',$currentid);
        $this->display();
    }
    public function F2d_ceng10F()
    {
        $this->makeRegionCompareChartF('guidD7CEAC81-5E4A-4A3A-9C50-4D377A5082BD');
//     $this->makeRegionCompareChartF2('guid6B6AB76A-1D0B-481C-AF83-AB3BBE05515F', 'b2c_flr_1');
        $this->makeRegionCompareChartF2('guidD471BC27-85B0-4E38-A408-B9AFE6DB267C', 'b2d_flr_1');
        $this->makeRegionCompareChartF2('guid6CDB325F-458A-4E4E-ABF6-BAEEBC116273', 'b2d_flr_2');
        $this->makeRegionCompareChartF2('guidA3C107AF-AB84-432E-A5D7-ECF4547B7F46', 'b2d_flr_3');
        $this->makeRegionCompareChartF2('guidB5A029FD-E7E3-44C3-815A-31C728238F01', 'b2d_flr_4');
        $this->makeRegionCompareChartF2('guid22DA729D-A282-4ADF-A6D3-C5B823855569', 'b2d_flr_5');
        $this->makeRegionCompareChartF2('guidF62A9B01-DC6B-46C8-8C2A-3F325A92AD53', 'b2d_flr_6');
        $this->makeRegionCompareChartF2('guid0B52D431-23C3-4916-B5A0-6CA3986294D3', 'b2d_flr_7');
        $this->makeRegionCompareChartF2('guid7D97D89E-8649-4162-8469-9C6F1ADA9BF1', 'b2d_flr_8');
        $this->makeRegionCompareChartF2('guid84D6D793-7AC6-40BB-ACFC-FB6B7680B9DB', 'b2d_flr_9');
        $this->makeRegionCompareChartF2('guidD7CEAC81-5E4A-4A3A-9C50-4D377A5082BD', 'b2d_flr_10');
        $this->makeRegionCompareChartF2('guidB0C345F6-B146-4BF5-9CCD-914747E4A966', 'b2d_flr_11');
        $this->makeRegionCompareChartF2('guidBAB98582-C86E-49D0-B23D-57B04F0F058B', 'b2d_flr_12');
        $this->makeRegionCompareChartF2('guid3F2D1714-FF0E-4BB7-9160-FA06C93A53E2', 'b2d_flr_13');

        $currentid= $_GET['rgn_atpidcurrent']?$_GET['rgn_atpidcurrent']:false;
        $this->assign('currentid',$currentid);
        $this->display();
    }

    public function F2d_ceng11F()
    {
        $this->makeRegionCompareChartF('guidB0C345F6-B146-4BF5-9CCD-914747E4A966');
//        $this->makeRegionCompareChartF('guid7007AC27-6A45-4C1A-894D-0F41EAC2DF49');
        $this->makeRegionCompareChartF2('guidD471BC27-85B0-4E38-A408-B9AFE6DB267C', 'b2d_flr_1');
        $this->makeRegionCompareChartF2('guid6CDB325F-458A-4E4E-ABF6-BAEEBC116273', 'b2d_flr_2');
        $this->makeRegionCompareChartF2('guidA3C107AF-AB84-432E-A5D7-ECF4547B7F46', 'b2d_flr_3');
        $this->makeRegionCompareChartF2('guidB5A029FD-E7E3-44C3-815A-31C728238F01', 'b2d_flr_4');
        $this->makeRegionCompareChartF2('guid22DA729D-A282-4ADF-A6D3-C5B823855569', 'b2d_flr_5');
        $this->makeRegionCompareChartF2('guidF62A9B01-DC6B-46C8-8C2A-3F325A92AD53', 'b2d_flr_6');
        $this->makeRegionCompareChartF2('guid0B52D431-23C3-4916-B5A0-6CA3986294D3', 'b2d_flr_7');
        $this->makeRegionCompareChartF2('guid7D97D89E-8649-4162-8469-9C6F1ADA9BF1', 'b2d_flr_8');
        $this->makeRegionCompareChartF2('guid84D6D793-7AC6-40BB-ACFC-FB6B7680B9DB', 'b2d_flr_9');
        $this->makeRegionCompareChartF2('guidD7CEAC81-5E4A-4A3A-9C50-4D377A5082BD', 'b2d_flr_10');
        $this->makeRegionCompareChartF2('guidB0C345F6-B146-4BF5-9CCD-914747E4A966', 'b2d_flr_11');
        $this->makeRegionCompareChartF2('guidBAB98582-C86E-49D0-B23D-57B04F0F058B', 'b2d_flr_12');
        $this->makeRegionCompareChartF2('guid3F2D1714-FF0E-4BB7-9160-FA06C93A53E2', 'b2d_flr_13');

        $currentid= $_GET['rgn_atpidcurrent']?$_GET['rgn_atpidcurrent']:false;
        $this->assign('currentid',$currentid);
        $this->display();
    }

    public function F2d_ceng12F()
    {
        $this->makeRegionCompareChartF('guidBAB98582-C86E-49D0-B23D-57B04F0F058B');
//        $this->makeRegionCompareChartF('guid7007AC27-6A45-4C1A-894D-0F41EAC2DF49');
        $this->makeRegionCompareChartF2('guidD471BC27-85B0-4E38-A408-B9AFE6DB267C', 'b2d_flr_1');
        $this->makeRegionCompareChartF2('guid6CDB325F-458A-4E4E-ABF6-BAEEBC116273', 'b2d_flr_2');
        $this->makeRegionCompareChartF2('guidA3C107AF-AB84-432E-A5D7-ECF4547B7F46', 'b2d_flr_3');
        $this->makeRegionCompareChartF2('guidB5A029FD-E7E3-44C3-815A-31C728238F01', 'b2d_flr_4');
        $this->makeRegionCompareChartF2('guid22DA729D-A282-4ADF-A6D3-C5B823855569', 'b2d_flr_5');
        $this->makeRegionCompareChartF2('guidF62A9B01-DC6B-46C8-8C2A-3F325A92AD53', 'b2d_flr_6');
        $this->makeRegionCompareChartF2('guid0B52D431-23C3-4916-B5A0-6CA3986294D3', 'b2d_flr_7');
        $this->makeRegionCompareChartF2('guid7D97D89E-8649-4162-8469-9C6F1ADA9BF1', 'b2d_flr_8');
        $this->makeRegionCompareChartF2('guid84D6D793-7AC6-40BB-ACFC-FB6B7680B9DB', 'b2d_flr_9');
        $this->makeRegionCompareChartF2('guidD7CEAC81-5E4A-4A3A-9C50-4D377A5082BD', 'b2d_flr_10');
        $this->makeRegionCompareChartF2('guidB0C345F6-B146-4BF5-9CCD-914747E4A966', 'b2d_flr_11');
        $this->makeRegionCompareChartF2('guidBAB98582-C86E-49D0-B23D-57B04F0F058B', 'b2d_flr_12');
        $this->makeRegionCompareChartF2('guid3F2D1714-FF0E-4BB7-9160-FA06C93A53E2', 'b2d_flr_13');

        $currentid= $_GET['rgn_atpidcurrent']?$_GET['rgn_atpidcurrent']:false;
        $this->assign('currentid',$currentid);
        $this->display();
    }

    public function F2d_ceng13F()
    {
        $this->makeRegionCompareChartF('guid3F2D1714-FF0E-4BB7-9160-FA06C93A53E2');
//    $this->makeRegionCompareChartF2('guid6B6AB76A-1D0B-481C-AF83-AB3BBE05515F', 'b2c_flr_1');
        $this->makeRegionCompareChartF2('guidD471BC27-85B0-4E38-A408-B9AFE6DB267C', 'b2d_flr_1');
        $this->makeRegionCompareChartF2('guid6CDB325F-458A-4E4E-ABF6-BAEEBC116273', 'b2d_flr_2');
        $this->makeRegionCompareChartF2('guidA3C107AF-AB84-432E-A5D7-ECF4547B7F46', 'b2d_flr_3');
        $this->makeRegionCompareChartF2('guidB5A029FD-E7E3-44C3-815A-31C728238F01', 'b2d_flr_4');
        $this->makeRegionCompareChartF2('guid22DA729D-A282-4ADF-A6D3-C5B823855569', 'b2d_flr_5');
        $this->makeRegionCompareChartF2('guidF62A9B01-DC6B-46C8-8C2A-3F325A92AD53', 'b2d_flr_6');
        $this->makeRegionCompareChartF2('guid0B52D431-23C3-4916-B5A0-6CA3986294D3', 'b2d_flr_7');
        $this->makeRegionCompareChartF2('guid7D97D89E-8649-4162-8469-9C6F1ADA9BF1', 'b2d_flr_8');
        $this->makeRegionCompareChartF2('guid84D6D793-7AC6-40BB-ACFC-FB6B7680B9DB', 'b2d_flr_9');
        $this->makeRegionCompareChartF2('guidD7CEAC81-5E4A-4A3A-9C50-4D377A5082BD', 'b2d_flr_10');
        $this->makeRegionCompareChartF2('guidB0C345F6-B146-4BF5-9CCD-914747E4A966', 'b2d_flr_11');
        $this->makeRegionCompareChartF2('guidBAB98582-C86E-49D0-B23D-57B04F0F058B', 'b2d_flr_12');
        $this->makeRegionCompareChartF2('guid3F2D1714-FF0E-4BB7-9160-FA06C93A53E2', 'b2d_flr_13');

        $currentid= $_GET['rgn_atpidcurrent']?$_GET['rgn_atpidcurrent']:false;
        $this->assign('currentid',$currentid);
        $this->display();
    }


    //2e
    public function F2e_ceng1F()
    {
        $this->makeRegionCompareChartF('guid7D32802D-9E7F-4CAF-B013-8BB8B09BC533');
//        $this->makeRegionCompareChartF('guid7007AC27-6A45-4C1A-894D-0F41EAC2DF49');
        $this->makeRegionCompareChartF2('guid7D32802D-9E7F-4CAF-B013-8BB8B09BC533', 'b2e_flr_1');
        $this->makeRegionCompareChartF2('guid3841830D-7446-4B51-95D8-EA2B800814C3', 'b2e_flr_2');
        $this->makeRegionCompareChartF2('guid6C753E02-7E22-44DD-8F18-B5E8CAC09452', 'b2e_flr_3');
        $this->makeRegionCompareChartF2('guidD51DE0FF-93DA-4404-9840-78DCF7566BC8', 'b2e_flr_4');
        $this->makeRegionCompareChartF2('guidB55EA1DA-A837-4DFF-928A-825BE13D2648', 'b2e_flr_5');
        $this->makeRegionCompareChartF2('guidD541E8BA-BACB-4D14-B1B3-DF41EAB3F5A7', 'b2e_flr_6');
        $this->makeRegionCompareChartF2('guid14EFCE4C-CB65-4222-A37E-B698BD4CD0DF', 'b2e_flr_7');
        $this->makeRegionCompareChartF2('guid0612E0B4-14CC-4437-A149-E35C02759A74', 'b2e_flr_8');
        $this->makeRegionCompareChartF2('guid4D51AF8A-EAD1-4A61-9670-BDEFFDB1A093', 'b2e_flr_9');
        $this->makeRegionCompareChartF2('guidBDF4F680-AF9F-4072-B120-1464DABE0E7B', 'b2e_flr_10');
        $currentid= $_GET['rgn_atpidcurrent']?$_GET['rgn_atpidcurrent']:false;
        $this->assign('currentid',$currentid);
        $this->display();
    }
    public function F2e_ceng2F()
    {
        $this->makeRegionCompareChartF('guid3841830D-7446-4B51-95D8-EA2B800814C3');
//        $this->makeRegionCompareChartF('guid7007AC27-6A45-4C1A-894D-0F41EAC2DF49');
        $this->makeRegionCompareChartF2('guid7D32802D-9E7F-4CAF-B013-8BB8B09BC533', 'b2e_flr_1');
        $this->makeRegionCompareChartF2('guid3841830D-7446-4B51-95D8-EA2B800814C3', 'b2e_flr_2');
        $this->makeRegionCompareChartF2('guid6C753E02-7E22-44DD-8F18-B5E8CAC09452', 'b2e_flr_3');
        $this->makeRegionCompareChartF2('guidD51DE0FF-93DA-4404-9840-78DCF7566BC8', 'b2e_flr_4');
        $this->makeRegionCompareChartF2('guidB55EA1DA-A837-4DFF-928A-825BE13D2648', 'b2e_flr_5');
        $this->makeRegionCompareChartF2('guidD541E8BA-BACB-4D14-B1B3-DF41EAB3F5A7', 'b2e_flr_6');
        $this->makeRegionCompareChartF2('guid14EFCE4C-CB65-4222-A37E-B698BD4CD0DF', 'b2e_flr_7');
        $this->makeRegionCompareChartF2('guid0612E0B4-14CC-4437-A149-E35C02759A74', 'b2e_flr_8');
        $this->makeRegionCompareChartF2('guid4D51AF8A-EAD1-4A61-9670-BDEFFDB1A093', 'b2e_flr_9');
        $this->makeRegionCompareChartF2('guidBDF4F680-AF9F-4072-B120-1464DABE0E7B', 'b2e_flr_10');
        $currentid= $_GET['rgn_atpidcurrent']?$_GET['rgn_atpidcurrent']:false;
        $this->assign('currentid',$currentid);
        $this->display();
    }
    public function F2e_ceng3F()
    {
        $this->makeRegionCompareChartF('guid6C753E02-7E22-44DD-8F18-B5E8CAC09452');
//        $this->makeRegionCompareChartF('guid7007AC27-6A45-4C1A-894D-0F41EAC2DF49');
        $this->makeRegionCompareChartF2('guid7D32802D-9E7F-4CAF-B013-8BB8B09BC533', 'b2e_flr_1');
        $this->makeRegionCompareChartF2('guid3841830D-7446-4B51-95D8-EA2B800814C3', 'b2e_flr_2');
        $this->makeRegionCompareChartF2('guid6C753E02-7E22-44DD-8F18-B5E8CAC09452', 'b2e_flr_3');
        $this->makeRegionCompareChartF2('guidD51DE0FF-93DA-4404-9840-78DCF7566BC8', 'b2e_flr_4');
        $this->makeRegionCompareChartF2('guidB55EA1DA-A837-4DFF-928A-825BE13D2648', 'b2e_flr_5');
        $this->makeRegionCompareChartF2('guidD541E8BA-BACB-4D14-B1B3-DF41EAB3F5A7', 'b2e_flr_6');
        $this->makeRegionCompareChartF2('guid14EFCE4C-CB65-4222-A37E-B698BD4CD0DF', 'b2e_flr_7');
        $this->makeRegionCompareChartF2('guid0612E0B4-14CC-4437-A149-E35C02759A74', 'b2e_flr_8');
        $this->makeRegionCompareChartF2('guid4D51AF8A-EAD1-4A61-9670-BDEFFDB1A093', 'b2e_flr_9');
        $this->makeRegionCompareChartF2('guidBDF4F680-AF9F-4072-B120-1464DABE0E7B', 'b2e_flr_10');
        $currentid= $_GET['rgn_atpidcurrent']?$_GET['rgn_atpidcurrent']:false;
        $this->assign('currentid',$currentid);
        $this->display();
    }
    public function F2e_ceng4F()
    {
        $this->makeRegionCompareChartF('guidD51DE0FF-93DA-4404-9840-78DCF7566BC8');
//        $this->makeRegionCompareChartF('guid7007AC27-6A45-4C1A-894D-0F41EAC2DF49');
        $this->makeRegionCompareChartF2('guid7D32802D-9E7F-4CAF-B013-8BB8B09BC533', 'b2e_flr_1');
        $this->makeRegionCompareChartF2('guid3841830D-7446-4B51-95D8-EA2B800814C3', 'b2e_flr_2');
        $this->makeRegionCompareChartF2('guid6C753E02-7E22-44DD-8F18-B5E8CAC09452', 'b2e_flr_3');
        $this->makeRegionCompareChartF2('guidD51DE0FF-93DA-4404-9840-78DCF7566BC8', 'b2e_flr_4');
        $this->makeRegionCompareChartF2('guidB55EA1DA-A837-4DFF-928A-825BE13D2648', 'b2e_flr_5');
        $this->makeRegionCompareChartF2('guidD541E8BA-BACB-4D14-B1B3-DF41EAB3F5A7', 'b2e_flr_6');
        $this->makeRegionCompareChartF2('guid14EFCE4C-CB65-4222-A37E-B698BD4CD0DF', 'b2e_flr_7');
        $this->makeRegionCompareChartF2('guid0612E0B4-14CC-4437-A149-E35C02759A74', 'b2e_flr_8');
        $this->makeRegionCompareChartF2('guid4D51AF8A-EAD1-4A61-9670-BDEFFDB1A093', 'b2e_flr_9');
        $this->makeRegionCompareChartF2('guidBDF4F680-AF9F-4072-B120-1464DABE0E7B', 'b2e_flr_10');
        $currentid= $_GET['rgn_atpidcurrent']?$_GET['rgn_atpidcurrent']:false;
        $this->assign('currentid',$currentid);
        $this->display();
    }
    public function F2e_ceng5F()
    {
        $this->makeRegionCompareChartF('guidB55EA1DA-A837-4DFF-928A-825BE13D2648');
//     $this->makeRegionCompareChartF2('guidFB65B509-0008-4F0A-9B10-C86C06858351', 'b2b_flr_1');
        $this->makeRegionCompareChartF2('guid7D32802D-9E7F-4CAF-B013-8BB8B09BC533', 'b2e_flr_1');
        $this->makeRegionCompareChartF2('guid3841830D-7446-4B51-95D8-EA2B800814C3', 'b2e_flr_2');
        $this->makeRegionCompareChartF2('guid6C753E02-7E22-44DD-8F18-B5E8CAC09452', 'b2e_flr_3');
        $this->makeRegionCompareChartF2('guidD51DE0FF-93DA-4404-9840-78DCF7566BC8', 'b2e_flr_4');
        $this->makeRegionCompareChartF2('guidB55EA1DA-A837-4DFF-928A-825BE13D2648', 'b2e_flr_5');
        $this->makeRegionCompareChartF2('guidD541E8BA-BACB-4D14-B1B3-DF41EAB3F5A7', 'b2e_flr_6');
        $this->makeRegionCompareChartF2('guid14EFCE4C-CB65-4222-A37E-B698BD4CD0DF', 'b2e_flr_7');
        $this->makeRegionCompareChartF2('guid0612E0B4-14CC-4437-A149-E35C02759A74', 'b2e_flr_8');
        $this->makeRegionCompareChartF2('guid4D51AF8A-EAD1-4A61-9670-BDEFFDB1A093', 'b2e_flr_9');
        $this->makeRegionCompareChartF2('guidBDF4F680-AF9F-4072-B120-1464DABE0E7B', 'b2e_flr_10');
        $currentid= $_GET['rgn_atpidcurrent']?$_GET['rgn_atpidcurrent']:false;
        $this->assign('currentid',$currentid);
        $this->display();
    }
    public function F2e_ceng6F()
    {
        $this->makeRegionCompareChartF('guidD541E8BA-BACB-4D14-B1B3-DF41EAB3F5A7');
//        $this->makeRegionCompareChartF('guid7007AC27-6A45-4C1A-894D-0F41EAC2DF49');
        $this->makeRegionCompareChartF2('guid7D32802D-9E7F-4CAF-B013-8BB8B09BC533', 'b2e_flr_1');
        $this->makeRegionCompareChartF2('guid3841830D-7446-4B51-95D8-EA2B800814C3', 'b2e_flr_2');
        $this->makeRegionCompareChartF2('guid6C753E02-7E22-44DD-8F18-B5E8CAC09452', 'b2e_flr_3');
        $this->makeRegionCompareChartF2('guidD51DE0FF-93DA-4404-9840-78DCF7566BC8', 'b2e_flr_4');
        $this->makeRegionCompareChartF2('guidB55EA1DA-A837-4DFF-928A-825BE13D2648', 'b2e_flr_5');
        $this->makeRegionCompareChartF2('guidD541E8BA-BACB-4D14-B1B3-DF41EAB3F5A7', 'b2e_flr_6');
        $this->makeRegionCompareChartF2('guid14EFCE4C-CB65-4222-A37E-B698BD4CD0DF', 'b2e_flr_7');
        $this->makeRegionCompareChartF2('guid0612E0B4-14CC-4437-A149-E35C02759A74', 'b2e_flr_8');
        $this->makeRegionCompareChartF2('guid4D51AF8A-EAD1-4A61-9670-BDEFFDB1A093', 'b2e_flr_9');
        $this->makeRegionCompareChartF2('guidBDF4F680-AF9F-4072-B120-1464DABE0E7B', 'b2e_flr_10');
        $currentid= $_GET['rgn_atpidcurrent']?$_GET['rgn_atpidcurrent']:false;
        $this->assign('currentid',$currentid);
        $this->display();
    }
    public function F2e_ceng7F()
    {
        $this->makeRegionCompareChartF('guid14EFCE4C-CB65-4222-A37E-B698BD4CD0DF');
// $this->makeRegionCompareChartF2('guidD471BC27-85B0-4E38-A408-B9AFE6DB267C', 'b2d_flr_1');
        $this->makeRegionCompareChartF2('guid7D32802D-9E7F-4CAF-B013-8BB8B09BC533', 'b2e_flr_1');
        $this->makeRegionCompareChartF2('guid3841830D-7446-4B51-95D8-EA2B800814C3', 'b2e_flr_2');
        $this->makeRegionCompareChartF2('guid6C753E02-7E22-44DD-8F18-B5E8CAC09452', 'b2e_flr_3');
        $this->makeRegionCompareChartF2('guidD51DE0FF-93DA-4404-9840-78DCF7566BC8', 'b2e_flr_4');
        $this->makeRegionCompareChartF2('guidB55EA1DA-A837-4DFF-928A-825BE13D2648', 'b2e_flr_5');
        $this->makeRegionCompareChartF2('guidD541E8BA-BACB-4D14-B1B3-DF41EAB3F5A7', 'b2e_flr_6');
        $this->makeRegionCompareChartF2('guid14EFCE4C-CB65-4222-A37E-B698BD4CD0DF', 'b2e_flr_7');
        $this->makeRegionCompareChartF2('guid0612E0B4-14CC-4437-A149-E35C02759A74', 'b2e_flr_8');
        $this->makeRegionCompareChartF2('guid4D51AF8A-EAD1-4A61-9670-BDEFFDB1A093', 'b2e_flr_9');
        $this->makeRegionCompareChartF2('guidBDF4F680-AF9F-4072-B120-1464DABE0E7B', 'b2e_flr_10');
        $currentid= $_GET['rgn_atpidcurrent']?$_GET['rgn_atpidcurrent']:false;
        $this->assign('currentid',$currentid);
        $this->display();
    }
    public function F2e_ceng8F()
    {
        $this->makeRegionCompareChartF('guid0612E0B4-14CC-4437-A149-E35C02759A74');
//        $this->makeRegionCompareChartF('guid7007AC27-6A45-4C1A-894D-0F41EAC2DF49');
        $this->makeRegionCompareChartF2('guid7D32802D-9E7F-4CAF-B013-8BB8B09BC533', 'b2e_flr_1');
        $this->makeRegionCompareChartF2('guid3841830D-7446-4B51-95D8-EA2B800814C3', 'b2e_flr_2');
        $this->makeRegionCompareChartF2('guid6C753E02-7E22-44DD-8F18-B5E8CAC09452', 'b2e_flr_3');
        $this->makeRegionCompareChartF2('guidD51DE0FF-93DA-4404-9840-78DCF7566BC8', 'b2e_flr_4');
        $this->makeRegionCompareChartF2('guidB55EA1DA-A837-4DFF-928A-825BE13D2648', 'b2e_flr_5');
        $this->makeRegionCompareChartF2('guidD541E8BA-BACB-4D14-B1B3-DF41EAB3F5A7', 'b2e_flr_6');
        $this->makeRegionCompareChartF2('guid14EFCE4C-CB65-4222-A37E-B698BD4CD0DF', 'b2e_flr_7');
        $this->makeRegionCompareChartF2('guid0612E0B4-14CC-4437-A149-E35C02759A74', 'b2e_flr_8');
        $this->makeRegionCompareChartF2('guid4D51AF8A-EAD1-4A61-9670-BDEFFDB1A093', 'b2e_flr_9');
        $this->makeRegionCompareChartF2('guidBDF4F680-AF9F-4072-B120-1464DABE0E7B', 'b2e_flr_10');
        $currentid= $_GET['rgn_atpidcurrent']?$_GET['rgn_atpidcurrent']:false;
        $this->assign('currentid',$currentid);
        $this->display();
    }
    public function F2e_ceng9F()
    {
        $this->makeRegionCompareChartF('guid4D51AF8A-EAD1-4A61-9670-BDEFFDB1A093');
//   $this->makeRegionCompareChartF2('guid6B6AB76A-1D0B-481C-AF83-AB3BBE05515F', 'b2c_flr_1');
        $this->makeRegionCompareChartF2('guid7D32802D-9E7F-4CAF-B013-8BB8B09BC533', 'b2e_flr_1');
        $this->makeRegionCompareChartF2('guid3841830D-7446-4B51-95D8-EA2B800814C3', 'b2e_flr_2');
        $this->makeRegionCompareChartF2('guid6C753E02-7E22-44DD-8F18-B5E8CAC09452', 'b2e_flr_3');
        $this->makeRegionCompareChartF2('guidD51DE0FF-93DA-4404-9840-78DCF7566BC8', 'b2e_flr_4');
        $this->makeRegionCompareChartF2('guidB55EA1DA-A837-4DFF-928A-825BE13D2648', 'b2e_flr_5');
        $this->makeRegionCompareChartF2('guidD541E8BA-BACB-4D14-B1B3-DF41EAB3F5A7', 'b2e_flr_6');
        $this->makeRegionCompareChartF2('guid14EFCE4C-CB65-4222-A37E-B698BD4CD0DF', 'b2e_flr_7');
        $this->makeRegionCompareChartF2('guid0612E0B4-14CC-4437-A149-E35C02759A74', 'b2e_flr_8');
        $this->makeRegionCompareChartF2('guid4D51AF8A-EAD1-4A61-9670-BDEFFDB1A093', 'b2e_flr_9');
        $this->makeRegionCompareChartF2('guidBDF4F680-AF9F-4072-B120-1464DABE0E7B', 'b2e_flr_10');
        $currentid= $_GET['rgn_atpidcurrent']?$_GET['rgn_atpidcurrent']:false;
        $this->assign('currentid',$currentid);
        $this->display();
    }
    public function F2e_ceng10F()
    {
        $this->makeRegionCompareChartF('guidBDF4F680-AF9F-4072-B120-1464DABE0E7B');
//     $this->makeRegionCompareChartF2('guid6B6AB76A-1D0B-481C-AF83-AB3BBE05515F', 'b2c_flr_1');
        $this->makeRegionCompareChartF2('guid7D32802D-9E7F-4CAF-B013-8BB8B09BC533', 'b2e_flr_1');
        $this->makeRegionCompareChartF2('guid3841830D-7446-4B51-95D8-EA2B800814C3', 'b2e_flr_2');
        $this->makeRegionCompareChartF2('guid6C753E02-7E22-44DD-8F18-B5E8CAC09452', 'b2e_flr_3');
        $this->makeRegionCompareChartF2('guidD51DE0FF-93DA-4404-9840-78DCF7566BC8', 'b2e_flr_4');
        $this->makeRegionCompareChartF2('guidB55EA1DA-A837-4DFF-928A-825BE13D2648', 'b2e_flr_5');
        $this->makeRegionCompareChartF2('guidD541E8BA-BACB-4D14-B1B3-DF41EAB3F5A7', 'b2e_flr_6');
        $this->makeRegionCompareChartF2('guid14EFCE4C-CB65-4222-A37E-B698BD4CD0DF', 'b2e_flr_7');
        $this->makeRegionCompareChartF2('guid0612E0B4-14CC-4437-A149-E35C02759A74', 'b2e_flr_8');
        $this->makeRegionCompareChartF2('guid4D51AF8A-EAD1-4A61-9670-BDEFFDB1A093', 'b2e_flr_9');
        $this->makeRegionCompareChartF2('guidBDF4F680-AF9F-4072-B120-1464DABE0E7B', 'b2e_flr_10');
        $currentid= $_GET['rgn_atpidcurrent']?$_GET['rgn_atpidcurrent']:false;
        $this->assign('currentid',$currentid);
        $this->display();
    }



//2f
    public function F2f_ceng1F()
    {
        $this->makeRegionCompareChartF('guid7577FD4A-1243-4249-97DD-5C9FF3097644');
//        $this->makeRegionCompareChartF('guid7007AC27-6A45-4C1A-894D-0F41EAC2DF49');
        $this->makeRegionCompareChartF2('guid7577FD4A-1243-4249-97DD-5C9FF3097644', 'b2f_flr_1');
        $this->makeRegionCompareChartF2('guid57C99A72-2B48-4AA9-A2C5-C6E5CBA58900', 'b2f_flr_2');
        $this->makeRegionCompareChartF2('guid34737AF6-E82F-4E71-81FF-4708D8A83C42', 'b2f_flr_3');
        $this->makeRegionCompareChartF2('guidFA26ADB1-29F0-4AA8-8496-21F3BFBBD65A', 'b2f_flr_4');
        $this->makeRegionCompareChartF2('guid8DDDC8BB-9F3B-4FA3-B58D-145965AB7643', 'b2f_flr_5');
        $this->makeRegionCompareChartF2('guidF446EED8-428F-4101-8249-94F2704A119B', 'b2f_flr_6');
        $this->makeRegionCompareChartF2('guidF20CFA8C-8F6A-4073-8745-62118441A359', 'b2f_flr_7');
        $this->makeRegionCompareChartF2('guid21C31CDE-8ED5-4A13-9BDA-EE80C441F218', 'b2f_flr_8');
        $this->makeRegionCompareChartF2('guid0B072972-68B6-4BD2-8928-C4AFD1A3975F', 'b2f_flr_9');
        $this->makeRegionCompareChartF2('guid3B65A286-2BE0-4F92-A472-012E7B3661D2', 'b2f_flr_10');
        $currentid= $_GET['rgn_atpidcurrent']?$_GET['rgn_atpidcurrent']:false;
        $this->assign('currentid',$currentid);
        $this->display();
    }
    public function F2f_ceng2F()
    {
        $this->makeRegionCompareChartF('guid57C99A72-2B48-4AA9-A2C5-C6E5CBA58900');
//        $this->makeRegionCompareChartF('guid7007AC27-6A45-4C1A-894D-0F41EAC2DF49');
        $this->makeRegionCompareChartF2('guid7577FD4A-1243-4249-97DD-5C9FF3097644', 'b2f_flr_1');
        $this->makeRegionCompareChartF2('guid57C99A72-2B48-4AA9-A2C5-C6E5CBA58900', 'b2f_flr_2');
        $this->makeRegionCompareChartF2('guid34737AF6-E82F-4E71-81FF-4708D8A83C42', 'b2f_flr_3');
        $this->makeRegionCompareChartF2('guidFA26ADB1-29F0-4AA8-8496-21F3BFBBD65A', 'b2f_flr_4');
        $this->makeRegionCompareChartF2('guid8DDDC8BB-9F3B-4FA3-B58D-145965AB7643', 'b2f_flr_5');
        $this->makeRegionCompareChartF2('guidF446EED8-428F-4101-8249-94F2704A119B', 'b2f_flr_6');
        $this->makeRegionCompareChartF2('guidF20CFA8C-8F6A-4073-8745-62118441A359', 'b2f_flr_7');
        $this->makeRegionCompareChartF2('guid21C31CDE-8ED5-4A13-9BDA-EE80C441F218', 'b2f_flr_8');
        $this->makeRegionCompareChartF2('guid0B072972-68B6-4BD2-8928-C4AFD1A3975F', 'b2f_flr_9');
        $this->makeRegionCompareChartF2('guid3B65A286-2BE0-4F92-A472-012E7B3661D2', 'b2f_flr_10');
        $currentid= $_GET['rgn_atpidcurrent']?$_GET['rgn_atpidcurrent']:false;
        $this->assign('currentid',$currentid);
        $this->display();
    }
    public function F2f_ceng3F()
    {
        $this->makeRegionCompareChartF('guid34737AF6-E82F-4E71-81FF-4708D8A83C42');
//        $this->makeRegionCompareChartF('guid7007AC27-6A45-4C1A-894D-0F41EAC2DF49');
        $this->makeRegionCompareChartF2('guid7577FD4A-1243-4249-97DD-5C9FF3097644', 'b2f_flr_1');
        $this->makeRegionCompareChartF2('guid57C99A72-2B48-4AA9-A2C5-C6E5CBA58900', 'b2f_flr_2');
        $this->makeRegionCompareChartF2('guid34737AF6-E82F-4E71-81FF-4708D8A83C42', 'b2f_flr_3');
        $this->makeRegionCompareChartF2('guidFA26ADB1-29F0-4AA8-8496-21F3BFBBD65A', 'b2f_flr_4');
        $this->makeRegionCompareChartF2('guid8DDDC8BB-9F3B-4FA3-B58D-145965AB7643', 'b2f_flr_5');
        $this->makeRegionCompareChartF2('guidF446EED8-428F-4101-8249-94F2704A119B', 'b2f_flr_6');
        $this->makeRegionCompareChartF2('guidF20CFA8C-8F6A-4073-8745-62118441A359', 'b2f_flr_7');
        $this->makeRegionCompareChartF2('guid21C31CDE-8ED5-4A13-9BDA-EE80C441F218', 'b2f_flr_8');
        $this->makeRegionCompareChartF2('guid0B072972-68B6-4BD2-8928-C4AFD1A3975F', 'b2f_flr_9');
        $this->makeRegionCompareChartF2('guid3B65A286-2BE0-4F92-A472-012E7B3661D2', 'b2f_flr_10');
        $currentid= $_GET['rgn_atpidcurrent']?$_GET['rgn_atpidcurrent']:false;
        $this->assign('currentid',$currentid);
        $this->display();
    }
    public function F2f_ceng4F()
    {
        $this->makeRegionCompareChartF('guidFA26ADB1-29F0-4AA8-8496-21F3BFBBD65A');
//        $this->makeRegionCompareChartF('guid7007AC27-6A45-4C1A-894D-0F41EAC2DF49');
        $this->makeRegionCompareChartF2('guid7577FD4A-1243-4249-97DD-5C9FF3097644', 'b2f_flr_1');
        $this->makeRegionCompareChartF2('guid57C99A72-2B48-4AA9-A2C5-C6E5CBA58900', 'b2f_flr_2');
        $this->makeRegionCompareChartF2('guid34737AF6-E82F-4E71-81FF-4708D8A83C42', 'b2f_flr_3');
        $this->makeRegionCompareChartF2('guidFA26ADB1-29F0-4AA8-8496-21F3BFBBD65A', 'b2f_flr_4');
        $this->makeRegionCompareChartF2('guid8DDDC8BB-9F3B-4FA3-B58D-145965AB7643', 'b2f_flr_5');
        $this->makeRegionCompareChartF2('guidF446EED8-428F-4101-8249-94F2704A119B', 'b2f_flr_6');
        $this->makeRegionCompareChartF2('guidF20CFA8C-8F6A-4073-8745-62118441A359', 'b2f_flr_7');
        $this->makeRegionCompareChartF2('guid21C31CDE-8ED5-4A13-9BDA-EE80C441F218', 'b2f_flr_8');
        $this->makeRegionCompareChartF2('guid0B072972-68B6-4BD2-8928-C4AFD1A3975F', 'b2f_flr_9');
        $this->makeRegionCompareChartF2('guid3B65A286-2BE0-4F92-A472-012E7B3661D2', 'b2f_flr_10');
        $currentid= $_GET['rgn_atpidcurrent']?$_GET['rgn_atpidcurrent']:false;
        $this->assign('currentid',$currentid);
        $this->display();
    }
    public function F2f_ceng5F()
    {
        $this->makeRegionCompareChartF('guid8DDDC8BB-9F3B-4FA3-B58D-145965AB7643');
//     $this->makeRegionCompareChartF2('guidFB65B509-0008-4F0A-9B10-C86C06858351', 'b2b_flr_1');
        $this->makeRegionCompareChartF2('guid7577FD4A-1243-4249-97DD-5C9FF3097644', 'b2f_flr_1');
        $this->makeRegionCompareChartF2('guid57C99A72-2B48-4AA9-A2C5-C6E5CBA58900', 'b2f_flr_2');
        $this->makeRegionCompareChartF2('guid34737AF6-E82F-4E71-81FF-4708D8A83C42', 'b2f_flr_3');
        $this->makeRegionCompareChartF2('guidFA26ADB1-29F0-4AA8-8496-21F3BFBBD65A', 'b2f_flr_4');
        $this->makeRegionCompareChartF2('guid8DDDC8BB-9F3B-4FA3-B58D-145965AB7643', 'b2f_flr_5');
        $this->makeRegionCompareChartF2('guidF446EED8-428F-4101-8249-94F2704A119B', 'b2f_flr_6');
        $this->makeRegionCompareChartF2('guidF20CFA8C-8F6A-4073-8745-62118441A359', 'b2f_flr_7');
        $this->makeRegionCompareChartF2('guid21C31CDE-8ED5-4A13-9BDA-EE80C441F218', 'b2f_flr_8');
        $this->makeRegionCompareChartF2('guid0B072972-68B6-4BD2-8928-C4AFD1A3975F', 'b2f_flr_9');
        $this->makeRegionCompareChartF2('guid3B65A286-2BE0-4F92-A472-012E7B3661D2', 'b2f_flr_10');
        $currentid= $_GET['rgn_atpidcurrent']?$_GET['rgn_atpidcurrent']:false;
        $this->assign('currentid',$currentid);
        $this->display();
    }
    public function F2f_ceng6F()
    {
        $this->makeRegionCompareChartF('guidF446EED8-428F-4101-8249-94F2704A119B');
//        $this->makeRegionCompareChartF('guid7007AC27-6A45-4C1A-894D-0F41EAC2DF49');
        $this->makeRegionCompareChartF2('guid7577FD4A-1243-4249-97DD-5C9FF3097644', 'b2f_flr_1');
        $this->makeRegionCompareChartF2('guid57C99A72-2B48-4AA9-A2C5-C6E5CBA58900', 'b2f_flr_2');
        $this->makeRegionCompareChartF2('guid34737AF6-E82F-4E71-81FF-4708D8A83C42', 'b2f_flr_3');
        $this->makeRegionCompareChartF2('guidFA26ADB1-29F0-4AA8-8496-21F3BFBBD65A', 'b2f_flr_4');
        $this->makeRegionCompareChartF2('guid8DDDC8BB-9F3B-4FA3-B58D-145965AB7643', 'b2f_flr_5');
        $this->makeRegionCompareChartF2('guidF446EED8-428F-4101-8249-94F2704A119B', 'b2f_flr_6');
        $this->makeRegionCompareChartF2('guidF20CFA8C-8F6A-4073-8745-62118441A359', 'b2f_flr_7');
        $this->makeRegionCompareChartF2('guid21C31CDE-8ED5-4A13-9BDA-EE80C441F218', 'b2f_flr_8');
        $this->makeRegionCompareChartF2('guid0B072972-68B6-4BD2-8928-C4AFD1A3975F', 'b2f_flr_9');
        $this->makeRegionCompareChartF2('guid3B65A286-2BE0-4F92-A472-012E7B3661D2', 'b2f_flr_10');
        $currentid= $_GET['rgn_atpidcurrent']?$_GET['rgn_atpidcurrent']:false;
        $this->assign('currentid',$currentid);
        $this->display();
    }
    public function F2f_ceng7F()
    {
        $this->makeRegionCompareChartF('guidF20CFA8C-8F6A-4073-8745-62118441A359');
// $this->makeRegionCompareChartF2('guidD471BC27-85B0-4E38-A408-B9AFE6DB267C', 'b2d_flr_1');
        $this->makeRegionCompareChartF2('guid7577FD4A-1243-4249-97DD-5C9FF3097644', 'b2f_flr_1');
        $this->makeRegionCompareChartF2('guid57C99A72-2B48-4AA9-A2C5-C6E5CBA58900', 'b2f_flr_2');
        $this->makeRegionCompareChartF2('guid34737AF6-E82F-4E71-81FF-4708D8A83C42', 'b2f_flr_3');
        $this->makeRegionCompareChartF2('guidFA26ADB1-29F0-4AA8-8496-21F3BFBBD65A', 'b2f_flr_4');
        $this->makeRegionCompareChartF2('guid8DDDC8BB-9F3B-4FA3-B58D-145965AB7643', 'b2f_flr_5');
        $this->makeRegionCompareChartF2('guidF446EED8-428F-4101-8249-94F2704A119B', 'b2f_flr_6');
        $this->makeRegionCompareChartF2('guidF20CFA8C-8F6A-4073-8745-62118441A359', 'b2f_flr_7');
        $this->makeRegionCompareChartF2('guid21C31CDE-8ED5-4A13-9BDA-EE80C441F218', 'b2f_flr_8');
        $this->makeRegionCompareChartF2('guid0B072972-68B6-4BD2-8928-C4AFD1A3975F', 'b2f_flr_9');
        $this->makeRegionCompareChartF2('guid3B65A286-2BE0-4F92-A472-012E7B3661D2', 'b2f_flr_10');
        $currentid= $_GET['rgn_atpidcurrent']?$_GET['rgn_atpidcurrent']:false;
        $this->assign('currentid',$currentid);
        $this->display();
    }
    public function F2f_ceng8F()
    {
        $this->makeRegionCompareChartF('guid21C31CDE-8ED5-4A13-9BDA-EE80C441F218');
//        $this->makeRegionCompareChartF('guid7007AC27-6A45-4C1A-894D-0F41EAC2DF49');
        $this->makeRegionCompareChartF2('guid7577FD4A-1243-4249-97DD-5C9FF3097644', 'b2f_flr_1');
        $this->makeRegionCompareChartF2('guid57C99A72-2B48-4AA9-A2C5-C6E5CBA58900', 'b2f_flr_2');
        $this->makeRegionCompareChartF2('guid34737AF6-E82F-4E71-81FF-4708D8A83C42', 'b2f_flr_3');
        $this->makeRegionCompareChartF2('guidFA26ADB1-29F0-4AA8-8496-21F3BFBBD65A', 'b2f_flr_4');
        $this->makeRegionCompareChartF2('guid8DDDC8BB-9F3B-4FA3-B58D-145965AB7643', 'b2f_flr_5');
        $this->makeRegionCompareChartF2('guidF446EED8-428F-4101-8249-94F2704A119B', 'b2f_flr_6');
        $this->makeRegionCompareChartF2('guidF20CFA8C-8F6A-4073-8745-62118441A359', 'b2f_flr_7');
        $this->makeRegionCompareChartF2('guid21C31CDE-8ED5-4A13-9BDA-EE80C441F218', 'b2f_flr_8');
        $this->makeRegionCompareChartF2('guid0B072972-68B6-4BD2-8928-C4AFD1A3975F', 'b2f_flr_9');
        $this->makeRegionCompareChartF2('guid3B65A286-2BE0-4F92-A472-012E7B3661D2', 'b2f_flr_10');
        $currentid= $_GET['rgn_atpidcurrent']?$_GET['rgn_atpidcurrent']:false;
        $this->assign('currentid',$currentid);
        $this->display();
    }
    public function F2f_ceng9F()
    {
        $this->makeRegionCompareChartF('guid0B072972-68B6-4BD2-8928-C4AFD1A3975F');
//   $this->makeRegionCompareChartF2('guid6B6AB76A-1D0B-481C-AF83-AB3BBE05515F', 'b2c_flr_1');
        $this->makeRegionCompareChartF2('guid7577FD4A-1243-4249-97DD-5C9FF3097644', 'b2f_flr_1');
        $this->makeRegionCompareChartF2('guid57C99A72-2B48-4AA9-A2C5-C6E5CBA58900', 'b2f_flr_2');
        $this->makeRegionCompareChartF2('guid34737AF6-E82F-4E71-81FF-4708D8A83C42', 'b2f_flr_3');
        $this->makeRegionCompareChartF2('guidFA26ADB1-29F0-4AA8-8496-21F3BFBBD65A', 'b2f_flr_4');
        $this->makeRegionCompareChartF2('guid8DDDC8BB-9F3B-4FA3-B58D-145965AB7643', 'b2f_flr_5');
        $this->makeRegionCompareChartF2('guidF446EED8-428F-4101-8249-94F2704A119B', 'b2f_flr_6');
        $this->makeRegionCompareChartF2('guidF20CFA8C-8F6A-4073-8745-62118441A359', 'b2f_flr_7');
        $this->makeRegionCompareChartF2('guid21C31CDE-8ED5-4A13-9BDA-EE80C441F218', 'b2f_flr_8');
        $this->makeRegionCompareChartF2('guid0B072972-68B6-4BD2-8928-C4AFD1A3975F', 'b2f_flr_9');
        $this->makeRegionCompareChartF2('guid3B65A286-2BE0-4F92-A472-012E7B3661D2', 'b2f_flr_10');
        $currentid= $_GET['rgn_atpidcurrent']?$_GET['rgn_atpidcurrent']:false;
        $this->assign('currentid',$currentid);
        $this->display();
    }
    public function F2f_ceng10F()
    {
        $this->makeRegionCompareChartF('guid3B65A286-2BE0-4F92-A472-012E7B3661D2');
//     $this->makeRegionCompareChartF2('guid6B6AB76A-1D0B-481C-AF83-AB3BBE05515F', 'b2c_flr_1');
        $this->makeRegionCompareChartF2('guid7577FD4A-1243-4249-97DD-5C9FF3097644', 'b2f_flr_1');
        $this->makeRegionCompareChartF2('guid57C99A72-2B48-4AA9-A2C5-C6E5CBA58900', 'b2f_flr_2');
        $this->makeRegionCompareChartF2('guid34737AF6-E82F-4E71-81FF-4708D8A83C42', 'b2f_flr_3');
        $this->makeRegionCompareChartF2('guidFA26ADB1-29F0-4AA8-8496-21F3BFBBD65A', 'b2f_flr_4');
        $this->makeRegionCompareChartF2('guid8DDDC8BB-9F3B-4FA3-B58D-145965AB7643', 'b2f_flr_5');
        $this->makeRegionCompareChartF2('guidF446EED8-428F-4101-8249-94F2704A119B', 'b2f_flr_6');
        $this->makeRegionCompareChartF2('guidF20CFA8C-8F6A-4073-8745-62118441A359', 'b2f_flr_7');
        $this->makeRegionCompareChartF2('guid21C31CDE-8ED5-4A13-9BDA-EE80C441F218', 'b2f_flr_8');
        $this->makeRegionCompareChartF2('guid0B072972-68B6-4BD2-8928-C4AFD1A3975F', 'b2f_flr_9');
        $this->makeRegionCompareChartF2('guid3B65A286-2BE0-4F92-A472-012E7B3661D2', 'b2f_flr_10');
        $currentid= $_GET['rgn_atpidcurrent']?$_GET['rgn_atpidcurrent']:false;
        $this->assign('currentid',$currentid);
        $this->display();
    }




    //3#
    public function F3_ceng1F()
    {
        $this->makeRegionCompareChartF('guidCA335990-3FA2-47DF-85A4-9197C8EFB812');
//        $this->makeRegionCompareChartF('guid7007AC27-6A45-4C1A-894D-0F41EAC2DF49');
        $this->makeRegionCompareChartF2('guidCA335990-3FA2-47DF-85A4-9197C8EFB812', 'b3_flr_1');
        $this->makeRegionCompareChartF2('guidDF46EC83-D15E-4E8C-BECE-F8CAEF68D6FF', 'b3_flr_2');
        $this->makeRegionCompareChartF2('guid51F79894-2166-4F85-B1A9-CB1FDE851F67', 'b3_flr_3');
        $this->makeRegionCompareChartF2('guid2809F029-3060-4938-8E19-5E747508DCAC', 'b3_flr_4');
        $this->makeRegionCompareChartF2('guid5F7EE944-26E8-409C-994C-E6498979513F', 'b3_flr_5');
        $this->makeRegionCompareChartF2('guid49BC7341-BF37-4CFC-B227-4387BAF86494', 'b3_flr_6');
        $this->makeRegionCompareChartF2('guid38605F5C-8AE9-48B2-B4F9-81E8B1DC6BB0', 'b3_flr_7');
        $this->makeRegionCompareChartF2('guidD5C3AD06-E4F6-4C3F-8D40-D96EBB5AF5AD', 'b3_flr_8');
        $currentid= $_GET['rgn_atpidcurrent']?$_GET['rgn_atpidcurrent']:false;
        $this->assign('currentid',$currentid);
        $this->display();
    }
    public function F3_ceng2F()
    {
        $this->makeRegionCompareChartF('guidDF46EC83-D15E-4E8C-BECE-F8CAEF68D6FF');
//        $this->makeRegionCompareChartF('guid7007AC27-6A45-4C1A-894D-0F41EAC2DF49');
        $this->makeRegionCompareChartF2('guidCA335990-3FA2-47DF-85A4-9197C8EFB812', 'b3_flr_1');
        $this->makeRegionCompareChartF2('guidDF46EC83-D15E-4E8C-BECE-F8CAEF68D6FF', 'b3_flr_2');
        $this->makeRegionCompareChartF2('guid51F79894-2166-4F85-B1A9-CB1FDE851F67', 'b3_flr_3');
        $this->makeRegionCompareChartF2('guid2809F029-3060-4938-8E19-5E747508DCAC', 'b3_flr_4');
        $this->makeRegionCompareChartF2('guid5F7EE944-26E8-409C-994C-E6498979513F', 'b3_flr_5');
        $this->makeRegionCompareChartF2('guid49BC7341-BF37-4CFC-B227-4387BAF86494', 'b3_flr_6');
        $this->makeRegionCompareChartF2('guid38605F5C-8AE9-48B2-B4F9-81E8B1DC6BB0', 'b3_flr_7');
        $this->makeRegionCompareChartF2('guidD5C3AD06-E4F6-4C3F-8D40-D96EBB5AF5AD', 'b3_flr_8');
        $currentid= $_GET['rgn_atpidcurrent']?$_GET['rgn_atpidcurrent']:false;
        $this->assign('currentid',$currentid);
        $this->display();
    }
    public function F3_ceng3F()
    {
        $this->makeRegionCompareChartF('guid51F79894-2166-4F85-B1A9-CB1FDE851F67');
//        $this->makeRegionCompareChartF('guid7007AC27-6A45-4C1A-894D-0F41EAC2DF49');
        $this->makeRegionCompareChartF2('guidCA335990-3FA2-47DF-85A4-9197C8EFB812', 'b3_flr_1');
        $this->makeRegionCompareChartF2('guidDF46EC83-D15E-4E8C-BECE-F8CAEF68D6FF', 'b3_flr_2');
        $this->makeRegionCompareChartF2('guid51F79894-2166-4F85-B1A9-CB1FDE851F67', 'b3_flr_3');
        $this->makeRegionCompareChartF2('guid2809F029-3060-4938-8E19-5E747508DCAC', 'b3_flr_4');
        $this->makeRegionCompareChartF2('guid5F7EE944-26E8-409C-994C-E6498979513F', 'b3_flr_5');
        $this->makeRegionCompareChartF2('guid49BC7341-BF37-4CFC-B227-4387BAF86494', 'b3_flr_6');
        $this->makeRegionCompareChartF2('guid38605F5C-8AE9-48B2-B4F9-81E8B1DC6BB0', 'b3_flr_7');
        $this->makeRegionCompareChartF2('guidD5C3AD06-E4F6-4C3F-8D40-D96EBB5AF5AD', 'b3_flr_8');
        $currentid= $_GET['rgn_atpidcurrent']?$_GET['rgn_atpidcurrent']:false;
        $this->assign('currentid',$currentid);
        $this->display();
    }
    public function F3_ceng4F()
    {
        $this->makeRegionCompareChartF('guid2809F029-3060-4938-8E19-5E747508DCAC');
//        $this->makeRegionCompareChartF('guid7007AC27-6A45-4C1A-894D-0F41EAC2DF49');
        $this->makeRegionCompareChartF2('guidCA335990-3FA2-47DF-85A4-9197C8EFB812', 'b3_flr_1');
        $this->makeRegionCompareChartF2('guidDF46EC83-D15E-4E8C-BECE-F8CAEF68D6FF', 'b3_flr_2');
        $this->makeRegionCompareChartF2('guid51F79894-2166-4F85-B1A9-CB1FDE851F67', 'b3_flr_3');
        $this->makeRegionCompareChartF2('guid2809F029-3060-4938-8E19-5E747508DCAC', 'b3_flr_4');
        $this->makeRegionCompareChartF2('guid5F7EE944-26E8-409C-994C-E6498979513F', 'b3_flr_5');
        $this->makeRegionCompareChartF2('guid49BC7341-BF37-4CFC-B227-4387BAF86494', 'b3_flr_6');
        $this->makeRegionCompareChartF2('guid38605F5C-8AE9-48B2-B4F9-81E8B1DC6BB0', 'b3_flr_7');
        $this->makeRegionCompareChartF2('guidD5C3AD06-E4F6-4C3F-8D40-D96EBB5AF5AD', 'b3_flr_8');
        $currentid= $_GET['rgn_atpidcurrent']?$_GET['rgn_atpidcurrent']:false;
        $this->assign('currentid',$currentid);
        $this->display();
    }
    public function F3_ceng5F()
    {
        $this->makeRegionCompareChartF('guid5F7EE944-26E8-409C-994C-E6498979513F');
//        $this->makeRegionCompareChartF('guid7007AC27-6A45-4C1A-894D-0F41EAC2DF49');
        $this->makeRegionCompareChartF2('guidCA335990-3FA2-47DF-85A4-9197C8EFB812', 'b3_flr_1');
        $this->makeRegionCompareChartF2('guidDF46EC83-D15E-4E8C-BECE-F8CAEF68D6FF', 'b3_flr_2');
        $this->makeRegionCompareChartF2('guid51F79894-2166-4F85-B1A9-CB1FDE851F67', 'b3_flr_3');
        $this->makeRegionCompareChartF2('guid2809F029-3060-4938-8E19-5E747508DCAC', 'b3_flr_4');
        $this->makeRegionCompareChartF2('guid5F7EE944-26E8-409C-994C-E6498979513F', 'b3_flr_5');
        $this->makeRegionCompareChartF2('guid49BC7341-BF37-4CFC-B227-4387BAF86494', 'b3_flr_6');
        $this->makeRegionCompareChartF2('guid38605F5C-8AE9-48B2-B4F9-81E8B1DC6BB0', 'b3_flr_7');
        $this->makeRegionCompareChartF2('guidD5C3AD06-E4F6-4C3F-8D40-D96EBB5AF5AD', 'b3_flr_8');
        $currentid= $_GET['rgn_atpidcurrent']?$_GET['rgn_atpidcurrent']:false;
        $this->assign('currentid',$currentid);
        $this->display();
    }
    public function F3_ceng6F()
    {
        $this->makeRegionCompareChartF('guid49BC7341-BF37-4CFC-B227-4387BAF86494');
//        $this->makeRegionCompareChartF('guid7007AC27-6A45-4C1A-894D-0F41EAC2DF49');
        $this->makeRegionCompareChartF2('guidCA335990-3FA2-47DF-85A4-9197C8EFB812', 'b3_flr_1');
        $this->makeRegionCompareChartF2('guidDF46EC83-D15E-4E8C-BECE-F8CAEF68D6FF', 'b3_flr_2');
        $this->makeRegionCompareChartF2('guid51F79894-2166-4F85-B1A9-CB1FDE851F67', 'b3_flr_3');
        $this->makeRegionCompareChartF2('guid2809F029-3060-4938-8E19-5E747508DCAC', 'b3_flr_4');
        $this->makeRegionCompareChartF2('guid5F7EE944-26E8-409C-994C-E6498979513F', 'b3_flr_5');
        $this->makeRegionCompareChartF2('guid49BC7341-BF37-4CFC-B227-4387BAF86494', 'b3_flr_6');
        $this->makeRegionCompareChartF2('guid38605F5C-8AE9-48B2-B4F9-81E8B1DC6BB0', 'b3_flr_7');
        $this->makeRegionCompareChartF2('guidD5C3AD06-E4F6-4C3F-8D40-D96EBB5AF5AD', 'b3_flr_8');
        $currentid= $_GET['rgn_atpidcurrent']?$_GET['rgn_atpidcurrent']:false;
        $this->assign('currentid',$currentid);
        $this->display();
    }
    public function F3_ceng7F()
    {
        $this->makeRegionCompareChartF('guid38605F5C-8AE9-48B2-B4F9-81E8B1DC6BB0');
//        $this->makeRegionCompareChartF('guid7007AC27-6A45-4C1A-894D-0F41EAC2DF49');
        $this->makeRegionCompareChartF2('guidCA335990-3FA2-47DF-85A4-9197C8EFB812', 'b3_flr_1');
        $this->makeRegionCompareChartF2('guidDF46EC83-D15E-4E8C-BECE-F8CAEF68D6FF', 'b3_flr_2');
        $this->makeRegionCompareChartF2('guid51F79894-2166-4F85-B1A9-CB1FDE851F67', 'b3_flr_3');
        $this->makeRegionCompareChartF2('guid2809F029-3060-4938-8E19-5E747508DCAC', 'b3_flr_4');
        $this->makeRegionCompareChartF2('guid5F7EE944-26E8-409C-994C-E6498979513F', 'b3_flr_5');
        $this->makeRegionCompareChartF2('guid49BC7341-BF37-4CFC-B227-4387BAF86494', 'b3_flr_6');
        $this->makeRegionCompareChartF2('guid38605F5C-8AE9-48B2-B4F9-81E8B1DC6BB0', 'b3_flr_7');
        $this->makeRegionCompareChartF2('guidD5C3AD06-E4F6-4C3F-8D40-D96EBB5AF5AD', 'b3_flr_8');
        $currentid= $_GET['rgn_atpidcurrent']?$_GET['rgn_atpidcurrent']:false;
        $this->assign('currentid',$currentid);
        $this->display();
    }
    public function F3_ceng8F()
    {
        $this->makeRegionCompareChartF('guidD5C3AD06-E4F6-4C3F-8D40-D96EBB5AF5AD');
//        $this->makeRegionCompareChartF('guid7007AC27-6A45-4C1A-894D-0F41EAC2DF49');
        $this->makeRegionCompareChartF2('guidCA335990-3FA2-47DF-85A4-9197C8EFB812', 'b3_flr_1');
        $this->makeRegionCompareChartF2('guidDF46EC83-D15E-4E8C-BECE-F8CAEF68D6FF', 'b3_flr_2');
        $this->makeRegionCompareChartF2('guid51F79894-2166-4F85-B1A9-CB1FDE851F67', 'b3_flr_3');
        $this->makeRegionCompareChartF2('guid2809F029-3060-4938-8E19-5E747508DCAC', 'b3_flr_4');
        $this->makeRegionCompareChartF2('guid5F7EE944-26E8-409C-994C-E6498979513F', 'b3_flr_5');
        $this->makeRegionCompareChartF2('guid49BC7341-BF37-4CFC-B227-4387BAF86494', 'b3_flr_6');
        $this->makeRegionCompareChartF2('guid38605F5C-8AE9-48B2-B4F9-81E8B1DC6BB0', 'b3_flr_7');
        $this->makeRegionCompareChartF2('guidD5C3AD06-E4F6-4C3F-8D40-D96EBB5AF5AD', 'b3_flr_8');
        $currentid= $_GET['rgn_atpidcurrent']?$_GET['rgn_atpidcurrent']:false;
        $this->assign('currentid',$currentid);
        $this->display();
    }




    /**
     * 自动构造每楼的【能源】与【报警】信息
     * @param $loudata
     * @param $loubj
     * @param $regionid
     */
    public function makeEnergyAndAlarm($loudata, $loubj, $regionid)
    {
        $rgn_atpid1 = $regionid;
        $res1 = $this->regionrecursive($rgn_atpid1);
        foreach ($res1 as $key => $value) {
            $date1[] = "" . $value['rgn_atpid'] . "";
            $date_fh[] = "'" . $value['rgn_atpid'] . "'";
        }
        $endrgn_atpidsstrings1 = implode(',', $date1);

        $endrgn_atpidsstrings_fh = implode(',', $date_fh);
        $num1['d2d_regionid'] = array('in', $endrgn_atpidsstrings1);
        $num1['d2d_dt'] = date("Y-m-d",time());
        $num1['d2d_atpstatus'] = array('EXP','IS NULL');

        $list1 = M('data2day')->field("SUM(d2d_dglaccu) as ydl,SUM(d2d_syslaccu) as ysl,SUM(d2d_ynlaccu) as ynl,SUM(d2d_yllaccu) as yll")
            ->where($num1)
            ->find();






        $bj1 = M('alarm')->query("
                SELECT t.*,t1.*,t2.*,t3.*,MIN(t.alm_datetime) mindate
                FROM szny_alarm t
                left join szny_device t1 on t.alm_deviceid=t1.dev_atpid
                left join szny_alarmconfig t2 on t.alm_alarmconfigid = t2.almc_atpid
                left join szny_region t3 on t2.almc_regionid = t3.rgn_atpid
                where t.alm_confirmstatus = '待确认' and t2.almc_regionid in ($endrgn_atpidsstrings_fh)
                group by t3.rgn_atpid,t.alm_deviceid,t.alm_alarmconfigid
                order by mindate asc
                LIMIT 3  ");

        $sql_select = "
            select
             sum(if( t2.alm_confirmstatus='待确认',1,0)) alarmcount
            from szny_region t
            left join szny_device t1 on t.rgn_atpid = t1.dev_regionid
            left join szny_alarm t2 on t.rgn_deviceid = t2.alm_deviceid
            where t.rgn_pregionid in ($endrgn_atpidsstrings_fh) and t.rgn_atpstatus is null and t1.dev_atpstatus is null
            order by t.rgn_name asc ";
        $newsbd = M()->query($sql_select);

        $this->assign("alarmcount_".$loubj, $newsbd[0]['alarmcount']);


        $this->assign($loubj, $bj1);
        $this->assign($loudata, $list1);

    }

    public  function checkone(){
        $data=$_GET['rgjson'];

        $data=$this->makeRegionCompareChartF($data,1);

        $this->assign('rgarr',$data);

        $this->display();

    }
    public function makeRegionCompareChart()
    {
        $year = date("Y", time());
        $month = date("Y-m", time());
        $monthf = date("Y-m", strtotime("-1 month"));
        //本年数据
        $whereyear['d2y_dt'] = $year;
        $yearcou = M('data2year')->field("SUM(d2y_dglaccu) as ydl,SUM(d2y_syslaccu) as ysl,SUM(d2y_ynlaccu) as ynl,SUM(d2y_yllaccu) as yll")->where($whereyear)->find();
        // 本月数据
        $wheremonth['d2m_dt'] = $month;
        $monthcou = M('data2month')->field("SUM(d2m_dglaccu) as ydl,SUM(d2m_syslaccu) as ysl,SUM(d2m_ynlaccu) as ynl,SUM(d2m_yllaccu) as yll")->where($wheremonth)->find();
        // 上月数据
        $wheremonthf['d2m_dt'] = $monthf;
        $monthcouf = M('data2month')->field("SUM(d2m_dglaccu) as ydl,SUM(d2m_syslaccu) as ysl,SUM(d2m_ynlaccu) as ynl,SUM(d2m_yllaccu) as yll")->where($wheremonthf)->find();

        $this->assign("qnydl", $yearcou['ydl']?$yearcou['ydl']:"0.00");
        $this->assign("qnysl", $yearcou['ysl']?$yearcou['ysl']:"0.00");
        $this->assign("qnynl", $yearcou['ynl']?$yearcou['ynl']:"0.00");
        $this->assign("qnyll", $yearcou['yll']?$yearcou['yll']:"0.00");


        $this->assign("byydl", $monthcou['ydl']?$monthcou['ydl']:"0.00");
        $this->assign("byysl", $monthcou['ysl']?$monthcou['ysl']:"0.00");
        $this->assign("byynl", $monthcou['ynl']?$monthcou['ynl']:"0.00");
        $this->assign("byyll", $monthcou['yll']?$monthcou['yll']:"0.00");

        $this->assign("syydl", $monthcouf['ydl']?$monthcouf['ydl']:"0.00");
        $this->assign("syysl", $monthcouf['ysl']?$monthcouf['ysl']:"0.00");
        $this->assign("syynl", $monthcouf['ynl']?$monthcouf['ynl']:"0.00");
        $this->assign("syyll", $monthcouf['yll']?$monthcouf['yll']:"0.00");
    }




    public function makeRegionCompareChartF($rgn_id,$istemp=0)
    {
        //获取园区范围
        $res = $this->regionrecursive($rgn_id);
        foreach ($res as $key => $value) {
            $date[] = "" . $value['rgn_atpid'] . "";
            $date_fh[] = "'" . $value['rgn_atpid'] . "'";
        }
        $endrgn_atpidsstrings = implode(',', $date);
        $endrgn_atpidsstrings_fh = implode(',', $date_fh);

        $Model = M();

        //获取位置点信息
        $sql_select = "
            select
             t.*,
             t1.*,
             sum(if( t2.alm_confirmstatus='待确认',1,0)) alarmcount
            from szny_region t
            left join szny_device t1 on t.rgn_atpid = t1.dev_regionid
            left join szny_alarm t2 on t.rgn_deviceid = t2.alm_deviceid
            where t.rgn_pregionid in ($endrgn_atpidsstrings_fh) and t.rgn_atpstatus is null and t1.dev_atpstatus is null
            group by t.rgn_atpid
            order by t.rgn_name asc ";
        $arr = $Model->query($sql_select);
        $newsbd=[];
        $dian=[];
        $rgnid=[];
        $bj=0;
        foreach($arr as $k=>$v) {
            if ($v['dev_name'] == '电表') {
                if($v['alaralarmcount']>0){
                    $bj=1;
                }
                array_push($rgnid,$v['dev_regionid']);
                array_push($dian, $v);

            } else {
                array_push($newsbd, $v);
            }

        }

            foreach($newsbd as $k=>$v){
                    $array[$k+1]=$v;

            }

        $array['dian']['data']=$dian;
        $array['dian']['bj']=$bj;
        $array['dian']['rgnids']=$rgnid;



//        foreach ($newsbd as $key => &$value) {
//            $value['alarmcount'] = $value['alarmcount']."";
//        }
        $this->assign("sbdstatus", $array);
        $this->assign('rgnid',$rgn_id);
        if($istemp){
            return $dian;die;
        }
//dump($newsbd);

        //获取报警信息
        $wherebj['dev_regionid'] = array('in', $endrgn_atpidsstrings);
//        $bjdata = M('alarm')
//            ->join('szny_device on szny_alarm.alm_deviceid=szny_device.dev_atpid')
//            ->join('szny_region on szny_region.rgn_atpid = szny_device.dev_regionid')
//            ->join('szny_devicemodel on szny_device.dev_devicemodelid=szny_devicemodel.dm_atpid')
//            ->where($wherebj)
//            ->order("alm_datetime desc")
//            ->group("rgn_atpid")
//            ->limit(3)
//            ->select();
        $bjdata = M('alarm')->query("
                SELECT t.*,t1.*,t2.*,t3.*,MIN(t.alm_datetime) mindate
                FROM szny_alarm t
                left join szny_device t1 on t.alm_deviceid=t1.dev_atpid
                left join szny_alarmconfig t2 on t.alm_alarmconfigid = t2.almc_atpid
                left join szny_region t3 on t2.almc_regionid = t3.rgn_atpid
                where t.alm_confirmstatus = '待确认' and t2.almc_regionid in ($endrgn_atpidsstrings_fh)
                group by t3.rgn_atpid,t.alm_deviceid,t.alm_alarmconfigid
                order by mindate asc
                LIMIT 3  ");
        $this->assign("bjdata", $bjdata);


        //获取当天数据
        $whereday['d2d_regionid'] = array('in', $endrgn_atpidsstrings);
        $whereday['d2d_dt'] = date("Y-m-d",time());;
        $whereday['d2d_atpstatus'] = array('EXP','IS NULL');
        $dayused = M('data2day')
            ->field("SUM(d2d_dglaccu) as ydl,SUM(d2d_syslaccu) as ysl,SUM(d2d_ynlaccu) as ynl,SUM(d2d_yllaccu) as yll")
            ->where($whereday)
            ->find();
        $dayused['ynl']=$dayused['ynl'];
        $dayused['yll']=$dayused['yll'];
        $this->assign("dayused", $dayused);

        // 当月总体用量
        $month = date("Y-m", time());
        $wheremonth['d2m_dt'] = $month;
        $wheremonth['d2m_regionid'] = array('in', $endrgn_atpidsstrings);
        $yearcou = M('data2month')
            ->field("SUM(d2m_dglaccu) as ydl,SUM(d2m_syslaccu) as ysl,SUM(d2m_ynlaccu) as ynl,SUM(d2m_yllaccu) as yll")
            ->where($wheremonth)
            ->find();
        $yearcou['ynl']=$yearcou['ynl'];
        $yearcou['yll']=$yearcou['yll'];
        // 全年统计总和
        $yearcou['lnl'] = ($yearcou['ynl'] + $yearcou['yll']) . "";
        $zysl = $yearcou['ysl']+0;
        $zydl = $yearcou['ydl']+0;
        $zynl = $yearcou['ynl']+0;
        $zyll = $yearcou['yll']+0;
        $zlnl = $yearcou['lnl']+0;
        $this->assign("zysl", $zysl);
        $this->assign("zydl", $zydl);
        $this->assign("zynl", $zynl);
        $this->assign("zyll", $zyll);
        $this->assign("zlnl", $zlnl);

//        统计本月跟上月数据对比
        // 本月数据
        $month = date("Y-m", time());
        $monthf = date("Y-m", strtotime("-1 month"));
        $wheremonth['d2m_dt'] = $month;
        $wheremonth['d2m_regionid'] = array('in', $endrgn_atpidsstrings);
        $monthcou = M('data2month')->field("SUM(d2m_dglaccu) as ydl,SUM(d2m_syslaccu) as ysl,SUM(d2m_ynlaccu) as ynl,SUM(d2m_yllaccu) as yll")
            ->where($wheremonth)->find();
        $monthcou['lnl'] = $monthcou['ynl'] + $monthcou['yll'];
        if (empty($monthcou['ydl'])) {
            $monthcou['ydl'] = "0";
        }
        if (empty($monthcou['ysl'])) {
            $monthcou['ysl'] = "0";
        }
//        上月数据
        $wheremonthf['d2m_dt'] = $monthf;
        $wheremonthf['d2m_regionid'] = array('in', $endrgn_atpidsstrings);
        $monthcouf = M('data2month')->field("SUM(d2m_dglaccu) as ydl,SUM(d2m_syslaccu) as ysl,SUM(d2m_ynlaccu) as ynl,SUM(d2m_yllaccu) as yll")
            ->where($wheremonthf)->find();
        $monthcouf['lnl'] = $monthcouf['ynl'] + $monthcouf['yll'];
        if (empty($monthcouf['ydl'])) {
            $monthcouf['ydl'] = "0";
        }
        if (empty($monthcouf['ysl'])) {
            $monthcouf['ysl'] = "0";
        }
//        对比
        $duibi['ydl'] = $monthcou['ydl'] - $monthcouf['ydl'];
        $duibi['ysl'] = $monthcou['ysl'] - $monthcouf['ysl'];
        $duibi['lnl'] = $monthcou['lnl'] - $monthcouf['lnl'];
        $duibi['ydl%'] = number_format(($monthcou['ydl'] / $monthcouf['ydl'] - 1) * 100, 2);
        $duibi['ysl%'] = number_format(($monthcou['ysl'] / $monthcouf['ysl'] - 1) * 100, 2);
        $duibi['lnl%'] = number_format(($monthcou['lnl'] / $monthcouf['lnl'] - 1) * 100, 2);
        $this->assign("duibi", $duibi);

//        测试打印
//        dump($newsbd);
//        dump($bjdata);
//        dump($dayused);
//        dump($zysl);
//        dump($zydl);
//        dump($zynl);
//        dump($zyll);
//        dump($zlnl);
//        dump($duibi);
    }


    public function makeRegionCompareChartF2($rgn_id,$assignname)
    {
        //获取园区范围
        $res = $this->regionrecursive($rgn_id);
        foreach ($res as $key => $value) {
            $date_fh[] = "'" . $value['rgn_atpid'] . "'";
        }
        $endrgn_atpidsstrings_fh = implode(',', $date_fh);
        $Model = M();
        //获取位置点信息
        $sql_select = "
            select
             sum(if( t2.alm_confirmstatus='待确认',1,0)) alarmcount
            from szny_region t
            left join szny_device t1 on t.rgn_atpid = t1.dev_regionid
            left join szny_alarm t2 on t.rgn_deviceid = t2.alm_deviceid
            where t.rgn_pregionid in ($endrgn_atpidsstrings_fh)
            order by t.rgn_name asc ";
        $newsbd = $Model->query($sql_select);
        $this->assign($assignname, $newsbd[0]['alarmcount']);
//        dump($newsbd[0]['alarmcount']);
    }




}
