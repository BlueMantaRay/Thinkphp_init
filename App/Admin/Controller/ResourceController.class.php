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
use Admin\Controller\CommonController;
class ResourceController extends CommonController {

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