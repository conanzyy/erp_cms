<?php
/*
 *ad model 文件
 *@author 王建 
 */
class M_ad extends M_common {
	function M_ad(){
		parent::__construct();	
	}

	//生成下拉框
	function query_ad_type(){
		$sql_ad_type = "SELECT id,typename  FROM {$this->table_}extra_adtype where `status` = 1 ORDER by id desc " ;
		$list = $this->M_common->querylist($sql_ad_type);			
		return $list ;
	}
	
	/*
	 *@page 第几页
	*@per_page 每一页显示的数据
	*@where 条件数组格式
	*/
	public function queryAdList($page =  1 ,$per_page = 10 , $where = array() ){
		$getwhere = '' ;
		$condition = intval(isset($where['condition'])?$where['condition']:1);
		$condition  = in_array($condition,array(1,2))?$condition:1;
		if(isset($where['name']) && $where['name']){
			$name = $this->db->escape_str($where['name']) ;
			$getwhere = " AND a.name like '%{$name}%' " ;
		}
		if(isset($where['typeid']) && $where['typeid']){
			
			$getwhere = " AND b.id = '{$where['typeid']}' " ;
		}
		if(isset($where['status']) && in_array($where['status'] , array('1' , '0'))){	
			$getwhere = " AND a.status = '{$where['status']}' " ;
		}
		if(isset($where['type']) && in_array($where['type'] , array('1' , '0'))){
			$getwhere = " AND a.type = '{$where['type']}' " ;
		}
		$data = array() ;
		$this->load->library("common_page");
		if($page <=0 ){
			$page = 1 ;
		}
		$limit = ($page-1)*$per_page;
		$limit.=",{$per_page}";
		$sql_count = "SELECT COUNT(*) AS tt FROM {$this->table_}extra_ad  as a left join {$this->table_}extra_adtype  as b on a.ad_type = b.id  where 1 = 1 {$getwhere} ";
		
		$total  = $this->M_common->query_count($sql_count);
		$page_string = $this->common_page->page_string($total, $per_page, $page);
		$sql = "SELECT a.*,b.typename FROM {$this->table_}extra_ad as a left join {$this->table_}extra_adtype  as b on a.ad_type = b.id  where 1 = 1 {$getwhere} order by a.addtime desc   limit  {$limit}";
		//echo $sql;
		$list = $this->M_common->querylist($sql);
	
		foreach($list as $k=>$v){
			$list[$k]['status'] = ($v['status'] == 1 )?"开启":'<font color="red">关闭</font>';
			$list[$k]['begin_date'] = ($v['begin_date'] > 0 )?date("Y-m-d H:i:s" , $v['begin_date']):'' ; 
			$list[$k]['end_date'] = ($v['end_date'] > 0 )?date("Y-m-d H:i:s" , $v['end_date']):'' ;
			$list[$k]['type'] = ($v['type'] == 0 )?"图片广告":'<font color="red">文字广告</font>';
		}
		$data = array(
				'list'=>$list ,
				'page_sting'=>$page_string
		);
		return $data ;
	}
	//删除广告数据
	public function del_ad($id  = ''){
		
		$sql = "SELECT `pic` , `pic2` FROM `{$this->table_}extra_ad` WHERE id in ($id) limit 1  " ; 
		$pic_array = $this->M_common->query_one($sql)  ;
		$sql_del = "DELETE FROM `{$this->table_}extra_ad` WHERE id in ($id)  " ;
		$num = $this->M_common->del_data($sql_del);
		if($num >= 1 ){
			if(isset($pic_array['pic']) && $pic_array['pic'] && file_exists(config_item("ad_path")."/".$pic_array['pic'])){
				@unlink(config_item("ad_path")."/".$pic_array['pic']);
			}
			if(isset($pic_array['pic2']) && $pic_array['pic2'] && file_exists(config_item("ad_path")."/".$pic_array['pic2'])){
				@unlink(config_item("ad_path")."/".$pic_array['pic2']);
			}
			//写入日志记录
			write_action_log($sql_del,$this->uri->uri_string(),$this->visitor['username'],get_client_ip(),1,"删除广告ID 【{$id}】成功");	
			return array('status'=> true  , 'message'=>'success');
		}else{
			write_action_log($sql_del,$this->uri->uri_string(),$this->visitor['username'],get_client_ip(),0,"删除广告ID 【{$id}】失败");	
			return array('status'=> false  , 'message'=>'服务器繁忙请稍后');
		}
	}
	//根据ID查询广告数据
	public function query_ad_one($id = '' ){
		$sql_= "SELECT a.* FROM {$this->table_}extra_ad as a where a.id = '{$id}'";
		$info_ = $this->M_common->query_one($sql_);
		return $info_ ;
	}
	
	//修改广告数据
	public function update_ad($data = array() , $id = '' ){
		$this->db->where('id', $id);
		$num = $this->db->update($this->table_."extra_ad", $data);
		if($num){
			return $this->db->last_query(); 
		}
		
	}
	function query_ad_by_typeid($id , $num){
		$last_data = array() ;
	
		$data = $this->read_ad_cache($id);
		if($data){
			return $data ;
		}
		$sql_type = "SELECT * FROM {$this->table_pre}extra_adtype where id = '{$id}' AND `status` = '1'  limit 1  ";
		$info = $this->M_common->query_one($sql_type);
		if(!$info){
			return ;
		}
		$sql = "SELECT * FROM {$this->table_pre}extra_ad where ad_type = '23' AND status = '1' order by addtime desc limit $num  ";
		$result = $this->M_common->querylist($sql);
		$re = array() ;
	
		if($result){
			$time = time();
			foreach($result as $k => $v ){
				if($v['begin_date'] > 0 && $v['end_date'] > 0 ){
					if($time > $v['end_date'] || $time < $v['begin_date']){
						continue ;
					}
				}
				$v['pic'] = __DATA_UPLOAD_PATH__.$v['pic'];
				$v['pic2'] = __DATA_UPLOAD_PATH__.$v['pic2'];
				$re[] = $v ;
			}
			$last_data = array('info'=>$info , 'list'=>$re) ;
			$this->write_ad_cache($id , $last_data);
		}
	
		return $last_data ;
	}
	//写入缓存
	public function write_ad_cache($id , $data){
		
		if(!is_really_writable(config_item("ad_cache"))){
			show_error("目录".config_item("ad_cache")."不可写,或者不存在");
		}
		if(!file_exists(config_item("ad_cache")."/{$id}")){
			mkdir(config_item("ad_cache")."/{$id}");
		}
		$cache_file = config_item("ad_cache")."/{$id}"."/ad_{$id}";
		$string = serialize($data) ;
		$fp = fopen($cache_file,'w');
		flock($fp,3);
		fwrite($fp,"$string;\r\n");
	}
	//获取广告缓存data
	public function read_ad_cache($id){
		$string = '' ;
		if(file_exists(config_item("ad_cache")."/{$id}/ad_{$id}")){
			$string = file_get_contents(config_item("ad_cache")."/{$id}/ad_{$id}") ;
			$string = unserialize($string);
			//print_r($string);
		}
		return $string ;
	}	
}