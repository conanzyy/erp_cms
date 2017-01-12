<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
include __ROOT__."/share/helpers/common_function.php" ;  //包含公用的方法 前台和后台公用
/*
 * 后台常见的方法
 * author 王建
 * time 2014_01_20
 * 
 */
//获取登录的用户名
if( !function_exists("login_name")){
	function login_name(){
		$data = decode_data();
		if(isset($data['username'])){
			return $data['username'];
		}else{
			return '' ;
		}
		
	}
}

//获取登录的用户所在的群组
if(!function_exists("group_name")){
	function group_name(){
		$data = decode_data();
		if(isset($data['group_name'])){
			return $data['group_name'];
		}else{
			return '' ;
		}		
	}	
}
//获取登录的用户所在的角色ID 
if(!function_exists("role_id")){
	function role_id(){
		$data = decode_data();
		if(isset($data['role_id'])){
			return $data['role_id'];
		}else{
			return '' ;
		}		
	}	
}

//获取登录的用户的uid
if(!function_exists("admin_id")){
	function admin_id(){
		$data = decode_data();
		if(isset($data['admin_id'])){
			return $data['admin_id'];
		}else{
			return '' ;
		}		
	}	
}

//判断当前登录的用户是不是超级管理员
if(!function_exists("is_super_admin")){
	function is_super_admin(){
		$data = decode_data();
		if(isset($data['isadmin']) && $data['isadmin']){
			return true ;
		}else{
			return false  ;
		}		
	}	
}

/*
 *@记录系统操作日志文件到数据库里面 
 **sql 是要插入数据库中的 log_sql的值 
 *$action 动作
 *$person 操作人
 *$ip ip地址
 *status 操作是否成功 1成功 0失败
 *message 失败信息
 *groupname_ 定义数据库连接信息的时候的 groupname
 */
if(!function_exists("write_action_log") ){
	function write_action_log($sql,$url = '' ,$person = '' ,$ip = '',$status = '1' ,$message = '' , $groupname_ = "real_data"){
		if(!config_item('is_write_log_to_database')){//是否记录日志文件到数据表中
			return false ;
		}
		
		//$sql = str_replace("\\", "", $sql); // 把\进行过滤掉
		//$sql = str_replace("%", "\%", $sql); // 把 '%'前面加上\
		//$sql = str_replace("'", "\'", $sql); // 把 ''过滤掉
		//$db = $this->load->database($groupname_,true);
	//	$message = daddslashes($message ) ;
		$time = date("Y-m-d H:i:s",time());
		$time_table = date("Ym",time());
		$table_pre = table_pre($groupname_) ;
		
	$sql_table = <<<EOT
CREATE TABLE IF NOT EXISTS `{$table_pre}common_log_{$time_table}` (
  `log_id` mediumint(8) NOT NULL auto_increment,
  `log_url` varchar(50) NOT NULL,
  `log_person` varchar(16) NOT NULL,
  `log_time` datetime NOT NULL,
  `log_ip` char(15) NOT NULL,
  `log_sql` text NOT NULL,
  `log_status` tinyint(1) NOT NULL default '1',
  `log_message` text NOT NULL,
  PRIMARY KEY  (`log_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;		
EOT;
		$ci = &get_instance(); //初始化 为了用方法
		$d = $ci->load->database($groupname_,true);
		$d->query($sql_table);
		$insert_data = array(
			'log_url'=>$url , 
			'log_person'=>$person ,
			'log_time'=>$time , 
			'log_ip'=>$ip , 
			'log_sql'=>$sql ,
			'log_status'=>$status ,
			'log_message'=>$message
		) ;
		$d->insert("{$table_pre}common_log_{$time_table}" , $insert_data) ;
		
		
	}
}



/**
 * 将数据格式化成树形结构
 * @author 王建
 * @param array $items
 * @return array
 */
if(!function_exists("genTree9")){
	function genTree9($items,$id = 'id' ,$pid = 'pid' ,$child = 'children' ) {
	    $tree = array(); //格式化好的树
	    foreach ($items as $item)
	        if (isset($items[$item[$pid]]))
	            $items[$item[$pid]][$child][] = &$items[$item[$id]];
	        else
	            $tree[] = &$items[$item[$id]];
	    return $tree;
	}	
}
/**
 * 格式化select
 * @author 王建
 * @param array $parent
 * @deep int 层级关系 
 * @return array
 */
function getChildren($parent,$deep=0) {
		foreach($parent as $row) {
			$data[] = array("id"=>$row['id'], "name"=>$row['name'],"pid"=>$row['parentid'],'deep'=>$deep,'url'=>$row['url']);
			if (isset($row['childs']) && !empty($row['childs'])) {
				$data = array_merge($data, getChildren($row['childs'], $deep+1));
			}
		}
		return $data;
}

/**
 * 格式化select,生成options
 * @author 王建
 * @param array $parent
 * @deep int 层级关系 
 * @return array
 */
function getChildren2($parent,$deep=0,$id = 'id' , $pid = 'pid' ,$name = 'typename',$children = 'children') {
	foreach($parent as $row) {
		$data[] = array("id"=>$row[$id], "name"=>$row[$name],"pid"=>$row[$pid],'deep'=>$deep);
		if (isset($row[$children]) && !empty($row[$children])) {
			$data = array_merge($data, getChildren2($row[$children], $deep+1,$id,$pid,$name,$children));
		}
	}
	return $data;
}
/**
 * 格式化数组，
 * @author 王建
 * @param array $list
 * @return array
 */	
function tree_format(&$list,$pid=0,$level=0,$html='--',$pid_string = 'pid' ,$id_string = 'id'){
		static $tree = array();		
		foreach($list as $v){
			if($v[$pid_string] == $pid){
				$v['sort'] = $level;
				$v['html'] = str_repeat($html,$level);
				$tree[] = $v;
				tree_format($list,$v[$id_string],$level+1,$html);
			} 
		}
		return $tree;
} 
/**
 * 显示页面
 * @author 王建
 * @param string $message 错误信息
 * @param string $url 页面跳转地址
 * @param string $timeout 时间
 * @param string $iserror 是否错误 1正确 0错误
 * @param string $params 其他参数前面加? 例如?id=122&time=333
 */
if ( ! function_exists('showmessage')){
	//跳转
	
	function showmessage($message='',$url='',$timeout='3',$iserror = 1,$params = '' ){
		if($iserror == 1 ){//正确
			include APPPATH.'/errors/showmessage.php';
		}else{
			include APPPATH.'/errors/showmessage_error.php';
		}
		
		die();
	}	
}
/**
 * 获取后台登陆的数据，其中参数主要是为了 ，有时候用插件上传图片的时候 登陆状态消失
 * @author 王建
 * @param $string 解密的值
 * @return array
 */	
if(!function_exists("decode_data")){
	function decode_data($string = '' ){
		$data = array() ; 
		$encode_string = '' ; 
		$encode_string = ($string != "" )?$string:(isset($_COOKIE['admin_auth'])?$_COOKIE['admin_auth']:'') ; 
		
		//$encode_string = isset($_COOKIE['admin_auth'])?$_COOKIE['admin_auth']:'' ;
		if(empty($encode_string)){
			return $data ; 
		}
		$encode_string = auth_code($encode_string,"DECODE",config_item("s_key"));
		$data = unserialize($encode_string) ; 
		return $data ; 
	}
}
/**
 * 获取ids数据
 * @author 王建
 * @param $array array(1,3,4,5,6,7)
 * @return String 1,3,4,5,6,7
 */	
 if(!function_exists("get_ids")){
	 function get_ids($ids = '' ){
			if($ids){			
				$id = '' ; 
				for($i = 0 ; $i<count($ids) ; $i++){
					if(intval($ids[$i])<=0){continue ; }
					$id.=intval($ids[$i])."," ; 
				}
				$id = rtrim($id,",") ; 
				return $id ; 			
			}else{
				return '' ; 
			}	
		}	
 }
?>