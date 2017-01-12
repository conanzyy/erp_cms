<?php 
if (! defined('BASEPATH')) {
	exit('Access Denied');
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo isset($this->site_config['web_site_name'])?$this->site_config['web_site_name']:'';?>
--网站用户修改</title>
<script type="text/javascript" src="<?php echo _JSPATH_ ; ?>jquery.js"></script>
<link href="<?php echo _CSSPATH_ ; ?>style.css" rel="stylesheet" type="text/css" />
<script src="<?php echo _JSPATH_ ; ?>layer/lib.js"></script>
<script type="text/javascript" src="<?php echo _JSPATH_ ; ?>layer/layer.min.js"></script>  
<script type="text/javascript" src="<?php echo _JSPATH_  ; ?>DatePicker/WdatePicker.js"></script>

</head>

<body>

	
    
    <div class="formbody">
    <form action="<?php echo  site_url("member/edit") ; ?>?action=doedit" method="post">
    <input type="hidden" name="id" value="<?php echo $info['uid'];?>">
    <div class="formtitle"><span>网站用户编辑</span></div>
     
    <ul class="forminfo">

    <li><label>用户名字</label><input name="username" value="<?php echo $info['username'];?>" type="text" class="dfinput" /><i class="">请输入用户名称</i></li>   
    <li><label>用户密码</label><input name="passwd"  type="text" class="dfinput" /><i class="">请输入用户密码 ， 留空表示不修改</i></li>   
    
    <li><label>过期日期</label><input type='text' value="<?php if($info['expire'] > 0 ){echo date("Y-m-d H:i:s" , $info['expire'])  ;}?>" class="dfinput" name='expire' onFocus="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss'})"><i>如果不选表示永不过期</i></li>
 
 
    <li><label >状态</label>
        <input type='hidden' class="dfinput" name='status' value="<?php echo $info['status'];?>" />
        
       	<span class="onoff">
       	<?php if($info['status'] == 1 ){?>
       	<label style="width:44px" title="开启" class="cb-enable selected" for="1"><span>开启</span></label>
        <label  style="width:44px" title="关闭" class="cb-disable" for="0"><span>关闭</span></label>
        <?php }else{ ?>
        <label style="width:44px" title="开启" class="cb-enable " for="1"><span>开启</span></label>
        <label  style="width:44px" title="关闭" class="cb-disable selected" for="0"><span>关闭</span></label>
        <?php }?>
  	 </span>
    </li>
    <li><label>&nbsp;</label><input name="" type="submit" id="btn" class="btn" value="确认保存"/></li>
    </ul>
    
    </form>
    </div>


</body>

</html>

<script>

	$(function () {   
		$("#btnSave").click(function(){		
			if($("#myform").Valid() == false || !$("#myform").Valid()) {
				return false ;
			}
		});
		$(".onoff label").each(function(){
			$(this).click(function(){
				var v = $(this).attr("for");
				$("input[name='status']").val(v);
				$(this).siblings().removeClass("selected");
				$(this).addClass("selected");
			});
		});
	});
	
</script>
