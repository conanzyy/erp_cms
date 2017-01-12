<?php
/*
 *后台用户配置
 *author 王建 
 */
if (! defined('BASEPATH')) {
    exit('Access Denied');
}
class Sys_admin extends MY_Controller{
	private $admin_perm_path ='';
	private $perm_array = array() ; //用户的特殊权限
	function Sys_admin(){
		parent::__construct();
		$this->load->model('M_common');
		$this->load->model('M_sysadmin');
		$this->admin_perm_path = config_item("role_cache");
	}
	function index(){
		$action = $this->input->get_post("action");	
		$action_array = array("show","ajax_data");
		$action = !in_array($action,$action_array)?'show':$action ;
		if($action == 'show'){
			$this->load->view(__TEMPLET_FOLDER__."/views_sys_admin");
		}elseif($action == 'ajax_data'){
			$this->ajax_data();
		}
	}
	//ajax get data
	private function ajax_data(){
		$page = intval($this->input->get_post("page" , true ));
		$list = $this->M_sysadmin->querySysadminList($page ,30 , 
				array(
							'username'=>trim($this->input->get_post("username", true)) ,
							'nick'=>trim($this->input->get_post("nick", true)) ,
						 	'condition'=>$this->input->get_post("condition" , true ) ,
						 	'field'=>$this->input->get_post("field" , true ) ,
							'orderby'=>$this->input->get_post("orderby" , true ) ,
						) );
		echo result_to_towf_new($list['list'], 1, '成功', $list['page_sting']) ;
	}
	//添加后台用户
	function add(){
		
		$action = $this->input->get_post("action");		
		$action_array = array("add","doadd");
		$action = !in_array($action,$action_array)?'add':$action ;	
		if($action == 'add'){
			$sql_role = "SELECT * FROM {$this->table_}common_role where status = 1 order by id desc ";
			$list = $this->M_common->querylist($sql_role);
			$data  = array(
				'list'=>$list
			) ;
			$this->load->view(__TEMPLET_FOLDER__."/views_sys_admin_add",$data);		
		}elseif($action =='doadd'){
			$this->doadd();
		}
	}
	//处理添加
	private function doadd(){
		$data = array(
			'gid'=>	verify_id($this->input->get_post("gid" , true ))	,
			'username'=>trim($this->input->get_post("username" , true ) ),
			'nick'=>trim($this->input->get_post("nick" , true ) ),
			'passwd'=>$this->input->get_post("passwd" , true )  , 
			'status'=>verify_id($this->input->get_post("status" , true ))	,
			'super_admin'=>	verify_id($this->input->get_post("super_admin" , true )) , 
			'addtime'=>date("Y-m-d H:i:s",time()),
		);
		$data = $this->M_sysadmin->add_sysadmin($data);
		$url = site_url("sys_admin/index") ;
		if($data['status']){
			echo "<script>parent.window.location.href='{$url}';</script>";
		}else{
			show_error($data['message'],'500','信息提示');
			exit ;
		}	
	}
	//编辑页面
	function edit(){
		$action = $this->input->get_post("action");		
		$action_array = array("edit","doedit");
		$action = !in_array($action,$action_array)?'edit':$action ;		
		if($action == 'edit'){
			$id = verify_id($this->input->get_post("id"));//用户的ID
			/*if($this->admin_id == $id ){
				showmessage("对不起你不能编辑自己的权限信息","sys_admin/index",3,0);
				exit();
			}*/
			$data = $this->M_sysadmin->judge($id);
			if($data['status'] == 0 ){
				showmessage($data['message'] , "sys_admin/index", 3 , 0 ) ; 
				exit();
			}
			
			$this->load->view(__TEMPLET_FOLDER__."/views_sys_admin_edit",$data);		

		}elseif($action == 'doedit'){
			$this->doedit();
		}

	}
	//处理编辑数据
	private function doedit(){
		
		$data = array(
			'id'=>	$this->input->get_post("id" , true ) , 
			'username'=>trim($this->input->get_post("username" , true )) ,
			'nick'=>trim($this->input->get_post("nick" , true )) ,
			'super_admin'=> $this->input->get_post("super_admin" , true ) , 
			'status'=>$this->input->get_post("status" , true ) , 
			'gid'=>$this->input->get_post("gid"  , true) ,
			'perms'=>$this->input->get_post("p" , true ) , 
			
		);
		
		$data = $this->M_sysadmin->doSetPerminsions($data);
		if($data['status'] == 0 ){
			showmessage($data['message'] , "sys_admin/edit" , 3 , 0 , "?id={$this->input->get_post("id" , true )}" ) ;
			exit();
		}
		showmessage("修改成功" ,"sys_admin/index" , 3 ,1  ) ;
		
	}
	//管理员修改密码
	public function passwd(){
		$action = $this->input->get_post("action");
		$action_array = array("edit","doedit");
		$action = !in_array($action,$action_array)?'passwd':$action ;
		if($action == 'passwd' ){
			$id = verify_id($this->input->get_post("id" , true ))  ;
			$info = $this->M_sysadmin->query_sys_admin($id);
			$data = array(
					'id'=>	$id ,
					'info'=>$info
			);
			$this->load->view(__TEMPLET_FOLDER__."/views_passwd"  , $data);
		}elseif($action == 'doedit' ){
			$id = verify_id($this->input->get_post("id" , true ))  ;
			$password = $this->input->get_post("password" , true )  ; 
			$data = array(
				'id'=>$id , 
				'password'=>$password		
			);
			$data = $this->M_sysadmin->edit_passwd($data);
			if($data['status'] == 0 ){
				show_error($data['message']) ; 
				exit();
			}
			$url = site_url("sys_admin/index") ;
			echo "<script>parent.window.location.href='{$url}';</script>";
		}
		
	}
	
	//修改密码
	public function edit_passwd(){
		$action = $this->input->get_post("action");
		$action_array = array("edit","doedit");
		$action = !in_array($action,$action_array)?'edit':$action ;
		if($action == 'edit' ){
			$this->load->view(__TEMPLET_FOLDER__."/views_sys_admin_editpasswd");
		}elseif($action == 'doedit' ){
			$this->do_edit_passwd() ; 
		}
		
	}
	//修改密码
	private  function do_edit_passwd(){
		$password = $this->input->get_post("password" , true )  ;
		$repassword = $this->input->get_post("repassword" , true )  ;
		$data = array(
				'id'=>$this->visitor['id'] ,
				'password'=>$password , 
				'repassword'=>$repassword
		);
		
		$data = $this->M_sysadmin->self_edit_passwd($data);
		if($data['status'] == 0 ){
			show_error($data['message']) ;
			exit();
		}else{
			if(isset($_COOKIE['admin_auth']) && $_COOKIE['admin_auth'] ){
				setcookie("admin_auth","",time()-config_item("cookie_expire"),config_item("cookie_path"),config_item("cookie_domain"));
			}
			$url = site_url("login/index");
			echo "<script>parent.location.href = '{$url}' ;  </script>";
			//redirect("login/index");
		}
	}
	
	
	
	
	
}