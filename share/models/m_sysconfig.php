<?php
/*
 *@des 系统基本配置model文件
*@author 57sy.com
*
*/
class M_sysconfig extends M_common {
	public $sysconfig_cache_path ;  // 系统环境路径
	function M_sysconfig(){
		parent::__construct();
		$this->sysconfig_cache_path = __ROOT__."/data/cache/sysconfig";
	}
	function query_sysconfig($group){
		$data = array();
		foreach($group as $kk => $v ){
			$sql_gid = "SELECT * FROM {$this->table_}common_sysconfig where groupid = '{$kk}' ORDER BY disorder asc ";
			$list_data = $this->M_common->querylist($sql_gid);
			if($list_data){
				foreach($list_data as $k1=>$v1){
			
					$text = '' ;
					$v1['varname'] = $v1['varname'].'[]';
					if(in_array($v1['type'],array('number','string'))){
						$text = "<input type='text' class=\"dfinput\" name='{$v1['varname']}' value='{$v1['value']}'>";
					}elseif($v1['type'] == 'boolean'){
						if($v1['value'] == 'Y'){
							$text = "是<input type='radio' name='{$v1['varname']}' value='Y' checked='checked'>否<input type='radio' name='{$v1['varname']}' value='N'>";
						}else{
							$text = "是<input type='radio' name='{$v1['varname']}' value='Y'>否<input type='radio' name='{$v1['varname']}' value='N' checked='checked'>";
						}
			
					}elseif($v1['type'] == 'textarea'){
						$text = "<textarea style='border:solid 1px #A7B5BC ;width:345px ; height:90px' class='dfinput' name='{$v1['varname']}' style='width:360px'>{$v1['value']}</textarea>";
					}
					$text.="&nbsp;排序：<input type='text' class='dfinput' style='border:solid 1px #A7B5BC ;width:50px ; ' name='{$v1['varname']}__my57sy_{$v1['disorder']}[]' value='{$v1['disorder']}'>";
					$del_url = site_url("sysconfig/del")."?varname={$v1['varname']}&gid={$kk}" ; 
					$text.="&nbsp;&nbsp;&nbsp;&nbsp;<a class=\"tablelink\"  href=\"javascript:void(0)\" onclick=\"del_var('{$del_url}' , '{$v1['varname']}' )\">删除</a>";
					$list_data[$k1]['text'] = $text ;
				}
			}
			$data[$kk] = $list_data ;
			
		}
		return $data ;
	}
	
	//修改数据
	public function update_data($data){
		
		if($data){
			foreach($data as $last_key=>$last_val){
				$last_key = $this->db->escape_str($last_key);
				//$last_val = $this->db->escape_str($last_val);
				/* $last_val = daddslashes(html_escape(strip_tags($last_val)));
				$last_key = daddslashes(html_escape(strip_tags($last_key))); */
				$disorder = 0 ; 
				$disorder = verify_id(isset($last_val[1])?$last_val[1]:0);
				$value = (isset($last_val[0]))?$this->db->escape_str($last_val[0]):'';
				if(empty($value)){
					continue ;
				}
				$sql_ = "UPDATE `{$this->table_}common_sysconfig` SET `value` = '{$value}'  , disorder = '{$disorder}' WHERE `varname` = '{$last_key}'";
				$this->M_common->update_data($sql_);
		
			}

			$this->make_sysconfig();
			write_action_log("sysconfig_update",$this->uri->uri_string(),$this->visitor['username'],get_client_ip(),1,"修改系统变量成功");
			return true ;
		}else{
			write_action_log("sysconfig_update",$this->uri->uri_string(),$this->visitor['username'],get_client_ip(),0,"修改系统变量失败");
			return false ;
		}
		
	}
	//根据varname查询是否存在
	public function query_isexists_by_varname($varname){
		$sql_one = "SELECT * FROM {$this->table_}common_sysconfig WHERE varname = '{$varname}' limit 1 ";
		if($this->M_common->query_one($sql_one)){
			return true ;
		}
		return false ;
	}
	
	//插入系统环境变量
	public function insert_sysconfig($data){
		$array = $this->M_common->insert_one("{$this->table_}common_sysconfig",$data);
		if($array['affect_num']>=1){
			$this->make_sysconfig();
			write_action_log($array['sql'],$this->uri->uri_string(),$this->visitor['username'],get_client_ip(),1,"添加系统变量{$data['varname']}成功");
			return true ;
		}else{
			write_action_log($array['sql'],$this->uri->uri_string(),$this->visitor['username'],get_client_ip(),0,"添加系统变量{$data['varname']}失败");
			return false ;
		}
	}
	
	//删除数据
	public function del_varname($varname){
		$sql = "delete from {$this->table_}common_sysconfig where varname = '{$varname}' " ;
		$num = $this->M_common->del_data($sql);
		if($num){
			write_action_log($sql,$this->uri->uri_string(),$this->visitor['username'],get_client_ip(),1,"删除环境变量{$varname}成功");
			$this->make_sysconfig();
			return true ; 
		}
		write_action_log($sql,$this->uri->uri_string(),$this->visitor['username'],get_client_ip(),0,"删除环境变量{$varname}失败");
		return false ;
	}
	//生成
	public function make_sysconfig(){
		$sql_gid = "SELECT * FROM {$this->table_}common_sysconfig";
		$list_data = array();
		$list_data = $this->M_common->querylist($sql_gid);
		if(!is_really_writable(dirname($this->sysconfig_cache_path))){
			exit("目录".dirname($this->sysconfig_cache_path)."不可写,或者不存在");
		}
	
		if(!file_exists($this->sysconfig_cache_path)){
			mkdir($this->sysconfig_cache_path);
		}
		
		$configfile = $this->sysconfig_cache_path."/sysconfig.inc.php";
		$time = date("Y-m-d H:i" , time());
		$fp = fopen($configfile,'w');
		flock($fp,3);
		fwrite($fp,"<"."?php\r\n");
		fwrite($fp,"/*网站基本信息配置*/\r\n");
		fwrite($fp,"/*author wangjian*/\r\n");
		fwrite($fp,"/*time {$time}*/\r\n");
		
		$data = array() ;
		if($list_data){
			foreach($list_data as $j_key=>$j_val){
				$value =$j_val['value'];
				if($j_val['type'] == 'number'){
					$value = intval($j_val['value']);
				}
				$data[$j_val['varname']] = $value ; 
				//fwrite($fp,"\${$j_val['varname']} ='{$value}';\r\n");
			}
		}
		$string = "\$site_config = " ;
		$string.= var_export($data , true ) ;
		
		fwrite($fp,"$string;\r\n");
	}
}	