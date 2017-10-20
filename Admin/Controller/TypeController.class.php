<?php
namespace Admin\Controller;
class TypeController extends CommentController
{
       public function add(){
       	if(IS_POST){	

		   M('Type')->create();
		   $model = M('Type')->add();

		if($model){
			$this->success('添加成功',U('showlist'),3);
		}else{
			$this->error('添加失败');
		}
       	}else{
       	$this->display();	
       	}
       	
       }

       // 展示
       public function showlist(){
              $data = M('Type')->select();
              $this->assign('data',$data);
       	$this->display();
       }
}