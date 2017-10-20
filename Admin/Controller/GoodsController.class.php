<?php
namespace Admin\Controller;
use Think\Controller;
class GoodsController extends CommentController
{

	public function add(){
     if(IS_POST){     
      if($_FILES['shangpintu']['error']==0){
        $upload = new \Think\Upload(array('rootPath'=> './Public/Uploads/'));
        //调用上传方法
        $info = $upload-> uploadOne($_FILES['shangpintu']);
        //判断是否成功
        if($info){
          //组装存储路径
          $_POST['goods_big_logo'] = $upload-> rootPath.$info['savepath'].$info['savename'];
		  dump($_POST);die;
          //制作缩略图
          $image = new \Think\Image();
          $image -> open($_POST['goods_big_logo']); //打开图片
          $image -> thumb(100,100);//等比例缩放
          //保存
          $image -> save($upload->rootPath.$info['savepath'].'thumb'.$info['savename']);
          //将数据写入数据表中
          $_POST['good_small_logo'] = $upload -> rootPath.$info['savepath'].'thumb_'.$info['savename'];
        }else{
          $this->error($upload->getEror());die;
        }
      }
      //将数据写入数据库
      $_POST['upd_time'] = $_POST['add_time']=time();
      $attr = I('post.attr');
      $model = D('Goods');
      
      $data = $model->create();
// dump($data);die;
      $data['goods_introduce'] = filterXSS($_POST['goods_introduce']);
  
      //创建数据库对象  调用映射 验证方法
    if($data){
       $result = $model->add($data);
        if($result){
             D('Goodsattr')->saveAttr($result,$attr);
          $this->success('添加成功');die;
        }else{
          $this->error('添加失败');die;
        }
    }else{
      $this->error($model->getError());
    }
     }else{
      $type= M('Type')->select();
      $this->assign('data',$type);
      $this->display();
     }      		
	}

	//创建商品列表
	public function showList(){
        
        $count = M('Goods')->count();
        $page = new \Think\Page($count,3);
        //定义分页样式
        $page->setConfig('prev', '上一页');
        $page->setConfig('next', '下一页');
        $page->setConfig('first', '首页');
        $page->setConfig('last', '末页');
        $firs= $page->firstRow;
        $show = $page -> show();
        $data = M('Goods')->limit($firs,$page->listRows)-> select();
 
        $this -> assign('firs',$firs/3);
        $this -> assign('count',$count);
        $this -> assign('show',$show);
        $this -> assign('data',$data);
		$this -> display();
	}

  //ajax
  public function getAttr(){
    $type_id = I('get.type_id');
    $data = M('Attribute')->where("type_id = $type_id ")->select();
    $this->ajaxReturn($data);
  }
}