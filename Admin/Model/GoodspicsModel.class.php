<?php
namespace Admin\Model;
use Think\Model;
class GoodspicsModel extends Model
{
    public function savePics($goods_id,$files){
    	$flag = false;
    	foreach ($files['goods_pic']['error'] as $key => $value){
    		if($value == '0'){
    			$flag = true;
    			break;
    		}
    	}
    	//地址开始
    	if($flag){
    		//实例化上传类
    		$success = 0;
    		$error = 0;
    		$upload = new \Think\Upload(array('rootPath'=>'./Public/Uploads/'));
    		$info = $upload -> upload($files);
    		$image = new \Think\Image();

          foreach ($info as $key => $value){	
    		if($value){
                $data['goods_id'] = $goods_id;
                // 原图
                $data['pics_ori'] = $upload -> rootPath.$value['savepath'].$value['savename'];
                //缩略图 大图
                $image->open($data['pics_ori']);
                $image->thumb(800,800);
                $big = $upload-> rootPath.$value['savepath'].'big_'.$value['savename'];
                $image->save($big);
                $data['pics_big'] = $big;
                //缩略图 中图
                
                $image->thumb(350,350);
                $mid = $upload-> rootPath.$value['savepath'].'mid_'.$value['savename'];
                $image->save($mid);
                $data['pics_mid'] = $mid;
                //缩略图 小图
               
                $image->thumb(50,50);
                $sma = $upload-> rootPath.$value['savepath'].'sma_'.$value['savename'];
                $image->save($sma);
                $data['pics_sma'] = $sma;
                //写入数据库
                $rst= $this -> add($data);
                if($rst){
                	$success++;
                }
    		}else{
               $error++;
    		}
    	  }
    
        }
    	//组织返回数据
    	if($success>0){
    		$result['code'] = '1';
    		$result['message'] = '图片上传成功 , 共成功'.$success.'个, 失败'.$error.'个';
    	}else{
    		$result['code']='0';
    		$result['message'] = '上传失败';
    	}   
    	return $result;

    }	
}