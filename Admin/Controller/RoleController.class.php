<?php
namespace Admin\Controller;
class RoleController extends CommentController
{    
	//角色列表展示
	public function showList(){
        $data = M('Role')->select();
        $this->assign('data',$data);
        $this->display();
	}

	//分派权限
	public function assignAuth(){
		$role_id = I('get.role_id');
		if(IS_POST){
			$auth_id=I('post.auth_id');
			//处理数据写入数据表
			$result = D('Role') -> saveAuth($role_id,$auth_id);
			if($result){
				$this->success('权限分派成功',U('showList'),3);
			}else{
				$this->error('权限分派失败');
			}
		}else{
		//获取role_id
		$role_id = I('get.role_id');
		$role = M('Role')-> find($role_id);

		$top = M('Auth')->where("auth_pid = 0 ")->select();
		$cat = M('Auth')->where("auth_pid != 0")->select();
        
		$this->assign('top',$top);
		$this->assign('cat',$cat);
		$this->assign('role',$role);
        $this->display();
		}
		
	}

	//添加用户
	public function add(){
		if(IS_POST){
		$data = I('post.');

		$model = M('Role')->add($data);
		if($model){
			$this->success('添加成功',U('showList'),3);
		}else{
			$this->error('添加失败');
		}	

		}else{
			$this->display();
		}
	}


	//删除角色
	public function delrole(){
		$role_id = I('get.role_id');
		$result = M('Role')->delete($role_id);
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