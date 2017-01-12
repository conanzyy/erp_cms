<?php
/*
 *@des role model文件
*@author 57sy.com
*
*/
class M_role extends M_common {
	private $role_id = '' ;
	private $role_cache_path = '' ;
	private $perm_data = array() ;
	function M_role(){
		parent::__construct();
		
		$this->role_cache_path =  config_item("role_cache");
	}
	//查询角色列表数据和分页
	/*
	 *@page 第几页
	 *@per_page 每一页显示的数据 
	 */
	public function queryRoleList($page =  1 ,$per_page){
		$data = array() ;
		$this->load->library("common_page");
		if($page <=0 ){
			$page = 1 ;
		}
		$limit = ($page-1)*$per_page;
		$limit.=",{$per_page}";
		$sql_count = "SELECT COUNT(*) AS tt FROM {$this->table_}common_role ";
		$total  = $this->M_common->query_count($sql_count);
		$page_string = $this->common_page->page_string($total, $per_page, $page);
		$sql_role = "SELECT * FROM {$this->table_}common_role order by id desc limit  {$limit}";
		$list = $this->M_common->querylist($sql_role);
		foreach($list as $k=>$v){
			$list[$k]['status'] = ($v['status'] == 1 )?"开启":'<font color="red">关闭</font>';
			$list[$k]['cache_file'] = (file_exists(config_item("role_cache")."/cache_role_{$v['id']}.inc.php"))?"存在":'<font color="red">不存在</font>';
			$list[$k]['filemtime'] = (file_exists(config_item("role_cache")."/cache_role_{$v['id']}.inc.php"))?date("Y-m-d H:i:s",filemtime(config_item("role_cache")."/cache_role_{$v['id']}.inc.php")):'<font color="red">文件不存在</font>';
		}
		$data = array(
			'list'=>$list , 
			'page_sting'=>$page_string		
		);
		return $data ;
	}
	//添加角色
	public function addRole($data){
		$returnData = $this->queryRolenameExists($data['rolename']) ;
		
		if($returnData){
			return array('status'=>false , 'message'=>'角色已经存在' ) ;
		}

		$array = $this->M_common->insert_one("{$this->table_}common_role",$data);
		if($array['affect_num']>=1){
			write_action_log($array['sql'],$this->uri->uri_string(),$this->visitor['username'],get_client_ip(),1,"添加角色为{$data['rolename']}成功");
			return array('status'=>true , 'message'=>'success' ) ;
		}else{
			write_action_log($array['sql'],$this->uri->uri_string(),$this->visitor['username'],get_client_ip(),0,"添加角色为{$data['rolename']}失败");
			return array('status'=>false , 'message'=>'服务器繁忙请稍后' ) ;
		}
	}
	//根据角色名称查询是不是存在
	public function queryRolenameExists($rolename){
		$rolename = $this->db->escape_str($rolename) ;
		$sql = "select id , rolename from {$this->table_}common_role where rolename = '{$rolename}' limit 1 " ;
		return $this->db->query($sql)->row_array();
	}
	//根据角色id查询角色是否存在
	public function queryRoleById($id){
		$sql = "select * from {$this->table_}common_role where id = '{$id}' limit 1 " ;
		return $this->db->query($sql)->row_array();
	}
	
	//设置权限
	public function updateRole($data){
		$sql_role = "SELECT rolename FROM {$this->table_}common_role WHERE id = '{$data['id']}'";
		$info = $this->M_common->query_one($sql_role);
		if(!$info){
			write_action_log($sql_role,$this->uri->uri_string(),$this->visitor['username'],get_client_ip(),0,"参数错误");
			return array('status'=> 0 , 'message'=>'数据存在' ) ;
		}
		$role_array = $data['role_array'];
		if($role_array){
			for($k = 0 ; $k<count($role_array);$k++){
				$role_data[] = $role_array[$k];
			}
			$perm = serialize($role_data);
		}

		$update_data = array(
			'rolename'=>$data['rolename'] ,
			'perm'=>$perm , 
			'status'=>$data['status'] 	
		);
	 	$status = $this->db->update("{$this->table_}common_role", $update_data, "id = '{$data['id']}' ");
		$sql_last = $this->db->last_query();
		if($status){
			write_action_log($sql_last,$this->uri->uri_string(),$this->visitor['username'],get_client_ip(),1,"修改角色为{$data['rolename']}的权限成功");
			$this->role_id = $data['id'];
			$this->perm_data = $role_data;
			$this->make_cache();
			return array('status'=>1 , 'message'=>'success' );
		} 
		write_action_log($sql_last,$this->uri->uri_string(),$this->visitor['username'],get_client_ip(),0,"服务器繁忙请稍后");
		return array('status'=> 0  , 'message'=>'服务器繁忙请稍后' );
		
	}
	//生成缓存
	private function make_cache(){
		if(!is_really_writable($this->role_cache_path)){
			exit("目录".$this->role_cache_path."不可写");
		}
	
		if(!file_exists($this->role_cache_path)){
			mkdir($this->role_cache_path);
		}
		$configfile = $this->role_cache_path."/cache_role_{$this->role_id}.inc.php";
		$str = '' ;
		$time = date("Y-m-d H:i:s",time());
		$fp = fopen($configfile,'w');
		flock($fp,3);
		fwrite($fp,"<"."?php\r\n");
		fwrite($fp,"/*团队角色缓存*/\r\n");
		fwrite($fp,"/*author 57sy.com*/\r\n");
		fwrite($fp,"/*time {$time}*/\r\n");
		//fwrite($fp,"\$role_array = array(\r\n");
		/* foreach($this->perm_data as $k=>$v){
		 fwrite($fp,"'{$k}' => '{$v}',\r\n");
		} */
		$str.="\$role_array = ";
		$str.= var_export($this->perm_data,true)  ;
		fwrite($fp,"{$str};\r\n");
		//fwrite($fp,");\r\n");
		fwrite($fp,"?".">");
		fclose($fp);
	}
}