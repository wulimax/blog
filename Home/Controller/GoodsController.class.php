<?php
namespace Home\Controller;
use Think\Controller;
class GoodsController extends Controller
{
	public function showlist(){
        $keyword = I('get.keyword');
        $keyword = $keyword?" and goods_name like '%$keyword%'":'';

		 $data = M('Goods')->where("is_show = '1' $keyword ")->select();
		 $sql = M('Goods') -> getLastSql();
	
          $this->assign('data',$data);
		$this->display();
	}

	public function detail(){
	    $goods_id = I('get.goods_id');
	    $goodsInfo = M('Goods')->find($goods_id);
          //获取商品基本信息
	    $this->assign('data',$goodsInfo);
         //获取商品图片
	    $pics = M('Goodspics') -> where("goods_id = $goods_id ")->select();
	    $this->assign('pics',$pics);
	  
        //查询商品唯一属性
	    $single = M('Goodsattr')->field('t2.attr_name,t1.attr_value')
	             ->alias('t1')
	             ->join("left join sp_attribute as t2 on t1.attr_id = t2.attr_id ")
	             ->where("t1.goods_id = $goods_id and t2.attr_sel = '0'")
	             ->select();
        $this-> assign('single',$single);
         
         //查询商品选择属性
         $multi = M('Goodsattr')->field('t2.attr_name,t1.attr_value')
	             ->alias('t1')
	             ->join("left join sp_attribute as t2 on t1.attr_id = t2.attr_id ")
	             ->where("t1.goods_id = $goods_id and t2.attr_sel = '1'")
	             ->select();

	       foreach ($multi as $key => $value) {
	       	$multi[$key]['value'] = explode(',',$value['attr_value']);
	       }
         $this->assign('multi',$multi);
         

		$this->display();
	}
}