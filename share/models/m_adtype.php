<?php
/*
 *adtype model 文件
 *@author 王建 
 */
class M_adtype extends M_common {
	function M_adtype(){
		parent::__construct();	
	}

	
	/*
	 *@page 第几页
	*@per_page 每一页显示的数据
	*@where 条件数组格式
	*/
	public function queryAdtypeList($page =  1 ,$per_page = 10 , $where = array() ){
		$getwhere = '' ;
		$condition = intval(isset($where['condition'])?$where['condition']:1);
		$condition  = in_array($condition,array(1,2))?$condition:1;
		if(isset($where['typename']) && $where['typename']){
			$typename = $this->db->escape_str($where['typename']) ;
			$array_condition_search  = array(
					1=>" LIKE '%{$typename}%'", //模糊搜索
					2=>"= '{$typename}'"
			);
			$getwhere = " AND typename {$array_condition_search[$condition]} " ;
		}
		
		if($where['id'] > 0 ){
			$getwhere.=" AND id = '{$where['id']}' ";
		}
		
		if(in_array($where['status'], array('1','0')  )){
			$getwhere.=" AND `status` = '{$where['status']}' ";
		}
		$data = array() ;
		$this->load->library("common_page");
		if($page <=0 ){
			$page = 1 ;
		}
		$limit = ($page-1)*$per_page;
		$limit.=",{$per_page}";
		$sql_count = "SELECT COUNT(*) AS tt FROM {$this->table_}extra_adtype  as a   where 1 = 1 {$getwhere} ";
		
		$total  = $this->M_common->query_count($sql_count);
		$page_string = $this->common_page->page_string($total, $per_page, $page);
		$sql = "SELECT a.* FROM {$this->table_}extra_adtype as a   where 1 = 1 {$getwhere} order by a.addtime desc   limit  {$limit}";
		
		$list = $this->M_common->querylist($sql);
	
		foreach($list as $k=>$v){
			//$list[$k]['status'] = ($v['status'] == 1 )?"开启":'<font color="red">关闭</font>';
			$list[$k]['addtime'] = date("Y-m-d H:i" , $v['addtime']);
			$list[$k]['updatetime'] = date("Y-m-d H:i" , $v['updatetime']);
		}
		$data = array(
				'list'=>$list ,
				'page_sting'=>$page_string
		);
		return $data ;
	}
	
	//添加广告类型
	public function add_adtype($params = array() ){
		$array = $this->insert_one("{$this->table_}extra_adtype",$params);
		if($array['affect_num']>=1){
			write_action_log($array['sql'],$this->uri->uri_string(),$this->visitor['username'],get_client_ip(),1,"添加广告类型为{$params['typename']}成功");
			return array('status'=>true , 'message'=>'success') ; 
		}else{
			write_action_log($array['sql'],$this->uri->uri_string(),$this->visitor['username'],get_client_ip(),0,"添加广告类型为{$params['typename']}失败");
			return array('status'=>false , 'message'=>'服务器繁忙请稍后' ) ;
		}
	}
	//修改数据
	public function edit_ad($params = array()){
		if(empty($params['field'])){
			return array('status'=>false , 'message'=>'参数错误' ) ;
		}
		$value = $this->db->escape_str($params['value']) ;
		$field = $this->db->escape_str($params['field']) ;
		$time = time() ;
		$sql_edit = "UPDATE {$this->table_}extra_adtype SET `{$field}` = '{$value}'  , `updatetime` = '{$time}'  where id = '{$params['id']}'";
	
		$num = $this->M_common->update_data($sql_edit);
		if($num>=1){
			write_action_log($sql_edit,$this->uri->uri_string(),$this->visitor['username'],get_client_ip(),1,"修改字段{$field}，为 {$value}成功");
			return array('status'=>true , 'message'=>'success') ; 
		}else{
			write_action_log($sql_edit,$this->uri->uri_string(),$this->visitor['username'],get_client_ip(),0,"修改字段{$field}，为 {$value}失败");
			return array('status'=>false , 'message'=>'服务器繁忙请稍后' ) ;
		}
	}

}