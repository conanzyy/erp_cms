<?php
/*
 *网站用户管理controller
 *author  王建 
 */
if (! defined('BASEPATH')) {
    exit('Access Denied');
}
class User extends MY_Controller{
	function User(){
		parent::__construct();
		$this->load->model('M_common','',false , array('type'=>'real_data'));
	}
	function index(){
		$action = $this->input->get_post("action");	
		$action_array = array("show","ajax_data");
		$action = !in_array($action,$action_array)?'show':$action ;
		if($action == 'show'){
			$this->load->view(__TEMPLET_FOLDER__."/views_user");
		}elseif($action == 'ajax_data'){
			$this->ajax_data();
		}		
	}
	//ajax 获取数据
	private function ajax_data(){
		$this->load->library("common_page");
		$page = $this->input->get_post("page");	
		if($page <=0 ){
			$page = 1 ;
		}
		$per_page = 10;//每一页显示的数量
		$limit = ($page-1)*$per_page;
		$limit.=",{$per_page}";
		$where = ' where 1= 1 ';
		$username = daddslashes(html_escape(strip_tags(trim($this->input->get_post("username",true))))) ;
		
		if(!empty($username)){
			$condition = intval($this->input->get_post("condition"));
			$condition  = in_array($condition,array(1,2))?$condition:1;
			$array_condition_search  = array(
				1=>" LIKE '%{$username}%'", //模糊搜索
				2=>"= '{$username}'"
			);
			$where.=" AND username {$array_condition_search[$condition]}";
		}
		$status = $this->input->get_post("status");	
		if(in_array($status,array('1','0',true))){
			$where.=" AND `status` = '{$status}'"; 
		}
		$sql_count = "SELECT COUNT(*) AS tt FROM {$this->table_}common_user {$where}";
		$total  = $this->M_common->query_count($sql_count);
		$page_string = $this->common_page->page_string($total, $per_page, $page);
		$sql_role = "SELECT * FROM {$this->table_}common_user {$where} order by uid desc   limit  {$limit}";	
		$list = $this->M_common->querylist($sql_role);
		foreach($list as $k=>$v){
			$list[$k]['status'] = ($v['status'] == 1 )?"开启":'<font color="red">关闭</font>';			
			$list[$k]['regdate'] = date("Y-m-d H:i:s",$v['regdate']);
			$list[$k]['expire'] = ($v['expire'] == 0 )?'<font color="green">永不过期</font>':date("Y-m-d H:i:s",$v['expire']);
		}
		echo result_to_towf_new($list, 1, '成功', $page_string) ;
	}
	//编辑页面
	function edit(){
		$action = $this->input->get_post("action");		
		$action_array = array("edit","doedit");
		$action = !in_array($action,$action_array)?'edit':$action ;		
		if($action == 'edit'){
			$id = verify_id($this->input->get_post("id"));
			$sql_user = "SELECT * FROM {$this->table_}common_user WHERE uid = '{$id}'";
			$info = $this->M_common->query_one($sql_user);
			if(empty($info)){
				showmessage("暂无数据","user/index",3,0);
				exit();
			}		
			$data = array(
				'info'=>$info
			);
			$this->load->view(__TEMPLET_FOLDER__."/views_user_edit",$data);		
		}elseif($action == 'doedit'){
			$this->doedit();
		}

	}
	//处理编辑数据
	private function doedit(){
		$username = dowith_sql(daddslashes(html_escape(strip_tags($this->input->get_post("username")))));//username
		$passwd = dowith_sql(daddslashes(html_escape(strip_tags($this->input->get_post("passwd")))));//passwd
		$status = verify_id($this->input->get_post("status")); //状态	
		$id = verify_id($this->input->get_post("id")); //id
		$expire = $this->input->get_post("expire"); //过期日期
		$set = '' ;
		if(!empty($username)){
			$set.=",`username` = '{$username}'";
		}
		if(!empty($passwd)){
			if(utf8_str($passwd) != 1 ){
				showmessage("密码必须是英文","user/edit",3,0,"?id={$id}");
				exit();
			}
			$passwd = md5($passwd);
			$set.=",`passwd`= '{$passwd}'";
		}
		
		if($expire != '0'  && strripos($expire,"-") !== FALSE ){
			$expire = strtotime($expire);
		}else{
			$expire = 0 ;
		}			
		$sql_edit = "UPDATE `{$this->table_}common_user` SET `expire` = '{$expire}' {$set} ,`status` = '{$status}' where uid = '{$id}'";
		$num = $this->M_common->update_data($sql_edit);
		if($num>=1){
			//
			write_action_log($sql_edit,$this->uri->uri_string(),login_name(),get_client_ip(),1,"修改用户为{$username}成功");
			header("Location:".site_url("user/index/"));
		}else{
			write_action_log($sql_edit,$this->uri->uri_string(),login_name(),get_client_ip(),0,"修改用户{$username}失败");
			showmessage("服务器繁忙，或者你没有修改任何数据","user/edit",3,0,"?id={$id}");
			die();
		}
	}
	
	///用户增加
	 function add(){
		$action = $this->input->get_post("action");		
		$action_array = array("add","doadd");
		$action = !in_array($action,$action_array)?'show':$action ;	
		if($action == 'show'){			
			$this->load->view(__TEMPLET_FOLDER__."/views_user_add");		
		}elseif($action == 'doadd'){
			$this->doadd();
		}
	}
	//处理增加
	private function doadd(){
		$username = dowith_sql(daddslashes(html_escape(strip_tags($this->input->get_post("username")))));//username
		$passwd = dowith_sql(daddslashes(html_escape(strip_tags($this->input->get_post("passwd")))));//passwd
		$status = verify_id($this->input->get_post("status")); //状态	
		$expire = $this->input->get_post("expire"); //过期日期
		if(empty($username)){
			showmessage("用户名不能为空","user/add",3,0);
			exit();
		}
		if(empty($passwd)){
			showmessage("密码不能为空","user/add",3,0);
			exit();
		}
		if(utf8_str($passwd) != 1 ){
			showmessage("密码必须是英文","user/add",3,0);
			exit();
		}
		if($expire != '0'  && strripos($expire,"-") !== FALSE ){
			$expire = strtotime($expire);
		}else{
			$expire = 0 ;
		}
		//查询用户是否存在
		$info = $this->M_common->query_one("SELECT username FROM `{$this->table_}common_user` where username = '{$username}' limit 1 ");
		if(!empty($info)){
			showmessage("用户{$username}已经存在","user/add",3,0);
			exit();
		}
		$data = array(
			'username'=>$username,
			'status'=>$status,
			'regdate'=>time(),
			'passwd'=>md5($passwd),
			'expire'=>$expire
		);
		$array = $this->M_common->insert_one("{$this->table_}common_user",$data);
		if($array['affect_num']>=1){
			write_action_log($array['sql'],$this->uri->uri_string(),login_name(),get_client_ip(),1,"添加用户为{$username}成功");
			header("Location:".site_url("user/index"));
			//showmessage("添加用户成功","user/index",3,1);
			//exit();
		}else{
			write_action_log($array['sql'],$this->uri->uri_string(),login_name(),get_client_ip(),0,"添加用户为{$username}失败");
			showmessage("添加用户失败","user/add",3,0);
			exit();
		}
	}
	
	//生成缓存
	private function make_cache(){
		if(!is_really_writable($this->role_cache_path)){				
			exit("目录".$this->role_cache_path."不可写");
		}
		
		if(!file_exists($this->role_cache_path)){
			mkdir($this->role_cache_path);
		}
		$configfile = $this->role_cache_path."/cache_role_{$this->role_id}.inc.php";
		$str = '' ; 
		$time = date("Y-m-d H:i:s",time());
		$fp = fopen($configfile,'w');
		flock($fp,3);
		fwrite($fp,"<"."?php\r\n");
    	fwrite($fp,"/*团队角色缓存*/\r\n");
    	fwrite($fp,"/*author wangjian*/\r\n");
    	fwrite($fp,"/*time {$time}*/\r\n");
    	//fwrite($fp,"\$role_array = array(\r\n");
		/* foreach($this->perm_data as $k=>$v){
			fwrite($fp,"'{$k}' => '{$v}',\r\n");
		} */
		$str.="\$role_array = ";
    	$str.= var_export($this->perm_data,true)  ; 
    	fwrite($fp,"{$str};\r\n");
		//fwrite($fp,");\r\n");
		fwrite($fp,"?".">");
    	fclose($fp);
	}
	
	//预览所在用户组的用户
	private function preview_user(){
		$id = verify_id($this->input->get_post("id"));
		if($id<=0){
			echo "参数传递错误"; 
			exit();
		}
		$list = $this->M_common->querylist("SELECT id,username,status FROM {$this->table_}common_system_user where gid = '{$id}' ");
		if($list){
			foreach($list as $k=>$v){
				$status = ($v['status'] == 1 )?"<font color='green'>正常</font>":'<font color="red" >禁止</font>' ;
				echo "<li style=\"text-decoration:none; display:block ; width:100px; height:30px; padding:2px; float:left; border:solid 1px #F0F0F0 ;  text-align:center;line-height:30px; margin-left:3px\">";
				echo $v['username']."【".$status."】";
				echo "</li>";
			}
		}else{
			echo "暂无用户";
		}
	}
}