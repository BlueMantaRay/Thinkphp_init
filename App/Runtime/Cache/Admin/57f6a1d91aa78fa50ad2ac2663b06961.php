<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="zh-cn">
	<head>
	    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	    <!-- 移动设备上禁止缩放 -->
	    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
	    <!-- 弹窗css，可以在artDialog5.0找到你喜欢的颜色方案  -->
		<link rel="stylesheet" href="/github/Thinkphp_init/Public/css/admin/artDialog5.0/blue.css" />
	    <!-- Bootstrap -->
	    <link rel="stylesheet" href="/github/Thinkphp_init/Public/css/bootstrap.min.css" />
	    <link rel="stylesheet" href="/github/Thinkphp_init/Public/css/bootstrap-theme.min.css" />
	    
		<link rel="stylesheet" href="/github/Thinkphp_init/Public/css/admin/admin.css" />
		
		<script type="text/javascript">
			var PUBLIC = '/github/Thinkphp_init/Public';
			var MODULE = '/github/Thinkphp_init/index.php/Admin';
			
		</script>
		
		<script type="text/javascript" src="/github/Thinkphp_init/Public/js/jquery-1.11.1.min.js"></script>
		<script type="text/javascript" src="/github/Thinkphp_init/Public/js/bootstrap.min.js"></script>
		
		<script type="text/javascript" src="/github/Thinkphp_init/Public/js/admin/artDialog.min.js"></script>
		<script type="text/javascript" src="/github/Thinkphp_init/Public/js/admin/admin.js"></script>
		
	    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
	    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	    <!--[if lt IE 9]>
	        <script src="http://cdn.bootcss.com/html5shiv/3.7.0/html5shiv.min.js"></script>
	        <script src="http://cdn.bootcss.com/respond.js/1.3.0/respond.min.js"></script>
	    <![endif]-->
		
		
		<title>管理员列表</title>
	</head>
	<body>
	


<nav class="navbar navbar-default navbar-fixed-top navbar-inverse my_side_top_nav" role="navigation">
	<!-- Brand and toggle get grouped for better mobile display -->
	<div class="navbar-header">
		<button type="button" class="navbar-toggle" data-toggle="collapse"
			data-target="#bs-example-navbar-collapse-1">
			<span class="sr-only">Toggle navigation</span> <span class="icon-bar"></span>
			<span class="icon-bar"></span> <span class="icon-bar"></span>
		</button>
		<a class="navbar-brand" href="#">Brand</a>
	</div>

	<!-- Collect the nav links, forms, and other content for toggling -->
	<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
		<ul class="nav navbar-nav">
			<li class="active"><a href="#">设置</a></li>
			<li><a href="#">微信</a></li>
			<li class="dropdown">
				<a href="#" class="dropdown-toggle"data-toggle="dropdown">Dropdown <b class="caret"></b></a>
				<ul class="dropdown-menu">
					<li><a href="#">m</a></li>
					<li><a href="#">Another action</a></li>
					<li><a href="#">Something else here</a></li>
					<li class="divider"></li>
					<li><a href="#">Separated link</a></li>
					<li class="divider"></li>
					<li><a href="#">One more separated link</a></li>
				</ul>
			</li>
		</ul>
		<form action="#" method="get" class="navbar-form navbar-left" role="search">
		    <div class="input-group">
		      <input type="text" name="nav_serach" class="form-control" placeholder="Serach" >
		      <span class="input-group-btn">
		        <button class="btn btn-default" type="button">Go!</button>
		      </span>
		    </div><!-- /input-group -->
		</form>
		<ul class="nav navbar-nav navbar-right">
			<li><a href="#">Link</a></li>
			<li class="dropdown"><a href="#" class="dropdown-toggle"
				data-toggle="dropdown">Dropdown <b class="caret"></b></a>
				<ul class="dropdown-menu">
					<li><a href="#">Action</a></li>
					<li><a href="#">Another action</a></li>
					<li><a href="#">Something else here</a></li>
					<li class="divider"></li>
					<li><a href="#">Separated link</a></li>
				</ul></li>
		</ul>
	</div>
	<!-- /.navbar-collapse -->
</nav>



<div id="my_container" class="container col-xs-12" style="padding: 0 15px;">
	<div class="row">
		<div class="col-xs-3">
			<div class="" role="complementary">
				<ul class="nav my_side_nav">
                <li class="">
				  <a href="#nav_1" data-toggle="collapse">权限管理</a>
				  <ul id="nav_1" class="nav collapse">
				    <li><a href="#overview-doctype">HTML5文档类型</a></li>
				    <li><a href="#overview-mobile">移动设备优先</a></li>
				    <li><a href="#overview-responsive-images">响应式图片</a></li>
				    <li><a href="#overview-type-links">排版和链接</a></li>
				    <li><a href="#overview-normalize">Normalize</a></li>
				    <li><a href="#overview-container">Containers</a></li>
				  </ul>
				</li>
                <li>
				  <a href="#nav_2" data-toggle="collapse">管理员管理</a>
				  <ul id="nav_2" class="nav collapse">
				    <li><a href="/github/Thinkphp_init/index.php/Admin/Admin/index">管理员列表</a></li>
				    <li><a href="/github/Thinkphp_init/index.php/Admin/Admin/admin_add">管理员添加</a></li>
				    <li><a href="#overview-responsive-images">用户</a></li>
				    <li><a href="#overview-type-links">用户</a></li>
				    <li><a href="#overview-normalize">Nor用户</a></li>
				    <li><a href="#overview-container">Cont用户</a></li>
				  </ul>
				</li>

				</ul>
			</div>
		</div>
		
		<div class="col-xs-9" role="main">
			<div class="bs-docs-section">
				<div class="page-header">
					<h1 id="overview">管理员列表</h1>
				</div>
			</div>
		</div>







<script type="text/javascript">
$('.affix').affix({
    offset: {
      top: 100
    , bottom: function () {
        return (this.bottom = $('.bs-footer').outerHeight(true))
      }
    }
  })

</script>


<div class="col-xs-9" role="main">

	<form action="/github/Thinkphp_init/index.php/Admin/Admin/add" method="post" enctype="multipart/form-data" class="form-horizontal" role="form">
		<div class="row" id="my_img_box">
		  <div class="col-xs-2 col-md-2 my_img_list">
		  </div>
		  <div class="col-xs-2 col-md-2 my_img_list" id="js_img_div">
		    <a href="#" class="thumbnail">
		      <img src="/github/Thinkphp_init/Public/images/admin/default-avatar.gif" alt="...">
		      <span class="close my_image_del" title="点击删除图片">&times;</span>
		    </a>
		  </div>
		</div>
		  
		<div class="form-group ">
        	<label for="input-staff_num" class="col-sm-2 control-label">图片</label>
        	<div class="col-sm-8">
	        <input type="file" name="image_up"  class="btn" id="image_up" value="" title="<i class='glyphicon glyphicon-folder-open'></i> 上传图片" >
	        <input type="hidden" name="photo_id" value="">
	        </div>
      	</div>
	
		<div class="form-group">
			<label for="inputEmail3" class="col-sm-2 control-label">用户名</label>
			<div class="col-xs-4">
				<input type="text" name="adminname" class="form-control" id="email" placeholder="用户名">
			</div>
		</div>
		<div class="form-group">
			<label for="inputPassword3" class="col-sm-2 control-label">Password</label>
			<div class="col-xs-4">
				<input type="password" name="password" class="form-control" id="password" placeholder="Password">
			</div>
		</div>
		<div class="form-group">
			<label for="inputPassword3" class="col-sm-2 control-label">确认密码</label>
			<div class="col-xs-4">
				<input type="password" name="re_password" class="form-control" id="re_password" placeholder="Password">
			</div>
		</div>

		<div class="form-group">
			<div class="col-sm-offset-2 col-sm-10">
				<button type="submit" class="btn btn-default">保 存</button>
			</div>
		</div>
	</form>


</div>


<script type="text/javascript" charset="utf-8"  src="/github/Thinkphp_init/Public/js/admin/ajaxfileupload.js"></script>
<script type="text/javascript" charset="utf-8"  src="/github/Thinkphp_init/Public/js/admin/bootstrap-filestyle.min.js"></script>
<script type="text/javascript">
var a_id = '';
var domain = "";

$(function(){
	
	// 上传图片样式
	$('#image_up').bootstrapFileInput();
	// 上传图片
	var file_name = '0';
	$("body").on('change','.file-input-wrapper input[type=file]', function(e){
		e.preventDefault();
		var len = $(".my_img_list").length;
		if (len >= 5) {
			js_prompt('最多上传5张图片');
		} else {
			console.log($(".file-input-name").html());
			console.log(file_name);
			if ($(".file-input-name").length < 1 || $(".file-input-name").html() != file_name) {
				console.log('------------------');
				ajaxFileUpload('image');
				file_name = $(".file-input-name").html();
			}
		}
		return true;
	});
	
    // 删除图片
    $(".image_del").on('click','.file-input-name', function(e){
    	e.preventDefault();
		var obj = $(this);
		var p_obj = obj.parents('.js_img_list')
		var p_id = p_obj.attr('data-id');
    	var data = new Object();
    	data.p_id = p_id;
    	data.a_id = a_id;
    	var url = '/github/Thinkphp_init/index.php/Admin/Common/del_img';
    	$.post(url, data, function(json){
    		if (json.info == 'ok') {
    			p_obj.remove();
    			// 拖动排序
    			$( "#js_img_list_div" ).sortable();
    		} else {
    			js_prompt(json.data);
    		}
    	}, 'json');
    });
	
	
});

// 图片上传
function ajaxFileUpload(up){
	$(".js_loading_"+up).ajaxStart(function(){
		$(this).show();
	}).ajaxComplete(function(){
		$(this).hide();
	});
	var url =  '/github/Thinkphp_init/index.php/Admin/Common/upload_img';
	var my_file = up + '_up';
	var data = new Object();
	data.res_id = a_id;
	data.res_name = 'article_photo';
	data.my_file = my_file;
	data.is_ajax = 1;
	$.ajaxFileUpload({
		url: url,
		secureuri:false,
		fileElementId: my_file,
		dataType: 'json',
		data: data,
		success: function (json, status){
			console.log(json);
			if (json.info == 'ok') {
				$("#js_img_div").find('img').attr('src', json.data.path);
				$("input[name='photo_id']").attr('value', json.data.id);
				$("#image_up").attr('value', json.data.name);
			} else {
				js_prompt(json.data);
			}
		},
		error: function (data, status, e){
			console.log(e);
			js_prompt('上传出错了，请刷新后重试');
			//alert(e);
		}
	})
	return false;
}


function get_li_html(data){
	var html = '';
	var url = domain + 'Photo/get_photo?id='+data.id+'&w=190&h=190&t=thumb';
	html +='  <div class="col-xs-2 col-md-2 my_img_list" data-id="'+data.id+'">';
	html +='    <div class="thumbnail">';
	html +='      	<img src="'+url+'" title="'+data.photo_name+'">';
	html +='	  	<span class="close image_del" title="点击删除图片">&times;</span>';
	html +='    </div>';
	html +='  </div>';

	return html;
}
</script>

		
			</div>
		</div>
	</body>
</html>