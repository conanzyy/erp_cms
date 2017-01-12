<?php
/*
 *ad model 文件
 *@author 王建 
 */
class M_ad extends M_common {
	function M_ad(){
		parent::__construct();	
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