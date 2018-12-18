function pcCase(){

/**************************************************【开始】**************************************************/

//【打开弹窗并插入内容】
	this.show = function(whitch,data){
		switch(whitch){
			case 1:
				case_01.fadeIn(500);
				case_01_content.empty();
				case_01_content.html(data);
				break;
			case 2:
				case_02.fadeIn(500);
				case_02_content.empty();
				case_02_content.html(data);
				break;
			case 3:
				case_03.fadeIn(500);
				case_03_content.empty();
				case_03_content.html(data);
				break;
			default:
				break;
		}
	}

//【弹窗功能】
	this.case = function(){

	//【配置页面】
		var case_html =
			'<div class="case_01" id="case_01">'
				+'<div class="case_01_title" id="case_01_title">'
					+'<div class="case_01_move" id="case_01_move" title="移动">Operation:</div>'
					+'<div class="case_01_close" id="case_01_close" title="关闭"></div>'
				+'</div>'
				+'<div class="case_01_content" id="case_01_content"></div>'
			+'</div>'
			+'<div class="case_02" id="case_02">'
				+'<div class="case_02_title" id="case_02_title">'
					+'<div class="case_02_move" id="case_02_move" title="移动">Result:</div>'
					+'<div class="case_02_close" id="case_02_close" title="关闭"></div>'
				+'</div>'
				+'<div class="case_02_content" id="case_02_content"></div>'
			+'</div>'
			+'<div class="case_03" id="case_03">'
				+'<div class="case_03_title" id="case_03_title">'
					+'<div class="case_03_move" id="case_03_move" title="移动">Test:</div>'
					+'<div class="case_03_close" id="case_03_close" title="关闭"></div>'
				+'</div>'
				+'<div class="case_03_content" id="case_03_content"></div>'
			+'</div>';
		$('body').append(case_html);

	//【节点定位】
		case_01 = $('#case_01');
		case_01_title = $('#case_01_title');
		case_01_move = $('#case_01_move');
		case_01_close = $('#case_01_close');
		case_01_content = $('#case_01_content');

		case_02 = $('#case_02');
		case_02_title = $('#case_02_title');
		case_02_move = $('#case_02_move');
		case_02_close = $('#case_02_close');
		case_02_content = $('#case_02_content');

		case_03 = $('#case_03');
		case_03_title = $('#case_03_title');
		case_03_move = $('#case_03_move');
		case_03_close = $('#case_03_close');
		case_03_content = $('#case_03_content');

	//【实现功能】
		case_01_close.live('click',off);//关闭效果
		case_02_close.live('click',off);//关闭效果
		case_03_close.live('click',off);//关闭效果
		function off(){
			case_01.fadeOut(500);
			case_02.fadeOut(500);
			case_03.fadeOut(500);
		}

		var _move=false;//移动标记  
		var _x,_y;//鼠标离控件左上角的相对位置
	    case_01_move.mousedown(mDown).mousemove(mMove).mouseup(mUp);
	    case_02_move.mousedown(mDown).mousemove(mMove).mouseup(mUp);
	    case_03_move.mousedown(mDown).mousemove(mMove).mouseup(mUp);
	    function mDown(e){
	        _move=true;
	        var test = $(this).parent().parent();
	        _x=e.pageX-parseInt(test.css('left'));  
	        _y=e.pageY-parseInt(test.css('top'));  
	        test.fadeTo(20, 0.5);//点击后开始拖动并透明显示  
		}
	  	function mMove(e){
	  		if(_move){
	  			var test = $(this).parent().parent();
		  		var x=e.pageX-_x;//移动时根据鼠标位置计算控件左上角的绝对位置  
		        var y=e.pageY-_y;  
		        test.css({top:y,left:x});//控件新位置  
	        }
	  	}
	  	function mUp(e){
	  		_move=false;
	  		var test = $(this).parent().parent();
	    	test.fadeTo('fast', 1);//松开鼠标后停止移动并恢复成不透明  
	  	}
	}

/**************************************************【】**************************************************/
}