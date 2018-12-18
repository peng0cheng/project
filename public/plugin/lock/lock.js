function pcLock(){
/**************************************************【初始化参数】**************************************************/

	var _this = this;//解决 this 冲突

/**************************************************【输出页面】**************************************************/

	var lock_html =
		'<div lock_body>'
			+'<div lock_area>'
				+'<div lock_arrow></div>'
			+'</div>'
		+'</div>';
	$('body').append(lock_html);

/**************************************************【节点定位】**************************************************/

	lock_body = $('div[lock_body]');	//锁屏背景的 id
	lock_area = $('div[lock_area]');	//锁屏滑行区域的 id
	lock_arrow = $('div[lock_arrow]');	//锁屏滑块的 id

/**************************************************【外部接口】**************************************************/

//【锁定页面】
	this.onlock = function(){
		lock_body.css('display','block');
	}

//【解锁页面】
	this.unlock = function(){
		lock_body.css('display','none');
	}

/**************************************************【实现功能】**************************************************/

	var _areaWidth = lock_area.width();//滑行区域宽度
	var _arrowWidth = lock_arrow.width();//滑块宽度
	var _unlockSpace = '5';//解锁区域最大宽度（ px ）
	var _move = false;//滑动标记
	var _x;//滑块左侧的相对座标

	lock_arrow.mousedown(mDown).mousemove(mMove).mouseup(mUp);
	lock_body.mousemove(mMove).mouseup(mUp);
	function mDown(e){
		_move = true;
		_x = e.pageX;//初始化鼠标位置座标
	}
	function mMove(e){
		if(!_move){return}
		var x = e.pageX-_x;//当前鼠标位置 - 初始化的鼠标位置 = 滑块移动长度
		if(x<0){
			lock_arrow.css({left:0});//鼠标位置超出滑行区域左侧时固定位置
		}else if(x>(_areaWidth-_arrowWidth)){
			lock_arrow.css({left:_areaWidth-_arrowWidth});//鼠标位置超出滑行区域右侧时固定位置
		}else if(x>(_areaWidth-_arrowWidth-_unlockSpace)){
			lock_body.css('display','none');//滑块位置在解锁区域内时解锁
		}else{
			lock_arrow.css({left:x});//鼠标位置在其它区域时滑块跟随
		}
	}
	function mUp(e){
		_move = false;
		var x = e.pageX-_x;
		if(x>(_areaWidth-_arrowWidth)){
			lock_body.css('display','none');//鼠标抬起位置超出滑行区域右侧时解锁
		}else if(x<(_areaWidth-_arrowWidth-_unlockSpace)){
			lock_arrow.animate({left:"0"},100);//鼠标抬起位置未达到解锁区域时归位
		}
	}

/**************************************************【】**************************************************/
}