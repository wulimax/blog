<?php
namespace Admin\Controller;
use Think\Controller;
class UserController extends Controller
{
		public function login(){

        if(IS_POST){
         
          $verify = new \Think\Verify();
          if($verify->check(I('post.captcha'))){
             $model = D('User');
          $result = $model->create();
          if($result){
             $result['mg_pwd'] =getPassword($result['mg_pwd']);
             $data = $model->where($result)->find();
             if($data){
                $data['mg_time']= time();
                $model->save($data);
                session('user_id',$data['mg_id']);
                session('user_name',$data['mg_name']);
                session('user_time',$data['mg_time']);
                session('role_id',$data['role_id']);
                $this->error('登录成功!',U('Index/index'),3); 
             }else{

              $this->error('用户名密码不正确!');
             }   
          }else{

            $this->error($model->getError());
          }
          }else{
            $this->error('验证码不正确!');
          }

         
         }else{
        	$this->display();
         }
		
	}

	//验证码方法
	public function captcha(){
		$cfg = array(
			'userImgBg'  => false,
			'fontSize'	 => 14,
			'useCurve'   => false,
			'useNoise'   => false,
			'imageH'     => 0,
			'imageW'     => 0,
			'length'     => 4,
			'fontttf'    => '4.ttf'

			);
	    $verify = new \Think\Verify($cfg);
    	$verify -> entry();
	}
  


	public function logout(){
		    session(null);
         if(!session('?user_name')){
         	$this->success('退出成功',U('login'),3);
         }else{
         		$this->error('退出失败',U('Index/index'),3);
         }
	}
}