<?php
/*
 *@des 后台导航model文件
 *@author 57sy.com 
 * 
 */
class M_nav extends M_common {
	public $nav_path = '' ;
	function M_nav(){
		parent::__construct();
		$this->nav_path = config_item("nav_cache");
	}
	/*@child_str 数组下标
	 *@where 查询条件
	 *
	 */
	function queryNav($child_str = 'items' , $where = '' ){
		
		if($where == '' ){
			$where = " AND status = '1' " ;
		}
		$sql = "SELECT id,name,pid as parentid,url,status,addtime,disorder ,path from {$this->table_}common_admin_nav where 1=1 {$where}  order by disorder,id desc " ;
		$list = $this->querylist($sql);
		$result = array();
		/* echo "<pre>";
		print_r($list) ; */
		if($list){
			foreach($list as $k=>$v){
				
				$result[$v['id']]  = $v ;
				
			}
		}
		
		$result = genTree9($result,'id','parentid',$child_str);
		/* echo "<pre>";
		print_r($result) ; die(); */
		return $result ;
	}
	
	//查询头部导航菜单
	public function queryTopNav($isJudgeUrl = false ){
		$where = " AND status = '1' AND pid = '0'  " ;
		$sql = "SELECT id,name,pid as parentid,url,status,addtime,disorder ,path from {$this->table_}common_admin_nav where 1=1 {$where}  order by disorder,id desc " ;
		$list = $this->querylist($sql);
		if($list && $isJudgeUrl){
			foreach($list as $k => $v ){
				$url = $v['url'];
				if(substr($v['url'],-1) == '/'){
					$url= substr($url,0,-1) ;
				}
				if(!in_array($url, $this->_url_data)){
					unset($list[$k]) ; 
				}
			}
		}
		
		return $list ;
	}
	
	
	//把数格式化为二位数组进行遍历
	public function getTreeData($tree  ){
		static $data ;
		foreach($tree as $t){
			$data[] = array(
					'id'=>$t['id'] ,
					'name'=>$t['name'] ,
					'status'=>$t['status'] ,
					'parentid'=>$t['parentid'] ,
					'path'=>$t['path'] ,
					'addtime'=>$t['addtime'] ,
					'url'=>$t['url'] ,
					'disorder'=>$t['disorder'] ,
					'index'=>count(explode("-" , $t['path']))
						
			)  ;
			if(isset($t['items'])){
				
				$this->getTreeData($t['items']  );
			}
		}
		return $data ;
	}

	//插入数据
	public function insert_nav($data){
		$array = $this->M_common->insert_one("{$this->table_}common_admin_nav",$data);
		if($array['affect_num']>=1){
			$one = $this->M_common->query_one("select pid from `{$this->table_}common_admin_nav` where id = '{$array['insert_id']}' limit 1 ") ;
			$top = $this->queryPid($one['pid']);
			$path_array = array_reverse($top) ;
			$path = implode("-" , $path_array);
			$sql_update = "UPDATE `{$this->table_}common_admin_nav` set path = '{$path}' where id = '{$array['insert_id']}'";
			$num = $this->M_common->update_data($sql_update);
			//showmessage("添加成功","nav/index",3,1);
			write_action_log($array['sql'],$this->uri->uri_string(),$this->visitor['username'],get_client_ip(),1,"添加导航{$data['name']}成功");
			return true;
		}else{
			write_action_log($array['sql'],$this->uri->uri_string(),$this->visitor['username'],get_client_ip(),0,"添加导航{$data['name']}失败");
			return false ;
		} 
	}
	//修改导航
	public function edit_nav($data){
		$one = $this->M_common->query_one("select pid,path from `{$this->table_}common_admin_nav` where id = '{$data['pid']}' limit 1 ") ;
		if($data['pid'] == 0 ){
			$newpath = 0 ; 
		}else{
			$newpath = $one['path']."-".$data['pid'];
		}
		
		$update_data = array(
				'pid'=>$data['pid'],	
				'name'=>$data['name'],
				'url'=>$data['url'],
				'disorder'=>$data['disorder'],
				'status'=>$data['status'],
				'path'=>$newpath
		) ;
		
		$status =  $this->db->update("{$this->table_}common_admin_nav", $update_data, "id = '{$data['id']}' ");
		$last_sql =  $this->db->last_query();
		
		//修改下一级的状态
		$sql_child  = "UPDATE `{$this->table_}common_admin_nav` SET `status` = '{$data['status']}' where path like '{$newpath}-{$data['id']}%'  " ;
		//die();
		$this->M_common->update_data($sql_child);
		if($status){
			write_action_log($last_sql,$this->uri->uri_string(),$this->visitor['username'],get_client_ip(),1,"编辑导航{$data['name']}成功");
			return true ;
		}else{
			write_action_log($last_sql,$this->uri->uri_string(),$this->visitor['username'],get_client_ip(),0,"编辑导航{$this->name}失败");
			return false ;
		}
	}
	//其中ID是导航的id
	private function queryPid($id){
		static $top = array() ; 
		$sql = "select pid ,id  from `{$this->table_}common_admin_nav` where id = '{$id}' limit 1 " ;
		$data = array() ;
		$data = $this->M_common->query_one($sql) ;
		$top[] = isset($data['id'])?$data['id']:0;
		if(isset($data) && $data  ){
			$this->queryPid(isset($data['pid'])?$data['pid']:0) ;
		}
		return $top ;
	}
	
	//删除导航数据
	public function delNav($id){
		$sql = "select pid ,id ,path ,name from `{$this->table_}common_admin_nav` where id = '{$id}' limit 1 " ;
		$data = $this->M_common->query_one($sql) ;
		if(!$data){
			return false ;
		}
		$num = $this->M_common->del_data("delete from `{$this->table_}common_admin_nav` where id = '{$id}'  limit 1 ");
		$path = $data['path']."-".$data['id'] ; 
		if($num){
			$sql_child = "delete from `{$this->table_}common_admin_nav` where path like '{$path}%' " ; 
			$this->M_common->del_data($sql_child);
			write_action_log($sql_child,$this->uri->uri_string(),$this->visitor['username'],get_client_ip(),1,"删除导航{$data['name']}和下面的子导航成功成功");
			return true ;
		}else{
			write_action_log($sql_child,$this->uri->uri_string(),$this->visitor['username'],get_client_ip(),0,"删除导航{$data['name']}和下面的子导航成功失败");
			return false ;	
		} 
		
	}

	//查询导航数据 ， 返回
	public function get_nav(){
		$nav_data = array(); 
		if(!file_exists($this->nav_path."/nav.inc.php")){
			$this->make_nav() ; 
			include_once $this->nav_path."/nav.inc.php" ; 
			$nav_data = $nav_config ;  
		}else{
			include_once $this->nav_path."/nav.inc.php" ; 
			$nav_data = $nav_config ; 
		}
		return $nav_data ;

	}
	public function make_nav(){
		$sql_gid = "SELECT * FROM {$this->table_}common_admin_nav where status = '1' ";
		$list_data = array();
		$list_data = $this->M_common->querylist($sql_gid);
		if(!is_really_writable($this->nav_path)){
			exit("目录".$this->nav_path."不可写,或者不存在");
		}
		$configfile = $this->nav_path."/nav.inc.php";
		$time = date("Y-m-d H:i" , time());
		$fp = fopen($configfile,'w');
		flock($fp,3);
		fwrite($fp,"<"."?php\r\n");
		fwrite($fp,"/*导航基本信息配置*/\r\n");
		fwrite($fp,"/*author wangjian*/\r\n");
		fwrite($fp,"/*time {$time}*/\r\n");
		
		$data = array() ;
		if($list_data){
			foreach($list_data as $j_key=>$j_val){
				if(substr($j_val['url'],-1) == '/'){
					$j_val['url']= substr($j_val['url'],0,-1) ;
				} 
				if($j_val['url'] != '' ){
					$data[] = $j_val['url'] ;
				}
				 
			}
		}
		$no_need_perm = $this->config->item('no_need_perm') ;
		$last_data = array();
		$last_data = array_merge($data , $no_need_perm);
		$string = "\$nav_config = " ;
		$string.= var_export($last_data , true ) ;
		
		fwrite($fp,"$string;\r\n");
	}
}