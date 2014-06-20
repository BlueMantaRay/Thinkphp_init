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
use Org\Util\Rbac;
class CommonController extends AppController {

	public function _initialize() {
		/*
		// 用户权限检查
        if (C('USER_AUTH_ON') && !in_array(MODULE_NAME, explode(',', C('NOT_AUTH_MODULE')))) {
            //import('@.ORG.Util.RBAC');	// 3.2以前的写法
            if (!Rbac::AccessDecision()) {
                //检查认证识别号
                if (!$_SESSION [C('USER_AUTH_KEY')]) {
                    //跳转到认证网关
                    redirect(PHP_FILE . C('USER_AUTH_GATEWAY'));
                }
                // 没有权限 抛出错误
                if (C('RBAC_ERROR_PAGE')) {
                    // 定义权限错误页面
                    redirect(C('RBAC_ERROR_PAGE'));
                } else {
                    if (C('GUEST_AUTH_ON')) {
                        $this->assign('jumpUrl', PHP_FILE . C('USER_AUTH_GATEWAY'));
                    }
                    // 提示错误信息
                    $this->error(L('_VALID_ACCESS_'));
                }
            }
        }
		*/
	}

	public function upload_img(){
		$config['exts'] = array('jpg', 'gif', 'png', 'jpeg');

		$this->_upload_one($_FILES['image_up'] ,$config);

	}

	public function _upload_one($files, $config = array()){
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
		}else{
			$model = D("resource"); // 实例化User对象
			unset($info['key']);
			unset($info['md5']);
			unset($info['sha1']);
			$id = $model->data($info)->add();
			$info['id'] = $id;
			$info['path'] = __ROOT__.'/Public'.ltrim($info['savepath'], '.').$info['savename'];
			// 上传成功
			$this->out('ok', $info);
		}
	}


}