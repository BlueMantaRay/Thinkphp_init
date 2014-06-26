<?php
/**
 * ThinkPHP的命名空间使用规范。注意：命名空间定义必须写在所有的PHP代码之前声明，否则会出错
 * 命名空间和实际的控制器文件所在的路径是一致的，
 */
namespace Admin\Controller;

use Admin\Controller\CommonController;
class MenuController extends CommonController {
	protected $page_num = 10;

    public function index(){
    	$status = I('status', 0);
    	$keyword = I('keyword', '');
    	$list = array();
    	$where = array ();
    	if ($status) {
    		$where['status'] = $status;
    	}
    	$this->assign('status', $status);
    	if ($keyword) {
    		$where['title'] = array('like', "%{$keyword}%");
    	}
    	$this->assign('keyword', $keyword);

    	$model = D('Menu');
    	$count = $model->where ($where)->count (); // 查询满足要求的总记录数
    	$page = new \Think\Page ($count, $this->page_num); // 实例化分页类 传入总记录数和每页显示的记录数
    	// 进行分页数据查询 注意limit方法的参数要使用Page类的属性
    	$order = 'id asc';
    	$field = array('id','title','module_name','controller_name','action_name','icon','param','pid','path','level','is_show','view_order','status',"concat(path,'-',id) as bpath");
    	$list = $model
	    	->where($where)
	    	->limit($page->firstRow.','.$page->listRows)
	    	->field($field)
	    	->order('bpath ASC,id DESC')
	    	->select();

    	$show = $page->pageShow (); // 分页显示输出

    	$this->assign ( 'list', $list ); // 赋值数据集
    	$this->assign ( 'page', $show ); // 赋值分页输出
    	$this->display(); // 输出模板
    }

    public function menu_add(){
    	$id = I('id', 0);

    	$model = D('Menu');
    	$info = false;
    	if ($id) {
    		$info = $model->find($id);
    	}

		$p_list = $this->get_level_node();

    	$this->assign('p_list', $p_list);
    	$this->assign('info', $info);
    	$this->display();
    }


    public function menu_save(){
    	$id = I('id', 0);
    	$title = I('title', '');
    	$remark = I('remark', '');
    	$pid = I('pid', 0);
    	if (empty($title)) {
    		$this->out('error', '请填写标题');
    	}
		if (empty($_POST['module_name'])) {
			$_POST['module_name'] = 'Admin';
		} else {
			$_POST['module_name'] = ucfirst($_POST['module_name']);
		}
		if (!empty($_POST['controller_name'])) {
			$_POST['controller_name'] = ucfirst($_POST['controller_name']);
		}
    	if (empty($remark)) {
			$_POST['remark'] = $title;
    	}
    	$model = D('Menu');
    	if (empty($pid)) {
			$_POST['level'] = 1;
			$_POST['path'] = 0;
    	} else {
    		// 如果有上级，则它的层级是再它上级的基础上加1
			$p_info = $model->find($pid);
			$_POST['level'] = ($p_info['level'] + 1);
			$_POST['path'] = ($p_info['path'].'-'.$pid);
    	}

    	// 验证通过 可以进行其他数据操作
    	if (empty($id)) {
    		$_POST['add_time'] = time();
    		$tmp = $model->create();
    		if (!$tmp){
    			// 如果创建失败 表示验证没有通过 输出错误提示信息
    			$this->out('error', $model->getError());
    		}
    		$result = $model->add();
    		$id = $result;
    	} else {

    		$result = $model->save($_POST);
    	}

    	if ($result) {
    		$this->out('ok', '保存成功');
    	} else {
    		$this->out('error', '保存失败');
    	}
    }

    /**
     * 获取有层级的节点
     * @param int $pid
     * @return array
     */
    protected function get_level_node($pid = 0, $is_show = 0, $role_node_list = array()){
		$model = D('Menu');
		if (empty($pid)) {
			$pid = 0;
		}
		if ($is_show) {
			$where['is_show'] = 1;
		}
		$where['pid'] = $pid;
		$order = 'view_order desc, id asc';
		$list = $model->where($where)->order($order)->select();
		if ($list) {
			foreach ($list as &$val) {
				if ($role_node_list && is_array($role_node_list)) {
					if (in_array($val['id'], $role_node_list)) {
						$val['is_selected'] = 1;
					} else {
						$val['is_selected'] = 0;
					}
				}
				$val['child'] = $this->get_level_node($val['id'], $is_show, $role_node_list);
			}
			unset($val);
		}
		return $list;
    }


    // 菜单删除 加入回收站
    public function menu_delete(){
    	$id = I('id', 0);
    	if (empty($id)) {
    		$this->out('error', '请选择要删除的记录！');
    	}
    	$model = D('Menu');

    	$arr = explode(',', $id);
    	$data['id'] = array('in', $arr);
    	$data['status'] = 0;
    	$result = $model->save($data);

    	if ($result) {
    		$this->add_log('menu', 'update', $id);
    		$this->out('ok', '删除成功');
    	} else {
    		$this->out('error', '删除失败');
    	}
    }

    // 菜单还原
    public function menu_reduction(){
    	$id = I('id', 0);
    	if (empty($id)) {
    		$this->out('error', '请选择要还原的记录！');
    	}
    	$model = D('Menu');

    	$arr = explode(',', $id);
    	$data['id'] = array('in', $arr);
    	$data['status'] = 1;
    	$result = $model->save($data);

    	if ($result) {
    		$this->add_log('menu', 'update', $id);
    		$this->out('ok', '还原成功');
    	} else {
    		$this->out('error', '还原失败');
    	}
    }

    // 菜单彻底删除
    public function menu_delete_really(){
    	$id = I('id', 0);
    	if (empty($id)) {
    		$this->out('error', '请选择要还原的记录！');
    	}
    	$model = D('Menu');
    	$arr = explode(',', $id);
    	$data['id'] = array('in', $arr);

    	$result = $model->where($data)->delete($data);

    	if ($result) {
    		$this->add_log('menu', 'delete', $id);
    		$this->out('ok', '还原成功');
    	} else {
    		$this->out('error', '还原失败');
    	}
    }

    // 角色列表
    public function role_list(){
    	$status = I('status', -1);
    	$search_id = I('search_id', 0, 'intval');
    	$search_name = I('search_name', '');
    	$order = I('order', 0);				// 排序 0：降序 1：升序
    	$where = array();
    	// 按状态
    	if ($status == 0) {
    		$where['status'] = 0;
    	} else if ($status == 1) {
    		$where['status'] = 1;
    	} else {
    		$where['status'] = array('in', array(0, 1));
    	}
    	$this->assign('status', $status);
    	// 按id搜索
    	if ($search_id) {
    		$where['id'] = $search_id;
    		// 将变量再分配到模板中
    		$this->assign('search_id', $search_id);
    	}
    	// 按名称搜索
    	if ($search_name) {
    		$where['name'] = array('like', "%{$search_name}%");
    		// 将变量再分配到模板中
    		$this->assign('search_name', $search_name);
    	}
    	// 排序
    	if ($order == 1) {
    		$order = 'id ASC';
    		$this->assign('order', 0);
    	} else {
    		$order = 'id DESC';
    		$this->assign('order', 1);
    	}
    	$model = D('Role');
    	$count = $model->where ($where)->count (); // 查询满足要求的总记录数
    	$page = new \Think\Page ($count, $this->page_num); // 实例化分页类 传入总记录数和每页显示的记录数
    	// 进行分页数据查询 注意limit方法的参数要使用Page类的属性
    	$order = 'id asc';
    	$list = $model->where($where)->order($order)->limit($page->firstRow.','.$page->listRows)->select();

    	$show = $page->pageShow (); // 分页显示输出

    	$this->assign('list', $list);
    	$this->assign('page', $show);
    	$this->display();
    }

    // 添加编辑角色
    public function role_add(){
    	$id = I('id', 0, 'intval');
    	$info = array();
    	$role_node_list = array();
    	if ($id) {
    		$model = D('Role');
    		$info = $model->find($id);
    		// 角色与菜单关系
    		$role_node_list = D('Role_menu')->where(array('role_id' => $id))->getField('menu_id', true);
    	}
		$menu_list = $this->get_level_node(0, 0, $role_node_list);

		$this->assign('menu_list', $menu_list);
    	$this->assign('id', $id);
    	$this->assign('info', $info);
    	$this->display();
    }

    // 角色保存
    public function role_save(){
    	$id = I('id', 0);
    	$name = I('name', '');
    	$remark = I('remark', '');
    	$menu_id = I('menu_id', array());

    	if (empty($remark)) {
    		$_POST['remark'] = $name;
    	}
    	$model = D('Role');
    	$where['name'] = $name;
    	$where['id'] = array('neq', $id);
    	$info = $model->where($where)->find();
    	if ($info) {
    		$this->out('error', '该名称已经存在了！');
    	}
    	unset($_POST['menu_id']);
    	if (empty($id)) {
    		$tmp = $model->create();
    		$result = $model->add();
    		$id = $result;
    		$this->add_log('role', 'add', $id);
    	} else {
    		$result = $model->save($_POST);
    		$this->add_log('role', 'update', $id);
    	}
    	$model_role_menu = D('role_menu');
    	// 先删除，再插入 ，角色与菜单对应关系
    	$resu = $model_role_menu->where(array('role_id' => $id))->delete();
    	if ($menu_id) {
    		foreach ($menu_id as $val) {
    			$data['role_id'] = $id;
    			$data['menu_id'] = $val;
    			$re = $model_role_menu->data($data)->add();
    		}
    	}
    	if ($result || $resu || $re) {
    		$this->out('ok', '保存成功');
    	} else {
    		$this->out('error', '保存失败');
    	}
    }

    // 角色删除 加入回收站
    public function role_delete(){
    	$id = I('id', 0);
    	if (empty($id)) {
    		$this->out('error', '请选择要删除的记录！');
    	}
    	$model = D('Role');

    	$arr = explode(',', $id);
    	$data['id'] = array('in', $arr);
    	$data['status'] = 0;
    	$result = $model->save($data);

    	if ($result) {
    		$this->add_log('role', 'update', $id);
    		$this->out('ok', '删除成功');
    	} else {
    		$this->out('error', '删除失败');
    	}
    }

    // 角色还原
    public function role_reduction(){
    	$id = I('id', 0);
    	if (empty($id)) {
    		$this->out('error', '请选择要还原的记录！');
    	}
    	$model = D('Role');

    	$arr = explode(',', $id);
    	$data['id'] = array('in', $arr);
    	$data['status'] = 1;
    	$result = $model->save($data);

    	if ($result) {
    		$this->add_log('role', 'update', $id);
    		$this->out('ok', '还原成功');
    	} else {
    		$this->out('error', '还原失败');
    	}
    }

    // 角色彻底删除
    public function role_delete_really(){
    	$id = I('id', 0);
    	if (empty($id)) {
    		$this->out('error', '请选择要还原的记录！');
    	}
    	$model = D('Role');
    	$arr = explode(',', $id);
    	$data['id'] = array('in', $arr);

    	$result = $model->where($data)->delete($data);

    	if ($result) {
    		$this->add_log('role', 'delete', $id);
    		$this->out('ok', '还原成功');
    	} else {
    		$this->out('error', '还原失败');
    	}
    }
}