<?php
return array(
	//'配置项'=>'配置值'
	'TMPL_ACTION_ERROR'     =>  APP_PATH.MODULE_NAME.'/View/Public/error.html', // 默认错误跳转对应的模板文件
	'TMPL_ACTION_SUCCESS'   =>  APP_PATH.MODULE_NAME.'/View/Public/success.html', // 默认成功跳转对应的模板文件
	'TMPL_EXCEPTION_FILE'   =>  APP_PATH.MODULE_NAME.'/View/Public/exception.html',// 异常页面的模板文件

	// 配置文件增加设置
	'USER_AUTH_ON' 		=> true, //是否需要认证
	'USER_AUTH_TYPE' 	=> '1', //认证类型
	'USER_AUTH_KEY' 	=> '', //认证识别号
	'REQUIRE_AUTH_MODULE' => '', //需要认证模块
	'NOT_AUTH_MODULE' 	=> 'Public', // 无需认证模块
	'USER_AUTH_GATEWAY' => '/Admin/Public/login', // 认证网关
	'RBAC_USER_TABLE' 	=> 'think_admin', // 用户表名称
	'RBAC_ROLE_TABLE' 	=> 'think_role', // 角色表名称
	'RBAC_ACCESS_TABLE' => 'think_access', // 权限表名称
	'RBAC_NODE_TABLE' 	=> 'think_node', // 节点表名称

);