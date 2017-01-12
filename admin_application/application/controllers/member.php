<?php
/*
 *网站用户列表管理
 *author 王建 
 */
if (! defined('BASEPATH')) {
    exit('Access Denied');
}
class Member extends MY_Controller{
	function Member(){
		parent::__construct();
		$this->load->model('M_common');
		$this->load->model('M_member');
	}
	function index(){
		$action = $this->input->get_post("action");	
		$action_array = array("show","ajax_data");
		$action = !in_array($action,$action_array)?'show':$action ;
		if($action == 'show'){
			$this->load->view(__TEMPLET_FOLDER__."/views_member");
		}elseif($action == 'ajax_data'){
			$this->ajax_data();
		}
	}
	//ajax get data
	private function ajax_data(){
		$page = intval($this->input->get_post("page" , true ));
		$list = $this->M_member->queryMemberList($page ,16 , 
				array(
							'username'=>$this->input->get_post("username", true) ,
						 	'condition'=>$this->input->get_post("condition" , true ) ,
						 	'field'=>$this->input->get_post("field" , true ) ,
							'orderby'=>$this->input->get_post("orderby" , true ) ,
							'status'=>$this->input->get_post("status" , true ) ,
						) );
		echo result_to_towf_new($list['list'], 1, '成功', $list['page_sting']) ;
	}
	//添加后台用户
	function add(){
		
		$action = $this->input->get_post("action" , true );		
		$action_array = array("add","doadd");
		$action = !in_array($action,$action_array)?'add':$action ;	
		if($action == 'add'){
			$this->load->view(__TEMPLET_FOLDER__."/views_member_add");		
		}elseif($action =='doadd'){
			$this->doadd();
		}
	}
	//处理添加
	private function doadd(){
		$data = array(
			'username'=>$this->input->get_post("username" , true ) ,
			'passwd'=>$this->input->get_post("passwd" , true )  , 
			'status'=>verify_id($this->input->get_post("status" , true ))	,
			'expire'=>	(stripos($this->input->get_post("expire" , true ), "-") !== false ) ? (strtotime($this->input->get_post("expire" , true ))) :0  , 
			'regdate'=>date("Y-m-d H:i:s",time()),
		);
		$data = $this->M_member->add_member($data);
		$url = site_url("member/index") ;
		if($data['status']){
			echo "<script>parent.window.location.href='{$url}';</script>";
		}else{
			show_error($data['message'],'500','信息提示');
			exit ;
		}	
	}
	//编辑页面
	function edit(){
		$action = $this->input->get_post("action" , true );		
		$action_array = array("edit","doedit");
		$action = !in_array($action,$action_array)?'edit':$action ;		

		if($action == 'edit'){
			$id = verify_id($this->input->get_post("id" , true ));//用户的ID
	
			$data = $this->M_member->memberInfo($id);
			if(!$data ){
				showmessage("暂无此信息" , "member/index", 3 , 0 ) ; 
				exit();
			}
			$this->load->view(__TEMPLET_FOLDER__."/views_member_edit",array('info'=>$data));		

		}elseif($action == 'doedit'){
			$this->doedit();
		}

	}
	//处理编辑数据
	private function doedit(){
		
		$data = array(
			'uid'=>	$this->input->get_post("id" , true ) , 
			'username'=>$this->input->get_post("username" , true ) ,
			'status'=>$this->input->get_post("status" , true ) , 
			'passwd'=>$this->input->get_post("passwd"  , true) ,
			'expire'=>(stripos($this->input->get_post("expire" , true ), "-") !== false ) ? (strtotime($this->input->get_post("expire" , true ))) :0  ,  
			
		);
		
		$data = $this->M_member->doEditMember($data);
		if($data['status'] == 0 ){
			showmessage($data['message'] , "member/edit" , 3 , 0 , "?id={$this->input->get_post("id" , true )}" ) ;
			exit();
		}
		showmessage("修改成功" ,"member/index" , 3 ,1  ) ;
		
	}

}