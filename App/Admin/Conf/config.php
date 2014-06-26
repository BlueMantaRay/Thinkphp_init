<?php
return array(
	//'配置项'=>'配置值'
	'TMPL_ACTION_ERROR'     =>  APP_PATH.MODULE_NAME.'/View/Public/error.html', // 默认错误跳转对应的模板文件
	'TMPL_ACTION_SUCCESS'   =>  APP_PATH.MODULE_NAME.'/View/Public/success.html', // 默认成功跳转对应的模板文件
	'TMPL_EXCEPTION_FILE'   =>  APP_PATH.MODULE_NAME.'/View/Public/exception.html',// 异常页面的模板文件

	// 配置文件增加设置
	/*
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
	*/

	'MENU_USER_AUTH_ON'				=> true,	// 是否开启权限认证
	'MENU_USER_AUTH_TYPE'			=>  2,		// 默认认证类型 1 登录认证 2 实时认证
	'MENU_USER_AUTH_KEY'           	=>  'admin_id',	// 用户认证SESSION标记
	'MENU_ADMIN_USER_AUTH_KEY'       =>  'adminname',	// 用户名在SESSION中的标记
	'MENU_ADMIN_AUTH_KEY'			=>  'admin',	// 无需要认证的用户名
	'MENU_AUTH_PWD_ENCODER'         =>  'md5',	// 用户认证密码加密方式
	'MENU_USER_AUTH_GATEWAY'        =>  '/Admin/Public/login',// 默认认证网关
	'MENU_NOT_AUTH_MODULE'          =>  'Public,Common',	// 默认无需认证模块
	'MENU_NOT_AUTH_CONTROLLER'      =>  'Public,Common,Index',	// 默认无需认证的控制器

	'MENU_TABLE_USER' 	=> 'admin', 	// 用户表名称,不要表前缀
	'MENU_TABLE_ROLE' 	=> 'role', 		// 角色表名称,不要表前缀
	'MENU_TABLE_NODE' 	=> 'menu', 		// 菜单节点表名称,不要表前缀
	'MENU_TABLE_ACCESS' => 'role_menu', 	// 角色和菜单节点的关系表,不要表前缀
	'MENU_TABLE_ROLE_USER'	=> 'role_admin',	// 用户和角色的关系表,不要表前缀

	'MENU_FIELD_USER_ID'		=> 'id',			// 用户表中表示用户的身份的字段
	'MENU_FIELD_USER_ID_OTHER'	=> 'admin_id',		// 用户id在其他表中的表示
	'MENU_FIELD_ROLE_ID'		=> 'id',			// 角色表中表示角色自增的字段
	'MENU_FIELD_ROLE_ID_OTHER'	=> 'role_id',		// 角色id在其他表中的表示
	'MENU_FIELD_NODE_ID'		=> 'id',			// 菜单节点表中表示角色自增的字段
	'MENU_FIELD_NODE_ID_OTHER'	=> 'menu_id',		// 菜单节点id在其他表中的表示



);