<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
|--------------------------------------------------------------------------
| 后台cookie的周期
| 默认1个小时的时间
|
*/
$config['cookie_expire'] =  60*60 ; //

/*
|--------------------------------------------------------------------------
|--------------------------------------------------------------------------
| 后台cookie的路径
| 
|
*/
$config['cookie_path'] = "/" ; //

/*
|--------------------------------------------------------------------------
|--------------------------------------------------------------------------
| 后台cookie的域
| 
|
*/
$config['cookie_domain'] = "" ; //

/*
|--------------------------------------------------------------------------
|--------------------------------------------------------------------------
| 后台加密的key
| 
|
*/
$config['s_key'] = "phpspeak_" ; //

/*
|--------------------------------------------------------------------------
|--------------------------------------------------------------------------
| 角色缓存文件的路径
|
*/
$config['role_cache'] =APPPATH."/cache/role_cache/" ; //备注要确保role_cache文件夹存在
/*
|--------------------------------------------------------------------------
|--------------------------------------------------------------------------
| 后台导航文件路径
|
*/
$config['nav_cache'] = APPPATH."/cache/nav_cache/" ; //备注要确保role_cache文件夹存在
/*
| 没有权限的时候返回的一个code值 写小于0的值
*/
$config['no_permition'] = -8 ;


/*
| 网站基本信息组
*/
$config['web_group'] =array(
		1=>'站点设置',
		2=>'会员设置',
		3=>'性能设置',
);

/*
| 网站基本信息输入框类型配置
*/
$config['web_type'] =array(
	'string'=>'文本输入',
	'boolean'=>'boolean值',
	'textarea'=>'文本域',
	'number'=>'数字输入',
);
/*
| 不需要进行权限认证的控制器里面的方法（但是需要进行登录才能使用的）
| 注意每个控制器后面需要加上/
*/
$config['no_need_perm'] = array(
	'admin/index' , 
	'sys_admin/edit_passwd',
	'http://www.57sy.com' , 
	'admin/top' , 
	'admin/left' , 
	'common/ad_upload',
	'admin/main'
) ;

/*
| 是否保存日志到数据库里面
| 默认是true
*/
$config['is_write_log_to_database'] = true ; 
/*
| 是否在后台登录的时候有验证码
| 默认是true
*/
$config['yzm_open'] = true ; 



/*
| 超级管理员 ， 【这个主要是为了操作一些危险操作的】
| 
*/
$config['super_admin'] =array("wangjian") ;

/*
| 用户的字段类型 配置
| 
*/
$config['field_type'] = array(
	array('type'=>'varchar','info'=>'单行文本(varchar)'),
	array('type'=>'char','info'=>'单行文本(char)'),
	array('type'=>'int','info'=>'整数类型'),
	array('type'=>'text','info'=>'多行文本 text类型'),
	
	array('type'=>'mediumtext','info'=>'HTML文本'),
	
	array('type'=>'float','info'=>'小数类型'),
	array('type'=>'datetime','info'=>'时间类型'),
	array('type'=>'enum','info'=>'enum 类型的数据'),
);



