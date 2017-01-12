<?php
/*
 *@des 系统基本配置model文件
*@author 57sy.com
*
*/
class M_sysconfig extends M_common {
	private $sysconfig_cache_path = '' ;
	function M_sysconfig(){
		parent::__construct();
		$this->sysconfig_cache_path = config_item("sysconfig_cache") ; 
	}

	//生成
	public function make_sysconfig(){
		$sql_gid = "SELECT * FROM {$this->table_pre}common_sysconfig";
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