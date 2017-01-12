
<!DOCTYPE html>
<html lang="zh-cn">
<head>
    <meta charset="utf-8">
    <title>欢迎使用CICMS</title>

    <style type="text/css">

    ::selection{ background-color: #E13300; color: white; }
    ::moz-selection{ background-color: #E13300; color: white; }
    ::webkit-selection{ background-color: #E13300; color: white; }

    body {
        background-color: #fff;
        margin: 40px;
        font: 13px/20px normal Helvetica, Arial, sans-serif;
        color: #4F5155;
    }

    a {
        color: #003399;
        background-color: transparent;
        font-weight: normal;
    }

    h1 {
        color: #444;
        background-color: transparent;
        border-bottom: 1px solid #D0D0D0;
        font-size: 19px;
        font-weight: normal;
        margin: 0 0 14px 0;
        padding: 14px 15px 10px 15px;
    }

    code {
        font-family: Consolas, Monaco, Courier New, Courier, monospace;
        font-size: 12px;
        background-color: #f9f9f9;
        border: 1px solid #D0D0D0;
        color: #002166;
        display: block;
        margin: 14px 0 14px 0;
        padding: 12px 10px 12px 10px;
    }

    #body{
        margin: 0 15px 0 15px;
    }
    
    p.footer{
        text-align: right;
        font-size: 11px;
        border-top: 1px solid #D0D0D0;
        line-height: 32px;
        padding: 0 10px 0 10px;
        margin: 20px 0 0 0;
    }
    
    #container{
        margin: 10px;
        border: 1px solid #D0D0D0;
        -webkit-box-shadow: 0 0 8px #D0D0D0;
    }
    </style>
</head>
<body>

<div id="container">
    <h1>欢迎使用CICMS! ,网址：<a href="http://www.speakphp.com">http://www.speakphp.com</a></h1>

    <div id="body">

        <code style="color: red">
            <a href="http://www.57sy.com">CICMS</a>只有后台的基础部分，只要简单的前台程序，请确认满足您的需求再进行安装使用。
        </code>

        <p>安装</p>
        <code>
          
            <ul>
                <li>请把根目录下面的data.sql文件导入到数据库</li>
                <li>更改config/config.inc.php数据库配置，^_^</li>
                <li>默认是有一个基础的前台，和后台</li>
                <li>1：请绑定前台文件夹：home</li>
                <li>2：请绑定后台文件夹：admin_application</li>
                <li>3:打开config/global.php 修改里面的配置 ， 里面有一些域名需要根据你自己的情况进行修改</li>
                <li>数据库已经内置了账户：用户：wangjian 密码：wangjian</li>
                <li>另外如果你熟悉了此系统想新建一个比如api应用，只需要简单的复制一个application项目即可</li>
            </ul>
        </code>
        <p>目录结构说明：</p>
        <code style="color:red">
          
            <ul>
                <li>admin_application后台绑定的目录</li>
                 <li>----application后台的所有应用文件，比如模版 ， js , 之类的</li>
                 <li>----index.php后台的入口文件</li>
                <li>config配置文件夹</li>
                <li>----config.inc.php数据库配置文件</li>
                <li>----global.php全局配置文件,比如说域名配置之类的。。</li>
                <li>data 数据文件</li>
                <li>----cache缓存文件</li>
                <li>----upload上传的资源文件，这个目录你需要绑定一个域名,然后在global.php里面修改下。</li>
                <li>home 前台应用，绑定的目录，绑定之后需要修改在global.php</li>
                <li>----application前台的一些应用文件，比如模版 ， 之类的</li>
                <li>share公共资源文件夹</li>
                <li>----config前台后台的一些配置变量之类的</li>
                <li>----helpers系统的公共方法,供前后台调用</li>
                <li>----models模型文件夹，放所有的model文件</li>
                <li>----libraries第三方类库，需要按照CI的格式进行写第三方类库</li>
                 <li>--------libraries/Code.php验证码类</li>
                <li>--------models/home文件夹 放前台的model文件</li>
                <li>--------models/M_common.php基类模型文件，所有你写的model文件要全部继承这个类</li>
                 <li>static静态资源文件夹路径,这个目录你可以绑定一个域名,然后在global.php里面进行修改，其他的地方都可以进行调用</li>
				<li>system CI的核心文件夹</li>
			</ul>
        </code>
        <p>global.php 展示：</p>
        <code>
        <ul>
          <li>  if(!defined('__ROOT__')) define('__ROOT__', dirname(__FILE__).DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR);</li>
          <li>  define("__ADMIN__DO_MAIN" , "http://manager.cicms.com" ); // 后台的域名</li>
          <li>  define("__UPLOAD__DO_MAIN" , "http://upload.cicms.com" ); // 上传文件的域名</li>
          <li>  define("__STATIC__DO_MAIN" , "http://static.cicms.com" ); // 静态文件域名</li>
          <li>  define("__WEB__DO_MAIN" , "http://www.cicms.com" ); // 网站域名</li>
        </ul>
        </code>




        <p>QQ</p>
        <code>821200318</code>
		<p>Email</p>
      <code>wangjian@speakphp.com</code>

        <p>如果您是第一次使用CICMS或者有任何疑问, 请到<a target="_blank" href="http://www.speakphp.com">博客留言</a></p>
    </div>

</div>

</body>
</html>