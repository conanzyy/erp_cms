<?php
/*
 *@des 后台日志文件log model
 *@author 57sy.com 
 * 
 */
class M_log extends M_common {
	function __construct(){
		parent::__construct();
	}
	/*
	 *@des 获取log列表 ， table的名字 
	 * 
	 */
	public function log_table(){
		$query_table = "show tables like '{$this->table_}common_log%'" ;
		$res_table = $this->M_common->querylist($query_table);

		$table_array = array();
		if($res_table){
			foreach($res_table as $k_t=>$k_v){
				foreach($k_v as $kk=>$vv){
					$table_array[] = $vv ;
				}
			}
			rsort($table_array)	;
		}
		
		
		return $table_array ;
	}
	/*
	 *@page 第几页
	*@per_page 每一页显示的数据
	*@where 条件数组格式
	*/
	public function queryLogList($page =  1 ,$per_page , $whereArray = array() ){
		
		$this->load->library("common_page");
		$status = $whereArray['status'];		
		if($page <=0 ){
			$page = 1 ;
		}
		$limit = ($page-1)*$per_page;
		$limit.=",{$per_page}";
		$where = ' where 1= 1 ';
		$table = $this->db->escape_str($whereArray['table']);
		$tablename = '';
		$tableArray = $this->log_table() ; 
		if( in_array($table,$this->log_table())){
			$tablename = $table ;
		}else{
			$tablename = $tableArray[0];
		}
		if(!empty($whereArray['log_person'])){	
			$log_person = $this->db->escape_str($whereArray['log_person']) ; 
			$where.=" AND `log_person` LIKE '%{$log_person}%'";
		}
		if(!empty($whereArray['log_url'])){
			$log_url = $this->db->escape_str($whereArray['log_url']) ;
			$where.=" AND `log_url` LIKE '%{$log_url}%'";
		}
		if(in_array($status,array('1','0'))){
			$where.=" AND `log_status` = '{$status}'"; 
		}
		$sql_count = "SELECT COUNT(*) AS tt FROM {$tablename} {$where} ";
		
		$total  = $this->M_common->query_count($sql_count);
		$page_string = $this->common_page->page_string($total, $per_page, $page);
		$sql_log = "SELECT * FROM {$tablename} {$where} order by log_id desc limit  {$limit}";	

		$list = $this->M_common->querylist($sql_log);
		foreach($list as $k=>$v){
			$list[$k]['log_status'] = ($v['log_status'] == 1 )?"成功":'<font color="red">失败</font>';
			$list[$k]['log_sql'] = msubstr($v['log_sql'] , 0 , 20 , abslength($v['log_sql']));
			$list[$k]['log_sql_all'] = base64_encode($v['log_sql']) ; 
		}
		
		return array('list'=>$list , 'page_sting'=>$page_string) ;
	}
}