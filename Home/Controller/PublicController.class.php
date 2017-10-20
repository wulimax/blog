<?php
namespace Home\Controller;
use Think\Controller;
class PublicController extends Controller
{
	public function login(){

         if(IS_POST){
         	//接收用户信息
         	$code = I('post.checkcode');//验证码
            $verify = new \Think\Verify();
            $result = $verify->check($code); //验证验证码返回布尔值
          
            $_POST['password1'] = getPassword($_POST['password1']);
           
            if($result){   	
               $model = D('User');
               $data= $model -> create();
              $data['is_del'] = '0';
               $user = $model->where($data)->find();
                $data['add_time']  = time(); 
               
               if($user){
                  $model ->save($data);
                  session('user_id',$user['user_id']);
                  session('user_name',$user['user_name']);
                  //根据情况跳转 判断
                  $redirectUrl  = I('get.redirectUrl');
                  if($redirectUrl){
                    $this -> success('登录成功',base64_decode($redirectUrl),3);
                  }else{
                    $this-> success('登录成功',U('Index/index'),3);
                  }
                 

               }else{
                  $this->error('用户名名密码不正确',U('login'),3);
               }
            }else{
               $data=session('?username');

               $this->assign('data',$data);
            	$this->error('验证码错误');
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
  
          

	//注册页面
	public function register(){
      if(IS_POST){

          if(I('post.password1') != I('post.password2')){
                   $this->error('密码两次不一致');
          }
          $_POST['add_time'] = time();
          $rules = array(
      array('user_name','require','用户名不能为空',1),
      array('user_name','','用户名以存在',1,'unique',1),
      array('user_pwd','require','密码不能为空',1)
       );

      	$model = D('User');
      	$data=$model ->validate($rules)-> create();

       
      	if($data){
          $data['user_pwd']= getPassword($data['user_pwd']);
          

          $result = $model->add($data);
          if($result){
            $this->success('注册成功',U('Index/index'),3);
          }else{
               $this->error('注册失败');
          } 
      		
      	}
      }else{
      	$this->display();
      }
		
	}

   //用户信息
   public function order(){
      $data=session('?username');
      if($data){
         $this->assign('data',$data);
        $this->display(); 
     }else{
         $this->error('请先登录',U('User/login'),1);
      
      }
     }
     //退出
     public function logout(){
      session(null);
      if(!session("?username")){
        $this->success('退出成功');
      }else{
        $this->error('退出失败');
      }
     }

    
}