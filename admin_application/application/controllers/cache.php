<?php
/*
 *缓存更新
 *author 王建 
 *time 2015-02-25
 */
if (! defined('BASEPATH')) {
    exit('Access Denied');
}
class Cache extends MY_Controller{
	public  $cache_type = array();
	function Cache(){
		parent::__construct();
		$this->cache_type =  array(
		1=>array(
			'name'=>'广告缓存' ,
			'path'=>config_item("ad_cache")		,
		) ,	
		2=>array(
			'name'=>'站点基本信息',		
			'path'=>config_item("sysconfig_cache")
		),	
		3=>array(
			'name'=>'导航缓存',		
			'path'=>config_item("nav_cache")
		),	
	);
	}
	function index(){
		$action = $this->input->get_post("action" ,true );	
		$action_array = array("show" , "updateCache");
		$action = !in_array($action,$action_array)?'show':$action ;
		if($action == 'show'){		
			$data = array(
				
			);						
			$this->load->view(__TEMPLET_FOLDER__."/views_cache",$data);
		}elseif($action == 'updateCache' ){
			$this->updateCache() ;
		}
	}
	//更新缓存
	private function updateCache(){
		$cache = $this->input->get_post("cache" , true);
		if(empty($cache)){
			showmessage("参数错误" , "cache/index" , 3 , 0 ) ;
		}
		$this->load->helper('file');
		foreach($cache as $k=>$v){
			if(array_key_exists($v, $this->cache_type)){
				delete_files($this->cache_type[$v]['path'], TRUE);
			}
		}
		
		showmessage("缓存更新成功" , "cache/index" , 3 , 1 ) ; 
	}

}
//file end