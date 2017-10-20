<?php
namespace Admin\Model;
use Think\Model;
class RoleModel extends Model
{
	public function saveAuth($role_id,$auth_id){
		$data['role_id'] = $role_id;
		$data['role_auth_ids'] = implode(',',$auth_id);
		$str = '';
		
		$ac = M('Auth') ->where("auth_id in ({$data['role_auth_ids']}) and auth_pid != 0 ")->select();

		foreach($ac as $key => $value){
			$str .=$value['auth_c'].'-'.$value['auth_a'].',';
		}

		$data['role_auth_ac'] = rtrim($str,',');

		return $this -> save($data);
	}
}