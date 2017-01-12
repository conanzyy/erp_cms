<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo (isset($this->site_config['web_site_name']))?$this->site_config['web_site_name']:'' ;?>____________用户中心</title>
<form action="<?php echo site_url("users/register/doregister")?>" method="post">
<h1>用户中心</h1>
<p>用户名：<?php echo $this->userInfo['username'] ; ?></p>
<p>用户uid：<?php echo $this->userInfo['uid'] ; ?></p>
<p>注册日期：<?php echo date("Y-m-d H:i" , $this->userInfo['regdate']) ; ?></p>
<h2><a href="<?php echo site_url("users/login/loginout")?>">退出登录</a></h2>
</form>