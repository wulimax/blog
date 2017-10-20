<?php
namespace Admin\Model;
use Think\Model;
class GoodsattrModel extends Model
{
	public function saveAttr($goods_id,$attr){
       $i = 0;
       foreach($attr as $key => $value){
       	$data[$i]['goods_id'] = $goods_id;
       	$data[$i]['attr_id'] = $key;
       	$data[$i]['attr_value'] = implode(',',$value);
       	$i++;
       }
       $this->addAll($data);
	}
}