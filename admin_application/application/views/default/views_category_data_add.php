<?php 
if (! defined('BASEPATH')) {
	exit('Access Denied');
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>添加联动模型数据</title>
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
<form action="<?php echo site_url("category_data/add");?>" method="post" class="definewidth m20" id="myform_add">
<input type="hidden" value="<?php echo isset($typeid)?$typeid:'' ;?>" name="typeid">
<input type="hidden" value="<?php echo isset($pid)?$pid:'' ;?>" name="pid">
<input type="hidden" value="doadd" name="action">

<table class="table table-bordered table-hover definewidth m10">
    <tr>
        <td width="10%" class="tableleft">名称</td>
        <td><input type="text" id="name" name="name" placeholder="名称" required="true"/></td>
    </tr>
     <tr>
        <td width="10%" class="tableleft">排序</td>
       
        <td><input type="text" name="disorder" placeholder="排序" value="0" id="disorder" /></td>
     
    </tr> 
    <tr>
        <td width="10%" class="tableleft">SEO标题</td>
        <td><input type="text" id="seotitle" name="seotitle" placeholder="seo标题"/></td>
    </tr>	
    <tr>
        <td width="10%" class="tableleft">关键字</td>
        <td><input type="text" id="keywords" name="keywords" placeholder="关键字"/></td>
    </tr>	
    <tr>
        <td width="14%" class="tableleft">栏目描述</td>
        <td>
		<textarea id="description" name="description" placeholder="栏目描述" style="width:400px"></textarea>
		</td>
    </tr>		
    <tr>
        <td class="tableleft">状态</td>
        <td>
            <input type="radio" name="status" value="1" checked/> 启用
           <input type="radio" name="status" value="0"/> 禁用
        </td>
    </tr>
</table>
</form>
</body>
</html>
