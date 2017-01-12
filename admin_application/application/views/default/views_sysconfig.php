<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo isset($this->site_config['web_site_name'])?$this->site_config['web_site_name']:'';?></title>
<link href="<?php echo _CSSPATH_ ; ?>style.css" rel="stylesheet" type="text/css" />
<link href="<?php echo _CSSPATH_ ; ?>select.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo _JSPATH_  ; ?>jquery.js"></script>
<script src="<?php echo _JSPATH_ ; ?>layer/lib.js"></script>
<script type="text/javascript" src="<?php echo _JSPATH_ ; ?>layer/layer.min.js"></script>  
<script type="text/javascript" src="<?php echo _JSPATH_  ; ?>jquery.idTabs.min.js"></script>
<script type="text/javascript" src="<?php echo _JSPATH_  ; ?>select-ui.min.js"></script>

<script type="text/javascript">
$(document).ready(function(e) {
    $(".select1").uedSelect({
		width : 345			  
	});
	$(".select2").uedSelect({
		width : 167  
	});
	$(".select3").uedSelect({
		width : 100
	});
});
</script>
</head>

<body>

	<div class="place">
    <span>位置：</span>
    <ul class="placeul">
    <li><a href="#">首页</a></li>
    <li><a href="#">系统设置</a></li>
    </ul>
    </div>
    <div class="tips">
    <span><img src="<?php echo _IMGPATH_ ; ?>tip.png" alt="友情提示" /></span>
    <b><?php echo $this->visitor['username'];?>你好，欢迎使用<?php echo isset($this->site_config['web_site_name'])?$this->site_config['web_site_name']:'' ; ?></b> ,下面的导航如果你要添加请在配置文件||<?php echo __ROOT__.APPPATH."/config/admin.config.php里面进行添加" ; ?></b> 
    
    </div>
    <div class="formbody">
    
    
    <div id="usual1" class="usual"> 
    
    <div class="itab">
  	<ul> 
  		<?php 
  			if(isset($group) && $group){
  				foreach($group as $gkey => $gval){	
  			
  		?>
	    <li><a href="#tab<?php echo $gkey  ; ?>" <?php if($gid == $gkey){echo "class='selected'";}?> ><?php echo $gval ;?></a></li> 
	    
	    <?php }}?>
	    <li>
			<a <?php if($gid == 1000){echo "class='selected'";}?> href="#tab1000" >添加环境变量</a>
		</li>
  	</ul>
    </div> 
     <?php 
    	if(isset($list) && $list){
    		foreach ($list as $list_key => $list_val){
    	
     ?>
  	<div id="tab<?php echo $list_key;?>" class="tabson">
    <form action="<?php echo site_url("sysconfig/edit")?>?gid=<?php echo  $list_key ;  ?>" method="post">
    <div class="formtext">Hi，<b><?php echo $this->visitor['username'];?></b>，欢迎您试用站点设置功能！</div>
    
    <ul class="forminfo">
   <?php 
   		if(isset($list_val) && $list_val){
   			foreach($list_val as $child_key => $child_val){
   		
   ?>
    <li><label style="width:142px"><?php echo $child_val['info'];?><b>*</b></label><?php echo $child_val['text'];?></li>
	<?php 
		}
	}	
	?>
    <li><label>&nbsp;</label><input name="" type="submit" class="btn" value="修改数据<?php echo $list_key ;?>"/></li>
    </ul>
    </form>
    </div> 
	<?php } }?>
    
   	<div id="tab1000" class="tabson">
    <form action="<?php echo site_url("sysconfig/add")?>" method="post">
    <div class="formtext">Hi，<b>wangjian</b>，欢迎您试用站点设置功能！</div>
    
    <ul class="forminfo">
       <li><label style="width:142px">变量组<b>*</b></label>
        <div class="usercity">
       	<select name="gid" class="select2">
       	<?php 
       
  			if(isset($group) && $group){
  				foreach($group as $gkey_ => $gval_){	
  			
  		?>
  		<option value="<?php echo $gkey_ ;?>"><?php echo $gval_ ;?></option>
  		<?php 
  			}
  		}	
  		?>
       	</select>
       	</div>
       </li>
       <li><label style="width:142px">变量类型<b>*</b></label>
        <div class="usercity">
       	<select name="type" class="select2">
       	<?php 
       
  			if(isset($type) && $type){
  				foreach($type as $typekey_ => $typeval_){	
  			
  		?>
  		<option value="<?php echo $typekey_;?>"><?php echo $typeval_ ;?></option>
  		<?php 
  			}
  		}	
  		?>
       	</select>
       	</div>
       </li>
	    <li><label style="width:142px">变量名称<b>*</b></label><input type='text' class="dfinput" name='varname' > 必须是英文</li>
		<li><label style="width:142px">变量值：<b>*</b></label><input type='text' class="dfinput" name='value' >如果变量类型是boolean值，此处必须填写 N或者Y</li>
	
	    <li><label style="width:142px">变量说明<b>*</b></label><input type='text' class="dfinput" name='info' ></li>
	    <li><label style="width:142px">排序<b>*</b></label><input type='text' class="dfinput" name='disorder' value="0" ></li>
	    <li><label>&nbsp;</label><input name="" type="submit" class="btn" value="添加环境变量"/></li>
    </ul>
    </form>
    </div> 
    
  	 
       
	</div> 
 
	<script type="text/javascript"> 
      $("#usual1 ul").idTabs(); 
    </script>
    
    <script type="text/javascript">
	$('.tablelist tbody tr:odd').addClass('odd');
	</script>

    </div>


</body>

</html>
<script>
	function del_var(url , varname){
		$.layer({
		    shade: [1],
		    area: ['240px','auto'],
		    dialog: {
		        msg: '确定删除系统环境变量是:'+varname+",此操作不可恢复！",
		        btns: 2,                    
		        type: 4,
		        btn: ['确定','取消'],
		        yes: function(){
		        	window.location.href=url ; 
		            //layer.msg('重要', 1, 1);
		        }, no: function(){
		            
		        }
		    }
		});
	}
</script>
