<?php 
if (! defined('BASEPATH')) {
	exit('Access Denied');
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>模型数据管理</title>
    <meta charset="UTF-8">
	<link rel="stylesheet" type="text/css" href="<?php echo  base_url() ;?>/<?php echo APPPATH?>/views/static/Css/bootstrap.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo  base_url() ;?>/<?php echo APPPATH?>/views/static/Css/bootstrap-responsive.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo  base_url() ;?>/<?php echo APPPATH?>/views/static/Css/style.css" />   
	<link rel="stylesheet" type="text/css" href="<?php echo  base_url() ;?>/<?php echo APPPATH?>/views/static/assets/css/dpl-min.css" />   
    <script type="text/javascript" src="<?php echo  base_url() ;?>/<?php echo APPPATH?>/views/static/assets/js/jquery-1.8.1.min.js"></script>
    <script type="text/javascript" src="<?php echo  base_url() ;?>/<?php echo APPPATH?>/views/static/Js/admin.js"></script>
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
    模型类别：
	  <select id="type">
		<option value="">请选择</option>
		<?php 
			if(isset($list) && $list){
				foreach($list as $k=>$v){
				
		?>
		<option value="<?php echo isset($v['id'])?$v['id']:'' ;?>"><?php echo isset($v['cname'])?$v['cname']:'' ;?></option>
		<?php 
			}
		}	
		?>
 	</select>  

    <button type="submit" class="btn btn-primary" onclick="search_()">查询数据</button>&nbsp;&nbsp; <a  class="btn btn-success" id="addnew" href="javascript:void(0)" onclick="add_top()">新增顶级分类<span class="glyphicon glyphicon-plus"></span></a>
</div>
<table class="table table-bordered table-hover definewidth m10">
    <thead>
    <tr>
        <th>id</th>
        <th>名称</th>
        <th>类别名称</th>
		<th>seo标题</th>
		<th>关键字</th>
		<th>栏目描述</th>
        <th>状态</th>
        <th>排序</th>
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
每次添加或者修改将生成缓存文件，缓存文件路径是： <?php echo config_item("category_modeldata_cache") ; ?>,确保此文件夹可写
<br / >
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;暂不提供删除功能,如果你要删除,请联系数据库管理员，直接从数据库删除
</div>
</body>
</html>
<script>
var pid = 0 ; 
var page = 1 ; 
$(function () {	
	if(getQueryStringValue("typeid") != ""){
		var v = getQueryStringValue("typeid") ;
		$("#type").attr("value",v);
	}else{
		//
		$("#type option").eq(1).attr("selected","selected") ; 
		
	}
	common_request();
});
function common_request(){
	var url="<?php echo site_url("category_data/index");?>?inajax=1";
	var data_ = {
		'page':page,
		'time':<?php echo time();?>,
		'action':'ajax_data',
		'typeid':$("#type").val(),
		'pid':pid
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
				BUI.Message.Alert("你没权限执行此操作" ,'error');
				return false ;
			}else if(msg.resultcode == 0 ){
				BUI.Message.Alert(msg.resultinfo.errmsg ,'error');
				return false ;				
			}else{
				if(list.length>0){
					for(var i in list){
						var onclick = '' ;					
						if(parseInt(list[i].pid) != 0 ){
							
							onclick = "<a href=\"javascript:void(0)\" onclick=\"goback('"+list[i].pid+"')\">返回</a>" ; 
						}
						shtml+='<tr>';
						shtml+='<td>'+list[i].id+'</td>';
						shtml+='<td ><a href="javascript:void(0)" onclick="get_child('+list[i].id+')" >'+list[i]['name']+'</a>&nbsp;&nbsp;'+onclick+'</td>';				
						shtml+='<td>'+list[i]['typename']+'</td>';
						shtml+='<td>'+list[i]['seotitle']+'</td>';
						shtml+='<td>'+list[i]['keywords']+'</td>';
						shtml+='<td>'+list[i]['description']+'</td>';
						shtml+='<td>'+list[i]['status']+'</td>';
						shtml+='<td>'+list[i]['disorder']+'</td>';
						shtml+='<td><a href="javascript:void(0);" onclick="add_('+list[i].typeid+','+list[i].id+')" class="icon-plus" title="添加'+list[i]['typename']+'的子类"></a>&nbsp;&nbsp;&nbsp;<a href="javascript:void(0)" onclick="edit('+list[i].id+','+list[i].typeid+','+list[i].pid+',\''+list[i].name+'\')" class="icon-edit" title="编辑'+list[i]['typename']+'"></a></td>';
						shtml+='</tr>';
					}
					$("#result_").html(shtml);				
					$("#page_string").html(msg.resultinfo.obj);
				}else{
					$("#result_").html("暂无数据,<a href='javascript:void(0)' onclick=\"goback("+pid+")\">点击返回</a>");	
					$("#page_string").html("");	
				}

			}
		   },
		   beforeSend:function(){
			  $("#result_").html('<font color="red"><img src="<?php echo base_url();?>/<?php echo APPPATH?>/views/static/Images/progressbar_microsoft.gif"></font>');
		   },
		   error:function(){
			   BUI.Message.Alert('服务器繁忙请稍后' ,'error');
		   }
		  
		});		
	

}
function ajax_data(p){
	page = p ;
	common_request();	
}


//获取子类
function get_child(mypid){
	pid = mypid ; 
	page = 1 ; 
	common_request();
	
}
//查询
function search_(){
	pid = 0 ;
	page = 1 ;
	common_request(1);	
}

function goback(myid){
	$.ajax({
		   type: "POST",
		   url: "<?php echo site_url('category_data/index');?>" ,
		   data: {'action':'query_pid_by_id','id':myid},
		   cache:false,
		   dataType:"text",
		   async:false,
		   success: function(msg){			
			 get_child(msg);
		   }
		  
		});	
}
</script>
<script type="text/javascript" src="<?php echo  base_url() ;?>/<?php echo APPPATH?>/views/static/assets/js/bui-min.js"></script>

<!-- script start-->
<script type="text/javascript">

function edit(id,typeid,mypid,name){
	var Overlay = BUI.Overlay
	var dialog = new Overlay.Dialog({
		title:"编辑级别"+name+'数据',
		width:700,
		height:500,
		loader : {
		url : '<?php echo site_url("category_data/edit");?>',
		autoLoad : false, //不自动加载
		params : {"showpage":"1"},//附加的参数
		lazyLoad : true //不延迟加载	
		},
		mask:true,//遮罩层是否开启
		closeAction : 'destroy',
		success:function(){
			submit_edit(id,typeid,mypid); //编辑级别分类处理
			this.close();
		}
	});
	dialog.show();
	dialog.get('loader').load({"id":id,"typeid":typeid});
}
function submit_edit(id,typeid,mypid){
	var data_ = $("#myform_edit").serializeArray();
	$.ajax({
		   type: "POST",
		   url: "<?php echo site_url('category_data/edit');?>?inajax=1" ,
		   data: data_,
		   cache:false,
		   dataType:"json",
		   async:false,
		   success: function(msg){
				if(msg.resultcode<0){
					BUI.Message.Alert('没有权限执行此操作','error');
					return false ;
				}else if(msg.resultcode == 0 ){
					BUI.Message.Alert(msg.resultinfo.errmsg,'error');
					return false ;
				}else{
						pid = mypid ;
						common_request();
				}
		   }
		  
		});		
	
}
//添加子类
//_typeid 分类ID
//_id 父级ID
function add_(_typeid,_id){

	var Overlay = BUI.Overlay
	var dialog = new Overlay.Dialog({
		title:"添加数据",
		width:700,
		height:400,
		loader : {
		url : '<?php echo site_url('category_data/add');?>',
		autoLoad : false, //不自动加载
		params : {"showpage":"1","typeid":_typeid,"pid":_id},//附加的参数
		lazyLoad : true //不延迟加载	
		},
		mask:true,//遮罩层是否开启
		closeAction : 'destroy',
		success:function(){
			submit_add(_typeid,_id); //添加处理
			this.close();
		}
	});
	dialog.show();
	dialog.get('loader').load();
}
function submit_add(_typeid,_id){
	var data_ = $("#myform_add").serializeArray();
	$.ajax({
		   type: "POST",
		   url: "<?php echo site_url('category_data/add');?>?inajax=1" ,
		   data: data_,
		   cache:false,
		   dataType:"json",
		   async:false,
		   success: function(msg){
				if(msg.resultcode<0){
					BUI.Message.Alert('没有权限执行此操作','error');
					return false ;
				}else if(msg.resultcode == 0 ){
					BUI.Message.Alert(msg.resultinfo.errmsg,'error');
					return false ;
				}else{
						pid = _id ;
						common_request();
				}
		   }
		  
		});		
}
//添加顶级分类
function add_top(){
	//
	
	if($("#type").val() == "" ){
		BUI.Message.Alert('请选择模型类别进行添加','error');
		return false ;
	} 	
	add_($("#type").val(),0);
}
</script>
<!-- script end -->

