<?php

/**
 * @Author: asus
 * @Date:   2017-08-25 11:01:10
 * @Last Modified by:   asus
 * @Last Modified time: 2017-08-25 19:24:19
 */
namespace Admin\Model;
use Think\Model;
class UserModel extends Model
{
      protected $_map = array(
      	'username'  => 'mg_name',
      	'password'  => 'mg_pwd'
      	);
      protected $patchValidate = true;
      protected $_validate = array(
       array('mg_name','checkName','用户名不正确',1,'function',4),
      array('mg_pwd','checkPwd','密码错误',1,'function',4)
      	);
      protected $trueTableName = 'sp_manager';
}