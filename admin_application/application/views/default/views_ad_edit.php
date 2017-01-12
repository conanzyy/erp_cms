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
<script type="text/javascript" src="<?php echo _JSPATH_  ; ?>DatePicker/WdatePicker.js"></script>

<script type="text/javascript">
var loadding_0 ;
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
    <li><a href="<?php echo site_url("ad/index") ; ?>">广告管理</a></li>
    </ul>
    </div>
    
    <div class="formbody">
    
    
    <div id="usual1" class="usual"> 
    
   

    
   	<div id="tab1000" class="tabson">
   <?php echo form_open_multipart('ad/edit');?>
   
    <div class="formtext">Hi，<b><?php echo $this->visitor['username']  ; ?></b>，欢迎您使用编辑广告功能！</div>
   
		<input type="hidden" value="doedit" name="action">
		<input type="hidden" value="<?php echo $info['id'] ; ?>" name="id">
    <ul class="forminfo">
    <li><label style="width:142px">广告名称<b>*</b></label><input type='text' class="dfinput" name='name' value="<?php echo $info['name']  ; ?>"></li>
       <li><label style="width:142px">广告位置<b>*</b></label>
        <div class="usercity">
       	<select name="ad_type" class="select2" id="ad_type">
       	<?php 
       
  			if(isset($ad_type) && $ad_type){
  				foreach($ad_type as $gkey_ => $gval_){	
  			
  		?>
  		<option value="<?php echo $gval_['id'] ;?>" <?php if($info['ad_type'] == $gval_['id'] ){echo "selected";}?> ><?php echo $gval_['typename'] ;?></option>
  		<?php 
  			}
  		}	
  		?>
       	</select>
       	</div>
       </li>
       <li><label style="width:142px">广告类型<b>*</b></label>
        <div class="usercity">
      
       	
  		<select name="type"  class="select2" onchange="_ad()" id="type">
  		<option value="0" <?php if($info['type'] == 0 ){echo "selected";}?>>图片广告</option>
		<option value="1" <?php if($info['type'] == 1 ){echo "selected";}?>>文字广告</option>
  		
       	</select>
       	</div>
       </li>
	    <div id="t_0" class="pp" <?php if($info['type'] == 1 ){echo "style='display:none'";}?>>
		<li><label style="width:142px ;">图片1：</label><input type='file' readonly class="dfinput" name='pic' >
			<img src="<?php echo _UPLOAD_PATH_. "ad/".$info['pic'];?>" width="100" height="40">
		</li>
		<li><label style="width:142px ;">图片2：</label><input type='file' readonly class="dfinput" name='pic2' >
		<img src="<?php echo _UPLOAD_PATH_. "ad/".$info['pic2'];?>" width="100" height="40">
		<i>附加图片，备用</i>	
		</li>
	    <li><label style="width:142px">图片描述<b>*</b></label><input type='text' class="dfinput" name='pic_des' value="<?php echo $info['pic_des'] ; ?>" ></li>
	    <li><label style="width:142px">广告链接地址<b>*</b></label><input type='text' class="dfinput" name='pic_url' value="<?php echo $info['pic_url'] ; ?>">
	    <i>请输入http://www.57sy.com 这样的地址</i>
	    </li>
	    </div>
	    <div id="t_1" class="pp" <?php if($info['type'] == 0 ){echo "style='display:none'";}?>>
	    <li><label style="width:142px">文字描述<b>*</b></label><input type='text' class="dfinput" name='words' value="<?php echo $info['words'] ; ?>"></li>
	    </div>
	    <li><label style="width:142px">属性1</label><input type='text' class="dfinput" name='attr_1' value="<?php echo $info['attr_1'] ; ?>"><i>请填写广告的属性1</i></li>
    	<li><label style="width:142px">属性2</label><input type='text' class="dfinput" name='attr_2' value="<?php echo $info['attr_2'] ; ?>"><i>请填写广告的属性2</i></li>
    	<li><label style="width:142px">开始日期</label><input type='text' class="dfinput" name='begin_date' onFocus="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss'})" value="<?php echo ($info['begin_date'] > 0 )?date("Y-m-d H:i:s" , $info['begin_date']):'';?>"><i>如果不选表示永不过期</i></li>
        <li><label style="width:142px">结束日期</label><input type='text' class="dfinput" name='end_date' onFocus="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss'})" value="<?php echo ($info['end_date'] > 0 )?date("Y-m-d H:i:s" , $info['end_date']):'';?>"><i>如果不选表示永不过期</i></li>
        <li><label style="width:142px">状态</label>
        <input type='hidden' class="dfinput" name='status' value="<?php echo $info['status'] ;?>" />
        <?php 
        	if($info['status'] == 1 ){
        	
        ?>
       	<span class="onoff"><label style="width:44px" title="开启" class="cb-enable selected" for="1"><span>开启</span></label>
        <label  style="width:44px" title="关闭" class="cb-disable" for="0"><span>关闭</span></label>
        <?php }else{?>
      	<span class="onoff"><label style="width:44px" title="开启" class="cb-enable " for="1"><span>开启</span></label>
        <label  style="width:44px" title="关闭" class="cb-disable selected" for="0"><span>关闭</span></label>
        <?php }?>
        
  	 </span>
        </li>
    
    <li><label>&nbsp;</label><input name="" type="submit" class="btn" value="修改广告"/></li>
    </ul>
    </form>
    </div> 
    
  	 
       
	</div> 
 

    


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
	function _ad(){
		$(".pp").hide() ; 
		$("#t_"+$("#type").val()).show() ; 
	}
</script>
