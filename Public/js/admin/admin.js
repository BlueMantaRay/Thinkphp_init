/**
 * admin.js 后台通用JS代码
 * @requires jQuery v1.4.4+
 * @requires jQuery-ui v1.8.7+
 */

// 对弹窗提示控件进行封装
function js_prompt(data, func){
	if (!func) {
		var func = function(){ };
	}
	art.dialog({
		title: '提示',
		content: data,
		okValue: '确定',
		ok: func
	});
}