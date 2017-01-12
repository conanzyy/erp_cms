<?php 
if (! defined('BASEPATH')) {
	exit('Access Denied');
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>修改联动模型数据</title>
    <meta charset="UTF-8">
	
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
<form action="<?php echo site_url("category_data/edit");?>" method="post" class="definewidth m20" id="myform_edit">
<input type="hidden" value="<?php echo isset($typeid)?$typeid:'' ;?>" name="typeid">
<input type="hidden" value="doedit" name="action">
<input type="hidden" value="<?php echo isset($id)?$id:'' ;?>" name="id">
<table class="table table-bordered table-hover definewidth m10">
    <tr>
        <td width="20%" class="tableleft">名称</td>
        <td><input type="text" id="name" name="name" placeholder="名称" required="true" value="<?php echo $info['name'];?>"/></td>
    </tr>
    <tr>
        <td width="10%" class="tableleft">SEO标题</td>
        <td><input type="text" id="seotitle" name="seotitle" placeholder="seo标题" value="<?php echo $info['seotitle'];?>"/></td>
    </tr>	
    <tr>
        <td width="10%" class="tableleft">关键字</td>
        <td><input type="text" id="keywords" name="keywords" placeholder="关键字" value="<?php echo $info['keywords'];?>"/></td>
    </tr>	
    <tr>
        <td width="14%" class="tableleft">栏目描述</td>
        <td>
		<textarea id="description" name="description" placeholder="栏目描述" style="width:400px"><?php echo $info['description'];?></textarea>
		</td>
    </tr>	
     <tr>
        <td width="20%" class="tableleft">排序</td>
       
        <td><input type="text" name="disorder" placeholder="排序"  id="disorder" value="<?php echo $info['disorder'];?>"/></td>
     
    </tr> 
    <tr>
        <td class="tableleft">状态</td>
        <td>
            <input type="radio" name="status" value="1"  <?php if($info['status'] == 1 ){echo "checked";}?>/> 启用
           <input type="radio" name="status" value="0" <?php if($info['status'] == 0 ){echo "checked";}?>/> 禁用
        </td>
    </tr>
  
</table>
</form>
</body>
</html>
<script>
/*
    $(function () {    
	$("#btnSave").click(function(){
			if($("#myform").Valid() == false || !$("#myform").Valid()) {
				return false ;
			}
	});
    });*/
</script>