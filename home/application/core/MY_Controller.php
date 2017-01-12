<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
 * 基本的类
*/
class CommonBase extends CI_Controller{
	public $site_config = array()  ; //站点基本信息
	public $userInfo = array();
	public $is_login = false ;
	public $table_ = '57sy_' ; //表的前缀
	public $table_pre = '57sy_' ; 
	public function __construct(){
		parent::__construct() ;
		$this->init();
		
	}
	//设置读取的文件目录
	public function init(){
		$this->load->add_package_path(__ROOT__."/share/");//此处必须
		$this->config->load();
		$this->table_ =table_pre("real_data"); //设置表前缀
		$this->table_pre =table_pre("real_data"); //设置表前缀
		$this->site_info() ; //获取站点基本信息
		$this->site_status();//站点状态
		$this->UserLogin();
	}
	private function site_info(){
		$filename = config_item("sysconfig_cache")."/sysconfig.inc.php" ;
		if(file_exists($filename)){
			include $filename;
			$this->site_config = $site_config ;
		}else{
			//从数据库里面进行查询，然后写入到缓存文件
			$this->load->model('M_common');
			$this->load->model('M_sysconfig');
			$this->M_sysconfig->make_sysconfig();
		}
	
	}
	//站点状态
	private function site_status(){
		if(isset($this->site_config['web_site_status']) && $this->site_config['web_site_status'] == 'N' ){
			header("Content-type:text/html;charset=utf-8");
			show_error(isset($this->site_config['var_close_reason'])?$this->site_config['var_close_reason']:'网站升级中，请稍后访问' , 500 , '站点关闭' ) ;
		}
	}
	/*
	*@des 加载广告
	*@author 57sy.com
	*$typeid 广告位置ID
	*$num 加载的广告条数 
	 */
	public function load_ad($typeid , $num  = 5 ){
		if(!$typeid){
			return '' ;
		}
		$this->load->model('M_common');
		$this->load->model('M_ad');
		return $this->M_ad->query_ad_by_typeid($typeid , $num);
	}
	
	//验证会员 用户是否登录
	public function UserLogin(){
		$dataString = auth_code(isset($_COOKIE['web_user_auth'])?$_COOKIE['web_user_auth']:'' , "DECODE" , config_item("cookie_auth_key"));
		if($dataString){
			$this->userInfo = unserialize($dataString) ;
				
		}
		if(!empty($this->userInfo) && is_array($this->userInfo)){
			$this->is_login = true ;
		}
	
	}
	
}
/*
 *让CI继承自己的类库
* ######################################
* 此类库主要是前台的继承
*###################################
*/
class HomeCommon extends CommonBase{
	
	public function __construct(){
		parent::__construct() ;
		
	}
}

/*
 *@des 用户中心的基类 ，主要是一些公共的数据和登录权限控制
 *@author 57sy.com
 *@time 2015-02-24 
 */
class UsersCommon extends CommonBase{
	function __construct(){
		parent::__construct() ; 
		
		$this->doIsLogin();
	}
	//判断用户是否登录，进行逻辑处理
	public function doIsLogin(){
		if(!$this->is_login){
			//用户状态已经失效
			showmessage("请重新登录，已经过期"  , "users/login" , 3 , 0 ) ;
		}
	}

}

