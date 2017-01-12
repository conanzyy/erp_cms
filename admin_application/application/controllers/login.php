<?php
/*
 *登录控制器
 *author 王建 
 */
if (! defined('BASEPATH')) {
    exit('Access Denied');
}

class Login extends AdminCommon{
	public $connect_string = 'real_data' ;
	function Login(){
		parent::__construct();
		$this->load->model('M_common');
		$this->load->model('M_user');
		$this->table_ =table_pre($this->connect_string);
	}
	function index(){
		//判断用户是否登录 如果登录直接跳转到后台首页
		@ob_clean() ;
		@session_start();				
		$data = array() ; 
		$data = decode_data() ; 
		if(isset($data['username']) && $data['username'] != ""){
			header("Location:".site_url("admin/index"));
		}
						
		$this->load->view(__TEMPLET_FOLDER__."/views_login");
	}
	function dologin(){
		$username = html_escape(strip_tags(trim($this->input->get_post("username"))));//name
		$password = html_escape(strip_tags(trim($this->input->get_post("passwd"))));//passwd
		if(empty($username) || empty($password)){
			showmessage("用户名或者密码不可以为空","login",3,0);
			exit();
		}		
		
		$info = $this->M_user->fineUser($username , $password);
		if(empty($info)){
			showmessage("用户不存在或者已经被禁用","login",3,0);
			exit();
		}
		$this->M_user->setUserCookie($info['id']);
		/*$gid = intval($info['gid']);
		$group_name = '' ;
		$sql_role = "SELECT rolename FROM {$this->table_}common_role where id = '{$gid}' limit 1 ";
		$role_info = $this->M_common->query_one($sql_role);
		
		$group_name = ($info['super_admin'] == 1 )?'超级管理员':(isset($role_info['rolename'])?$role_info['rolename']:'');
		if($group_name == "" ){
			showmessage("此用户可能没加入到系统组里面,请联系管理员!!","login",3,0);
			die();
		}*/
		
		//登录成功
		redirect("admin/index");
	}
	public function login_out(){
		if(isset($_COOKIE['admin_auth']) && $_COOKIE['admin_auth'] ){
			setcookie("admin_auth","",time()-config_item("cookie_expire"),config_item("cookie_path"),config_item("cookie_domain"));
			
		}
		@session_start() ; 
		if(isset($_SESSION)){
			session_destroy() ; 
		}
		redirect("login/index");
	
	}
/*	//生成验证码
	function code(){
		$this->load->library("code",array(
			'width'=>80,
			'height'=>35,
			'fontSize'=>20,
			'font'=>__ROOT__."/".APPPATH."/fonts/font.ttf"
		));
		$this->code->show();
		//echo $this->code->getCode();		
	}
	//校验验证码
	function check_code(){
		@ob_clean() ;
	    @session_start() ;
		$yzm = daddslashes(html_escape(strip_tags($this->input->get_post("code"))));//code
		if(strtolower($_SESSION['code']) != strtolower($yzm) ){
			//showmessage("验证码错误","login",3,0);
			exit('验证码不正确');
		}
		exit('success');
	}*/

}