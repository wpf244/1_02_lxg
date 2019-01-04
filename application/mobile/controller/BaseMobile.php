<?php
namespace app\mobile\controller;

use think\Controller;


class BaseMobile extends Controller
{
    function _initialize(){
      
        if (!defined('CONTROLLER_NAME')) {
            define('CONTROLLER_NAME', $this->request->controller());
        }
        if (!defined('ACTION_NAME')) {
            define('ACTION_NAME', $this->request->action());
        }
        if(empty(session('userid'))){
            $this->redirect("login/index");
        }
        $sys=db('sys')->where("id=1")->find();
        $this->assign("sys",$sys);

        $seo=db("seo")->where("id=1")->find();
        $this->assign("seo",$seo);
       
        
    }
}