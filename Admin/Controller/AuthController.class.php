<?php
namespace Admin\Controller;
class AuthController extends CommentController
{    
	//权限列表
	public function showlist(){
        $data = M('Auth')->select();
        //使用无限及分类
        load('@/tree');
        $data = getTree($data);
            $this->assign('data',$data);
		$this->display();
	}

	//添加权限
	public function add(){
		if(IS_POST){
			 M('Auth') -> create();
			$result=M('Auth')->add();
			if($result){
				$this->success('添加成功');
			}else{
				$this->error('添加失败');
			}
		}else{
		$top = M('Auth')->where('auth_pid = 0')->select();
		$this-> assign('auth',$top);
		$this->display();
		}
	}

	//删除
	public function delauth(){
		$auth_id = I('get.auth_id');
		$result = M('Auth')->delete($auth_id);
		if($result){
			$arr=array(
				'code' => '1',
				'message' => '删除成功'
				);
		}else{
			$arr=array(
				'code' => '0',
				'message' => '删除失败'
				);
		}
		return $this->ajaxReturn($arr);
	}
}