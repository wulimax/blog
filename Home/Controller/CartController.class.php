<?php

/**
 * @Author: asus
 * @Date:   2017-08-31 16:14:50
 * @Last Modified by:   asus
 * @Last Modified time: 2017-09-03 08:16:16
 */
namespace Home\Controller;
use Think\Controller;
use Tools\Cart;
class CartController extends Controller
{
	public function add(){
		$post = I('post.');

		$cart = new Cart;
		$info = M('Goods') -> find($post['goods_id']);

		$data = array(
			'goods_id'     =>  $post['goods_id'], //商品 id
			'goods_name'   =>  $info['goods_name'],//商品名
			'goods_price'  =>  $info['goods_price'] / 100 * $info['goods_discount'],//单价
			'goods_buy_number' => $post['amount'],//购买数量
			'goods_total_price'=> $info['goods_price'] /100 * $info['goods_discount'] * $post['amount']
			);
       
		$cart -> add($data);
		
		$total  = $cart-> getNumberPrice();
		$this->ajaxReturn($total);
	}

	public function flow1(){
		$cart = new Cart;
		$cartInfo  =  $cart->getCartInfo();
		if($cartInfo){
		$keys = array_keys($cartInfo);
        $ids = implode(',',$keys);  
        
        $pic =M('Goods')-> where("goods_id in ($ids) ")->getField('goods_id,goods_small_logo');

     
        foreach($cartInfo as $key => $value){
        	$cartInfo[$key]['thumb'] = ltrim ($pic[$key],'.');
        }
        $total = $cart->getNumberPrice();
        $price = $total['price'];
     
		$this->assign('cartInfo',$cartInfo);
		$this->assign('price',$price);
	   }	
		$this->display();
	}

	//订单处理 提交支付
	public function flow2(){
		if(IS_POST){
          $post = I('post.');
          $data['user_id'] = session('user_id');
          $data['order_number'] = date('YmdHis').rand(10000,99999);
          //获取购物车信息
          $cart  = new Cart;
          $total = $cart -> getNumberPrice();

          $data['order_price'] = $total['price'];  //支付金额
          $data = array_merge($post,$data);
          $data['add_time'] = $data['upd_time'] = time();

          //写入数据表
          if($oid = M('Order') ->add($data)){
          	$cartInfo = $cart -> getCartInfo();
          	foreach ($cartInfo as $key => $value) {
          		$temp['order_id'] = $oid;
          		$temp['goods_id'] = $key;
          		$temp['goods_price'] = $value['goods_price'];
          		$temp['goods_number']= $value['goods_buy_number'];
          		$temp['goods_total_price'] = $value['goods_total_price'];
          		M('Order_goods')->add($temp);

          	}
         
          	//清空购物车
          	$cart->delall();
          	//组织数据提交页面
          	$html = "<form action='/App/Tools/alipay/alipayapi.php' name='alipayform' method='post' target='_blank' style='display:none' >
			<input type='text' name='WIDout_trade_no' id='out_trade_no' value='{$data['order_number']}'>
			<input type='text' name='WIDsubject' value='test商品123'>
			<input type='text' name='WIDtotal_fee' value='0.01'>
			<input type='text' name='WIDbody' value='{$data['order_price']}'>
			<input type='submit' class='alisubmit' value ='确认支付'>
		</form>
		<script >
   	    function autoSubmint(){
   		 document.alipayform.submit();
   	     }
         	autoSubmint();
       </script>";
           echo  $html;
          }
		}else{
		if(!session('?user_id')){

			$this->error('请先登录...',U('Public/login',array('redirectUrl' => base64_encode(U('Cart/flow2')))),3);exit;
		}
         //获取数据展示
		$cart = new Cart;
		$cartInfo = $cart -> getCartInfo();
		if($cartInfo){
			$ids = implode(',',array_keys($cartInfo));
			$pic = M('Goods') -> where("goods_id in ($ids) ") ->getField('goods_id,goods_small_logo');
			//将数据进行合并
			foreach ($cartInfo as $key => $value) {
				$cartInfo[$key]['thumb'] = $pic[$key];
			}
            $total = $cart ->getNumberPrice();
            // 分配变量
            $this -> assign('cartInfo',$cartInfo);
            $this -> assign('total',$total);
		}
     
		$this->display();
	  }	
	}
	//支付成功展示页面
	public function flow3(){
		$this->display();
	}

	//实现购物车删除
	public function del(){
		$goods_id = I('post.goods_id');
		$cart = new Cart;
		$cart ->del($goods_id);
		 if(array_key_exists($goods_id, $cart -> getCartInfo())){
             $result = array( 'code' => '1');
		 }else{
		 	   $total = $cart->getNumberPrice();
               $result = array( 
               	'code' => '0',
               	'price' => $total['price']
               	);
		 }
		 $this -> ajaxReturn($result);
	}

	public function edit(){
		$goods_id = I('post.goods_id');
		$amount   = I('post.amout');
		$cart     = new Cart;
		$goods_total_price = $cart ->changeNumber($amount,$goods_id);
		$total = $cart -> getNumberPrice();
		$price = $total['price'];
		$data = array(
		 'goods_total_price' => $goods_total_price,
		 'price'             => $price
			);
		$this->ajaxReturn($data);
	}

}