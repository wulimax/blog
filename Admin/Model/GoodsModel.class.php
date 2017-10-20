<?php
namespace Admin\Model;
use Think\Model;
class GoodsModel extends Model
{
    protected $_map = array(
        //表单name值 => 数据表字段名
		'name'      =>  'goods_name',
		'price'     =>  'goods_price',
		'weight'    =>  'goods_weight',
    'shangpintu'=>  'goods_big_logo',
    	);
    
    // protected $patchValidate = true;
    // protected $_validate = array(
      // array('goods_name','require','商品名不能为空','1'),
      // array('goods_name','','商品名不能为空','1','unique',1)
      // array('goods_name','','商品名必须是唯一',1,'unique')
      // array('goods_name','','商品名必须是唯一','1','unique'),
      // array('goods_price','require','商品价格不能为空','1')

    	// );

      protected $_validate = array(
      //验证字段,验证规则,错误提示,验证条件,附加规则,验证时间
      //商品名称必填，唯一
      array('goods_name','require','商品名称不能为空','1'),
      array('goods_name','','商品名称必须唯一','1','unique'),
      array('goods_price','require','商品价格不能为空','1'),
      //...
    );
}