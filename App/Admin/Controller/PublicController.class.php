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
use Common\Lib\BaseController;
class PublicController extends BaseController {
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

    /**
     * 图片上传
     */
    public function upload_img(){
    	$config['exts'] = array('jpg', 'gif', 'png', 'jpeg');

    	$this->_upload_one($_FILES['image_up'] ,$config);

    }

    /**
     * 上传
     */
    public function _upload_one($files, $config = array()){
    	if (empty($_SESSION[C('MENU_USER_AUTH_KEY')])) {
    		// 没有登录
    		$this->out('error', '还没有登录');
    	}
    	$default_config = array(
    			'maxSize'    =>    3145728,
    			'rootPath'	 =>    './Public/',
    			'savePath'   =>    './upload/',
    			'saveName'   =>    array('uniqid',''),
    			'autoSub'    =>    true,
    			'subName'    =>    array('date','Ymd')
    	);
    	// 如果传入配置会覆盖上面的
    	if ($config && is_array($config)) {
    		$config = array_merge($config, $default_config);
    	} else {
    		$config = $default_config;
    	}

    	$upload = new \Think\Upload($config);

    	// 上传文件
    	$info   =   $upload->uploadOne($files);

    	if(!$info) {
    		// 上传错误提示错误信息
    		$this->out('error', $upload->getError());
    	}

    	$model = D("resource"); // 实例化对象,实例化的是App/Common/Model下的model
    	unset($info['key']);
    	unset($info['md5']);
    	unset($info['sha1']);
    	$info['add_time'] = time();
    	$id = $model->data($info)->add();
    	$info['id'] = $id;
    	$info['path'] = __ROOT__.'/Public'.ltrim($info['savepath'], '.').$info['savename'];
    	// 上传缩放
    	$type = I('type', 'thumb');
    	$width = I('width', 100);
    	$height = I('height', 100);
    	$thumb_img = '';
    	if ($type) {
    		$thumb_img = get_img($id, $width, $height, $type);
    	}
    	$info['thumb_img'] = $thumb_img;
    	// 上传成功
    	$this->out('ok', $info);

    }

    public function photo_del(){
    	$id = I('p_id', 0);
    	if (empty ( $id )) {
    		$this->out('ok', '删除成功');
    	}
    	$model = D("resource"); // 实例化对象,实例化的是App/Common/Model下的model
    	$info = $model->find($id);
    	if (empty($info)) {
    		$this->out('ok', '删除成功');
    	}
    	$img_path = 'Public'.ltrim($info['savepath'], '.').$info['savename'];
    	$dirname = dirname($img_path);
    	$filename = array_shift(explode('.', $info['savename']));
    	$search = $dirname.'/'.$filename.'_*.'.$info['ext'];
    	$arr = glob($search);
    	if ($arr) {
    		foreach ($arr as $v) {
    			$result = unlink($v);
    		}
    	}

    	if (file_exists($img_path)) {
    		$result = unlink($img_path);
    	}
    	$this->out('ok', '删除成功');
    }


}