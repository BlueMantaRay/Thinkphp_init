<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="zh-cn">
	<head>
	    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	    <!-- Bootstrap -->
	    <link rel="stylesheet" href="/github/Thinkphp_init/Public/css/bootstrap.min.css">
	    <link rel="stylesheet" href="/github/Thinkphp_init/Public/css/bootstrap-theme.min.css">
		
		<script type="text/javascript" src="/github/Thinkphp_init/Public/js/jquery-1.11.1.min.js"></script>
		<script type="text/javascript" src="/github/Thinkphp_init/Public/js/bootstrap.min.js"></script>
	    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
	    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	    <!--[if lt IE 9]>
	        <script src="http://cdn.bootcss.com/html5shiv/3.7.0/html5shiv.min.js"></script>
	        <script src="http://cdn.bootcss.com/respond.js/1.3.0/respond.min.js"></script>
	    <![endif]-->
	
		<title>登录</title>
	</head>
	<body>
	

<link rel="stylesheet" href="/github/Thinkphp_init/Public/css/admin/login.css" />

<div class="container">

	<form class="form-signin" action="/github/Thinkphp_init/index.php/Admin/Public/check_login" method="post">
		<h2 class="form-signin-heading">
			<img src="/github/Thinkphp_init/Public/image/admin/logo.png" alt="logo" />
		</h2>
		
		<div class="input-group input_div">
		  <span class="input-group-addon glyphicon glyphicon-user"></span>
		  <input type="text" name="adminname" class="form-control" placeholder="Username" autofocus required="" />
		</div>
		
		<div class="input-group input_div">
		  <span class="input-group-addon glyphicon glyphicon-lock"></span>
		  <input type="password" name="password" class="form-control" placeholder="Password" required="" />
		</div>
		
		<div class="input-group input_div">
		  <span class="input-group-addon glyphicon glyphicon-warning-sign"></span>
		  <input type="text" name="verify" class="form-control" placeholder="Verify" required="" />
		</div>
		
		<div class="form-group verify">
			<img src="/github/Thinkphp_init/index.php/Admin/Public/verify" alt="Verify" />
			<a href="javascript:void(0);" id="js_verify">换一张？</a>
		</div>
	
		<div class="alert alert-danger" id="login_error"></div>
		<button class="btn btn-lg btn-primary btn-block" type="submit">登录</button>
		<p>忘记密码了？<a href="/Public/forgetPassword">请点击</a>
	</form>

	<footer>© 2013 公司名称</footer>

</div>

<script type="text/javascript">
$(function(){


$("#js_verify").click(function(){
	var url = '/github/Thinkphp_init/index.php/Admin/Public/verify';
	var img_obj = $(".verify").find('img');
	var src = url + '?time' + Math.random();
	img_obj.attr('src', src);
});

// 表单提交
$(".form-signin").submit(function(e){
    e.preventDefault();
    e.stopPropagation();
	var data = new Object();
	data.adminname = $("input[name='adminname']").val();
	data.password = $("input[name='password']").val();
	data.verify = $("input[name='verify']").val();
	if (data.adminname == '') {
		$("input[name='adminname']").focus();
		lump_error("请输入用户名！");
		return false;
	}
	if (data.password == '') {
		$("input[name='password']").focus();
		lump_error("请输入密码！");
		return false;
	}
	if (data.verify == '') {
		$("input[name='verify']").focus();
		lump_error("请输入验证码！");
		return false;
	}
	lump_hide();
	var url = $(this).attr('action');
	$.post(url, data , function(json){
		if (json.info == 'ok') {
			lump_ok(json.data);
			window.location.href = "/github/Thinkphp_init/index.php/Admin/Index/index";
		} else {
			lump_error(json.data);
			return false;	
		}
	}, 'json');
	return false;
});

function lump_error(html){
	$("#login_error").removeClass('alert-success').addClass('alert-danger').html('* ' + html).show();
}
function lump_ok(html){
	$("#login_error").removeClass('alert-danger').addClass('alert-success').html(html).show();
}
function lump_hide(){
	$("#login_error").hide();
}

});
</script>



	
	</body>
</html>