<?php
namespace Mobile\Controller;
use Think\Controller;
class BaseAuthController extends BaseController
{
    function _initialize()
    {
        parent::_initialize();
        if (!session('emp_atpid')) {
            $this->redirect('/Mobile/Login/index');
        }
    }
}