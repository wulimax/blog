<?php
namespace Admin\Controller;
class ManagerController extends CommentController
{
	public function showlist(){
		$data = M('Manager')->select();
		$cat  = M('Role')->select();
		foreach($cat as $key => $value){

		}
		$this->assign('cat',$cat);
		$this->assign('data',$data);
		$this->display();
	}

	//删除用户
	public function delmg(){
		$mg_id = I('get.mg_id');
		$result = M('Manager')->delete($mg_id);
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