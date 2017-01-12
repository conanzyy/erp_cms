<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo isset($this->site_config['web_site_name'])?$this->site_config['web_site_name']:'';?>------咨询添加</title>
<link href="<?php echo _CSSPATH_ ; ?>style.css" rel="stylesheet" type="text/css" />
<link href="<?php echo _CSSPATH_ ; ?>select.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo _JSPATH_  ; ?>jquery.js"></script>
<script src="<?php echo _JSPATH_ ; ?>layer/lib.js"></script>
<script type="text/javascript" src="<?php echo _JSPATH_ ; ?>layer/layer.min.js"></script>  
<script type="text/javascript" src="<?php echo _JSPATH_  ; ?>select-ui.min.js"></script>
<script type="text/javascript" src="<?php echo _JSPATH_  ; ?>DatePicker/WdatePicker.js"></script>
<script type="text/javascript" src="<?php echo _JSPATH_  ; ?>kindeditor/kindeditor-all-min.js"></script>
<script type="text/javascript" src="<?php echo _JSPATH_  ; ?>kindeditor/lang/zh_CN.js"></script>
<script type="text/javascript">
var loadding_0 ;
$(document).ready(function(e) {
    $(".select1").uedSelect({
		width : 345			  
	});
	$(".select2").uedSelect({
		width : 300  
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
    <li><a href="<?php echo site_url("news/index") ; ?>">新闻咨询管理</a></li>
    </ul>
    </div>
    
    <div class="formbody">
    
    
    <div id="usual1" class="usual"> 
    
   

    
   	<div id="tab1000" class="tabson">
   <?php echo form_open_multipart('news/add');?>
    <div class="formtext">Hi，<b><?php echo $this->visitor['username']  ; ?></b>，欢迎您使用添加新闻咨询功能！</div>
   
		<input type="hidden" value="doadd" name="action">
    <ul class="forminfo">
    <li><label style="width:142px">名称<b>*</b></label><input type='text' class="dfinput" name='title' ></li>
       <li><label style="width:142px">类型<b>*</b></label>
        <div class="usercity">
       	<select name="typeid" class="select2" id="typeid" >
       	<?php 
       
  			if(isset($category) && $category){
  				foreach($category as $c_key => $c_v){	
  			
  		?>
  		<option value="<?php echo $c_v['id'] ;?>" ><?php echo $c_v['html'];?><?php echo $c_v['typename']  ; ?></option>
  		<?php 
  			}
  		}	
  		?>
       	</select>
       	</div>
       </li>
  	    <li><label style="width:142px">关键词<b>*</b></label><input type='text' class="dfinput" name='keysword' ><i>请用,号分割</i></li>
     	<li><label style="width:142px">权重<b>*</b></label><input type='text' class="dfinput" name='weight' ><i>请填写数字</i></li>
     	<li><label style="width:142px">点击数量<b>*</b></label><input type='text' class="dfinput" name='click' ><i>请填写数字</i></li>
     	<li><label style="width:142px">属性<b>*</b></label>
     		<?php 
				if(isset($this->news_attr)){
					foreach($this->news_attr as $attr_key => $attr_val){
						echo "<input type='checkbox' name='flag[]' value='{$attr_key}'>".$attr_val."&nbsp;&nbsp;" ;
					}
				}
			?>
     	</li>
  
		<li><label style="width:142px ;">缩略图：</label><input type='file' readonly class="dfinput" name='image' >
			
		</li>
	   
	   
	    
    	<li><label style="width:142px">添加日期</label><input type='text' class="dfinput" name='create_date' onFocus="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss'})" value="<?php echo date("Y-m-d H:i:s" , time());?>"></li>
        <li><label style="width:142px ;">内容：</label>
        <textarea class="dfinput" id="content" name="content"></textarea>
        
        
			
		</li>
		<li><label style="width:142px">介绍<b>*</b></label>
		<textarea class="dfinput"  name="introduce"></textarea>
		</li>
		
        <li><label style="width:142px">状态</label>
        <input type='hidden' class="dfinput" name='status' value="1" />
       	<span class="onoff"><label style="width:44px" title="开启" class="cb-enable selected" for="1"><span>开启</span></label>
        
        <label  style="width:44px" title="关闭" class="cb-disable" for="0"><span>关闭</span></label>
  	 </span>
        </li>
    
    <li><label>&nbsp;</label><input name="" type="submit" class="btn" value="添加咨询"/></li>
    </ul>
    </form>
    </div> 
    
  	 
       
	</div> 
 

    


    </div>


</body>

</html>
<script>
KindEditor.ready(function(K) {
       window.editor = K.create('#content',{
				width:'90%',
				height:'400px',
				allowFileManager:false ,
				allowUpload:false,
				afterCreate : function() {
					this.sync();
				},
				afterBlur:function(){
				      this.sync();
				},
				extraFileUploadParams:{
					'cookie':'<?php echo $_COOKIE['admin_auth'];?>'
				},
				uploadJson:"<?php echo site_url("news/index");?>?action=upload&session=<?php echo session_id();?>"
						
       });
});
$(function () {   
	
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

