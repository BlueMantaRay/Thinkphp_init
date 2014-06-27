<?php
/**
 * Rbac, 在thinkphp基础上修改来的
 * @author user
 *
 */
namespace Admin\ORG;

/**
 +------------------------------------------------------------------------------
 * 基于角色的数据库方式验证类
 +------------------------------------------------------------------------------
 */
/*

CREATE TABLE IF NOT EXISTS `think_admin` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增id',
  `adminname` char(60) NOT NULL COMMENT '管理员用户名',
  `password` char(32) NOT NULL COMMENT '密码',
  `email` char(60) NOT NULL COMMENT '邮箱',
  `gender` tinyint(1) NOT NULL COMMENT '性别：1男、2女',
  `tel` varchar(11) NOT NULL COMMENT '手机号',
  `pic` varchar(255) NOT NULL COMMENT '头像的id，在resource表中',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态 1：正常 2：删除',
  `login_time` int(11) NOT NULL COMMENT '最后登录时间',
  `login_ip` char(30) NOT NULL COMMENT '最后登录ip',
  `add_time` int(11) NOT NULL COMMENT '添加时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `admin_name` (`adminname`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='管理员表' AUTO_INCREMENT=1 ;


--
-- 表的结构 `think_menu`
--

CREATE TABLE IF NOT EXISTS `think_menu` (
  `id` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(125) NOT NULL COMMENT '标题',
  `icon` varchar(125) NOT NULL COMMENT '图标',
  `module_name` varchar(125) NOT NULL COMMENT '模块名',
  `controller_name` varchar(125) NOT NULL COMMENT '控制器名',
  `action_name` varchar(125) NOT NULL COMMENT '方法名',
  `param` varchar(125) NOT NULL COMMENT '参数',
  `replace` varchar(125) NOT NULL COMMENT '替换',
  `remark` varchar(255) NOT NULL COMMENT '介绍',
  `pid` int(11) NOT NULL COMMENT '上级id',
  `path` varchar(255) NOT NULL DEFAULT '0' COMMENT 'pid层级',
  `level` tinyint(1) unsigned NOT NULL COMMENT '层级',
  `view_order` int(11) NOT NULL DEFAULT '0' COMMENT '排序，越大越在前',
  `is_show` tinyint(4) NOT NULL DEFAULT '1' COMMENT '是否显示 1：显示',
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '状态 1：正常 2：删除',
  `add_time` int(11) NOT NULL COMMENT '添加时间',
  PRIMARY KEY (`id`),
  KEY `level` (`level`),
  KEY `pid` (`pid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='rbac 菜单、节点表' AUTO_INCREMENT=1 ;


--
-- 表的结构 `think_role`
--

CREATE TABLE IF NOT EXISTS `think_role` (
  `id` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `pid` smallint(6) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态 1：正常 2：删除',
  `remark` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `pid` (`pid`),
  KEY `status` (`status`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='角色表' AUTO_INCREMENT=1 ;


--
-- 表的结构 `think_role_admin`
--

CREATE TABLE IF NOT EXISTS `think_role_admin` (
  `role_id` int(11) NOT NULL,
  `admin_id` int(11) NOT NULL,
  KEY `group_id` (`role_id`),
  KEY `user_id` (`admin_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='角色和用户的关系表';


--
-- 表的结构 `think_role_menu`
--

CREATE TABLE IF NOT EXISTS `think_role_menu` (
  `role_id` int(10) unsigned NOT NULL,
  `menu_id` int(10) unsigned NOT NULL,
  `level` tinyint(1) NOT NULL,
  `module` varchar(125) NOT NULL,
  KEY `groupId` (`role_id`),
  KEY `nodeId` (`menu_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='角色和节点菜单的关系表';

*/


/* // 配置项
array(
		'MENU_USER_AUTH_ON'				=> true,	// 是否开启权限认证
		'MENU_USER_AUTH_TYPE'			=>  2,		// 默认认证类型 1 登录认证 2 实时认证
		'MENU_USER_AUTH_KEY'           	=>  'admin_id',	// 用户认证SESSION标记
		'MENU_ADMIN_USER_AUTH_KEY'       =>  'adminname',	// 用户名在SESSION中的标记
		'MENU_ADMIN_AUTH_KEY'			=>  'admin',	// 无需要认证的用户名
		'MENU_AUTH_PWD_ENCODER'         =>  'md5',	// 用户认证密码加密方式
		'MENU_USER_AUTH_GATEWAY'        =>  '/Admin/Public/login',// 默认认证网关
		'MENU_NOT_AUTH_MODULE'          =>  'Public,Common',	// 默认无需认证模块
		'MENU_NOT_AUTH_CONTROLLER'      =>  'Public,Common',	// 默认无需认证的控制器

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
*/


/*	// 验证的写法

		if (empty($_SESSION[C('MENU_USER_AUTH_KEY')])) {
			// 没有登录
			$this->redirect(C('MENU_USER_AUTH_GATEWAY'));
		}
		// 当前的操作
		$where['module_name'] = MODULE_NAME;
		$where['controller_name'] = CONTROLLER_NAME;
		$where['action_name'] = ACTION_NAME;
		$where['param'] = I('param', '');
		$active_info = D(C('MENU_TABLE_NODE'))->where($where)->find();

		if (empty($active_info)) {
			// 自动添加节点，正式运行后要注释掉
			$this->auto_add_node();
			$this->out('error', '对不起，未找到对应的操作', __MODULE__.'/Index/index');
		} else {
			// 如果有需要对标题替换的
			if ($active_info['replace']) {
				$replace_arr = explode(';', $active_info['replace']);
				if ($replace_arr) {
					$find = $replace_arr[0];
					$replace = $replace_arr[1];
					$active_info['title'] = str_ireplace($find, $replace, $active_info['title']);
				}
			}
		}
		// 获取菜单并分配到页面
		$_ajax = I('is_ajax', '');
		if ( !IS_AJAX  || $_ajax ) {
			$admin_menu_list = Menu::get_menu_list($active_info);
			$this->assign('admin_menu_list', $admin_menu_list);
			$this->assign('active_info', $active_info);
		}
		// 开启了验证
		if (C('MENU_USER_AUTH_ON')) {
			// 并且当前操作不在，无需认证模块，无需认证的控制器 中
			if (!in_array(MODULE_NAME, explode(',', C('MENU_NOT_AUTH_MODULE'))) && !in_array(CONTROLLER_NAME, explode(',', C('MENU_NOT_AUTH_CONTROLLER')))) {
				// 用户权限检查
				if (!Menu::auth($active_info)) {
					$this->out('ok', '对不起，您没有该操作的权限', __MODULE__.'/Index/index');
				}
			}
		}

 */

define('MENU_USER_AUTH_ON' ,  C('MENU_USER_AUTH_ON')  );	// 是否开启权限认证
define('MENU_USER_AUTH_TYPE',  C('MENU_USER_AUTH_TYPE')  );	// 默认认证类型 1 登录认证 2 实时认证
define('MENU_USER_AUTH_KEY',   C('MENU_USER_AUTH_KEY')  );	// 用户认证SESSION标记
define('MENU_ADMIN_USER_AUTH_KEY',   C('MENU_ADMIN_USER_AUTH_KEY')  );	// 用户名在SESSION中的标记
define('MENU_ADMIN_AUTH_KEY',  C('MENU_ADMIN_AUTH_KEY')  );	// 无需要认证的用户名
define('MENU_AUTH_PWD_ENCODER',  C('MENU_AUTH_PWD_ENCODER')  );	// 用户认证密码加密方式
define('MENU_USER_AUTH_GATEWAY',  C('MENU_USER_AUTH_GATEWAY')  );// 默认认证网关
define('MENU_NOT_AUTH_MODULE',  C('MENU_NOT_AUTH_MODULE')  );	// 默认无需认证模块
define('MENU_NOT_AUTH_CONTROLLER',  C('MENU_NOT_AUTH_CONTROLLER')  );		// 默认无需认证的控制器
define('MENU_TABLE_USER',   C('MENU_TABLE_USER')  );
define('MENU_TABLE_ROLE',   C('MENU_TABLE_ROLE')  );
define('MENU_TABLE_NODE',   C('MENU_TABLE_NODE')  );
define('MENU_TABLE_ACCESS',   C('MENU_TABLE_ACCESS')  );
define('MENU_TABLE_ROLE_USER',   C('MENU_TABLE_ROLE_USER')  );
define('MENU_FIELD_USER_ID',   C('MENU_FIELD_USER_ID')  );
define('MENU_FIELD_USER_ID_OTHER',   C('MENU_FIELD_USER_ID_OTHER')  );
define('MENU_FIELD_ROLE_ID',   C('MENU_FIELD_ROLE_ID')  );
define('MENU_FIELD_ROLE_ID_OTHER',   C('MENU_FIELD_ROLE_ID_OTHER')  );
define('MENU_FIELD_NODE_ID',   C('MENU_FIELD_NODE_ID')  );
define('MENU_FIELD_NODE_ID_OTHER',   C('MENU_FIELD_NODE_ID_OTHER')  );

class Menu {

	/**
	 * 验证权限
	 * @param array $active_info	// 当前请求的链接在节点菜单表中对应的信息
	 * @return boolean
	 */
	public static function auth($active_info){
		// 当前登录的用户
		$admin_id = $_SESSION [MENU_USER_AUTH_KEY];
		// 如果需要验证权限
		if (MENU_USER_AUTH_ON) {
			// 如果是超级管理员
			if ($_SESSION[MENU_ADMIN_USER_AUTH_KEY] == MENU_ADMIN_AUTH_KEY) {
				return true;
			}
			//
			$role_list = self::get_role_list($admin_id);
			$role_node_id_list = self::get_access($role_list);
			return self::check_node_auth($role_node_id_list, $active_info[MENU_FIELD_NODE_ID]);
		} else {
			return true;
		}
	}

	/**
	 * 获取当前用户允许操作的菜单列表
	 * @param array $active_info
	 * @return mixed|unknown
	 */
	public static function get_menu_list($active_info){
		// 当前登录的用户
		$admin_id = $_SESSION [MENU_USER_AUTH_KEY];
		// 如果是登录认证
		if (MENU_USER_AUTH_TYPE == 1) {
			if ($_SESSION['admin_node_list']) {
				return unserialize($_SESSION['admin_node_list']);
			}
		}
		// 获取所有节点相关数据
		$node_list = self::get_node_data();
		// 如果需要验证权限,并且不是超级管理员，要过滤菜单
		if (MENU_USER_AUTH_ON && $_SESSION[MENU_ADMIN_USER_AUTH_KEY] != MENU_ADMIN_AUTH_KEY) {
			// 获取当前用户的所有角色列表
			$role_list = self::get_role_list($admin_id);
			// 获取角色对应的节点菜单id列表
			$role_node_id_list = self::get_access($role_list);
			// 过滤菜单
			$node_list = self::get_auth_node($node_list, $role_node_id_list);
		}
		// 对菜单进行排序
		$node_list = self::node_sort($node_list, $active_info);

		$_SESSION['admin_node_list'] = serialize($node_list);
		return $node_list;
	}

	/**
	 * 获取所有的节点菜单数据
	 * @return array
	 */
	protected static function get_node_data(){
		// 如果是登录认证
		if (MENU_USER_AUTH_TYPE == 1) {
			if ($_SESSION['admin_node_data']) {
				return unserialize($_SESSION['admin_node_data']);
			}
		}
		$data = D(MENU_TABLE_NODE)
				->where(array('status' => 1))
				->order('view_order DESC, id ASC')
				->select();

		$_SESSION['admin_node_data'] = serialize($data);
		return $data;
	}

	/**
	 * 获取当前用户的角色列表
	 * @param int $admin_id
	 * @return array
	 */
	protected static function get_role_list($admin_id){
		// 如果是登录认证
		if (MENU_USER_AUTH_TYPE == 1) {
			if ($_SESSION['admin_role_list']) {
				return unserialize($_SESSION['admin_role_list']);
			}
		}
		// 所有正常角色id
		$all_role_list = D(MENU_TABLE_ROLE)
						->where(array('status' => 1))
						->getField('id', true);
		// 获取用户的角色id，是个一维数组
		$where[MENU_FIELD_USER_ID_OTHER] = $admin_id;
		$where[MENU_FIELD_ROLE_ID_OTHER] = array('in', $all_role_list);
		$role_list = D(MENU_TABLE_ROLE_USER)
					->where($where)
					->getField( MENU_FIELD_ROLE_ID_OTHER , true);

		$_SESSION['admin_role_list'] = serialize($role_list);
		return $role_list;
	}

	/**
	 * 根据角色列表获取对应的节点菜单的id列表
	 * @param array $role_list
	 * @return array
	 */
	protected static function get_access($role_list){
		// 如果是登录认证
		if (MENU_USER_AUTH_TYPE == 1) {
			if ($_SESSION['admin_access']) {
				return unserialize($_SESSION['admin_access']);
			}
		}
		// 获取用户的角色id，是个一维数组
		$where[MENU_FIELD_ROLE_ID_OTHER] = array('in', $role_list);
		$role_node_id_list = D(MENU_TABLE_ACCESS)
					->where($where)
					->getField(MENU_FIELD_NODE_ID_OTHER, true);
		$_SESSION['admin_access'] = serialize($role_node_id_list);
		return $role_node_id_list;
	}

	/**
	 * 对节点菜单过滤，返回当前用户允许操作的节点菜单
	 * @param array $all_node_list			// 所有的节点菜单
	 * @param array $role_node_id_list		// 当前用户所属角色允许操作的节点id列表
	 * @return array
	 */
	protected static function get_auth_node($all_node_list, $role_node_id_list){
		// 如果是登录认证
		$list = array();
		if ($all_node_list && is_array($all_node_list) && $role_node_id_list) {
			foreach ($all_node_list as $val) {
				if (in_array($val['id'], $role_node_id_list)) {
					$list[] = $val;
				}
			}
		}
		return $list;
	}

	/**
	 * 检测当前用户是否有节点菜单权限
	 * @param array $role_node_id_list	// 当前用户所属角色允许操作的节点id列表
	 * @param int $active_id			// 当前操作的节点id
	 * @return boolean
	 */
	protected function check_node_auth($role_node_id_list, $active_id){
		if (in_array($active_id, $role_node_id_list)) {
			return true;
		} else {
			return false;
		}
	}


	/**
	 * 对节点菜单进行排序
	 * @param array $menu_list		// 节点菜单列表
	 * @param array $active_info	// 当前操作的节点菜单信息
	 * @param number $p_id			// 当前操作的上级id
	 * @return array
	 */
	protected static function node_sort($menu_list, $active_info, $p_id = 0){
		if (empty($menu_list)) {
			return array();
		}
		$active_id = $active_info[MENU_FIELD_NODE_ID];
		$path = $active_info['path'];
		$path_arr = explode('-', $path);
		array_push($path_arr, $active_id);
		$list = array();
		if ($menu_list) {
			$flag = true;
			foreach ($menu_list as $val) {
				if ($val['is_show'] != 1) {
					continue;
				}
				if ($val['pid'] == $p_id) {
					$info = $val;
					if (in_array($val['id'], $path_arr)) {
						$info['is_active'] = 1;
						$flag = false;
					} else {
						$info['is_active'] = 0;
					}
					$info['child'] = self::node_sort($menu_list, $active_info, $val['id']);
					$list[] = $info;
				}
			}
			if ($list && $flag && $p_id == 0) {
				$list[0]['is_active'] = 1;
			}
			unset($info);
		}
		return $list;
	}

}