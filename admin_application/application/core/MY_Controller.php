<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
header("Content-type:text/html;charset=utf-8");
//后台的基本类
class AdminCommon extends CI_Controller{
	public $table_ = 'ylfy_' ; //表的前缀
	public $visitor = array() ; //用户的基本信息
	public $site_config = array()  ; //站点基本信息
	public $_cookie_data = array() ;
	public $_url_data = array() ;
	public $cur_url = '' ; //当前访问的url 格式 news/index
	public function __construct(){
		parent::__construct() ;
		$this->init() ;
		
	}
	//设置读取的文件目录
	public function init(){
		$this->load->add_package_path(__ROOT__."/share/");//此处必须
		$this->config->load();
		$this->site_info() ; //获取站点基本信息
		$this->table_ =table_pre("real_data"); //设置表前缀
		$this->set_cur_url();
	}
	/*
	 *@des 站点基本信息配置
	*/
	public function site_info(){
		$filename = config_item("sysconfig_cache")."/sysconfig.inc.php" ;
		if(file_exists($filename)){
			include $filename;
			$this->site_config = $site_config ;
		}
	
	}
	//检查是否登录了
	public function check_is_login($data = '' ){
		$data = $this->_cookie_data;
		if(isset($data['username'])){
			$this->username = $data['username'];
		}
		
		if(empty($this->username) || $this->username == ""  ){
			if($this->input->get_post("showpage") != "" ){ //这个地方是为了判断 ，ajax请求，但是显示的是一个提示页面
				show_error("对不起登陆超时或者你还没登陆！",'500','信息提示');
				//echo "对不起登陆超时，或者你还没登陆";
				die();
			}
			//如果没有登录
			if(isset($_GET['inajax']) || $this->is_ajax()){
				echo result_to_towf_new('',$this->config->item('no_permition'),"你的密码已经过期,重新登录",null);
				die();
			}
			showmessage("密码已经过期",'login/index',3,0);
		}
		$this->visitor = $data ;
	}
	public function is_ajax(){
		if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'){
			return true ;
		}else{
			echo false ;
		}
	}
	/*
	 *遍历数组 ， 并且去掉每个值后面的/
	*@params $array
	*@return array
	*/
	public  function delete_str_($array = array() ){
		$data = array();
		if(is_array($array) && $array){
			foreach($array as $kk => $vv ){
				//$url = isset($array[$i])?$array[$i]:'' ;
				
				if(substr($vv,-1) == '/'){
					$vv= substr($vv,0,-1) ;
				} 
			 	if($vv != '' ){
					$data[] = $vv ;
				}
			}
		}
		return $data ;
	}
		//设置当前的url地址
	public function set_cur_url(){
		$url_array = $this->uri->segment_array() ;
		
		$new_url = '';
		if(isset($url_array[1])){
			$new_url.=$url_array[1]."/";
		}
		if(isset($url_array[2])){
			$new_url.=$url_array[2]."/";
		}
		if(isset($url_array[3])){
			$new_url.=$url_array[3]."/";
		}
		if(isset($url_array[4])){
			$new_url.=$url_array[4]."/";
		}
		//判断当前的访问地址的最后一位是不是有/
		if(substr($new_url,-1) == "/"){
			$new_url = substr($new_url,0,-1);
		}
		$this->cur_url = $new_url ;		
	}
}

class LoginCommon extends AdminCommon{
	public function __construct(){
		parent::__construct();
		$this->initLogin();
	}
	private function initLogin(){
		$this->_cookie_data = decode_data($this->input->get_post("cookie", true )); //获取cookie数据
		$this->check_is_login();
		if($this->_cookie_data['super_admin'] == 0 ){
			$this->setPermition() ;
		}
		
		
	}
	//设置当期登录的用户  有哪些操作权限
	public function setPermition(){
		$last_permition = array();
		$permition =array();
		$permition_admin = array() ;
		$role_cache = $this->config->item('role_cache');
		
		//用户所属的组有哪些操作权限
		if(file_exists($role_cache."/cache_role_{$this->_cookie_data['gid']}.inc.php")){
			require_once  $role_cache."/cache_role_{$this->_cookie_data['gid']}.inc.php" ;
			$permition = $role_array ;
		}
		//当前登录的用户的特殊权限
		if(file_exists($role_cache."/cache_admin_{$this->_cookie_data['id']}.inc.php")){
			require_once $role_cache."/cache_admin_{$this->_cookie_data['id']}.inc.php" ;
			$permition_admin = $admin_perm_array ;
		}
		$last_permition = array();
		if($permition && $permition_admin){
			$last_permition = array_merge_recursive($permition,$permition_admin);
		}elseif(!$permition && $permition_admin){
			$last_permition = $permition_admin ;
		}elseif($permition && !$permition_admin){
			$last_permition = $permition ;
		}else{
			//show_error("You have no permisition ",403,'forbidden');
		}
		$no_need_perm = $this->config->item('no_need_perm') ;
		if($no_need_perm && $last_permition){
			$last_permition = array_merge_recursive($last_permition,$no_need_perm); ;
		}
		if($last_permition){
			$last_permition = array_unique($last_permition);
		}
		/*
		$url_array = $this->uri->segment_array() ;
		
		$new_url = '';
		if(isset($url_array[1])){
			$new_url.=$url_array[1]."/";
		}
		if(isset($url_array[2])){
			$new_url.=$url_array[2]."/";
		}
		if(isset($url_array[3])){
			$new_url.=$url_array[3]."/";
		}
		if(isset($url_array[4])){
			$new_url.=$url_array[4]."/";
		}
		//判断当前的访问地址的最后一位是不是有/
		if(substr($new_url,-1) == "/"){
			$new_url = substr($new_url,0,-1);
		}
		$this->cur_url = $new_url ;
		*/
		//echo $new_url;
		$last_permition = $this->delete_str_($last_permition);
		
		$this->_url_data = $last_permition ; //权限url数组
	}


}
/*
 * 让CI继承自己的类库 
 * ######################################
 * 这个类里面写权限代码 和登录判断代码 , 
 *###################################
 */

class MY_Controller extends LoginCommon{
	function MY_Controller(){
		parent::__construct() ;
		$this->check_user_onlyone_login();
		$this->check_url_exists();
		if($this->_cookie_data['super_admin'] == 0 ){
			//不是超级管理员
			$this->permition();
		}
		
		
	}
	//检测用户 ， 必须一个人登录
	public function check_user_onlyone_login(){
		$session_id = isset($_COOKIE['admin_auth'])?trim($_COOKIE['admin_auth']):'';
		if($session_id == '' ){
			$this->show_error_message("session无效，请重新登录");
		}
		
		$this->load->Model("M_common");
		$this->load->Model("M_user");
		$exists = $this->M_user->getDataBySessionIdUserid($session_id , $this->_cookie_data['id']);
		if(!$exists){
			$this->show_error_message("session无效，请重新登录");
		}
	}
	//检测url是不是存在的
	public function check_url_exists(){
		$this->load->model("M_common");
		$this->load->model("M_nav");
		$data = $this->M_nav->get_nav();
	
		if(!in_array($this->cur_url , $data)){
			$this->show_error_die("当前的url没有设置,或者已经禁用,请联系管理员{$this->config->item('web_admin_email')}设置！");
		}
	}
	//显示错误信息，中断程序
	function show_error_die($message = '' ){
			if($this->input->get_post("showpage") != "" ){ //这个地方是为了判断 ，ajax请求，但是显示的是一个错误页面
				show_error($message,'500','信息提示');
				die();
			}
			if(isset($_GET['inajax']) || $this->is_ajax()){
					echo result_to_towf_new('',0,$message,null);
			}else{
				show_error($message,403,'forbidden');
			}
			die();
	}


	//显示信息或者是跳转
	public function show_error_message($message){
		if(isset($_COOKIE['admin_auth']) && $_COOKIE['admin_auth'] ){//注销cookie
			setcookie("admin_auth","",time()-config_item("cookie_expire"),config_item("cookie_path"),config_item("cookie_domain"));
		}
		if(!isset($_SESSION)){
			session_start() ;
		}
		if(isset($_SESSION)){
			session_destroy() ;
		}
		if($this->input->get_post("showpage") != "" ){ //这个地方是为了判断 ，ajax请求，但是显示的是一个提示页面
			show_error($message,'500','信息提示');
			die();
		}
		if(isset($_GET['inajax']) || $this->is_ajax()){
			echo result_to_towf_new('',0,$message,null);
			die();
		}
		showmessage($message,'login/index',3,0);
	}
	//验证是否有访问的权限
	private function permition(){
		/* echo $this->cur_url ;
		echo "<pre>";
		print_r($this->_url_data); */
		if(!in_array($this->cur_url, $this->_url_data)){
			
			$this->show_error_die("对不起没权限执行此操作，请联系管理员：{$this->config->item('web_admin_email')}");
		}
	}
	


	
}
