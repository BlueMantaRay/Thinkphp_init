<?php
namespace Common\Lib;

use Think\Controller;
class AppController extends Controller {

	/**
	 +----------------------------------------------------------
	 * 智能判断输出格式 ajax 输出或 错误或成功跳转
	 +----------------------------------------------------------
	 * @access protected
	 +----------------------------------------------------------
	 * @param String $info 提示信息
	 * @param mixed $data 要返回的数据
	 * @param boolean $status 返回状态
	 +----------------------------------------------------------
	 * @return void
	 +----------------------------------------------------------
	 */
	protected function out($info='',$data = '', $jumpUrl = null) {
		$ajax = IS_AJAX;
		$_ajax = I('is_ajax', '');
		if ($ajax || $_ajax) {
			$data = array('info' => $info, 'data' => $data);
			exit(json_encode($data));
			return true;
		}
		$msg = $data;
		if ($info == 'ok' || $info == 'success' || $info == 'succ') {
			$this->success($msg, $jumpUrl);
		}
		if ($info == 'error' || $info == 'fail') {
			$this->error($msg, $jumpUrl);
		}
	}

}
