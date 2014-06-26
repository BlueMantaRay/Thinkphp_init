<?php

namespace Common\Model;
use Think\Model;
class AdminModel extends Model {
	// 自动验证
	protected $_validate = array(
			array('adminname', 'require', '用户名称已经存在！',0,'unique',1), // 在新增的时候验证name字段是否唯一
			array('email', 'email', '邮箱格式不正确！',2), 			// 当值不为空的时候验证邮箱是否正常
			array('password', 'require', '请填写密码', 1, '', 1),		// 新增时
			array('re_password', 'require', '请填写确认密码', 1, '', 1),		// 新增时
			array('re_password','password','密码与确认密码不一致!',2,'confirm'), // 验证确认密码是否和密码一致
	);


}

?>