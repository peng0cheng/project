function Popup(tag){
/**************************************************【初始化参数】**************************************************/

	var _this = this;//解决 this 冲突

/**************************************************【初始化节点】**************************************************/

	var popup = tag;//接收父节点

/**************************************************【节点配置】**************************************************/

	var html =
		'<div popup_body>'
			+'<div popup_control>'
				+'<div popup_title title="移动">'+'<span style="color:purple;">&nbsp;&nbsp;Operation</span>'+'</div>'
				+'<div popup_close title="关闭"></div>'
			+'</div>'
			+'<div popup_view></div>'
		+'</div>';
	popup.html(html);

/**************************************************【节点定位】**************************************************/

	var popup_body = popup.find('div[popup_body]');
	var popup_control = popup.find('div[popup_control]');
	var popup_title = popup.find('div[popup_title]');
	var popup_close = popup.find('div[popup_close]');
	var popup_view = popup.find('div[popup_view]');

/**************************************************【外部接口】**************************************************/

	//【预加载标题】
	this.title = function(title){
		popup_title.html(title);
	}

	//【预加载内容】
	this.content = function(content){
		popup_view.html(content);
	}

	//【打开】
	this.open = function(title,content){
		popup_body.fadeIn(500);
		if(title){popup_title.html(title)};
		if(content){popup_view.html(content)};
	}

	//【关闭】
	this.close = function(){
		popup_body.fadeOut(500);
	}

	//修改配置
	this.set = function(option){
		popup_body.css(option);
		_this.use();
	}

/**************************************************【内部接口】**************************************************/

	//【实现样式】
	this.use = function(){
		//分析
		var popup_body_width = parseInt(popup_body.css('width'));//总宽度
		var popup_body_height = parseInt(popup_body.css('height'));//总高度
		var popup_control_width = popup_body_width;
		var popup_control_height = 30;
		var popup_close_width = popup_control_height - 2;//关闭按扭宽
		var popup_close_height = popup_control_height - 2;//关闭按扭高
		var popup_title_width = popup_control_width - popup_close_width - 2;
		var popup_title_height = popup_control_height;
		var popup_view_width = popup_body_width;
		var popup_view_height = popup_body_height - popup_control_height;
		//实现
		popup_body.css({'width':popup_body_width,'height':popup_body_height});
		popup_control.css({'width':popup_control_width,'height':popup_control_height});
		popup_title.css({'width':popup_title_width,'height':popup_title_height,'line-height':popup_title_height+'px'});
		popup_close.css({'width':popup_close_width,'height':popup_close_height,'margin':1});
		popup_view.css({'width':popup_view_width,'height':popup_view_height});
	}

/**************************************************【实现功能】**************************************************/

	var _move=false;//移动标记  
	var _x,_y;//鼠标离控件左上角的相对位置
	popup_title.mousedown(mDown).mousemove(mMove).mouseup(mUp);
	function mDown(e){
	    _move=true;
	    _x=e.pageX-parseInt(popup_body.css('left'));  
	    _y=e.pageY-parseInt(popup_body.css('top'));  
	    popup_body.fadeTo(20, 0.5);//点击后开始拖动并透明显示  
	}
	function mMove(e){
		if(_move){
			var x=e.pageX-_x;//移动时根据鼠标位置计算控件左上角的绝对位置  
	    var y=e.pageY-_y;  
	    popup_body.css({top:y,left:x});//控件新位置  
	}
	}
	function mUp(e){
		_move=false;
		popup_body.fadeTo('fast', 1);//松开鼠标后停止移动并恢复成不透明  
	}

/**************************************************【事件控制】**************************************************/

	popup_close.live('click',this.close);//关闭效果

	_this.use();

/**************************************************【】**************************************************/
}