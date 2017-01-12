<?php 
if (! defined('BASEPATH')) {
	exit('Access Denied');
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>main页面</title>
<link href="<?php echo  _CSSPATH_ ;?>style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo _JSPATH_ ;?>jquery.js"></script>

</head>


<body>

	<div class="place">
    <span>位置：</span>
    <ul class="placeul">
    <li><a href="#">首页</a></li>
    </ul>
    </div>
    
    <div class="mainindex">
    
    
    <div class="welinfo">
    <span><img src="<?php echo _IMGPATH_ ; ?>sun.png" alt="天气" /></span>
    <b><?php echo $this->visitor['username'];?>你好，欢迎使用信息管理系统</b> 如果有任何 问题请联系：(<?php echo config_item("web_admin_email") ;?>)
    <a href="#">帐号设置</a>
    </div>
    
    <div class="welinfo">
    <span><img src="<?php echo _IMGPATH_ ; ?>time.png" alt="时间" /></span>
    <i>您上次登录的时间：<?php echo $info['logintime'];?></i> 
    </div>
    
    <div class="xline"></div>
    
    <ul class="iconlist">
    
    <li><img src="<?php echo _IMGPATH_ ; ?>ico01.png" /><p><a href="#">管理设置</a></p></li>
    <li><img src="<?php echo _IMGPATH_ ; ?>ico02.png" /><p><a href="#">发布文章</a></p></li>
    <li><img src="<?php echo _IMGPATH_ ; ?>ico03.png" /><p><a href="#">数据统计</a></p></li>
    <li><img src="<?php echo _IMGPATH_ ; ?>ico04.png" /><p><a href="#">文件上传</a></p></li>
    <li><img src="<?php echo _IMGPATH_ ; ?>ico05.png" /><p><a href="#">目录管理</a></p></li>
    <li><img src="<?php echo _IMGPATH_ ; ?>ico06.png" /><p><a href="#">查询</a></p></li> 
            
    </ul>
    
    <div class="ibox"><a class="ibtn"><img src="<?php echo _IMGPATH_ ; ?>iadd.png" />添加新的快捷功能</a></div>
    
    <div class="xline"></div>
    <div class="box"></div>
    
    <div class="welinfo">
    <span><img src="<?php echo _IMGPATH_ ; ?>dp.png" alt="提醒" /></span>
    <b>Uimaker信息管理系统使用指南</b>
    </div>
    
    <ul class="infolist">
    <li><span>您可以快速进行文章发布管理操作</span><a class="ibtn">发布或管理文章</a></li>
    <li><span>您可以快速发布产品</span><a class="ibtn">发布或管理产品</a></li>
    <li><span>您可以进行密码修改、账户设置等操作</span><a class="ibtn">账户管理</a></li>
    </ul>
    
    <div class="xline"></div>
    
    <div class="uimakerinfo"><b>查看Uimaker网站使用指南，您可以了解到多种风格的B/S后台管理界面,软件界面设计，图标设计，手机界面等相关信息</b>(<a href="http://www.uimaker.com" target="_blank">www.uimaker.com</a>)</div>
    
    <ul class="umlist">
    <li><a href="#">如何发布文章</a></li>
    <li><a href="#">如何访问网站</a></li>
    <li><a href="#">如何管理广告</a></li>
    <li><a href="#">后台用户设置(权限)</a></li>
    <li><a href="#">系统设置</a></li>
    </ul>
    
    
    </div>
    
    

</body>

</html>
