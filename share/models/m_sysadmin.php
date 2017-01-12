<?php
/*
 *@des 后台用户的基本model文件
*@author 57sy.com
*
*/
class M_sysadmin extends M_common {
	function M_sysadmin(){
		parent::__construct();
	}
	/*
	 *@page 第几页
	 *@per_page 每一页显示的数据 
	 *@where 条件数组格式
	 */
	public function querySysadminList($page =  1 ,$per_page , $where = array() ){
		$getwhere = '' ; 
		$condition = intval(isset($where['condition'])?$where['condition']:1);
		$condition  = in_array($condition,array(1,2))?$condition:1;
		if(isset($where['username']) && $where['username']){
			$username = $this->db->escape_str($where['username']) ;
			$array_condition_search  = array(
					1=>" LIKE '%{$username}%'", //模糊搜索
					2=>"= '{$username}'"
			);
			$getwhere = " AND username {$array_condition_search[$condition]} " ; 
		}
		if(isset($where['nick']) && $where['nick']){
			$nick = $this->db->escape_str($where['nick']) ;
			
			$getwhere = " AND nick like '%{$nick}%' " ; 
		}
		$colum = $this->query_columns($this->table_."common_system_user");
		$field = "a.".$where['field'] ; 
		if(!in_array($where['field'], $colum)){
			$field = "a.".$colum[0] ; 
		}
		$orderby = $where['orderby'] ;
		if(!in_array(strtolower($orderby), array('asc' , 'desc' ))){
			$orderby = "asc" ; 
		}
		//print_r($colum);
		$data = array() ;
		$this->load->library("common_page");
		if($page <=0 ){
			$page = 1 ;
		}
		$limit = ($page-1)*$per_page;
		$limit.=",{$per_page}";
		$sql_count = "SELECT COUNT(*) AS tt FROM {$this->table_}common_system_user  as a left join {$this->table_}common_role  as b on a.gid = b.id  where 1 = 1 {$getwhere} ";
		$total  = $this->M_common->query_count($sql_count);
		$page_string = $this->common_page->page_string($total, $per_page, $page);
		$sql_user = "SELECT a.*,b.rolename FROM {$this->table_}common_system_user as a left join {$this->table_}common_role  as b on a.gid = b.id  where 1 = 1 {$getwhere} order by {$field} {$orderby}   limit  {$limit}";
		//echo $sql_user ; die() ;
		$list = $this->M_common->querylist($sql_user);
		
		foreach($list as $k=>$v){
			$list[$k]['status'] = ($v['status'] == 1 )?"开启":'<font color="red">关闭</font>';
			$list[$k]['gid'] = ($v['super_admin'] == 1 )?"<font color='red'>管理员</font>" :$v['rolename'] ;  
			$list[$k]['super_admin'] = ($v['super_admin'] == 1 )?"<font color='red'>管理员</font>":'不是' ; 
		}
		$data = array(
			'list'=>$list , 
			'page_sting'=>$page_string		
		);
		return $data ;
	}
	//添加系统用户
	public function add_sysadmin($data){
		if($data['gid']<=0 && $data['super_admin']!=1 ){
			return array('status'=> 0 , 'message'=> '请选择用户组' ) ;
			
		}elseif(abslength($data['username'])<6 || abslength($data['username'])>16){
			return array('status'=> 0 , 'message'=> '用户名长度必须在3-16之间' ) ;
			
		}elseif($data['passwd'] == "" || utf8_str($data['passwd']) != 1){
			return array('status'=> 0 , 'message'=> '密码不能为空必须是英文' );
			
		}
		$data['username'] = $this->db->escape_str($data['username']) ;
		$data['passwd'] = md5($data['passwd']);
		if($data['super_admin'] == 1 ){
			$data['gid'] = 0 ;
		}
		$sql_one = "SELECT username FROM {$this->table_}common_system_user where username = '{$data['username']}' limit 1  ";
		$info = $this->M_common->query_one($sql_one);
		if(is_array($info) && $info){
			return array('status'=> 0 , 'message'=> '用户已经存在' );
		}
		$array = $this->M_common->insert_one("{$this->table_}common_system_user",$data);
		if($array['affect_num']>=1){
			write_action_log($array['sql'],$this->uri->uri_string(),$this->visitor['username'],get_client_ip(),1,"添加用户为{$data['username']}成功");
			return array('status'=> 1 , 'message'=> 'success' );
		}else{
			write_action_log($array['sql'],$this->uri->uri_string(),$this->visitor['username'],get_client_ip(),0,"添加用户为{$data['username']}失败");
			return array('status'=> 0 , 'message'=> '服务器繁忙 添加用户失败' );
			
		}
	}
	public function judge($id){
		if(!in_array($this->visitor['username'], config_item("super_admin"))){
			return array('status'=>0 , 'message'=>'对不起你没权限进行设置用户的权限信息，必须是超级管理员才可以设置' );
		}
		$sql_= "SELECT a.* FROM {$this->table_}common_system_user as a where a.id = '{$id}'";					
		$info_ = $this->M_common->query_one($sql_);//修改后台用户的基本信息
		if(empty($info_)){
			return array('status'=>0 , 'message'=>'没有此用户的信息' );
		}
		$sql_role = "SELECT * FROM {$this->table_}common_role where status = 1 order by id desc ";
		$list = $this->M_common->querylist($sql_role);
		$perm_array = $this->M_common->querylist("SELECT id,name,pid as parentid,url from {$this->table_}common_admin_nav order by disorder,id desc ");
		$result = array();
		if($perm_array){
			foreach($perm_array as $k=>$v){
				$result[$v['id']]  = $v ;
			}
		}
		$result = genTree9($result,'id','parentid','childs');
		$options =  getChildren($result);	
		$perms = $info_['perm'];
		$perm_array_exists = array();
		if($perms){
			$perm_array_exists = unserialize($perms);
		}
		$temp = array();
		if($options && $perm_array_exists){
		foreach($options as $o_=>$v_){
			if(in_array($v_['url'],$perm_array_exists)){
					$temp[$v_['url']] = $v_['name'];
			}
		}
		}
		unset($perm_array_exists);
		$perm_array_exists = $temp ;
		return array(
			'status'=>1 , 
			'info'=>$info_,
			'list'=>$list,
			'options'=>$options,
			'perm_array_exists'=>$perm_array_exists
		);
	}
	//处理用户设置权限
	public function doSetPerminsions($data){
		$perms = $this->db->escape_str($data['perms']) ;;
		$username = $this->db->escape_str($data['username']) ;
		$nick = $this->db->escape_str($data['nick']) ;
		$status = intval($data['status']);
		$super_admin = intval($data['super_admin']) ; 
		$gid  =intval($data['gid']);
		
		$id = intval($data['id']);
		$perms_string = '' ;
		$perms_array = array();
		if($perms){
			for($i = 0 ;$i <count($perms); $i++){
				if($perms[$i] == ''){
					continue ;
				}
				$perms_array[] = html_escape($perms[$i]);
			}
			if($perms_array){
				$perms_string = serialize($perms_array);
			}
		}
		if(abslength($username)<3 || abslength($username)>16){
			return array('status'=>0 , 'message'=>'用户名长度必须在3-16之间' );
		}
		$where = '';
		if(!$super_admin){
			$where.=", gid = '{$gid}'";
		}
		if(!$super_admin){
			$where.=", perm = '{$perms_string}'";
		}
		$sql_edit = "UPDATE `{$this->table_}common_system_user` SET status = '{$status}' {$where} ,username = '{$username}',super_admin = '{$super_admin}'  , nick = '{$nick}' where id = '{$id}'";
		
		$num = $this->M_common->update_data($sql_edit);
		if($perms_array && !$super_admin){
			$this->make_cache($id , $perms_array);
		}
		
		if($num>=1){
			write_action_log($sql_edit,$this->uri->uri_string(),$this->visitor['username'],get_client_ip(),1,"修改用户{$username}成功");
			return array('status'=>1 , 'message'=>'操作成功' );
		}else{
			write_action_log($sql_edit,$this->uri->uri_string(),$this->visitor['username'],get_client_ip(),0,"修改用户{$username}失败");
			return array('status'=>0 , 'message'=>'操作失败' );
		}
		
	}
	//根据用户的UId查询后台管理员的基本信息
	public function query_sys_admin($id){
		return $this->M_common->query_one("SELECT * FROM `{$this->table_}common_system_user` WHERE id = '{$id}' LIMIT 1 ");
	}
	//修改管理员的密码
	public function edit_passwd($data = array() ){
		if($data['password'] == "" || utf8_str($data['password']) != 1){
			return array('status'=> 0 , 'message'=> '密码不能为空必须是英文' );	
		}
		$passwd = md5($data['password']);
		$sql_edit = "UPDATE `{$this->table_}common_system_user` SET passwd = '{$passwd}' where id = '{$data['id']}'";
		
		$num = $this->M_common->update_data($sql_edit);
		if($num>=1){
			write_action_log($sql_edit,$this->uri->uri_string(),$this->visitor['username'],get_client_ip(),1,"修改用户id是{$data['id']}的密码成功");
			return array('status'=>1 , 'message'=>'操作成功' );
		}else{
			write_action_log($sql_edit,$this->uri->uri_string(),$this->visitor['username'],get_client_ip(),0,"修改用户id是{$data['id']}的密码失败");
			return array('status'=>0 , 'message'=>'操作失败' );
		}
	}
	
	public function self_edit_passwd($data = array() ){
		
		if($data['password'] == "" || utf8_str($data['password']) != 1){
			return array('status'=> 0 , 'message'=> '密码不能为空必须是英文' );
		}
		if($data['repassword'] == "" || utf8_str($data['repassword']) != 1){
			return array('status'=> 0 , 'message'=> '密码不能为空必须是英文' );
		}
		if($data['password'] != $data['repassword'] ){
			return array('status'=> 0 , 'message'=> '2次密码不一样' );
		}
		$passwd = md5($data['password']);
		$sql_edit = "UPDATE `{$this->table_}common_system_user` SET passwd = '{$passwd}' where id = '{$data['id']}'";
	
		$num = $this->M_common->update_data($sql_edit);
		if($num>=1){
			write_action_log($sql_edit,$this->uri->uri_string(),$this->visitor['username'],get_client_ip(),1,"修改密码成功");
			return array('status'=>1 , 'message'=>'操作成功' );
		}else{
			write_action_log($sql_edit,$this->uri->uri_string(),$this->visitor['username'],get_client_ip(),0,"修改密码失败");
			return array('status'=>0 , 'message'=>'操作失败' );
		}
	}
	//生成缓存
	private function make_cache($admin_id , $perm_array){
		if(!is_really_writable(config_item("role_cache"))){
			exit("目录".config_item("role_cache")."不可写");
		}
	
		if(!file_exists(config_item("role_cache"))){
			mkdir(config_item("role_cache"));
		}
		$configfile = config_item("role_cache")."/cache_admin_{$admin_id}.inc.php";
		$fp = fopen($configfile,'w');
		$time = date("Y-m-d", time() );
		flock($fp,3);
		fwrite($fp,"<"."?php\r\n");
		fwrite($fp,"/*用户特殊的权限缓存*/\r\n");
		fwrite($fp,"/*author wangjian*/\r\n");
		fwrite($fp,"/*time {$time}*/\r\n");
		fwrite($fp,"\$admin_perm_array = array(\r\n");
		foreach($perm_array as $k=>$v){
			fwrite($fp,"'{$k}' => '{$v}',\r\n");
		}
		fwrite($fp,");\r\n");
		fwrite($fp,"?".">");
		fclose($fp);
	}
}	