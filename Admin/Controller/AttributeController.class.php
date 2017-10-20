<?php
namespace Admin\Controller;
class AttributeController extends CommentController
{
	public function add(){
		
		if(IS_POST){
          $model = M('Attribute');
          $data = $model -> create();
          $data['attr_vals'] = str_replace(',',',',$data['attr_vals']);
          $result = $model -> add($data);
          if($result){
          	$this->success('商品属性添加成功',U('add'),3);
          }else{
          	$this->error('商品属性添加失败');
          }

		}else{
			$type = M('Type')->select();
			$this->assign('data',$type);
			$this->display();
		
		}

		
	}

		//展示视图
		public function showlist(){
            
            $data = M('Attribute') -> field('t1.*,t2.type_name')->alias('t1')->join('left join sp_type as t2 on t1.type_id=t2.type_id')->select();
            $this->assign('data',$data);
			$this->display();
		}
}