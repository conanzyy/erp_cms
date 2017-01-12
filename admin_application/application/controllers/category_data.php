<?php
/*
 *联动模型数据
 *author 王建 
 *time 2014-04-23
 */
if (! defined('BASEPATH')) {
    exit('Access Denied');
}
class Category_data extends MY_Controller{
	private $category_modeldata_cache; 
	private $category_ ; 
	function Category_data(){
		parent::__construct();
		$this->load->model('M_common');
		$this->category_modeldata_cache = config_item("category_modeldata_cache") ;
	}
	function index(){
		$action = $this->input->get_post("action");	
		$action_array = array("show","ajax_data",'query_pid_by_id');
		$action = !in_array($action,$action_array)?'show':$action ;
		if($action == 'show'){
			//查询出模型类别
			$sql_type = "SELECT id,cname FROM {$this->table_}common_category_type WHERE status = '1' ORDER BY id DESC  " ;
			$list = $this->M_common->querylist($sql_type);
			$this->load->view(__TEMPLET_FOLDER__."/views_category_data_index",array('list'=>$list));
		}elseif($action == 'ajax_data'){
			$this->ajax_data();
		}elseif($action == 'query_pid_by_id'){
			$pid = $this->query_pid_by_id();
			echo $pid ;
		}		
	}
	//ajax get data
	private function ajax_data(){
		$page = intval($this->input->get_post("page"));	
		$pid = intval($this->input->get_post("pid"));		
		$this->load->library("common_page");
		if($page <=0 ){
			$page = 1 ;
		}
		$per_page = 15;//每一页显示的数量
		$limit = ($page-1)*$per_page;
		$limit.=",{$per_page}";
		$where = ' where 1= 1 ';
		$type = verify_id($this->input->get_post("typeid"));//类型ID
		if(!$type){
			echo result_to_towf_new('', 0, 'type类型出错,请选择类型查询', null) ;
			die();
		}
		$where.=" AND typeid = '{$type}' AND pid =  {$pid} ";
		$sql_count = "SELECT COUNT(*) AS tt FROM {$this->table_}common_category_data as a  {$where} ";
		$total  = $this->M_common->query_count($sql_count);
		$page_string = $this->common_page->page_string($total, $per_page, $page);
		$sql_category = "SELECT *  FROM {$this->table_}common_category_data as a {$where} order by id,disorder desc limit  {$limit}";	
		$list = $this->M_common->querylist($sql_category);
		//$this->load->library("category");
		//$list = $this->category->format_category_data($list);
		$id_str = '' ; 
		$list_num = array() ; 
		if($list){
			foreach($list as $k=>$v){
				$list[$k]['status'] = ($v['status'] == 1 )?"开启":'<font color="red">关闭</font>';
			//	$list[$k]['name'] = str_repeat("&nbsp;", $v['deep']*3).$v['name'];
				$id_str.=$v['id'].",";
			}	
			$id_str = rtrim($id_str,",") ; 	
		}
		if($id_str){
			$list_num  = $this->M_common->querylist("SELECT pid,COUNT(*) as num  FROM {$this->table_}common_category_data  WHERE pid in ($id_str) group by pid ");
			
		}
		if($list && $list_num){
			$temp = array();
			foreach($list_num as $l_key => $l_val){
				$temp[$l_val['pid']] = $l_val['num'];
			}
			foreach($list as $kk=>$vv){
				$list[$kk]['name'] = $vv["name"]."[<font color='red'>".(isset($temp[$vv['id']])?$temp[$vv['id']]:'0' )."</font>]"; 
			}
		}
		echo result_to_towf_new($list, 1, '成功', $page_string) ;
	}
	//添加联动模型数据
	function add(){		
		$action = $this->input->get_post("action");		
		$action_array = array("add","doadd");
		$action = !in_array($action,$action_array)?'add':$action ;	
		if($action == 'add'){
			$typeid = verify_id($this->input->get_post("typeid")) ;
			$pid = verify_id($this->input->get_post("pid")) ;
			if($typeid<=0 ){
				showmessage("参数错误",'category_data/index',3,0,"?typeid={$typeid}");
				die();
			}
			$this->load->view(__TEMPLET_FOLDER__."/views_category_data_add",array('typeid'=>$typeid,'pid'=>$pid));		
		}elseif($action =='doadd'){
			$this->doadd();
		}
	}
	//处理添加
	private function doadd(){	
		$name = dowith_sql(daddslashes(html_escape(strip_tags($this->input->get_post("name")))));
		$seotitle = dowith_sql(daddslashes(html_escape(strip_tags($this->input->get_post("seotitle")))));
		$keywords = dowith_sql(daddslashes(html_escape(strip_tags($this->input->get_post("keywords")))));
		$description = dowith_sql(daddslashes(html_escape(strip_tags($this->input->get_post("description")))));
		
		$disorder = verify_id($this->input->get_post("disorder"));//排序
		$status = verify_id($this->input->get_post("status")); //状态	
		$typeid = verify_id($this->input->get_post("typeid")) ;
		$pid = verify_id($this->input->get_post("pid")) ;
		
		if($name == "" ){
			//showmessage("名称长度必须在3-16之间","category_data/add",3,0,"?pid={$pid}&typeid={$typeid}");
			echo result_to_towf_new('', 0, '名称不能为空', null);
			exit();
		}
		$type_array = $this->M_common->query_one("SELECT cname FROM {$this->table_}common_category_type WHERE id = '{$typeid}' LIMIT 1 ");
		$typename = isset($type_array['cname'])?$type_array['cname']:'';
		$data = array(
			'name'=>$name,
			'status'=>$status,
			'disorder'=>$disorder,
			'pid'=>$pid,
			'typeid'=>$typeid,
			'typename'=>$typename,
			'seotitle'=>$seotitle,
			'keywords'=>$keywords,
			'description'=>$description
			
		);
		$array = $this->M_common->insert_one("{$this->table_}common_category_data",$data);
		if($array['affect_num']>=1){
			write_action_log($array['sql'],$this->uri->uri_string(),login_name(),get_client_ip(),1,"添加数据为{$name}成功");
			$MessageArray = $this->make_categorydata_cache($typeid);
			if($MessageArray && isset($MessageArray['code'])){
				echo result_to_towf_new('', 0, $MessageArray['message'], null);
				die();
			}
			echo result_to_towf_new('', 1, 'success', null);
			die();
		//	header("Location:".site_url("category_data/index")."?typeid=".$typeid);
		}else{
			write_action_log($array['sql'],$this->uri->uri_string(),login_name(),get_client_ip(),0,"添加数据为{$name}失败");
			echo result_to_towf_new('', 0, '服务器繁忙', null);
			die() ;
			//showmessage("服务器繁忙","category_data/add",3,0,"?id={$pid}&type={$typeid}");
			//exit();
		}
	}
	//编辑页面
	function edit(){
		$action = $this->input->get_post("action");		
		$action_array = array("edit","doedit");
		$action = !in_array($action,$action_array)?'edit':$action ;		
		if($action == 'edit'){
			$id = verify_id($this->input->get_post("id"));//数据
			$typeid = verify_id($this->input->get_post("typeid")) ;
			$sql_= "SELECT a.* FROM {$this->table_}common_category_data as a where a.id = '{$id}'";					
			$info_ = $this->M_common->query_one($sql_);
			if(empty($info_)){
				showmessage("参数错误","category_data/index",3,0);
				exit();
			}			
			$data = array(
					'info'=>$info_,	
					'typeid'=>$typeid	,
					'id'=>$id		
			);				
			$this->load->view(__TEMPLET_FOLDER__."/views_category_data_edit",$data);	
			
		}elseif($action == 'doedit'){
			$this->doedit();
		}

	}
	//处理编辑数据
	private function doedit(){
		$id = verify_id($this->input->get_post("id"));	
		$typeid = verify_id($this->input->get_post("typeid"));	
		$name = dowith_sql(daddslashes(html_escape(strip_tags(trim($this->input->get_post("name"))))));//
		$status = verify_id($this->input->get_post("status"));
		$disorder = verify_id($this->input->get_post("disorder"));	
		$seotitle = dowith_sql(daddslashes(html_escape(strip_tags($this->input->get_post("seotitle")))));
		$keywords = dowith_sql(daddslashes(html_escape(strip_tags($this->input->get_post("keywords")))));
		$description = dowith_sql(daddslashes(html_escape(strip_tags($this->input->get_post("description")))));
				
		if($name == "" ){
			echo result_to_towf_new(array('id'=>$id,'typeid'=>$typeid), 0, '名称名不能为空', null) ;
			//showmessage("名称名长度必须在2-16之间","category/edit",3,0,"?id={$id}&typeid={$typeid}");
			exit();
		}
		$time = date("Y-m-d H:i:s",time());
		$sql_edit = "UPDATE `{$this->table_}common_category_data` SET status = '{$status}',name = '{$name}',disorder = '{$disorder}',seotitle='{$seotitle}',keywords = '{$keywords}' ,description = '{$description}'   where id = '{$id}'";
		
		$num = $this->M_common->update_data($sql_edit);
		if($num>=1){
			write_action_log($sql_edit,$this->uri->uri_string(),login_name(),get_client_ip(),1,"修改名称为{$name}成功");
			$MessageArray = $this->make_categorydata_cache($typeid);
			if($MessageArray && isset($MessageArray['code'])){
				echo result_to_towf_new('', 0, $MessageArray['message'], null);
				die();
			}
			echo result_to_towf_new(array('id'=>$id,'typeid'=>$typeid), 1, 'success', null) ;
			
		}else{
			write_action_log($sql_edit,$this->uri->uri_string(),login_name(),get_client_ip(),0,"修改名称为{$name}失败");
			echo result_to_towf_new(array('id'=>$id,'typeid'=>$typeid), 0, '服务器繁忙，或者你没有修改任何数据', null) ;
			die();
			//showmessage("服务器繁忙，或者你没有修改任何数据","category_data/edit",3,0,"?id={$id}&typeid={$typeid}");
		}
	}
	
	//根据id查询pid
	private function query_pid_by_id(){
		$id = verify_id($this->input->get_post("id"));	
		$info = $this->M_common->query_one("SELECT pid FROM {$this->table_}common_category_data WHERE id = '{$id}' limit 1  ");
		$pid = '0' ;
		$pid = isset($info['pid'])?$info['pid']:'0' ;
		return $pid ; 
	}
	//生成模型缓存
	//$id typeid 类型id
	 function make_categorydata_cache($id = '' ){
		if(!$id){
			return array('code'=>0,'message'=>"无数据,生成缓存文件失败");	
		}		
		if(!is_really_writable(dirname($this->category_modeldata_cache))){				
			return array('code'=>0,'message'=>"目录".dirname($this->category_modeldata_cache)."不可写,或者不存在,生成缓存文件失败");	
			//exit("目录".dirname($this->category_modeldata_cache)."不可写,或者不存在");
		}		
		if(!file_exists($this->category_modeldata_cache)){
			mkdir($this->category_modeldata_cache);
		}
		
		$category_data = $this->M_common->querylist("SELECT * FROM {$this->table_}common_category_data WHERE typeid = '{$id}' AND `status` = '1'  ");
		if(!$category_data){
			return ; 
		}
		$data = array() ; 
		foreach($category_data as $c=>$c_v){
			$data[$c_v['id']] = $c_v ;
		}
		$data = genTree9($data) ; 
		$str = '' ; 		
		$configfile = $this->category_modeldata_cache."/cache_categorydata_{$id}.inc.php";
		$fp = fopen($configfile,'w');
		flock($fp,3);
		fwrite($fp,"<"."?php\r\n");
    	fwrite($fp,"/*联动数据缓存*/\r\n");
    	fwrite($fp,"/*author wangjian*/\r\n");
    	fwrite($fp,"/*time 2014_04_22*/\r\n");
    	$str.="\$category_data = ";
    	$str.= var_export($data,true)  ; 
    	fwrite($fp,"{$str};\r\n");
		//fwrite($fp,");\r\n");
		fwrite($fp,"?".">");
    	fclose($fp);		
	}	
	
}
//file end