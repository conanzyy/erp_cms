<?php 
/*
 *产品管理
 *author 王建 
 */
if (! defined('BASEPATH')) {
    exit('Access Denied');
}
class Product extends MY_Controller {
	public  $upload_path = ''; //上传产品的保存路径
	public  $v_upload_path ; //访问的路径
	public  $product_type = 7 ; //定义分类的类型ID (产品的分类)
	public  $title = ''  ; //产品名字
	public	$url = '' ;//产品地址
	public	$weight = '' ;//权重
	public	$status = '' ;//状态
	public	$introduce = '' ;//介绍
	public	$typeid= '' ;//类别ID
	public	$typename = '' ;//类别名称
	public 	$modify_date = '';//修改日期
	public	$create_date = '' ;//创建日期
	function Product(){
		parent::__construct();
		$this->load->model('M_common');
		$this->upload_path = config_item("product_path");  //上传路径
		$this->v_upload_path = base_url().config_item("v_product_path");  //访问路径
	}

	function index(){
		$action = $this->input->get_post("action");	
		$action_array = array("show","ajax_data");
		$action = !in_array($action,$action_array)?'show':$action ;
		if($action == 'show'){		 
			$this->load->view(__TEMPLET_FOLDER__."/views_product_index");	
		}elseif($action == 'ajax_data'){
			$this->ajax_data();
		}
		
	}
	//ajax get data
	private function ajax_data(){
		$this->load->library('common_page');	
		$page = intval($this->input->get_post("page"));			
		if($page <=0 ){
			$page = 1 ;
		}
		$per_page = 15;//每一页显示的数量
		$limit = ($page-1)*$per_page;
		$limit.=",{$per_page}";
		$where = ' where 1= 1 ';
		$status = $this->input->get_post("status");
		if(in_array($status, array('0','1'),true)){
			$where.=" AND `status` = {$status}";
		}
		$productname = daddslashes(html_escape(strip_tags(trim($this->input->get_post("productname",true))))) ;
		if(!empty($productname)){
			$condition = intval($this->input->get_post("condition"));
			$condition  = in_array($condition,array(1,2))?$condition:1;
			$array_condition_search  = array(
				1=>" LIKE '%{$productname}%'", //模糊搜索
				2=>"= '{$productname}'"
			);
			$where.=" AND `title` {$array_condition_search[$condition]}";
		}
		$sql_count = "SELECT COUNT(*) AS tt FROM {$this->table_}extra_product as a   {$where} ";
		$total  = $this->M_common->query_count($sql_count);
		$page_string =$this->common_page->page_string($total, $per_page, $page);
		$sql_list = "SELECT * FROM {$this->table_}extra_product  {$where} order by id desc limit  {$limit}";	
		$list = $this->M_common->querylist($sql_list);
		foreach($list as $k=>$v){
			$list[$k]['modify_date'] = ($v['modify_date'] != "" )?date("Y-m-d H:i",$v['modify_date']):'';
			$list[$k]['create_date'] = ($v['create_date'] != "" )?date("Y-m-d H:i",$v['create_date']):'';
			$list[$k]['status'] = ($v['status'] == 1 )?"开启":'<font color="red">关闭</font>';
			$list[$k]['image'] = ($v['image'] != "")?"{$this->v_upload_path}"."/{$v['image']}":'';
		}
		echo result_to_towf_new($list, 1, '成功', $page_string) ;
	}	
	//function add
	function add(){		
		$action = $this->input->get_post("action");	
		$action_array = array("show","doadd");
		$action = !in_array($action,$action_array)?'show':$action ;
		$category_data_array = array();
		$category_data_array = $this->get_category_product();
		if($action == 'show'){
			$this->load->helper(array('form', 'url'));		
			$this->load->view(__TEMPLET_FOLDER__."/views_product_add",array('category_data'=>$category_data_array));	
		}elseif ($action == 'doadd'){
			$this->doadd() ;
		}
	}
	//设置参数
	private function set_params(){
		$this->title = dowith_sql(daddslashes(html_escape(strip_tags($this->input->get_post("title",true))))) ;//产品名称
		$this->url = daddslashes(html_escape(strip_tags($this->input->get_post("url",true)))) ; 
		$this->weight = verify_id($this->input->get_post("weight"));//权重
		$this->status = verify_id($this->input->get_post("status"));//状态
		$this->introduce = daddslashes(html_escape(strip_tags($this->input->get_post("introduce",true)))) ; 
		$this->typeid = verify_id($this->input->get_post("typeid"));//typeid
		$this->typename = dowith_sql(daddslashes(html_escape(strip_tags($this->input->get_post("typename",true))))) ;//typename
		$this->modify_date = time();
		$this->create_date = time() ;
	}
	private function doadd(){
		$this->set_params();
		$data = array(
			'title'=>$this->title,
			'url'=>$this->url,
			'weight'=>$this->weight,
			'modify_date'=>$this->modify_date,
			'create_date'=>$this->create_date,
			'status'=>$this->status,
			'introduce'=>$this->introduce,
			'addperson'=>$this->username,
			'typeid'=>$this->typeid,
			'typename'=>$this->typename
		);
		if(empty($this->title)){
			showmessage("产品名称不能为空","product/add",3,0);
			die();
		}
		$this->load->library("common_upload");
		$image  = $this->common_upload->upload_path($this->upload_path) ; 
		$data['image'] = $image ;
		$array = $this->M_common->insert_one("{$this->table_}extra_product",$data);
		if($array['affect_num']>=1){
			write_action_log($array['sql'],$this->uri->uri_string(),login_name(),get_client_ip(),1,"添加产品{$this->title}成功");
			showmessage("添加成功","product/index",3,1);
			exit();
		}else{
			write_action_log($array['sql'],$this->uri->uri_string(),login_name(),get_client_ip(),0,"添加产品{$this->title}失败");
			showmessage("服务器繁忙请稍候","product/add",3,0);
			exit();
		}	
	}
	function edit(){
		$action = $this->input->get_post("action");	
		$action_array = array("show","doedit","dostatus");
		$action = !in_array($action,$action_array)?'show':$action ;
		if($action == 'show'){
			$this->load->helper(array('form', 'url'));
			$id =verify_id($this->input->get_post("id"));
			if($id<=0){
				showmessage("暂无数据","product/index",3,0);
				exit();
			}
			$info = $this->M_common->query_one("SELECT * FROM {$this->table_}extra_product where id = '{$id}'");
			if(empty($info)){
				showmessage("暂无数据","product/index",3,0);
				exit();
			}
			$category_data_array = array();
			$category_data_array = $this->get_category_product();
			$data['info'] = $info ;
			$data['category_data'] = $category_data_array ;
			$this->load->view(__TEMPLET_FOLDER__."/views_product_edit",$data);			
		}elseif($action == 'doedit'){
			$this->doedit();
		}elseif($action == "dostatus"){
			$this->dostatus();
		}
	}
	private function doedit(){
		$this->set_params();
		$id = verify_id($this->input->get_post("id"));//id
		$image_path = $this->input->get_post("image_path");//
		$this->load->library("common_upload");
		$image  = $this->common_upload->upload_path($this->upload_path) ; 	
		$set_image = '' ;
		if($image != ''){
			$set_image = " image = '{$image}' , " ;
			if(file_exists($this->upload_path."/".$image_path)){
				@unlink($this->upload_path."/".$image_path);
			}
		}
		$modify_date = time();
		$update = "UPDATE {$this->table_}extra_product SET title = '{$this->title}',modify_date = '{$this->modify_date}', url = '{$this->url}', $set_image `weight` = '{$this->weight}',status = '{$this->status}',introduce= '{$this->introduce}',typeid = '{$this->typeid}',typename = '{$this->typename}'   where id = '{$id}'" ;
		$num = $this->M_common->update_data($update);
		if($num>=1){
			write_action_log($update,$this->uri->uri_string(),login_name(),get_client_ip(),1,"修改产品为{$this->title}成功");
			showmessage("修改成功","product/index",3,1);
			exit();
		}else{
			write_action_log($update,$this->uri->uri_string(),login_name(),get_client_ip(),0,"修改产品为{$this->title}失败");
			showmessage("服务器繁忙请稍候","product/edit",3,0,"?id={$id}");
		}
	}
	//删除
	public function del(){
		$ids = $this->input->get_post("ids");
		$id = '' ; 
		$id = get_ids($ids) ; 
		if(!$id){
			echo result_to_towf_new("", 0, "请选择删除", null);
			exit();
		}
		$sql_del = "DELETE FROM `{$this->table_}extra_product` WHERE id in ($id) AND `status` = '0' " ;
		$sql_product = "SELECT `image` FROM `{$this->table_}extra_product` WHERE id in ($id) AND `status` = '0' " ;
		$product_array = array() ; 
		$product_array = $this->M_common->querylist($sql_product);
		$num = $this->M_common->del_data($sql_del);
		if($num >= 1 ){
			//删除产品图片
			if($product_array){
				foreach($product_array as $p_k => $p_v){
					if(file_exists($this->upload_path."/{$p_v['image']}")){
						@unlink($this->upload_path."/{$p_v['image']}");
					}
				}
			}
			echo result_to_towf_new("", 1, "删除成功", null);
		}else{
			echo result_to_towf_new("", 0, "删除失败,必须删除是禁止的产品数据", null);
		}		
	}
	//修改状态
	private function dostatus(){
		$status  = verify_id($this->input->get_post("status",true));
		$ids = $this->input->get_post("ids");
		$id = '' ;
		$id = get_ids($ids) ; 
		if(!$id){
			echo result_to_towf_new("", 0, "请选择修改", null);
			die();
		}
		$sql_edit = "UPDATE `{$this->table_}extra_product` SET `status` = '{$status}' WHERE `id` in ($id)  " ; 
		$num = $this->M_common->del_data($sql_edit);
		if($num >= 1 ){
			echo result_to_towf_new("", 1, "修改成功", null);
		}else{
			echo result_to_towf_new("", 0, "修改失败,请重新尝试", null);
		}		
	}
	//获取下拉框 产品分类数据
	private  function get_category_product(){
		$category_data_array = array();
		if(file_exists(config_item("category_modeldata_cache")."/cache_categorydata_{$this->product_type}.inc.php")){
			include_once config_item("category_modeldata_cache")."/cache_categorydata_{$this->product_type}.inc.php";
			$category_data_array = $category_data ; 
		}
		$this->load->library('Myproduct',array('type' => $this->product_type));
		$category_data_array = $this->myproduct->getChildren($category_data_array);
		return $category_data_array ;
	}
}




