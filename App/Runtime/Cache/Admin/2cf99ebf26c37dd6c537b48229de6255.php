<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="zh-cn">
	<head>
	    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	    <!-- 移动设备上禁止缩放 -->
	    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
	    <!-- Bootstrap -->
	    <link rel="stylesheet" href="/github/Thinkphp_init/Public/css/bootstrap.min.css" />
	    <link rel="stylesheet" href="/github/Thinkphp_init/Public/css/bootstrap-theme.min.css" />
		<link rel="stylesheet" href="/github/Thinkphp_init/Public/css/admin/admin.css" />
		
		<script type="text/javascript" src="/github/Thinkphp_init/Public/js/jquery-1.11.1.min.js"></script>
		<script type="text/javascript" src="/github/Thinkphp_init/Public/js/bootstrap.min.js"></script>
	    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
	    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	    <!--[if lt IE 9]>
	        <script src="http://cdn.bootcss.com/html5shiv/3.7.0/html5shiv.min.js"></script>
	        <script src="http://cdn.bootcss.com/respond.js/1.3.0/respond.min.js"></script>
	    <![endif]-->
		
		<title>权限管理</title>
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
				  <a href="#nav_2" data-toggle="collapse">用户管理</a>
				  <ul id="nav_2" class="nav collapse">
				    <li><a href="/github/Thinkphp_init/index.php/Admin/Admin/index">用户列表</a></li>
				    <li><a href="#overview-mobile">用户</a></li>
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
					<h1 id="overview">权限管理</h1>
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
			<div class="bs-docs-section">
				<p class="lead">深入了解Bootstrap底层结构的关键部分，包括我们让web开发变得更好、更快、更强壮的最佳实践。</p>

				<h3 id="overview-doctype">HTML5文档类型</h3>
				<p>Bootstrap使用到的某些HTML元素和CSS属性需要将页面设置为HTML5文档类型。在你项目中的每个页面都要参照下面的格式进行设置。</p>
				<div class="highlight">
					<pre>
						<code class="language-html xml">
							<span class="doctype">&lt;!DOCTYPE html&gt;</span>
<span class="tag">&lt;<span class="title">html</span> <span
								class="attribute">lang</span>=<span class="value">"zh-cn"</span>&gt;</span>
  ...
<span class="tag">&lt;/<span class="title">html</span>&gt;</span>
						</code>
					</pre>

				</div>
			</div>
		</div>



		
			</div>
		</div>
	</body>
</html>