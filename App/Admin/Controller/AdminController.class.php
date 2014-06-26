<?php
/**
 * ThinkPHP的命名空间使用规范。注意：命名空间定义必须写在所有的PHP代码之前声明，否则会出错
 * 命名空间和实际的控制器文件所在的路径是一致的，
 */
namespace Admin\Controller;

use Admin\Controller\CommonController;
use Org\Util\Rbac;
class AdminController extends CommonController {
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
			$where['adminname'] = array('like', "%{$keyword}%");
		}
		$this->assign('keyword', $keyword);

		$model = D('Admin');
		$count = $model->where ($where)->count (); // 查询满足要求的总记录数
		$page = new \Think\Page ($count, $this->page_num); // 实例化分页类 传入总记录数和每页显示的记录数
		// 进行分页数据查询 注意limit方法的参数要使用Page类的属性
		$order = 'id asc';
		$list = $model->where($where)->order($order)->limit($page->firstRow.','.$page->listRows)->select();

		$show = $page->pageShow (); // 分页显示输出

		$this->assign ( 'list', $list ); // 赋值数据集
		$this->assign ( 'page', $show ); // 赋值分页输出
		$this->display(); // 输出模板
    }

    public function admin_add(){
		$id = I('id', 0);

		$model = D('Admin');
		$info = false;
		$role_user = array();
		if ($id) {
			$info = $model->find($id);
			// 角色与用户关系
			$role_user = D('Role_admin')->where(array('admin_id' => $id))->getField('role_id', true);
		}

		$role_list = D('Role')->where(array('status' => 1))->select();
		if ($role_list) {
			foreach ($role_list as &$val) {
				if (in_array($val['id'], $role_user)) {
					$val['is_selected'] = 1;
				} else {
					$val['is_selected'] = 0;
				}
			}
		}
		$this->assign('role_list', $role_list);
		$this->assign('info', $info);
    	$this->display();
    }

    public function save(){
    	$id = I('id', 0);
    	$adminname = I('adminname', '');
    	$password = I('password', '');
    	$re_password = I('re_password', '');
    	$role_id = I('role_id', array());
		if (empty($adminname)) {
			$this->out('error', '请填写用户名');
		}
    	$model = D('Admin');
    	// 验证通过 可以进行其他数据操作
    	unset($_POST['role_id']);
	    if (empty($id)) {
	    	$_POST['password'] = md5($password);
	    	$_POST['re_password'] = md5($re_password);
	    	$_POST['add_time'] = time();
	    	$tmp = $model->create();
	    	if (!$tmp){
	    		// 如果创建失败 表示验证没有通过 输出错误提示信息
	    		$this->out('error', $model->getError());
	    	}
	    	$result = $model->add();
	    	$id = $result;
	    } else {
	    	$where['adminname'] = $adminname;
	    	$where['id'] = array('neq', $id);
	    	$info = $model->where($where)->find();
	    	if ($info) {
	    		$this->out('error', '该名称已经存在了！');
	    	}
	    	if (!empty($password) && !empty($re_password)) {
				if ($password != $re_password) {
					$this->out('error', '密码与确认密码不一致！');
				}
				$_POST['password'] = md5($password);
				unset($_POST['re_password']);
	    	} else {
				unset($_POST['password']);
				unset($_POST['re_password']);
	    	}
	    	$result = $model->save($_POST);
	    }

    	$model_role_admin = D('Role_admin');
    	// 先删除，再插入 ，角色与用户对应关系
    	$resu = $model_role_admin->where(array('admin_id' => $id))->delete();
	    if ($role_id) {
	    	if ($role_id) {
	    		foreach ($role_id as $val) {
	    			$data['role_id'] = $val;
	    			$data['admin_id'] = $id;
	    			$re = $model_role_admin->data($data)->add();
	    		}
	    	}
	    }
		if ($result || $resu || $re) {
			$this->out('ok', '保存成功');
		} else {
			$this->out('error', '保存失败');
		}
    }

    // 用户删除 加入回收站
    public function delete(){
    	$id = I('id', 0);
    	if (empty($id)) {
    		$this->out('error', '请选择要删除的记录！');
    	}
    	$model = D('Admin');

    	$arr = explode(',', $id);
    	$data['id'] = array('in', $arr);
    	$data['status'] = 2;
    	$result = $model->save($data);
    	if ($result) {
    		$this->out('ok', '删除成功');
    	} else {
    		$this->out('error', '删除失败');
    	}
    }

    // 用户还原
    public function reduction(){
    	$id = I('id', 0);
    	if (empty($id)) {
    		$this->out('error', '请选择要还原的记录！');
    	}
    	$model = D('Admin');

    	$arr = explode(',', $id);
    	$data['id'] = array('in', $arr);
    	$data['status'] = 1;
    	$result = $model->save($data);

    	if ($result) {
    		$this->out('ok', '还原成功');
    	} else {
    		$this->out('error', '还原失败');
    	}
    }

    // 用户彻底删除
    public function delete_really(){
    	$id = I('id', 0);
    	if (empty($id)) {
    		$this->out('error', '请选择要还原的记录！');
    	}
    	$model = D('Admin');
    	$arr = explode(',', $id);
    	$data['id'] = array('in', $arr);

    	$result = $model->where($data)->delete($data);

    	if ($result) {
    		$this->out('ok', '还原成功');
    	} else {
    		$this->out('error', '还原失败');
    	}
    }
}