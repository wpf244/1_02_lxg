<?php
namespace app\mobile\controller;

class Index extends Common
{
    public function index()
    {
        //轮播图
        $lb=db("lb")->where("fid=1 and status=1")->select();
        $this->assign("lb",$lb);

        //商城公告
        $notic=db("lb")->where("fid=2 and status=1")->select();
        $this->assign("notic",$notic);

        //图标
        $new_icon=db("lb")->where("fid=3")->find();
        $this->assign("new_icon",$new_icon);

        $sales_icon=db("lb")->where("fid=4")->find();
        $this->assign("sales_icon",$sales_icon);

        $order_icon=db("lb")->where("fid=5")->find();
        $this->assign("order_icon",$order_icon);

        $all_icon=db("lb")->where("fid=6")->find();
        $this->assign("all_icon",$all_icon);

        return $this->fetch();
    }
    public function detail()
    {
        $id=input('id');
        $re=db("lb")->where("id=$id")->find();
        $this->assign("re",$re);
        return $this->fetch();
    }
}