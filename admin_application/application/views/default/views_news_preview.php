<?php 
if (! defined('BASEPATH')) {
	exit('Access Denied');
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>新闻预览_<?php echo $info['title']; ?></title>
    <meta charset="UTF-8">
	<link rel="stylesheet" type="text/css" href="<?php echo  base_url() ;?>/<?php echo APPPATH?>/views/static/Css/bootstrap.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo  base_url() ;?>/<?php echo APPPATH?>/views/static/Css/bootstrap-responsive.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo  base_url() ;?>/<?php echo APPPATH?>/views/static/Css/style.css" />   
	<link rel="stylesheet" type="text/css" href="<?php echo  base_url() ;?>/<?php echo APPPATH?>/views/static/assets/css/dpl-min.css" />   
    <script type="text/javascript" src="<?php echo  base_url() ;?>/<?php echo APPPATH?>/views/static/assets/js/jquery-1.8.1.min.js"></script>
	<script type="text/javascript" src="<?php echo  base_url() ;?>/<?php echo APPPATH?>/views/static/Js/validate/validator.js"></script>   
	
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
   <a  class="btn btn-primary" id="addnew" href="<?php echo site_url("news/index");?>">新闻列表数据</a>
</div>

<table class="table table-bordered table-hover definewidth m10">
    <tr>
        <td width="10%" class="tableleft">标题</td>
        <td><?php echo $info['title'];?></td>
    </tr>
    <tr>
        <td width="10%" class="tableleft">url</td>
        <td><?php echo $info['url'];?></td>
    </tr>
     
     <tr>
        <td width="10%" class="tableleft">关键词</td>
        <td>
      <?php echo $info['keysword'];?>
       </td>
    </tr> 
      <tr>
        <td width="10%" class="tableleft">介绍</td>
        <td>
      
      <?php echo $info['introduce'];?>
       </td>
    </tr>  
       <tr>
        <td width="10%" class="tableleft">权重</td>
        <td>
       <?php echo $info['weight'];?>
       </td>
    </tr>    
     <tr>
        <td class="tableleft">内容</td>
        <td>
          <?php echo html_entity_decode($info['content']);?>
        </td>
    </tr> 
     <tr>
        <td class="tableleft">类型</td>
        <td>
         <?php echo $info['typename'];?>
        </td>
    </tr>      
     <tr>
        <td class="tableleft">来源</td>
        <td>
        <?php echo $info['fromname'] ;?>
        </td>
    </tr>   
            
    <tr>
        <td class="tableleft">状态</td>
        <td>
           <?php if($info['status'] == 1 ){echo "启用";}else{echo "关闭";}?>
        </td>
    </tr>
    	

</table>

</body>
</html>
