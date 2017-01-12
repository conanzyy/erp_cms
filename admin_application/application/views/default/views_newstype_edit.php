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
--修改新闻类别</title>
<script type="text/javascript" src="<?php echo _JSPATH_ ; ?>jquery.js"></script>
<link href="<?php echo _CSSPATH_ ; ?>style.css" rel="stylesheet" type="text/css" />
<script src="<?php echo _JSPATH_ ; ?>layer/lib.js"></script>
<script type="text/javascript" src="<?php echo _JSPATH_ ; ?>layer/layer.min.js"></script>
<script type="text/javascript" src="<?php echo _JSPATH_ ; ?>admin.js"></script>
<style>
.forminfo li{
	float:left
	
}
select {
    opacity: 0.89;
	width:180px ; 
	border:solid 1px ; 
	border-color:#A7B5BC #CED9DF #CED9DF #A7B5BC  ;
	height:31px ; 
	padding:5px
}
</style>
</head>

<body>


    
    <div class="formbody">
    <form id="form">
    <div class="formtitle"><span>修改新闻类别</span></div>
     
    <ul class="forminfo">
	<input type="hidden" value="<?php echo $info['id'] ;?>" name="id">
	<li><label>上级栏目</label>
		<select name="pid" style="width:300px">
		<option value="0">顶层栏目</option>
		<?php 
			if(isset($category) && $category ){
				foreach($category as $k => $v ){
	
		?>
		<option value="<?php echo $v['id'];?>" <?php if($info['pid'] == $v['id']){echo "selected";}?>><?php echo $v['html'];?><?php echo $v['typename'];?></option>
		<?php }} ?>
		</select>
	</li>   
    <li><label>栏目名称</label><input name="typename"  value="<?php echo $info['typename'] ;?>" type="text" class="dfinput" /><i class="">请输入类别名称</i></li>   
    <li><label>排序</label><input  value="<?php echo $info['disorder'] ;?>" name="disorder" type="text" class="dfinput" value="0" /></li>   
    <li><label>SEO标题</label><input name="seotitle" type="text" class="dfinput"  value="<?php echo $info['seotitle'] ;?>" /></li>   
     <li><label>关键字</label><input name="keywords" type="text" class="dfinput" value="<?php echo $info['keywords'] ;?>" /></li>   
      <li><label>栏目描述</label>
      <textarea  style="border:solid 1px #A7B5BC ;width:345px ; height:90px"  name="description" class="dfinput"><?php echo $info['description'] ;?></textarea>
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
				url: "<?php echo site_url("newstype/edit") ; ?>?action=doedit&inajax=1" ,
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
						parent.close_edit_div();
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
