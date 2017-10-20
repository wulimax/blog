<?php
namespace Admin\Controller;
use Think\Controller;
//完成公共的功能  比如验证登录
class CommentController extends Controller
{
	public function __construct(){
		//重载  引入基类
		parent:: __construct();
		//确定未登录跳转路径
		$url=U('User/login');
		//跳转 使用 顶级 跳转 top/window
		// if(!session('?user_id')){
		// 	echo "<script> alert('请先登录'); top.location.href=' $url ';</script>";
		// }

		//获取当前页面用户访问的控制器和方法,与用户对应的角色进行比对
		//获取当前页面用户访问路径组合
		$route = strtolower(CONTROLLER_NAME.'-'.ACTION_NAME);
		//获取当前用户对于的角色
		
		if(session("role_id") != '1'){
			$ac = M('Role')->where("role_id=".session('role_id'))->getField('role_auth_ac');
			dump('1');die;
			//转换成小写
			$ac = strtolower($ac.',Index-index,Index-left,Index-top,Index-main');
			//判断是否有权限
		
			if(strpos($ac,$route)===false){
				echo "您没有权限访问";exit;
			}
			
		}
	}
}