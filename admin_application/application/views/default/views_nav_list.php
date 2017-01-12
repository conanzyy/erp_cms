<?php 
if (! defined('BASEPATH')) {
	exit('Access Denied');
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo isset($this->site_config['web_site_name'])?$this->site_config['web_site_name']:'';?>-导航列表</title>
<link href="<?php echo _CSSPATH_ ; ?>style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo _JSPATH_ ; ?>jquery.js"></script>
<script src="<?php echo _JSPATH_ ; ?>layer/lib.js"></script>
<script type="text/javascript" src="<?php echo _JSPATH_ ; ?>layer/layer.min.js"></script>



</head>


<body>

	<div class="place">
    <span>位置：</span>
    <ul class="placeul">
    
    
    <li>导航列表</li>
    </ul>
    </div>
    
    <div class="rightinfo">
    
    <div class="tools">
    
    	<ul class="toolbar">
        <li class="click" onclick="add()"><span><img src="<?php echo  _IMGPATH_ ;?>t01.png" /></span>添加</li>
        <!--
        <li class="click" onclick="dialog_edit()"><span><img src="<?php echo  _IMGPATH_ ;?>t02.png" /></span>修改</li>
        <li onclick="del_dialog()"><span><img src="<?php echo  _IMGPATH_ ;?>t03.png" /></span>删除</li>
       -->
        </ul>
        
       
    
    </div>
    
    
    <table class="tablelist">
    	<thead>
    	<tr>
        <th><input name="" type="checkbox" value=""  id="checkedall"/></th>
        <th>编号<i class="sort"><img src="<?php echo  _IMGPATH_ ;?>px.gif" /></i></th>
        <th>导航名称</th>
        <th>状态</th>
        <th>父ID</th>
        <th>path</th>
        <th>url</th>
       <th>排序</th>
        <th>添加日期</th>
        <th>操作</th>
        </tr>
        </thead>
        <tbody>
        <?php 
        	if(isset($list) && $list){
        		foreach($list as $key => $val ){
        			
        	
        ?>
        <tr id="tr_<?php echo $val['path'].'-'.$val['id'] ; ?>" onclick="swith_nav('<?php echo $val['path'].'-'.$val['id'] ; ?>' , this) ; ">
        <td><input name="id" type="checkbox" value="<?php echo $val['id'];?>" /></td>
        <td><?php echo $val['id'];?></td>
        <td style="color:<?php if(isset($this->nav_color[$val['index']])){echo $this->nav_color[$val['index']];}?>;"><?php echo  str_repeat("└─", $val['index']).$val['name'];?></td>
        <td><?php echo $this->_status_array[$val['status']];?></td>
        <td><?php echo $val['parentid'];?></td>
        <td><?php echo $val['path'];?></td>
        <td><?php echo $val['url'];?></td>
        <td><?php echo $val['disorder'];?></td>
        <td><?php echo $val['addtime'];?></td>
        <td><a href="javascript:void(0)" class="tablelink" onclick="add(<?php echo $val['id']?>)">添加</a>   <a href="javascript:void(0)" class="tablelink" onclick="edit(<?php echo $val['id']?>)">编辑</a>     <a href="javascript:void(0)" onclick="del(<?php echo $val['id']?>)" class="tablelink"> 删除</a></td>
        </tr> 
        <?php 
    	    }
        }
        ?>
     
            
        </tbody>
    </table>
  
    </div>
    
    <script type="text/javascript">
    	$('#checkedall').click(function(){
        	var checked = this.checked ; 
        	$("input[name='id']").each(function(){
        		this.checked = checked;
            })  ; 
    	}) 
		$('.tablelist tbody tr:odd').addClass('odd');
		function swith_nav(id,  o ){
			//$("tr[id^='tr_"+id+"']").toggle() ;
			//$(o).show();
		}
		//添加导航
		function add(pid){
			$.layer({
			    type: 2,
			    shadeClose: false,
			    title: false,
			    closeBtn: [0, true],
			    shade: [0.8, '#000'],
			    border: [1],
			    offset: ['20px',''],
			    area: ['720px','460px'],
			    iframe: {src: '<?php echo site_url("nav/add");?>?id='+pid+"&showpage=1"}
			}); 
		}
		//编辑
		function edit(id){
			$.layer({
			    type: 2,
			    shadeClose: false,
			    title: false,
			    closeBtn: [0, true],
			    shade: [0.8, '#000'],
			    border: [1],
			    offset: ['20px',''],
			    area: ['720px','460px'],
			    iframe: {src: '<?php echo site_url("nav/edit");?>?id='+id+"&showpage=1"}
			});
		}
		function dialog_edit(){
			var ids = $("input[name='id']:checked");
			if(ids.length >=2 ){
				layer.msg('只可以选择一个值进行修改');
				return false ;
			}else if(ids.length <= 0 ){
				layer.msg('请选择值进行修改');
				return false ;
			}
			edit(ids.val());
		}
		//删除
		function del_dialog(){
			var ids = $("input[name='id']:checked");
			if(ids.length >=2 ){
				layer.msg('只可以选择一个值进行删除');
				return false ;
			}else if(ids.length <= 0 ){
				layer.msg('请选择值进行删除');
				return false ;
			}
			del(ids.val());
		}
		function del(id){
		
			$.layer({
			    shade: [1],
			    area: ['240px','auto'],
			    dialog: {
			        msg: '确定删除数据吗？此操作不可恢复!',
			        btns: 2,                    
			        type: 4,
			        btn: ['确定','取消'],
			        yes: function(){
			        	$.ajax({
				 			   type: "POST",
				 			   url: "<?php echo site_url('nav/del');?>" ,
				 			   data: {"id":id},
				 			   cache:false,
				 			   dataType:"json",
				 			 //  async:false,
				 			   success: function(msg){
				 				   if(msg.resultcode<0){
					 				 layer.msg('没有权限执行此操作');
									 return false ; 
				 					}else if(msg.resultcode == 0 ){
				 						layer.msg(msg.resultinfo.errmsg);
				 						return false ;				
				 					}else{
				 						window.location.href="<?php echo site_url('nav/index');?>";
				 					}
				 			   },
				 			   beforeSend:function(){
					 				  var loadding_0 = layer.load('数据处理中....'); 
				 			   },
				 			   error:function(){
					 				  var loadding_1 = layer.load('服务器繁忙请稍后等待。。。。。。'); 
				 			   }
				 			  
				 			});	
			            //layer.msg('重要', 1, 1);
			        }, no: function(){
			            
			        }
			    }
			});
		}
	</script>

</body>

</html>
