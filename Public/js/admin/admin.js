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


$(function(){


//点击列表选中checkbox
$("table tbody  tr").click(function(e){
	var clickTarget = $(e.target);
    // 当直接点击checkbox时，不做checked的切换
    if (clickTarget.is("input.listSelect")) {
      return;
    }
    var listCheckbox = $("input.listSelect", $(this));
    if (listCheckbox.is(":disabled")) {
      return;
    }
    if (listCheckbox.attr("checked")) {
      listCheckbox.removeAttr("checked");
    } else {
      listCheckbox.attr("checked", "checked");
	    }
	});

// jquery1.9之后不再支持 $.browser了
//var $.browser.mozilla = /firefox/.test(navigator.userAgent.toLowerCase());	
// 用于去除mozilla中radio和checkbox的bug问题
if(/firefox/.test(navigator.userAgent.toLowerCase())) $("form").attr("autocomplete", "off");

// 全选
$("body").on('click','input.selectAll', function(){
    if ($(this).attr("checked")) {
      $("input.selectAll, input.listSelect").not(":disabled").attr("checked", "checked");
    } else {
      $("input.selectAll, input.listSelect").not(":disabled").removeAttr("checked");
    }
});
//当有未选中的取消全选的选中，当没有未选中时选中全选
$("body").on('click', 'input.listSelect',function(){
	var flag = false;
	var sign = false;
	$("input.listSelect").each(function(){
		if (!$(this).attr('checked')) {
			flag = true;
			sign = true;
		}
	});
	if (flag) {
		$("input.selectAll").removeAttr("checked");
	}
	if (!sign) {
		$("input.selectAll").attr("checked", "checked");
	}
});
  
	// 单个删除，加入回收站
$(".delete_one").click(function(e){
    e.preventDefault();
    e.stopPropagation();
    one_action($(this), '删除');
    return false;
});

// 还原
$(".reduction").click(function(e){
    e.preventDefault();
    e.stopPropagation();
    one_action($(this), '还原');
	    return false;
	});
  
	// 彻底删除
$(".delete_really").click(function(e){
    e.preventDefault();
    e.stopPropagation();
    one_action($(this), '彻底删除');
    return false;
});

/**
 * @param clickObj 	// 点击对像
 * @param txt 		// 提示信息
 * @return
 */
function one_action(clickObj, txt){
    if (!confirm("确定要"+txt+"该条记录吗？")) {
      return false;
    }
    var url = clickObj.attr("href");
    $.get(url, function(json){
      if (json.info != 'ok') {
        js_prompt(json.data);
      } else {
    	  if (typeof($status)=='undefined' || $status == -1) {
    		  window.location.reload();
    	  } else {
    		  clickObj.closest("tr").fadeOut(function(){
    			  $(this).remove();
    		  });
    	  }
      }
    }, 'json');
    return false;
}

// 批量删除，加入回收站
$(".delete_all").click(function(e){
    e.preventDefault();
    e.stopPropagation();
    var url = $(this).attr("href");
    var ids = getCheckedIds();
    bulk_action(url, ids, '删除');
    $("input[name=selectAll]").not(":disabled").removeAttr("checked");
    return false;
});
// 批量还原
$(".reduction_all").click(function(e){
    e.preventDefault();
    e.stopPropagation();
    var url = $(this).attr("href");
    var ids = getCheckedIds();
    bulk_action(url, ids, '还原');
    $("input[name=selectAll]").not(":disabled").removeAttr("checked");
    return false;
});
// 批量彻底删除
$(".delete_really_all").click(function(e){
    e.preventDefault();
    e.stopPropagation();
    var url = $(this).attr("href");
    var ids = getCheckedIds();
    bulk_action(url, ids, '彻底删除');
    $("input[name=selectAll]").not(":disabled").removeAttr("checked");
    return false;
});
/**
 * 批量操作
 * @param url	// url地址
 * @param ids 	// id的字符串，格式 5,6,7
 * @param txt	// 提示信息
 * @return
 */
function bulk_action(url, ids, txt) {
	var ids = getCheckedIds();
	var idstr = ids.join(',');
	if (!idstr) {
		js_prompt("请选择要"+txt+"的记录!");
		return false;
	}
	if (!confirm("确定要"+txt+"这些记录吗？")) {
		return false;
	}
	var postData = { 'id': idstr };
	$.post(url, postData, function(json){
	  if (json.info != 'ok') {
	    js_prompt(json.data);
	  } else {
    	  if ($status == -1) {
    		  window.location.reload();
    	  } else {
    		  $.each(ids, function(k, v){
    			  $("input[type=checkbox][value="+v+"]").fadeOut(function(){
    				  $(this).parents('tr').remove();
    			  });
    		  });
    	  }
	  }
	}, 'json');
}

/**
 * 获取页面中选中的checkbox对应的ids
 * @requires checkbox上统一加name="listSelect"
 * @requires tr的class="dataList1"
 * @return Array 所有选中的id数组
 */
function getCheckedIds() {
  var ids = [];
  $("input.listSelect:checked").not(":disabled").each(function(){
    var selectId = $(this).attr("value");
    ids.push(selectId);
  });
  return ids;
}

});
