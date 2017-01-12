<?php 
/*
 *后台首页文件
 *author 王建 
 */
if (! defined('BASEPATH')) {
    exit('Access Denied');
}
class Admin extends LoginCommon {
	private $navList = array() ;
	public $isJudgeUrl = false ; //是否判断权限url
	function Admin(){
		parent::__construct();
		$this->load->model('M_common');
		$this->load->model('M_nav');
		$this->load->model("M_main");
		//echo  $this->uri->segment(1);
		
		$this->isJudgeUrl = ($this->_cookie_data['super_admin'])?false:true ; 
		$this->navList = $this->M_nav->queryNav('items' , '' , $this->isJudgeUrl );
		
	}
	//后台框架首页
	function index(){
		$this->load->view(__TEMPLET_FOLDER__."/views_index");
	}
	function top(){
		
		$data  = array(
			'nav'=>$this->M_nav->queryTopNav($this->isJudgeUrl) ,		
		) ;
		$this->load->view(__TEMPLET_FOLDER__."/views_top" , $data );
	}
	function left(){
		/*  echo "<pre>";
		print_r($this->_url_data);  */
		$data  = array(
				'nav'=>$this->navList ,
		) ;
		 /* echo "<pre>";
		print_r($this->navList );
		die(); */
		$this->load->view(__TEMPLET_FOLDER__."/views_left"  , $data);
	}
	function main(){
		$info = $this->M_main->query_admin_log();
		$data = array(
				'group_name'=>group_name(),
				'info'=>$info
		);
		$this->load->view(__TEMPLET_FOLDER__."/views_main" , $data);
	}
	//获取导航列表
	
}
