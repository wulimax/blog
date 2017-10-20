<?php
namespace Admin\Controller;
use Think\Controller;
class IndexController extends CommentController {

    public function index(){
    	
        	$this->display();
    }

    public function top(){
        $this->display();
    }
     public function left(){
        $role_id = session('role_id');
        //获取权限id集合
        if($role_id == '1'){
            //获取超管权限
            $top = M('Auth') -> where("auth_pid = 0 and is_show = 1")->select();
            $cat = M('Auth') -> where("auth_pid != 0 and is_show = 1")->select();
        }else{
            //非超管
            $ids = M('Role')->where("role_id = $role_id")->getField("role_auth_ids");
            //根据ID查询集合
            $top = M('Auth') -> where("auth_pid = 0 and auth_id in ($ids) and is_show = 1")->select();
            $cat = M('Auth') -> where("auth_pid !=0 and auth_id in ($ids) and is_show = 1")->select();
        }

        $this->assign("top",$top);
        $this->assign("cat",$cat);
        $this->display();
    }
     public function main(){
      
        $this->display();
    }
}