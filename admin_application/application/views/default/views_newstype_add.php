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
--添加新闻类别</title>
<script type="text/javascript" src="<?php echo _JSPATH_ ; ?>jquery.js"></script>
<link href="<?php echo _CSSPATH_ ; ?>style.css" rel="stylesheet" type="text/css" />
<script src="<?php echo _JSPATH_ ; ?>layer/lib.js"></script>
<script type="text/javascript" src="<?php echo _JSPATH_ ; ?>layer/layer.min.js"></script>
<script type="text/javascript" src="<?php echo _JSPATH_ ; ?>admin.js"></script>
</head>

<body>

	
    
    <div class="formbody">
    <form id="form">
    <div class="formtitle"><span>添加新闻类别</span></div>
     
    <ul class="forminfo">
	<input type="hidden" value="<?php echo isset($pid)?$pid:0 ;?>" name="pid">
	<li><label>上级栏目</label><input disabled value="<?php echo $typename ;?>" style="color:gray;background:lightgray" type="text" class="dfinput" /><i class=""></i></li>   
    <li><label>栏目名称</label><input name="typename" type="text" class="dfinput" /><i class="">请输入类别名称</i></li>   
    <li><label>排序</label><input name="disorder" type="text" class="dfinput" value="0" /></li>   
    <li><label>SEO标题</label><input name="seotitle" type="text" class="dfinput" /></li>   
     <li><label>关键字</label><input name="keywords" type="text" class="dfinput"  /></li>   
      <li><label>栏目描述</label>
      <textarea  style="border:solid 1px #A7B5BC ;width:345px ; height:90px"  name="description" class="dfinput"></textarea>
      </li>   
      

    <li><label>&nbsp;</label><input name="" type="button" id="btn" class="btn" value="确认保存"/></li>
    </ul>
    
    </form>
    </div>


</body>

</html>

<script>
var loadding_0 ;
	$(function(){
		$("#btn").bind("click" , function(){
			if($.trim($("input[name='typename']").val()) == '' ){
				layer.msg("名称不可以为空");
				return false ;
			}
			var data_ = $("#form").serializeArray() ;
			$.ajax({
				type: "POST",
				url: "<?php echo site_url("newstype/add") ; ?>?action=doadd&inajax=1" ,
				data: data_,
				cache:false,
				dataType:"json",
				async:true,
				success: function(msg){
					
					var shtml = '' ;
					var list = msg.resultinfo.list;
					
					if(msg.resultcode != 1 ){
						layer.msg(msg.resultinfo.errmsg);
						return false ;
					}else{
						parent.common_request();
						parent.close_add_div();
					}
					layer.close(loadding_0);
					
				},
				beforeSend:function(){
					 loadding_0 = layer.load('数据正在加载中。。。。。。'); 
				},
				error:function(){
					layer.msg('服务器繁忙请稍后');
					return false ;
				}
				});
			
		});
		
	
	}) ; 


	
</script>
