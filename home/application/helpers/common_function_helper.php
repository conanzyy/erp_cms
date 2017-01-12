<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
include __ROOT__."/share/helpers/common_function.php" ;  //包含公用的方法 前台和后台公用
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
?>