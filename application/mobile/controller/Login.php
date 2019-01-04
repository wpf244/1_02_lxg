<?php
namespace app\mobile\controller;


class Login  extends Common
{
    public function index()
    {
        return $this->fetch();
    }
    public function check(){
        // $data = input('post.');
        //  if(!captcha_check(input('post.verify'))) {
        //      // 校验失败
        //      $this->error('验证码不正确');exit;
        //  }
         $phone=input('post.phone');
         $pwd=md5(input('post.pwd'));
         $re=db("user")->where(array('phone'=>$phone,'pwd'=>$pwd))->find();
         if($re){
            if($re['status'] == 1){
                session('userid',$re['uid']);
                $this->success('登陆成功 ^_^',url('Index/index'));
            }else{
             $this->error('此账号未激活，请联系管理员激活',url('Login/index'));
            }
             
         }else{
             $this->error('登录失败：用户名或密码错误。',url('Login/index'));
         }
     }
    public function register()
    {
        return $this->fetch();
    }
    //发送验证码
    public function checkphone()
    {
        $phone=input('phone');
        $reu=db("user")->where("phone= '$phone'")->find();
        if($reu){
            echo '1';exit;
        }else{
            $code =mt_rand(100000,999999);       
            $data['phone']=$phone;
            $data['code']=$code;
            $data['time']=time();
            $re=\db("sms_code")->where("phone='$phone'")->find();
            if($re){
                $del=db("sms_code")->where("phone='$phone'")->delete();
            }
            $rea=db("sms_code")->insert($data);
     
            Post($phone,$code);
        }
    }
    public function save()
    {      
        $phone=input('phone');
        $reu=db("user")->where("phone= '$phone'")->find();
        if(!$reu){
        
            $code=input('yzm');
            $re=db("sms_code")->where(['phone'=>$phone,'code'=>$code])->find();
            if($re){
                $time=$re['time'];
                $times=time();
                $c_time=($times-$time);
                if($c_time < 300){
                    $del=db("sms_code")->where("id={$re['id']}")->delete();
                    
                    $data['pwd']=md5(\input('pwd'));
                    $data['phone']=$phone;
                    $data['time']=time();
                    $data['coupon']=300;
    
                
                    $res=db("user")->insert($data);
                    if($res){
                        $this->success("注册成功",url('Login/index'));
                    }else{
                        $this->success("注册失败",url('Login/register'));
                    }

                }else{
                    $this->error("验证码已失效",url('Login/register'));
                }
            }else{
                $this->error("验证码错误",url('Login/register'));
            }
        }else{
            $this->error("此手机号码已注册",url('Login/register'));
        }  
    }
    public function forget()
    {
        return $this->fetch();
    }
    public function checkphones()
    {
        $phone=input('phone');
        $reu=db("user")->where("phone= '$phone'")->find();
        if($reu){
            $code =mt_rand(100000,999999);       
            $data['phone']=$phone;
            $data['code']=$code;
            $data['time']=time();
            $re=\db("sms_code")->where("phone='$phone'")->find();
            if($re){
                $del=db("sms_code")->where("phone='$phone'")->delete();
            }
            $rea=db("sms_code")->insert($data);
     
            Post($phone,$code);
           
        }else{
            echo '1';exit;
        }
    }
    public function usave()
    {      
        $phone=input('phone');
        $reu=db("user")->where("phone= '$phone'")->find();
        if($reu){
        
            $code=input('yzm');
            $re=db("sms_code")->where(['phone'=>$phone,'code'=>$code])->find();
            if($re){
                $time=$re['time'];
                $times=time();
                $c_time=($times-$time);
                if($c_time < 300){
                    $del=db("sms_code")->where("id={$re['id']}")->delete();
                    
                    $data['pwd']=md5(\input('pwd'));
                  
    
                    $res=db("user")->where("phone= '$phone'")->update($data);
                  
                   $this->success("修改成功",url('Login/index'));
                   

                }else{
                    $this->error("验证码已失效",url('Login/forget'));
                }
            }else{
                $this->error("验证码错误",url('Login/forget'));
            }
        }else{
            $this->error("此手机号码未注册",url('Login/register'));
        }  
    }







}