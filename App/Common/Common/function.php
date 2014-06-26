<?php
/**
 *   common.func.php
 * ============================================================================
 *     公共函数库
 * ----------------------------------------------------------------------------
 *
 * ============================================================================
 * $Author: 刘县栋 (lxd0120lxd@163.com) $
 * $Date:  2013-3-9 下午1:52:14 $
*/

/**
 * 输出各种类型的数据，调试程序时打印数据使用。
 * @param	mixed	参数：可以是一个或多个任意变量或值
 */
function p(){
	$args=func_get_args();  //获取多个参数
	if(count($args)<1){
		return '没有参数';
	}
	echo '<div style="width:100%;text-align:left"><pre>';
	//多个参数循环输出
	foreach($args as $arg){
		if(is_array($arg)){
			var_dump($arg);
			echo '<br>';
		}else if(is_string($arg)){
			var_dump($arg);
			echo '<br>';
		}else{
			var_dump($arg);
			echo '<br>';
		}
	}
	echo '</pre></div>';
}


/**
 * 检测邮箱是否正确 为了判断取反，正确返回false,不正确返回true
 * @param $mail
 */
function check_mail($mail){
	$pattern = '/^\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/i';
	$result = preg_match($pattern, $mail);
	if ($result) {
		return false;
	} else {
		return true;
	}
}
/**
 * 检测是否为正确url地址 为了判断取反，正确返回false,不正确返回true
 * @param $mail
 */
function check_url($url){
	$pattern = '/^(http|https|ftp):\/\/([A-Z0-9][A-Z0-9_-]*(?:\.[A-Z0-9][A-Z0-9_-]*)+):?(\d+)?\/?/i';
	$result = preg_match($pattern, $url);
	if ($result) {
		return false;
	} else {
		return true;
	}
}

/**
 * 检测手机号是否正确 为了判断取反，正确返回false，不正确返回true
 * @param $phone
 */
function check_phone($phone){
	$pattern = '/^(13\d{9})|(15[0-35-9]\d{8})|(17[0-35-9]\d{8})|(18[0-9]\d{8})$/';
	$result = preg_match($pattern, $phone);
	if ($result) {
		return false;
	} else {
		return true;
	}
}

/**
 * 检测是否为数字
 * @param $num
 */
function check_num($num){
	$result = is_numeric($num);
	if ($result) {
		return false;
	} else {
		return true;
	}
}

/**
 * 检测时间是否有效
 * @param $str
 * @param $format
 */
function check_time($str, $format="Y-m-d H:i:s"){
	$unixTime=strtotime($str);
	$checkDate= date($format, $unixTime);
	if($checkDate == $str){
		return true;
	} else {
		return false;
	}
}

/**
 * 文件尺寸转换，将大小将字节转为各种单位大小
 * @param	int	$bytes	字节大小
 * @return	string	转换后带单位的大小
 */
function to_size($bytes) {       	 	     //自定义一个文件大小单位转换函数
	if ($bytes >= pow(2,40)) {      		     //如果提供的字节数大于等于2的40次方，则条件成立
		$return = round($bytes / pow(1024,4), 2);    //将字节大小转换为同等的T大小
		$suffix = "TB";                        	     //单位为TB
	} elseif ($bytes >= pow(2,30)) {  		     //如果提供的字节数大于等于2的30次方，则条件成立
		$return = round($bytes / pow(1024,3), 2);    //将字节大小转换为同等的G大小
		$suffix = "GB";                              //单位为GB
	} elseif ($bytes >= pow(2,20)) {  		     //如果提供的字节数大于等于2的20次方，则条件成立
		$return = round($bytes / pow(1024,2), 2);    //将字节大小转换为同等的M大小
		$suffix = "MB";                              //单位为MB
	} elseif ($bytes >= pow(2,10)) {  		     //如果提供的字节数大于等于2的10次方，则条件成立
		$return = round($bytes / pow(1024,1), 2);    //将字节大小转换为同等的K大小
		$suffix = "KB";                              //单位为KB
	} else {                     			     //否则提供的字节数小于2的10次方，则条件成立
		$return = $bytes;                            //字节大小单位不变
		$suffix = "Byte";                            //单位为Byte
	}
	return $return ." " . $suffix;                       //返回合适的文件大小和单位
}






/**
 * 获取各种规格的图片，如果有同种规格的图片直接返回，没有将生成
 * @param string $img		// 要缩放的图片
 * @param int $width		// 是要缩放到的宽
 * @param int $height		// 要缩放到的高
 * @param string $type		// 缩放类型 thumb是缩放 merge是融图 cut是修剪,fixed是固定大小
 * @param string $default	// 如果图片为空时的默认图片
 * @return string $newName 	// 缩放后的文件名
 */
function get_img($id, $width = 100, $height = 100, $type = 'thumb', $default = ''){
	$info = get_img_info($id);
	if (empty($info)) {
		return $default;
	}
	$img_path = 'Public'.ltrim($info['savepath'], '.').$info['savename'];
	if (!file_exists($img_path)) {
		return $default;
	}
	$type = strtolower($type);
	$type_arr = array('thumb', 'merge', 'cut', 'fixed');
	if (!in_array($type, $type_arr)) {
		$type = 'thumb';
	}
	if (empty($width)) {
		$width = 100;
	}
	if (empty($height)) {
		$height = 100;
	}
	$dirname = dirname($img_path);
	$filename = array_shift(explode('.', $info['savename']));
	$name = $filename.'_'.$type.'_'.$width.$height.'.'.$info['ext'];
	$save = $dirname.'/'.$name;
	if (file_exists($save)) {
		return __ROOT__.'/'.$save;
	}
	$image = new \Think\Image();
	$image->open($img_path);
	switch ($type) {
		case 'merge':
			// 生成一个缩放后填充的缩略图并保存
			$image->thumb($width, $height,\Think\Image::IMAGE_THUMB_FILLED)->save($save);
			break;
		case 'cut':
			// 生成一个缩放后填充的缩略图并保存
			$image->thumb($width, $height,\Think\Image::IMAGE_THUMB_CENTER)->save($save);
			break;
		case 'fixed':
			// 生成一个缩放后填充的缩略图并保存
			$image->thumb($width, $height,\Think\Image::IMAGE_THUMB_FIXED)->save($save);
			break;
		default:
			// 单纯的缩放
			$image->thumb($width, $height)->save($save);
			break;
	}
	return __ROOT__.'/'.$save;
}



/**
 * 获取图片信息
 * @param int $id
 * @return array
 */
function get_img_info($id, $key = ''){
	if (empty($id)) {
		return false;
	}

	$model = D("resource"); // 实例化对象,实例化的是App/Common/Model下的model
	$info = $model->find($id);
	if ($key && !empty($info[$key])) {
		return $info[$key];
	} else {
		return $info;
	}
}




/**
 * 加密，解密函数
 * 从dzx1 中 copy
 * @param $string
 * @param $operation
 * @param $key
 * @param $expiry
 */
function auth_code($string, $operation = 'DECODE', $key = 'mycntvalltosun', $expiry = 36000)
{
    $ckey_length = 4;
    $key = md5($key);
    $keya = md5(substr($key, 0, 16));
    $keyb = md5(substr($key, 16, 16));
    $keyc = $ckey_length ? ($operation == 'DECODE' ? substr($string, 0, $ckey_length): substr(md5(microtime()), -$ckey_length)) : '';

    $cryptkey = $keya.md5($keya.$keyc);
    $key_length = strlen($cryptkey);

    $string = $operation == 'DECODE' ? base64_decode(substr($string, $ckey_length)) : sprintf('%010d', $expiry ? $expiry + time() : 0).substr(md5($string.$keyb), 0, 16).$string;
    $string_length = strlen($string);

    $result = '';
    $box = range(0, 255);

    $rndkey = array();
    for($i = 0; $i <= 255; $i++) {
        $rndkey[$i] = ord($cryptkey[$i % $key_length]);
    }

    for($j = $i = 0; $i < 256; $i++) {
        $j = ($j + $box[$i] + $rndkey[$i]) % 256;
        $tmp = $box[$i];
        $box[$i] = $box[$j];
        $box[$j] = $tmp;
    }

    for($a = $j = $i = 0; $i < $string_length; $i++) {
        $a = ($a + 1) % 256;
        $j = ($j + $box[$a]) % 256;
        $tmp = $box[$a];
        $box[$a] = $box[$j];
        $box[$j] = $tmp;
        $result .= chr(ord($string[$i]) ^ ($box[($box[$a] + $box[$j]) % 256]));
    }

    if($operation == 'DECODE') {
        if((substr($result, 0, 10) == 0 || substr($result, 0, 10) - time() > 0) && substr($result, 10, 16) == substr(md5(substr($result, 26).$keyb), 0, 16)) {
            return substr($result, 26);
        } else {
            return '';
        }
    } else {
        return $keyc.str_replace('=', '', base64_encode($result));
    }
}

/* 截取html代码 生成摘要
 * @param (string) $body  // 正文
 * @param (int) $size     // 摘要长度
 * @param (int) $format   // 输入格式 id
 */
function substr_html($body, $size, $format = NULL) {
    $_size = mb_strlen($body, "utf-8");
    if($_size <= $size) return $body;
    // 输入格式中有 PHP 过滤器
    /*if(!isset($format) && filter_is_php($format)){
        return $body;
    } */
    $strlen_var = strlen($body);
    // 不包含 html 标签
    if(strpos($body, '<') === false){
        return mb_substr($body, 0, $size);
    }
    // 包含截断标志，优先
    if($e = strpos($body, '<!-- break -->')){
        return mb_substr($body, 0, $e);
    }
    // html 代码标记
    $html_tag = 0;
    // 摘要字符串
    $summary_string = '';
    /**
    * 数组用作记录摘要范围内出现的 html 标签
    * 开始和结束分别保存在 left 和 right 键名下
    * 如字符串为：<h3><p><b>a</b></h3>，假设 p 未闭合
    * 数组则为：array('left' => array('h3', 'p', 'b'), 'right' => 'b', 'h3');
    * 仅补全 html 标签，<? <% 等其它语言标记，会产生不可预知结果
    */
    $html_array = array('left' => array(), 'right' => array());
    for($i = 0; $i < $strlen_var; ++$i) {
        if(!$size){
            break;
        }
        $current_var = substr($body, $i, 1);
        if($current_var == '<'){
            // html 代码开始
            $html_tag = 1;
            $html_array_str = '';
        }else if($html_tag == 1) {
            // 一段 html 代码结束
            if($current_var == '>'){
                // 去除首尾空格，如 <br /  > < img src="" / > 等可能出现首尾空格
                $html_array_str = trim($html_array_str);
                // 判断最后一个字符是否为 /，若是，则标签已闭合，不记录
                if(substr($html_array_str, -1) != '/'){
                // 判断第一个字符是否 /，若是，则放在 right 单元
                $f = substr($html_array_str, 0, 1);
                if($f == '/'){
                    // 去掉 /
                    $html_array['right'][] = str_replace('/', '', $html_array_str);
                }else if($f != '?'){
                    // 判断是否为 ?，若是，则为 PHP 代码，跳过
                    // 判断是否有半角空格，若有，以空格分割，第一个单元为 html 标签
                    // 如 <h2 class="a"> <p class="a">
                    if(strpos($html_array_str, ' ') !== false){
                        // 分割成2个单元，可能有多个空格，如：<h2 class="" id="">
                        $html_array['left'][] = strtolower(current(explode(' ', $html_array_str, 2)));
                    }else{
                        // 若没有空格，整个字符串为 html 标签，如：<b> <p> 等
                        // 统一转换为小写
                        $html_array['left'][] = strtolower($html_array_str);
                    }
                }
            }
            // 字符串重置
            $html_array_str = '';
            $html_tag = 0;
        }else{
            // 将< >之间的字符组成一个字符串,用于提取 html 标签
            $html_array_str .= $current_var;
        }
    }else{
        // 非 html 代码才记数
        --$size;
    }

    $ord_var_c = ord($body{$i});
    switch (true) {
        case (($ord_var_c & 0xE0) == 0xC0):
            // 2 字节
            $summary_string .= substr($body, $i, 2);
            $i += 1;
            break;
        case (($ord_var_c & 0xF0) == 0xE0):
            // 3 字节
            $summary_string .= substr($body, $i, 3);
            $i += 2;
            break;
        case (($ord_var_c & 0xF8) == 0xF0):
            // 4 字节
            $summary_string .= substr($body, $i, 4);
            $i += 3;
            break;
        case (($ord_var_c & 0xFC) == 0xF8):
            // 5 字节
            $summary_string .= substr($body, $i, 5);
            $i += 4;
            break;
        case (($ord_var_c & 0xFE) == 0xFC):
            // 6 字节
            $summary_string .= substr($body, $i, 6);
            $i += 5;
            break;
        default:
            // 1 字节
            $summary_string .= $current_var;
       }
    }

    if($html_array['left']){
    // 比对左右 html 标签，不足则补全
    /**
    * 交换 left 顺序，补充的顺序应与 html 出现的顺序相反
    * 如待补全的字符串为：<h2>abc<b>abc<p>abc
    * 补充顺序应为：</p></b></h2>
    */
    $html_array['left'] = array_reverse($html_array['left']);

    foreach($html_array['left'] as $index => $tag){
      // 判断该标签是否出现在 right 中
      $key = array_search($tag, $html_array['right']);
      if($key !== false){
        // 出现，从 right 中删除该单元
        unset($html_array['right'][$key]);
      }else{
        // 没有出现，需要补全
        $summary_string .= '</'.$tag.'>';
      }
    }
  }
  return $summary_string;
}




?>
