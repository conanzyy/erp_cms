<?php

//网站的基本信息配置[主要是前台和后台公用的配置文件]
/*
| 文档的自定义属性
*/
$config['content_att'] = array(
	'h'=>'图条',
	'c'=>'推荐',
	'f'=>'幻灯',
	'a'=>'特荐',
	'p'=>'图片'
);

/*
|--------------------------------------------------------------------------
|--------------------------------------------------------------------------
| 系统环境的基本信息路径
|
*/
$config['sysconfig_cache'] = __ROOT__."/data/cache/sysconfig/" ; //备注要确保文件夹sysconfig存在

/*
 | 广告缓存路径
|
*/
$config['ad_cache'] = __ROOT__."/data/cache/ad/" ; //备注要确保文件夹ad存在

/*
| 开发者的邮箱地址
*/
$config['web_admin_email'] = "wangjian@phpspeak.com" ;


/*
| 产品图片本地路径
| 
*/
$config['product_path'] = __ROOT__."/data/upload/product/" ; ; //

/*
| 产品图片访问路径
| 
*/
$config['v_product_path'] = "/data/upload/product/" ; ; //

/*
| 广告图片本地路径
| 
*/
$config['ad_path'] = __ROOT__."/data/upload/ad/" ; ; //

/*
| 广告图片访问路径
| 
*/
$config['v_ad_path'] = "/data/upload/ad/" ; ; //

/*
| 文章图片本地路径
| 
*/
$config['news_path'] = __ROOT__."/data/upload/news/" ; ; //

/*
| 文章图片访问路径
| 
*/
$config['v_news_path'] = "/data/upload/news/" ; ; //


/*
| 验证码图片保存的路径
*/
$config['yzm_path'] = __ROOT__.'/data/captcha/' ; 
/*
| 联动模型的 缓存路径
| 
*/
$config['category_model_cache'] = __ROOT__."/data/cache/category/" ; ; //

/*
| 联动模型数据 缓存路径
| 
*/
$config['category_modeldata_cache'] = __ROOT__."/data/cache/category/" ; ; //