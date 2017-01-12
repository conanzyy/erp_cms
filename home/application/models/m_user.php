<?php
/*@des 网站会员model文件
 *@author 57sy.com 
 *@time 2015-02-26 
 */
class M_user extends M_common {
	function M_user(){
		parent::__construct();
	}
	//添加用户
	public function addUser($data = array()){
		if(!preg_match("/^[a-zA-Z0-9_]{6,16}$/",$data['username'])){
			return array('status'=> 0 , 'message'=>'用户名必须是字母数字和下划线6-16位');
		}elseif(!preg_match("/^[a-zA-Z0-9_]{6,16}/",$data['passwd'])){
			return array('status'=> 0 , 'message'=>'密码必须是字母数字和下划线6-16位');
		}elseif($data['passwd'] != $data['repasswd']){
			return array('status'=> 0 , 'message'=>'2次密码不相同');
		}
		//查询用户是否存在
		$sql = "SELECT * FROM {$this->table_pre}common_user where username = ?  limit 1 ";	
		$query  = $this->db->query($sql, array($data['username']));
		if($query->num_rows() >= 1 ){
			return array('status'=> 0 , 'message' => '用户已经存在');
		}
		
		//插入到数据库里面
		$insertData = $this->M_common->insert_one("{$this->table_pre}common_user" , array(
			'username'=>$data['username'] , 
			'passwd'=>md5($data['passwd']),	
			'status'=>1 , 
			'regdate'=>time() ,
			'expire'=> 0 ,
		));
		if($insertData['affect_num'] >= 1 ){
			$this->saveUserCookie($insertData['insert_id']) ;
			return array('status'=>1 , 'message'=>'success');
		}else{
			return array('status'=> 0 , 'message' => '服务器繁忙请稍后');
		}
	}
	
	//写入用户的登录状态
	//uid 用户的UID
	public function saveUserCookie($uid = '' ){
		//根据UID查询用户的基本信息
		$info = $this->M_common->query_one("SELECT uid , username ,regdate FROM {$this->table_pre}common_user where uid = '{$uid}' limit 1  ");
		if($info){
			$str = serialize($info) ;
			$str = auth_code($str , "ENCODE" , config_item("cookie_auth_key"));
			setcookie("web_user_auth" ,$str , time()+config_item("cookie_expire") , config_item("cookie_path") , config_item("cookie_domain") , config_item("cookie_secure"));
		}
	}
	//用户登录
	public function userLogin($data = array() ){
		if(!preg_match("/^[a-zA-Z0-9_]{6,16}$/",$data['username'])){
			return array('status'=> 0 , 'message'=>'用户名必须是字母数字和下划线6-16位');
		}elseif(!preg_match("/^[a-zA-Z0-9_]{6,16}/",$data['passwd'])){
			return array('status'=> 0 , 'message'=>'密码必须是字母数字和下划线6-16位');
		}
		$passwd = md5($data['passwd']);
		//查询用户是否存在
		$sql = "SELECT * FROM {$this->table_pre}common_user where username = ? AND passwd  = ?  limit 1 ";
		$query  = $this->db->query($sql, array($data['username'] , $passwd));
		$info = $query->row_array() ;
		if(!$info){
			return array('status'=> 0 , 'message'=>'用户不存在或者密码错误');
		}
		if($info['status'] == 0 ){
			return array('status'=> 0 , 'message'=>'此帐号已经冻结，请联系管理员');
		}
		if($info['expire'] > 0 ){
			//判断日期
			if($info['expire'] < time()){
				return array('status'=> 0 , 'message'=>'此帐号已经过期，请联系管理员');
			}
		}
		//登录成功，写入登录状态
		$this->saveUserCookie($info['uid']);
		return array('status'=> 1 , 'message'=>'success');
	}

}	