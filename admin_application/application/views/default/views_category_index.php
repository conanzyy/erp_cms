<?php 
if (! defined('BASEPATH')) {
	exit('Access Denied');
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>联动模型管理</title>
    <meta charset="UTF-8">
	<link rel="stylesheet" type="text/css" href="<?php echo  base_url() ;?>/<?php echo APPPATH?>/views/static/Css/bootstrap.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo  base_url() ;?>/<?php echo APPPATH?>/views/static/Css/bootstrap-responsive.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo  base_url() ;?>/<?php echo APPPATH?>/views/static/Css/style.css" />   
	<link rel="stylesheet" type="text/css" href="<?php echo  base_url() ;?>/<?php echo APPPATH?>/views/static/assets/css/dpl-min.css" />   
    <script type="text/javascript" src="<?php echo  base_url() ;?>/<?php echo APPPATH?>/views/static/assets/js/jquery-1.8.1.min.js"></script>
    <link href="<?php echo  base_url() ;?>/<?php echo APPPATH?>/views/static/assets/css/dpl-min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo  base_url() ;?>/<?php echo APPPATH?>/views/static/assets/css/bui-min.css" rel="stylesheet" type="text/css" />
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
    模型名称：
    <input type="text" name="cname" id="cname" class="abc input-default" placeholder="" value="">&nbsp;&nbsp;  
	<select id="condition">
		<option value="1">模糊搜索</option>
		<option value="2">精确搜索</option>
	</select>
    <button type="submit" class="btn btn-primary" onclick="common_request(1)">查询</button>&nbsp;&nbsp; <a  class="btn btn-success" id="addnew" href="<?php echo site_url("category/add");?>">新增<span class="glyphicon glyphicon-plus"></span></a>
</div>
<table class="table table-bordered table-hover definewidth m10">
    <thead>
    <tr>
        <th>id</th>
        <th>分类名称</th>
		<th>添加者</th>
        <th>添加日期</th>
        <th>状态</th>
        <th>备注</th>
		<th>缓存文件</th>
        <th>操作</th>
    </tr>
    </thead>
	<tbody id="result_">
	</tbody> 
</table>
<div id="page_string" class="form-inline definewidth m10">
  
</div>
<div class="alert alert-warning alert-dismissable">
<strong>Tips!</strong>
每次添加或者修改将生成缓存文件，缓存文件路径是： <?php echo config_item("category_model_cache") ; ?>,确保此文件夹可写
<div><?php echo $tips ;?></div>

</div>
</body>
</html>
<script type="text/javascript" src="<?php echo  base_url() ;?>/<?php echo APPPATH?>/views/static/assets/js/bui-min.js"></script>
<script>
$(function () {
	common_request(1);
});
function common_request(page){
	var url="<?php echo site_url("category/index");?>?inajax=1";
	var data_ = {
		'page':page,
		'time':<?php echo time();?>,
		'action':'ajax_data',
		'cname':$("#cname").val(),
		'condition':$("#condition").val()
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
					shtml+='<td>'+list[i].id+'</td>';
					shtml+='<td>'+list[i]['cname']+'</td>';
					shtml+='<td>'+list[i]['addperson']+'</td>';
					shtml+='<td>'+list[i]['addtime']+'</td>';
					shtml+='<td>'+list[i]['status']+'</td>';
					shtml+='<td>'+list[i]['remark']+'</td>';
					shtml+='<td>'+list[i]['filename']+'</td>';
					shtml+='<td><a href="<?php echo site_url('category/edit');?>?id='+list[i].id+'" class="icon-edit" title="编辑'+list[i]['cname']+'"></a></td>';
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
			   
		   }
		  
		});		
	

}
function ajax_data(page){
	common_request(page);	
}
function preview_category(id){
	var Overlay = BUI.Overlay
	var dialog = new Overlay.Dialog({
		title:"查看id是"+id+"的分类数据",
		width:700,
		height:306,
		loader : {
		url : '<?php echo site_url("category/index");?>',
		autoLoad : false, //不自动加载
		params : {"showpage":"1","action":"preview_category"},//附加的参数
		lazyLoad : true //不延迟加载	
		},
		mask:true,//遮罩层是否开启
		closeAction : 'destroy',
		buttons:[],
		success:function(){
			
		}
	});
	dialog.show();
	dialog.get('loader').load({"id":id});
}
</script>
