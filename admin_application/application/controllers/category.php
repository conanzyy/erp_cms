<?php
/*
 *联动模型管理
 *author 王建 
 *time 2014-04-22
 */
if (! defined('BASEPATH')) {
    exit('Access Denied');
}
class Category extends MY_Controller{
	private $category_model_cache ; 
	private $category_ ; 
	function Category(){
		parent::__construct();
		$this->load->model('M_common');
		$this->category_model_cache = config_item("category_model_cache") ;
	}
	function index(){
		$action = $this->input->get_post("action");	
		$action_array = array("show","ajax_data","preview_category");
		$action = !in_array($action,$action_array)?'show':$action ;
		if($action == 'show'){
			$this->load->view(__TEMPLET_FOLDER__."/views_category_index",array('tips'=>"暂不提供删除的功能,请联系管理员在数据库里面删除【如果删除需要删除分类表{$this->table_}common_category_type和分类数据表{$this->table_}common_category_data】里面数据"));
		}elseif($action == 'ajax_data'){
			$this->ajax_data();
		}elseif($action == 'preview_category'){
			$this->preview_category();
		}	
	}
	//ajax get data
	private function ajax_data(){
		$page = intval($this->input->get_post("page"));		
		$this->load->library("common_page");
		if($page <=0 ){
			$page = 1 ;
		}
		$per_page = 10;//每一页显示的数量
		$limit = ($page-1)*$per_page;
		$limit.=",{$per_page}";
		$where = ' where 1= 1 ';
		$cname = daddslashes(html_escape(strip_tags(trim($this->input->get_post("cname"))))) ;
		if(!empty($cname)){
			$condition = intval($this->input->get_post("condition"));
			$condition  = in_array($condition,array(1,2))?$condition:1;
			$array_condition_search  = array(
				1=>" LIKE '%{$cname}%'", //模糊搜索
				2=>"= '{$cname}'"
			);
			$where.=" AND cname {$array_condition_search[$condition]}";
		}
		$sql_count = "SELECT COUNT(*) AS tt FROM {$this->table_}common_category_type as a  {$where} ";
		$total  = $this->M_common->query_count($sql_count);
		$page_string = $this->common_page->page_string($total, $per_page, $page);
		$sql_category = "SELECT *  FROM {$this->table_}common_category_type as a {$where} order by id desc limit  {$limit}";	
		$list = $this->M_common->querylist($sql_category);
		foreach($list as $k=>$v){
			$list[$k]['status'] = ($v['status'] == 1 )?"开启":'<font color="red">关闭</font>';
			$list[$k]['filename'] = file_exists($this->category_model_cache."/cache_category_{$v['id']}.inc.php")?"<font color='green'><a href='javascript:void(0)' title='点击查看文件内容' onclick=\"preview_category('{$v['id']}')\">已经生成</a></font>":'<font color="red">未生成</font>';
		}
		echo result_to_towf_new($list, 1, '成功', $page_string) ;
	}
	//添加联动模型数据
	function add(){
		
		$action = $this->input->get_post("action");		
		$action_array = array("add","doadd");
		$action = !in_array($action,$action_array)?'add':$action ;	
		if($action == 'add'){
			
			$this->load->view(__TEMPLET_FOLDER__."/views_category_add");		
		}elseif($action =='doadd'){
			$this->doadd();
		}
	}
	//处理添加
	private function doadd(){	
		$cname = dowith_sql(daddslashes(html_escape(strip_tags($this->input->get_post("cname")))));//cname
		$remark = dowith_sql(daddslashes(html_escape(strip_tags($this->input->get_post("remark")))));//remark
		$status = verify_id($this->input->get_post("status")); //状态	
		if($cname == "" ){
			showmessage("名称不能为空","category/add",3,0);
			exit();
		}	
		$data = array(
			'cname'=>$cname,
			'status'=>$status,
			'addtime'=>date("Y-m-d H:i:s",time()),
			'addperson'=>$this->username,
			'modifytime'=>date("Y-m-d H:i:s",time()),
			'remark'=>$remark
		);
		$array = $this->M_common->insert_one("{$this->table_}common_category_type",$data);
		if($array['affect_num']>=1){
			$this->make_category_cache($array['insert_id']);
			write_action_log($array['sql'],$this->uri->uri_string(),login_name(),get_client_ip(),1,"添加模型为{$cname}成功");
			header("Location:".site_url("category/index"));
		}else{
			write_action_log($array['sql'],$this->uri->uri_string(),login_name(),get_client_ip(),0,"添加模型为{$cname}失败");
			showmessage("服务器繁忙","category/add",3,0);
			exit();
		}
	}
	//编辑页面
	function edit(){
		$action = $this->input->get_post("action");		
		$action_array = array("edit","doedit");
		$action = !in_array($action,$action_array)?'edit':$action ;		
		if($action == 'edit'){
			$id = verify_id($this->input->get_post("id"));//模型ID
			$sql_= "SELECT a.* FROM {$this->table_}common_category_type as a where a.id = '{$id}'";					
			$info_ = $this->M_common->query_one($sql_);
			if(empty($info_)){
				showmessage("参数错误","sys_admin/index",3,0);
				exit();
			}			
			$data = array(
					'info'=>$info_,				
			);				
			$this->load->view(__TEMPLET_FOLDER__."/views_category_edit",$data);	
			
		}elseif($action == 'doedit'){
			$this->doedit();
		}

	}
	//处理编辑数据
	private function doedit(){
		$id = verify_id($this->input->get_post("id"));	
		$cname = dowith_sql(daddslashes(html_escape(strip_tags(trim($this->input->get_post("cname"))))));//cname
		$remark = dowith_sql(daddslashes(html_escape(strip_tags(trim($this->input->get_post("remark"))))));//remark
		$status = verify_id($this->input->get_post("status"));
		
		if(abslength($cname)<3 || abslength($cname)>16){
			showmessage("名称名长度必须在3-16之间","category/edit",3,0,"?id={$id}");
			exit();
		}
		$time = date("Y-m-d H:i:s",time());
		$sql_edit = "UPDATE `{$this->table_}common_category_type` SET status = '{$status}',cname = '{$cname}',modifytime = '{$time}',remark = '{$remark}'   where id = '{$id}'";
		$num = $this->M_common->update_data($sql_edit);
		if($num>=1){
			$this->make_category_cache($id);
			write_action_log($sql_edit,$this->uri->uri_string(),login_name(),get_client_ip(),1,"修改名称为{$cname}成功");
			header("Location:".site_url("category/index/"));
		}else{
			write_action_log($sql_edit,$this->uri->uri_string(),login_name(),get_client_ip(),0,"修改名称为{$cname}失败");
			showmessage("服务器繁忙，或者你没有修改任何数据","category/edit",3,0,"?id={$id}");
		}
	}
	
	//生成模型缓存
	//$id 模型ID
	private function make_category_cache($id = '' ){		
		if(!is_really_writable(dirname($this->category_model_cache))){				
			exit("目录".dirname($this->category_model_cache)."不可写,或者不存在");
		}		
		if(!file_exists($this->category_model_cache)){
			mkdir($this->category_model_cache);
		}
		$category = $this->M_common->query_one("SELECT * FROM {$this->table_}common_category_type WHERE id = '{$id}' limit 1  ");
		if(!$category){
			return ; 
		}
		$configfile = $this->category_model_cache."/cache_category_{$id}.inc.php";
		$fp = fopen($configfile,'w');
		flock($fp,3);
		fwrite($fp,"<"."?php\r\n");
    	fwrite($fp,"/*联动模型缓存*/\r\n");
    	fwrite($fp,"/*author wangjian*/\r\n");
    	fwrite($fp,"/*time 2014_04_22*/\r\n");
    	fwrite($fp,"\$category_ = array(\r\n");
		foreach($category as $k=>$v){
			$v = daddslashes(trim($v)) ;
			fwrite($fp,"'{$k}' => '{$v}',\r\n");
		}
		fwrite($fp,");\r\n");
		fwrite($fp,"?".">");
    	fclose($fp);		
	}
	//查看分类的缓存信息
	function preview_category(){
		$id = verify_id($this->input->get_post("id"));	
		if($id <= 0 ){
			exit("参数传递错误");
		}
		$configfile = $this->category_model_cache."/cache_category_{$id}.inc.php";
		if(!file_exists($configfile)){
			exit("缓存文件不存在");
		} 
		include $configfile ; 
		$data = array();
		$data = isset($category_)?$category_:'' ;
		echo "生成的路径是:".$configfile;
		echo "<pre>" ; 
		echo var_export($data,true);		
	}
	
}
//file end 