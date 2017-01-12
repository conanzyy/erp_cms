<?php 
if (! defined('BASEPATH')) {
	exit('Access Denied');
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>欢迎登录后台管理系统</title>
<link href="<?php echo _CSSPATH_ ;?>style.css" rel="stylesheet" type="text/css" />
<script language="JavaScript" src="<?php echo  _JSPATH_ ;?>jquery.js"></script>
<script src="<?php echo _JSPATH_ ; ?>/cloud.js" type="text/javascript"></script>

<script language="javascript">

$(function(){
	
	$('.loginbox').css({'position':'absolute','left':($(window).width()-692)/2});
	$(window).resize(function(){  
		$('.loginbox').css({'position':'absolute','left':($(window).width()-692)/2});
    })  
});  
</script> 

</head>

<body style="background-color:#1c77ac; background-image:url(<?php echo  _IMGPATH_ ;?>light.png); background-repeat:no-repeat; background-position:center top; overflow:hidden;">



    <div id="mainBody">
      <div id="cloud1" class="cloud"></div>
      <div id="cloud2" class="cloud"></div>
    </div>  


<div class="logintop">    
    <span>欢迎登录后台管理界面平台</span>    
    <ul style="display:none">
    <li><a href="#">回首页</a></li>
    <li><a href="#">帮助</a></li>
    <li><a href="#">关于</a></li>
    </ul>    
    </div>
    
    <div class="loginbody">
    	 <form action="<?php echo site_url("login/dologin") ; ?>" method="post">
    <span class="systemlogo"></span> 
       
    <div class="loginbox">
    
    <ul>
    <li><input name="username" type="text" class="loginuser" value="" /></li>
    <li><input name="passwd" type="password" class="loginpwd" value="" /></li>
   
    <li><input name="" type="submit" class="loginbtn" value="登录"   /></li>
    </ul>
    
    
    </div>
    </form>
    </div>
    
    
    
    <div class="loginbm">版权所有  2014 - 12 - 25  <a href="http://www.57sy.com">57sy.com</a>  仅供学习交流，勿用于任何商业用途</div>
	
    
</body>

</html>
