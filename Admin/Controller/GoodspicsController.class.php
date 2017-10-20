<?php
namespace Admin\Controller;

class GoodspicsController extends CommentController
{
	//相册模板页面
	public function photos(){
		$goods_id = I('get.goods_id');
		
        if(IS_POST){
        	 $model = D('Goodspics');
        	$result = $model->savePics($goods_id,$_FILES);

        	if($result['code']=='1'){
        		$this->success($result['message'],U('photos',array('goods_id'=>$goods_id)));
        	}else{
        		$this->error($result['message']);
        	}
        }else{
        	$data = M('Goodspics')->where($goods_id)->select();
            $this->assign('data',$data);
        	$this->display();
        }
		
	}

	//异步删除操作
	public function delPic(){
		if(IS_AJAX){
			$pic_id = I('get.pics_id');
			
			$data = M('Goodspics')->find($pic_id);
			unlink($data['pics_ori']);
			unlink($data['pics_big']);
			unlink($data['pics_mid']);
			unlink($data['pics_sma']);
			$result=M('Goodspics')->delete($pic_id);
			if($result){
				$arr = array(
					'code' => 1,
					'message' => '删除成功'
					);
			}else{
				$arr = array(
					'code' => 1,
					'message' => '删除失败'
					);
			}
			$this->ajaxReturn($arr);
		}
	}
}