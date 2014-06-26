<?php
/**
 * ThinkPHP的命名空间使用规范。注意：命名空间定义必须写在所有的PHP代码之前声明，否则会出错
 * 命名空间和实际的控制器文件所在的路径是一致的，
 */
namespace Admin\Controller;
/**
 * 引入 Common\Lib\AppController 命名空间便于直接使用
 * 等同于使用：class 类名 Common\Lib\AppController
 * (这里没有使用Thinkphp例子中写的Controller控制器，AppController是继承Controller的，这样你就可以在app中添加整个项目都会用到的方法了)
 */
use Common\Lib\AppController;
use Common\ORG\Menu;
class CommonController extends AppController {
	protected $page_num = 10;

	public function _initialize() {

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



	}

	/**
	 * 自动添加节点，正式运行后要注释掉
	 */
	protected function auto_add_node(){
		/*
		MODULE_NAME 当前模块名
		CONTROLLER_NAME 当前控制器名
		ACTION_NAME 当前操作名
		*/
		$module_name = MODULE_NAME;
		$controller_name = CONTROLLER_NAME;
		$action_name = ACTION_NAME;
		$model = D('Menu');
		$where['module_name'] = $module_name;
		$where['controller_name'] = $controller_name;
		$where['level'] = 2;
		$p_info = $model->where($where)->find();
		if (empty($p_info)) {
			$wh['module_name'] = $module_name;
			$wh['level'] = 1;
			$wh['pid'] = 0;
			$top_info = $model->where()->find();
			$where['title'] = $action_name;
			$where['pid'] = $top_info['id'];
			$where['path'] = $top_info['path'].'-'.$top_info['id'];
			$where['level'] = 2;
			$where['is_show'] = 0;
			$where['status'] = 1;
			$where['add_time'] = time();

			$p_id = $model->data($where)->add();
			$path = $where['path'].'-'.$p_id;
		} else {
			$p_id = $p_info['id'];
			$path = $p_info['path'].'-'.$p_info['id'];
		}
		$data['module_name'] = $module_name;
		$data['controller_name'] = $controller_name;
		$data['action_name'] = $action_name;
		$data['title'] = $action_name;
		$data['pid'] = $p_id;
		$data['path'] = $path;
		$data['level'] = 3;
		$data['is_show'] = 0;
		$data['status'] = 1;
		$data['add_time'] = time();
		$result = $model->data($data)->add();
	}



	public function add_log($a, $b, $data){

	}






}