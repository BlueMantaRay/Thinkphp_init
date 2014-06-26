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
class PublicController extends AppController {
    public function index(){

		$this->redirect('login');
    }

    public function login(){

    	$this->display();
    }

    public function check_login() {
		$adminname = I('adminname', '');
		$password = I('password', '');
		$verify_code = I('verify', '');
		if (empty($verify_code)) {
			$this->out('error', '请填写验证码');
		}
		if (empty($adminname)) {
			$this->out('error', '请填写用户名');
		}
		if (empty($password)) {
			$this->out('error', '请填写密码');
		}
		// array('verify_code'=>'当前验证码的值','verify_time'=>'验证码生成的时间戳')
		$verify = new \Think\Verify();
		if (!$verify->check($verify_code)) {
			$this->out('fail', '验证码不正确或已过期，请重试');
		}

		$model = D('Admin');
		$where['adminname'] = $adminname;
		$info = $model->where($where)->find();
		if (empty($info)) {
			$this->out('error', '用户名不存在');
		} else {
			if ($info['password'] != md5($password)) {
				$this->out('error', '密码不正确');
			} else {
				if ($info['status'] != 1) {
					$this->out('error', '用户被禁止');
				}
			}
		}

		session('adminname', $info['adminname']);
		session('admin_id', $info['id']);
		session('admin_info', $info);

		$model->where($info['id'])->save(array('login_time' => time()));

    	$this->out('ok', 'Success !');
    }

    public function logout(){
		unset($_SESSION['admin_id']);
		unset($_SESSION['adminname']);
		unset($_SESSION['admin_info']);

		$this->out('ok', '退出成功', 'login');
    }
    /**
     * 生成验证码
     */
    public function verify() {

    	$verify = new \Think\Verify();
    	$verify->entry();
    }

    public function show_menu(){

    }
}