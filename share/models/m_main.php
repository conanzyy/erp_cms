<?php
/*
 *@des main model
*@author 57sy.com
*
*/
class M_main extends M_common {
	function M_nav(){
		parent::__construct();
	}
	function query_admin_log(){
		$sql = "select logintime from {$this->table_}common_adminloginlog where username = '{$this->visitor['username']}' order by logintime desc limit 1   " ;
		$one = $this->M_common->query_one($sql);
		return $one ;
	}
}	