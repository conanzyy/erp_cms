<?php
/*
 *新闻管理
 *author 王建 
 *time 2014-05-18
 */
if (! defined('BASEPATH')) {
    exit('Access Denied');
}
class News extends MY_Controller{
	public $upload_path = '' ; 
	public $upload_save_url = '' ;
	
	public  $thum_upload_path = ''; //上传图片缩略图的保存路径
	public  $v_upload_path ; //访问的路径
	public 	$news_attr = '' ; //文章属性
	
	public 	$title = '' ;//文章title
	public	$keysword = '' ;//关键词
	public 	$introduce = '' ;//介绍
	public	$weight = '' ;//权重
	public	$content = '' ;//内容
	public	$status = '' ;//状态
	public	$create_date = '' ;//创建日期
	public	$flag = '' ;//属性
	public	$click = '' ;//点击数量
	public  $typeid = '' ; //类型ID
	public  $addperson ; //发布人
	function News(){
		parent::__construct();
		$this->load->model('M_common');
		$this->load->model('M_news');
		$this->upload_path = __ROOT__."/data/upload/k/" ; ; // 编辑器上传的文件保存的位置
		$this->upload_save_url = __UPLOAD_URL__."/k/"; //编辑器上传图片的访问的路径
		$this->news_attr = config_item("content_att") ;
		$this->thum_upload_path = config_item("news_path");  //上传路径
		$this->v_upload_path = base_url().config_item("v_news_path");  //访问路径
	}
	function index(){
		$action = $this->input->get_post("action");	
		$action_array = array("show","ajax_data","preview","upload");
		$action = !in_array($action,$action_array)?'show':$action ;
		if($action == 'show'){
			$this->load->model('M_news');			
			$list = $this->M_news->make_option_data();
			$data = array(
				'list'=>$list
			);			
			$this->load->view(__TEMPLET_FOLDER__."/views_news",$data);
		}elseif($action == 'ajax_data'){
			$this->ajax_data();
		}elseif($action == "preview" ){
			$this->preview() ;
		}elseif($action == "upload" ){
			$this->upload() ;
		}	
	}
	//ajax get data
	private function ajax_data(){
		$page = intval($this->input->get_post("page" , true ));
		$typeid = intval($this->input->get_post("typeid" , true ));
		$title = trim($this->input->get_post("title" , true ));
		$status = trim($this->input->get_post("status" , true ));
		$flag = trim($this->input->get_post("flag" , true ));
		$params = array(
			'typeid'=>$typeid , 
			'title'=>$title, 
			'status'=>$status	,
			'flag'	=>$flag
		);
		$list = $this->M_news->queryNewsList($page , 50 , $params);
		echo result_to_towf_new($list['list'], 1, '成功', $list['page_string']) ;
	}
	
	//添加新闻数据
	function add(){		
		$action = $this->input->get_post("action");		
		$action_array = array("add","doadd");
		$action = !in_array($action,$action_array)?'add':$action ;	
		if($action == 'add'){
			$this->load->helper(array('form', 'url'));
			$this->load->model('M_news');			
			$result = $this->M_news->make_option_data();//新闻类别
			/* echo "<pre>";
			print_r($result); */
			$data = array(
				'category'=>$result,
			);		
			$this->load->view(__TEMPLET_FOLDER__."/views_news_add",$data);		
		}elseif($action =='doadd'){			
			$this->doadd();
		}
	}
	//设置参数
	private function set_params(){
		$this->title = trim($this->input->get_post("title",true));
		$this->keysword = trim($this->input->get_post("keysword",true));
		$this->content = html_escape(trim($this->input->get_post("content",true)));
		$this->introduce = trim($this->input->get_post("introduce",true));
		if(empty($this->introduce) && !empty($this->content)){
			$this->introduce = msubstr(cutstr_html($_POST['content']),0,100,abslength(cutstr_html($_POST['content'])),'utf-8',false);	
			$this->introduce= str_replace(PHP_EOL, '', $this->introduce); 
		}	
		$this->weight = verify_id($this->input->get_post("weight",true));		
		$this->status  = verify_id($this->input->get_post("status",true));
		$this->create_date = (html_escape($this->input->get_post("create_date",true)))?strtotime(html_escape($this->input->get_post("create_date",true))):time();
		$this->flag =( html_escape($this->input->get_post("flag",true)) )?(implode(",", html_escape($this->input->get_post("flag",true)))):'';
		$this->click = verify_id($this->input->get_post("click",true));		
		$this->addperson = $this->visitor['username'];
		$this->typeid = verify_id($this->input->get_post("typeid",true));		
	}
	//处理添加
	private function doadd(){	
		$this->set_params();		
		$data = array(
			'title'=>$this->title,
			'keysword'=>$this->keysword,
			'introduce'=>$this->introduce,
			'weight'=>$this->weight,
			'content'=>$this->content,
			'status'=>$this->status,
			'create_date'=>$this->create_date,
			'modify_date'=>$this->create_date,
			'flag'=>$this->flag,
			'click'=>$this->click ,	
			'typeid'=>$this->typeid ,
			'addperson'=>$this->addperson
		);
		
		$array = $this->M_news->insertNews($data);
		if($array['status']){
			header("Location:".site_url("news/index"));
		}else{
			showmessage($array['message'],"news/add",3,0,"");
			exit();
		}
	}
	//编辑页面
	function edit(){
		$action = $this->input->get_post("action");		
		$action_array = array("edit","doedit","dostatus");
		$action = !in_array($action,$action_array)?'edit':$action ;		
		if($action == 'edit'){
			$this->load->helper(array('form', 'url'));
			$id = verify_id($this->input->get_post("id"));//数据				
			$info_ = $this->M_news->getNewsById($id);
			if(empty($info_)){
				showmessage("参数错误","news/index",3,0);
				exit();
			}		
			$result = $this->M_news->make_option_data();		
			//echo "<pre>";
			//print_r($result);	
			$data = array(
					'info'=>$info_,	
					'id'=>$id,
					'category'=>$result		
			);				
			$this->load->view(__TEMPLET_FOLDER__."/views_news_edit",$data);	
			
		}elseif($action == 'doedit'){
			$this->doedit();
		}elseif($action == "dostatus"){
			$this->dostatus();
		}

	}
	//处理编辑数据
	private function doedit(){
		$id  = verify_id($this->input->get_post("id",true));		
		$this->set_params();
		$data = array(
				'title'=>$this->title,
				'keysword'=>$this->keysword,
				'introduce'=>$this->introduce,
				'weight'=>$this->weight,
				'content'=>$this->content,
				'status'=>$this->status,
				'create_date'=>$this->create_date,
				'modify_date'=>$this->create_date,
				'flag'=>$this->flag,
				'click'=>$this->click ,
				'typeid'=>$this->typeid ,
				'addperson'=>$this->addperson,
				'modify_date'=>time(),
				
		);
		
		$re = $this->M_news->edit_news($data , $id );
		if($re['status']){
			header("Location:".site_url("news/index"));		
		}else{
			showmessage($re['message'],"news/edit",3,0,"?id={$id}");
		}
	}
	//删除
	public function del(){
		$id= $this->input->get_post("id" , true );
		$data = $this->M_news->del_news($id);
		if($data['status']){
			echo result_to_towf_new("", 1, $data['message'], null);
		}else{
			echo result_to_towf_new("", 0, $data['message'], null);
		}	
	}
	//修改状态
	private function dostatus(){
		$id = verify_id($this->input->get_post("id"));
		$field = $this->input->get_post("field" , true );
		$value = $this->input->get_post("value" , true );
		$params = array(
			'id'=>$id , 
			'field'=>$field , 
			'value'=>$value		
		) ;
		$data = $this->M_news->edit_news_by_params($params);
		if($data['status']){
			echo result_to_towf_new("", 1, "修改成功", null);
		}else{
			echo result_to_towf_new("", 0, $data['message'], null);
		}			
	}
	
	//预览
	private function preview(){
		$id = verify_id($this->input->get_post("id"));//数据
		$sql_= "SELECT a.* FROM {$this->table_}extra_news as a where a.id = '{$id}'";					
		$info_ = $this->M_common->query_one($sql_);
		if(empty($info_)){
			showmessage("参数错误","extra_news/index",3,0);
			exit();
		}
		$data = array(
			'info'=>$info_
		);				
		$this->load->view(__TEMPLET_FOLDER__."/views_news_preview",$data);			
	}
	//上传文件
	private function upload(){
		//包含kindeditor的上传文件
		$save_path =$this->upload_path ; // 编辑器上传的文件保存的位置
		$save_url = $this->upload_save_url; //访问的路径
		include_once APPPATH."libraries/JSON.php" ;
		include_once APPPATH."libraries/upload_json.php" ;
	}

	
}
//file end