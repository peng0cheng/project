function Alert(option){
/**************************************************【初始化参数】**************************************************/

	var _this = this;//解决 this 冲突

/**************************************************【输出页面】**************************************************/

	var alert_html = '<div alert_body></div>';
	$('body').append(alert_html);

/**************************************************【节点定位】**************************************************/

	var alert = $('div[alert_body]');

/**************************************************【外部接口】**************************************************/

	//【修改配置】
	this.set = function(option){
		alert.css(option);
		_this.use();
	}

	//【打开】
	this.open = function(content){
		alert.html(content);
		alert.fadeIn(1000);
		setTimeout(function(){
			alert.fadeOut(1000)
		},1500);
	}

/**************************************************【内部接口】**************************************************/

	//【使用样式】
	this.use = function(){
		//分析
		var css_left = (window.innerWidth/2) - (parseInt(alert.css('width'))/2);
		var css_top = (window.innerHeight/2) - (parseInt(alert.css('height'))/2);
		//实现
		alert.css({'left':css_left,'top':css_top});
	}

/**************************************************【事件控制】**************************************************/

	_this.use();

/**************************************************【】**************************************************/
}