<?php 
if (! defined('BASEPATH')) {
	exit('Access Denied');
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>头部</title>
<link href="<?php echo  _CSSPATH_ ;?>style.css" rel="stylesheet" type="text/css" />
<script language="JavaScript" src="<?php echo  _JSPATH_ ;?>jquery.js"></script>
<script src="<?php echo _JSPATH_ ; ?>layer/lib.js"></script>
<script type="text/javascript" src="<?php echo _JSPATH_ ; ?>layer/layer.min.js"></script>
<script type="text/javascript">
$(function(){	
	//顶部导航切换
	$(".nav li a").click(function(){
		$(".nav li a.selected").removeClass("selected")
		$(this).addClass("selected");
	})	
})	
</script>


</head>

<body style="background:url(<?php echo _IMGPATH_ ; ?>topbg.gif) repeat-x;">

    <div class="topleft">
    <a href="main.html" target="_parent"><img src="<?php echo _IMGPATH_ ; ?>logo.png" title="系统首页" /></a>
    </div>
        
    <ul class="nav">
    <?php 
    	if(isset($nav) && $nav ){
    		foreach($nav as $nav_key => $nav_val) {
				
    ?>
    <li><a href="javascript:void(0)" onclick="switch_left(<?php echo $nav_val['id'] ; ?>)"  class="<?php if($nav_key == 0 ){echo "selected";}?>"><img src="<?php echo _IMGPATH_ ; ?>icon01.png" title="工作台" /><h2><?php echo $nav_val['name'];?></h2></a></li>
    <?php } } ?>
   
    </ul>
            
    <div class="topright">    
    <ul>
    <li><span><img src="<?php echo _IMGPATH_ ; ?>help.png" title="帮助"  class="helpimg"/></span><a href="#">帮助</a></li>
    <li><a href="<?php echo site_url("sys_admin/edit_passwd");?>" target="rightFrame">密码修改</a></li>
    <li><a href="<?php echo site_url('login/login_out');?>" target="_parent">退出</a></li>
    </ul>
     
    <div class="user">
    <span><?php echo isset($this->visitor['username'])?$this->visitor['username']:'';?></span>
    <i>消息</i>
    <b>5</b>
    </div>    
    
    </div>

</body>
</html>
<script>
function switch_left(id){
	parent.window.frames["leftFrame"].$(".leftmenu").hide();
	parent.window.frames["leftFrame"].$("#menu_"+id).show() ; 
	//alert(parent.window.frames["leftFrame"].$("#menu_1").html());
	//alert(window.frames["leftFrame"].document.getElementById("menu_1").innerHTML);  
}

</script>
