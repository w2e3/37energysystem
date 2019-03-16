<?php
namespace Admin\Controller;
use Think\Controller;
class IndexController extends BaseController {

    public function index()
    {
        $this->redirect('/Admin/Login');
//        $this->display();
    }

    public function regionrecursive()
    {
        $Model = M();
        $sql_select = "
            call regionrecursive('guid1A15CA6C-E3D2-4779-BF6B-F6C2D4706C9D');";
        $Result = $Model->query($sql_select);
        dump($Result);
    }

}