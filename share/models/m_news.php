<?php
/*
 *news model 文件
 *@author 王建 
 */
class M_news extends M_common {
	function M_news(){
		parent::__construct();	
	}

	//生成下拉框
	function make_option_data(){
		$sql_news_type = "SELECT id,typename ,pid FROM {$this->table_}newstype where `status` = 1 ORDER by id,disorder desc " ;
		$list = $this->M_common->querylist($sql_news_type);	
		if($list){
			$list = tree_format($list,0,0,"&nbsp;&nbsp;&nbsp;&nbsp;");		
		}		
		return $list ;
	}
	//获取新闻类型列表数据
	public function queryNewsTypeList($page , $per_page = 100 ){
		
		$this->load->library("common_page");
		if($page <=0 ){
			$page = 1 ;
		}
		$limit = ($page-1)*$per_page;
		$limit.=",{$per_page}";
		$where = ' where 1= 1 ';
		$sql_count = "SELECT COUNT(*) AS tt FROM {$this->table_}newstype as a  {$where} ";
		$total  = $this->query_count($sql_count);
		$page_string = $this->common_page->page_string($total, $per_page, $page);
		$sql_category = "SELECT *  FROM {$this->table_}newstype as a {$where} order by id,disorder desc limit  {$limit}";
		$list = $this->M_common->querylist($sql_category);
		$ids = '' ;
		if($list){
				foreach($list as $k=>$v){
				$list[$k]['status'] = ($v['status'] == 1 )?"开启":'<font color="red">关闭</font>';
					$ids.=$v['id'].",";
				}
				$ids = rtrim($ids,",") ;
				$sql_count_child_article = "SELECT COUNT(*) AS num FROM {$this->table_}news WHERE typeid in ($ids) ";
				$list_count = $this->M_common->querylist($sql_count_child_article);
				$temp = array();
				
				foreach($list AS $k1 => $v1 ){
					$num = "&nbsp;&nbsp;【<a href='javascript:void(0)' onclick='jump_news(\"{$v1['id']}\")'><font color='red'>".(isset($temp[$v1['id']])?$temp[$v1['id']]:'0') ."</font></a>】";
					$list[$k1]['num'] = $num;
				}
				$list = tree_format($list,0,0,"---------");
		}	
		return array('list'=>$list , 'page_string'=>$page_string);	
	}
	
	//插入新闻类别
	public function insertNewType($params = array() ){
		if($params['typename'] == "" ){
			return array('status'=>false  , 'message'=>'类别名称不能为空' );
		}
		$array = $this->insert_one("{$this->table_}newstype",$params);
		if($array['affect_num']>=1){
			write_action_log($array['sql'],$this->uri->uri_string(),login_name(),get_client_ip(),1,"添加类别为{$params['typename']}成功");
			return array('status'=>true  , 'message'=>'success' );
		}else{
			write_action_log($array['sql'],$this->uri->uri_string(),login_name(),get_client_ip(),0,"添加类别为{$params['typename']}失败");
			return array('status'=>false  , 'message'=>'服务器繁忙' );
		}
	}
	//编辑新闻类别
	public function editNewsType($params , $id ){
		if($params['typename'] == "" ){
			return array('status'=>false  , 'message'=>'类别名称不能为空' );
		}
		$this->db->update("{$this->table_}newstype", $params, array('id' => $id));
		$sql_edit = $this->db->last_query();
		$num = $this->db->affected_rows() ; 
		if($num >= 1 ){
			write_action_log($sql_edit,$this->uri->uri_string(),login_name(),get_client_ip(),1,"修改类别名称为{$params['typename']}成功");
			return array('status'=>true  , 'message'=>'success' );
		}else{
			write_action_log($sql_edit,$this->uri->uri_string(),login_name(),get_client_ip(),0,"修改类别名称为{$params['typename']}失败");
			return array('status'=>false  , 'message'=>'服务器繁忙' );
		}
	}
	//根据新闻的类别ID查询类别名称
	public function getTypeName($id){
		$sql = "select typename from {$this->table_}newstype where id = '{$id}' limit 1 " ;
		$info = $this->query_one($sql);
		return $info['typename'];
	}
	//根据新闻的类别ID 返回数据
	public function getNewsTypeData($id){
		$sql = "select * from {$this->table_}newstype where id = '{$id}' limit 1 " ;
		$info = $this->query_one($sql);
		return $info;
	}
	//获取新闻咨询列表
	public function queryNewsList($page , $per_page = 100  , $where ){
		$getwhere = ' where 1 = 1 ' ;
		if(in_array($where['status'] , array('1' ,'0' ))){
			$getwhere.=" AND a.status = '{$where['status']}' " ;
		}
		if(isset($where['title']) && $where['title']){
			$title = $this->db->escape_str($where['title']) ;
			$getwhere.=" AND a.title like  '%{$title}%' " ;
		}
		if(isset($where['typeid']) && $where['typeid'] > 0 ){
			$getwhere.=" AND a.typeid = '{$where['typeid']}' " ;
		}
		if(isset($where['flag']) && $where['flag'] ){
			$getwhere.=" AND a.flag like  '%{$where['flag']}%' " ;
		}
		$this->load->library("common_page");
		if($page <=0 ){
			$page = 1 ;
		}
		$limit = ($page-1)*$per_page;
		$limit.=",{$per_page}";
		
		$sql_count = "SELECT COUNT(*) AS tt FROM {$this->table_}news as a left join {$this->table_}newstype as b on a.typeid = b.id {$getwhere} ";
		$total  = $this->query_count($sql_count);
		$page_string = $this->common_page->page_string($total, $per_page, $page);
		$sql= "SELECT a.* , b.typename  FROM {$this->table_}news as a  left join {$this->table_}newstype as b on a.typeid = b.id {$getwhere} order by a.create_date desc limit  {$limit}";
		$list = $this->M_common->querylist($sql);
		$ids = '' ;
		if($list){
			foreach($list as $k=>$v){
				$list[$k]['introduce'] = msubstr($v['introduce'],0,20,abslength($v['introduce']));
				$list[$k]['create_date'] = isset($v['create_date'])?date("Y-m-d H:i",$v['create_date']):'' ; 
				$list[$k]['modify_date'] = isset($v['modify_date'])?date("Y-m-d H:i",$v['modify_date']):'' ; 
				$flag = $v['flag'];
				$str = '' ;
				$str = $this->news_attr($flag);
				$str="&nbsp;&nbsp;".$str;
				$list[$k]['title'] = msubstr($v['title'],0,16,abslength($v['title']));	
				$list[$k]['flag'] = $str;	
				$pic_path = __UPLOAD_URL__."/news/{$v['image']}" ; 
				$list[$k]['image'] = "<img src='{$pic_path}' width='80px' height='80px'>" ;
				
			}
		}
		return array('list'=>$list , 'page_string'=>$page_string);
	}
	//根据新闻的标记获取新闻属性
	public function news_attr($flag){
		$str = '' ;
		$flag_array = array();
		if($flag){
			$flag_array  = explode(",", $flag) ;
			for($kk = 0 ; $kk<count($flag_array);$kk++){
				$str.=isset($this->news_attr[$flag_array[$kk]])?"<font color='red'>".$this->news_attr[$flag_array[$kk]]."</font>,":'' ;
			}
			$str = rtrim($str,",");
		}
		return $str ;
	}
	//插入新闻
	function insertNews($params = array() ){
		if($params['title'] == '' ){
			return array('status'=>false  , 'message'=>'标题不可以为空' );
		}elseif($params['content'] == '' ){
			return array('status'=>false  , 'message'=>'内容不可以为空' );
		}
		if(isset($_FILES['image']['name']) && $_FILES['image']['name']){
			$this->load->library("common_upload");
			$time = date("Ymd" , time());
			$re = $this->common_upload->upload_path($this->thum_upload_path."/{$time}");
			if(!$re['status'] ||$re['status'] != true  ){
				return array('status'=>false  , 'message'=>$re['message']  );
			}
			$params['image'] = $time."/".$re['pic'];
		}
		$array = $this->insert_one("{$this->table_}news",$params);
		if($array['affect_num']>=1){
			write_action_log($array['sql'],$this->uri->uri_string(),login_name(),get_client_ip(),1,"添加名称为{$params['title']}成功");
			return array('status'=>true  , 'message'=>'success' );
		}else{
			write_action_log($array['sql'],$this->uri->uri_string(),login_name(),get_client_ip(),0,"添加名称为{$params['title']}失败");
			return array('status'=>false  , 'message'=>'服务器繁忙' );
		}
	}
	//修改单个数据 根据传递过来的参数处理
	public function edit_news_by_params($params = array()){
		if(empty($params['field'])){
			return array('status'=>false , 'message'=>'参数错误' ) ;
		}
		$value = $this->db->escape_str($params['value']) ;
		$field = $this->db->escape_str($params['field']) ;
		$time = time() ;
		$sql_edit = "UPDATE {$this->table_}news SET `{$field}` = '{$value}'    where id = '{$params['id']}'";
	
		$num = $this->update_data($sql_edit);
		if($num>=1){
			write_action_log($sql_edit,$this->uri->uri_string(),$this->visitor['username'],get_client_ip(),1,"修改字段{$field}，为 {$value}成功");
			return array('status'=>true , 'message'=>'success') ;
		}else{
			write_action_log($sql_edit,$this->uri->uri_string(),$this->visitor['username'],get_client_ip(),0,"修改字段{$field}，为 {$value}失败");
			return array('status'=>false , 'message'=>'服务器繁忙请稍后' ) ;
		}
	}
	
	//编辑咨询
	public function edit_news($params , $id ){
		if($params['title'] == '' ){
			return array('status'=>false  , 'message'=>'标题不可以为空' );
		}elseif($params['content'] == '' ){
			return array('status'=>false  , 'message'=>'内容不可以为空' );
		}
		$info_ = $this->getNewsById($id);
		if(empty($info_)){
			return array('status'=>false  , 'message'=>'参数错误' );
		}
		
		if(isset($_FILES['image']['name']) && $_FILES['image']['name']){
			$this->load->library("common_upload");
			$time = date("Ymd" , time());
			$re = $this->common_upload->upload_path($this->thum_upload_path."/{$time}");
			if(!$re['status'] ||$re['status'] != true  ){
				return array('status'=>false  , 'message'=>$re['message']  );
			}
			if(file_exists($this->thum_upload_path."/{$info_['image']}") ){
				@unlink($this->thum_upload_path."/{$info_['image']}");
			}
			$params['image'] = $time."/".$re['pic'];
		}
		$this->db->update("{$this->table_}news", $params, array('id' => $id));
		$sql_edit = $this->db->last_query();
		$num = $this->db->affected_rows() ;
		if($num >= 1 ){
			
			write_action_log($sql_edit,$this->uri->uri_string(),$this->visitor['username'],get_client_ip(),1,"修改咨询{$params['title']}成功");
			return array('status'=>true , 'message'=>'success') ;
		}else{
			write_action_log($sql_edit,$this->uri->uri_string(),$this->visitor['username'],get_client_ip(),0,"修改咨询{$params['title']}失败");
			return array('status'=>true , 'message'=>'服务器繁忙你可能没有修改数据') ;
		}
	}
	
	//删除咨询
	public function del_news($id){
		$info_ = $this->getNewsById($id);
		if(empty($info_)){
			return array('status'=>false  , 'message'=>'参数错误' );
		}
		$sql_del = "DELETE FROM `{$this->table_}news` WHERE id in ($id) " ;
		$num = $this->del_data($sql_del);
		if($num >= 1 ){
			if(file_exists($this->thum_upload_path."/{$info_['image']}") ){
				@unlink($this->thum_upload_path."/{$info_['image']}");
			}
			write_action_log($sql_del,$this->uri->uri_string(),$this->visitor['username'],get_client_ip(),1,"删除咨询id为{$id},标题是{$info_['title']}成功");	
			return array('status'=>true , 'message'=>'success') ;
		}else{
			write_action_log($sql_del,$this->uri->uri_string(),$this->visitor['username'],get_client_ip(),0,"删除咨询id为{$id},标题是{$info_['title']}失败");
			return array('status'=>false , 'message'=>'服务器繁忙你可能没有修改数据') ;
		}
	}
	
	
	//根据文章的Id 获取数据
	public function getNewsById($id){
		$sql = "select a.* from {$this->table_}news as a  where a.id = '{$id}' limit 1 ";
		$info = $this->query_one($sql);
		return $info ;
	}
	//根据文章的类型获取类型名称
	function getTypeNameById($id){
		$sql = "select typename from {$this->table_}newstype where id = '{$id}' limit 1 ";
		$info = $this->query_one($sql);
		return isset($info['typename'])?$info['typename']:'';
	}
	
	
	

}