<?php 
if (! defined('BASEPATH')) {
	exit('Access Denied');
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>产品管理</title>
    <meta charset="UTF-8">
	<link rel="stylesheet" type="text/css" href="<?php echo  base_url() ;?>/<?php echo APPPATH?>/views/static/Css/bootstrap.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo  base_url() ;?>/<?php echo APPPATH?>/views/static/Css/bootstrap-responsive.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo  base_url() ;?>/<?php echo APPPATH?>/views/static/Css/style.css" />   
	<link rel="stylesheet" type="text/css" href="<?php echo  base_url() ;?>/<?php echo APPPATH?>/views/static/assets/css/dpl-min.css" />   
	<link href="<?php echo  base_url() ;?>/<?php echo APPPATH?>/views/static/assets/css/bui-min.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="<?php echo  base_url() ;?>/<?php echo APPPATH?>/views/static/assets/js/jquery-1.8.1.min.js"></script>
	 <script type="text/javascript" src="<?php echo  base_url() ;?>/<?php echo APPPATH?>/views/static/Js/admin.js"></script>
	 <script type="text/javascript" src="<?php echo  base_url() ;?>/<?php echo APPPATH?>/views/static/assets/js/bui-min.js"></script>
    <style type="text/css">
        body {
            padding-bottom: 40px;
        }
        .sidebar-nav {
            padding: 9px 0;
        }

        @media (max-width: 980px) {
            /* Enable use of floated navbar text */
            .navbar-text.pull-right {
                float: none;
                padding-left: 5px;
                padding-right: 5px;
            }
        }


    </style>
</head>
<body>
<div class="form-inline definewidth m20" >    
    产品名称：
    <input type="text" name="productname" id="productname"class="abc input-default" placeholder="" value="">&nbsp;&nbsp;  
	<select id="condition">
		<option value="1">模糊搜索</option>
		<option value="2">精确搜索</option>
	</select>
	状态：
	<select id="status">
		<option value="">请选择</option>
		<option value="1">开启</option>
		<option value="0">关闭</option>
	</select>	
    <button type="submit" class="btn btn-primary" onclick="common_request(1)">查询</button>&nbsp;&nbsp; <a  class="btn btn-success" id="addnew" href="<?php echo site_url("product/add");?>">新增产品<span class="glyphicon glyphicon-plus"></span></a>
</div>


<table class="table table-bordered table-hover definewidth m10">
    <thead>
    <tr>
         <th></th>
         <th>产品名称</th>
		 <th>类别名称</th>
		 <th>图片</th>        
         <th>地址</th>
         <th>权重</th>
         <th>修改日期</th>
         <th>创建日期</th>
		 <th>添加者</th>
         <th>状态</th>
         <th>操作</th>
    </tr>
    </thead>
	<tbody id="result_">
	</tbody> 
	<tr>
		<td colspan="11">
		全选<input type="checkbox" id="selAll" onclick="selectAll()">
		反选:<input type="checkbox" id="inverse" onclick="inverse();">
			<button class="button button-small" type="button" onclick="del()">
			<i class="icon-remove"></i>
			删除
			</button>
			<button class="button button-small" type="button" onclick="change_status(0)">
			<i class="icon-off"></i>
			设为禁用
			</button>
			<button class="button button-small" type="button" onclick="change_status(1)">
			<i class="icon-eye-open"></i>
			设为开启
			</button>
		</td>
	</tr>
</table>
<div id="page_string" class="form-inline definewidth m10">
  
</div>
</body>
</html>
<script>
$(function () {
	common_request(1);
});
function common_request(page){
	var url="<?php echo site_url("product/index");?>?inajax=1";
	var data_ = {
		'page':page,
		'time':<?php echo time();?>,
		'action':'ajax_data',
		'productname':$("#productname").val(),
		'condition':$("#condition").val(),
		'status':$("#status").val()
	} ;
	$.ajax({
		   type: "POST",
		   url: url ,
		   data: data_,
		   cache:false,
		   dataType:"json",
		 //  async:false,
		   success: function(msg){
			var shtml = '' ;
			var list = msg.resultinfo.list;
			if(msg.resultcode<0){
				alert("没有权限执行此操作");
				return false ;
			}else if(msg.resultcode == 0 ){
				alert("服务器繁忙");
				return false ;				
			}else{
				
				for(var i in list){
					shtml+='<tr>';
					shtml+='<td width="20px"><input type="checkbox" name="checkAll[]" onclick="setSelectAll();" value="'+list[i]['id']+'"></td>';
					shtml+='<td>'+list[i]['title']+'</td>';
					shtml+='<td>'+list[i]['typename']+'</td>';
					shtml+='<td><img src='+list[i]['image']+' width="200px" height="50px"></td>';				
					shtml+='<td>'+list[i]['url']+'</td>';
					shtml+='<td>'+list[i]['weight']+'</td>';
					shtml+='<td>'+list[i]['modify_date']+'</td>';
					shtml+='<td>'+list[i]['create_date']+'</td>';
					shtml+='<td>'+list[i]['addperson']+'</td>';
					shtml+='<td>'+list[i]['status']+'</td>';
					shtml+='<td><a href="<?php echo site_url('product/edit');?>?id='+list[i].id+'" class="icon-edit" title="编辑产品'+list[i]['title']+'"></a></td>';
					shtml+='</tr>';
				}
				$("#result_").html(shtml);
				
				$("#page_string").html(msg.resultinfo.obj);
			}
		   },
		   beforeSend:function(){
			  $("#result_").html('<font color="red"><img src="<?php echo base_url();?>/<?php echo APPPATH?>/views/static/Images/progressbar_microsoft.gif"></font>');
		   },
		   error:function(){
			   $("#result_").html("服务器繁忙请稍后");
		   }
		  
		});		
	

}
function ajax_data(page){
	common_request(page);	
}

function select_data(){
	var obj=document.getElementsByName("checkAll[]");
	var count = obj.length;
	var selectCount = 0;
	var data = [] ; 
	for(var i = 0; i < count; i++)
	{
		if(obj[i].checked == true)
		{
			selectCount++;
			data.push(obj[i].value);
		}
	}
	var o = {
		'selectCount':selectCount , 
		'data':data
	} ;
	return o ;
}
function del(){
	var selectCount = 0;
	var data = [] ; 	
	o = select_data() ;
	data = o.data ;
	selectCount = o.selectCount ; 
	if(selectCount == 0 ){
		BUI.Message.Alert('请选择进行删除','error');
		return false ;
	}
	BUI.Message.Confirm('此操作不可恢复,是否确定此操作',function(){
		$.ajax({
			   type: "POST",
			   url: "<?php echo site_url('product/del');?>" ,
			   data: {"ids":data},
			   cache:false,
			   dataType:"json",
			 //  async:false,
			   success: function(msg){
				   if(msg.resultcode<0){
					   BUI.Message.Alert('没有权限执行此操作','error');
					   return false ; 
					}else if(msg.resultcode == 0 ){
						BUI.Message.Alert(msg.resultinfo.errmsg ,'error');
						common_request();
						return false ;				
					}else{
						common_request();
					}
			   },
			   beforeSend:function(){
				  $("#result_").html('<font color="red"><img src="<?php echo base_url();?>/<?php echo APPPATH?>/views/static/Images/progressbar_microsoft.gif"></font>');
			   },
			   error:function(){
				   BUI.Message.Alert('服务器繁忙请稍后','error');
			   }
			  
			});		
	},'question');

}
//设置状态
function change_status(status){
	var selectCount = 0;
	var data = [] ; 	
	var o = select_data() ;
	selectCount = o.selectCount ; 
	data = o.data ;
	if(selectCount == 0 ){
		BUI.Message.Alert('请选择进行修改状态','error');
		return false ;
	}
	$.ajax({
			   type: "POST",
			   url: "<?php echo site_url('product/edit');?>" ,
			   data: {"ids":data,"action":'dostatus',"status":status},
			   cache:false,
			   dataType:"json",
			 //  async:false,
			   success: function(msg){
				   if(msg.resultcode<0){
					   BUI.Message.Alert('没有权限执行此操作','error');
					   return false ; 
					}else if(msg.resultcode == 0 ){
						BUI.Message.Alert(msg.resultinfo.errmsg ,'error');
						common_request();
						return false ;				
					}else{
						common_request();
					}
			   },
			   beforeSend:function(){
				  $("#result_").html('<font color="red"><img src="<?php echo base_url();?>/<?php echo APPPATH?>/views/static/Images/progressbar_microsoft.gif"></font>');
			   },
			   error:function(){
				   BUI.Message.Alert('服务器繁忙请稍后','error');
			   }
			  
	});		
	
}
</script>
