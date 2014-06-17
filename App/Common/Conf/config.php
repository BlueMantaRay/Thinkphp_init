<?php
// 配置参数不区分大小写（因为无论大小写定义都会转换成小写），
$config_all = array(
	//'配置项'=>'配置值'
	'TMPL_ACTION_ERROR'     =>  APP_PATH.MODULE_NAME.'/View/Public/error.html', // 默认错误跳转对应的模板文件
	'TMPL_ACTION_SUCCESS'   =>  APP_PATH.MODULE_NAME.'/View/Public/success.html', // 默认成功跳转对应的模板文件
	'TMPL_EXCEPTION_FILE'   =>  APP_PATH.MODULE_NAME.'/View/Public/exception.html',// 异常页面的模板文件


	// 模板配置
	'TMPL_CACHE_ON'         =>  true,       // 是否开启模板编译缓存,设为false则每次都会重新编译
	'TMPL_CACHE_TIME'       =>  0,          // 模板缓存有效期 0 为永久，(以数字为值，单位:秒)
	'TMPL_L_DELIM'          =>  '{',        // 模板引擎普通标签开始标记
	'TMPL_R_DELIM'          =>  '}',        // 模板引擎普通标签结束标记

	// url配置
	'URL_CASE_INSENSITIVE'  =>  true,   // 默认false 表示URL区分大小写 true则表示不区分大小写
	'URL_MODEL'             =>  1,       // URL访问模式,可选参数0、1、2、3,代表以下四种模式：// 0 (普通模式); 1 (PATHINFO 模式); 2 (REWRITE  模式); 3 (兼容模式)  默认为PATHINFO 模式

);

switch ($_SERVER['SERVER_NAME']) {
	case 'localhost':
		$env = 'dev';
		break;

	default:
		$env = 'dev';
		break;
}
$config_env = require $env.'_config.php';

return array_merge($config_all, $config_env);