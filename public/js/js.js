/**************************************************【系统方法】**************************************************/

//阻止 IE 浏览器运行
// if((navigator.userAgent.indexOf('MSIE') >= 0) && (navigator.userAgent.indexOf('Opera') < 0)){
// 	window.location.href('./public/html/error.html');
// }

//设置 cookie
function setCookie(name,value,days){
	if(days){
		var Days = days;
	}else{
		var Days = 30;
	}
	var exp = new Date();
	exp.setTime(exp.getTime() + Days*24*60*60*1000);
	document.cookie = name + "="+ escape (value) + ";expires=" + exp.toGMTString();
}

//取出 cookie
function getCookie(name){ 
	var arr,reg=new RegExp("(^| )"+name+"=([^;]*)(;|$)");
	if(arr=document.cookie.match(reg)){
		return unescape(arr[2]);
	}else{
		return null;
	}
}

//区分浏览器设置 css3 前缀
var Prefix;
if((navigator.userAgent.indexOf('MSIE') >= 0) && (navigator.userAgent.indexOf('Opera') < 0)){
	Prefix = '-ms-';
}else if(navigator.userAgent.indexOf('Opera') >= 0){
	Prefix = '-o-';
}else if(navigator.userAgent.indexOf('Firefox') >= 0){
	Prefix = '-moz-';
}else if(navigator.userAgent.indexOf('Safari') >= 0){
	Prefix = '-webkit-';
}else if(navigator.userAgent.indexOf('Chrome') >= 0){
	Prefix = '-webkit-';
}else{
	Prefix = '';
}

/**************************************************【自定义方法】**************************************************/

//滚动条回到顶部
function toTop(){
	//滚动条位置的像素数 = 滚回顶部的毫秒数
	var position = $('#body_right').scrollTop();
	$('#body_right').animate({scrollTop:0},position);
}

//返回随机 RGB 颜色
function rgbColor(){
	var arr = ['0','1','2','3','4','5','6','7','8','9','A','B','C','D','E','F'];
	var rgb1 = arr[Math.floor((Math.random()*arr.length))];
	var rgb2 = arr[Math.floor((Math.random()*arr.length))];
	var rgb3 = arr[Math.floor((Math.random()*arr.length))];
	var rgb4 = arr[Math.floor((Math.random()*arr.length))];
	var rgb5 = arr[Math.floor((Math.random()*arr.length))];
	var rgb6 = arr[Math.floor((Math.random()*arr.length))];
	return '#'+rgb1+rgb2+rgb3+rgb4+rgb5+rgb6;
}

/**************************************************【页面载入前】**************************************************/

//列表标题效果
$('#body_left ul>li:nth-child(1)').live('click',list);
function list(){
	$(this).toggleClass('active');
	if($(this).hasClass('active')){
		$(this).parent().siblings().children('li:nth-child(1)').removeClass('active');
		$(this).parent().siblings().children('li:nth-child(2)').slideUp(300);
		$(this).next().slideDown(300);
	}else{
		$(this).next().slideUp(300);
	}
}

//列表子标题效果
$('#body_left ul>li:nth-child(2)>div').live('click',activeList);
function activeList(){
	$('#body_left ul>li>div').removeClass('active');
	$(this).addClass('active');
}

//实例框选中效果
$('#testlist>a').live('mouseover',function(){
	$(this).animate({opacity:'0.5'},500);
	$(this).animate({opacity:'1'},500);
});

//加载内容页
$('#body_left ul>li:nth-child(2)>div').live('click',showContent);
function showContent(){
	var url = $(this).attr('href');
	var type = $(this).attr('type');
	if('' == url){return}
	$('#body_right').empty();
	$('#body_right').load(url,function(){
		$(this).removeClass('bg_table');
		$(this).removeClass('bg_set');
		$(this).removeClass('bg_theme');
		
		$(this).addClass('bg_table');
		//检测有无注释添加提示内容
		$('.i_table tr').each(function(){
			if($(this).attr('title')){
				$(this).children().eq(0).prepend('<span style="color:red">*</span>');
			}else{
				$(this).children().eq(0).prepend('<span style="color:transparent">*</span>');
			}
		});
		//检测有无提示框添加小手效果
		$('.i_table tr').each(function(){
			if($(this).attr('onclick')){
				$(this).css('cursor','pointer');
			}else{
				
			}
		});
		//恢复滚动条
		$(this).scrollTop(0);
		//加入回到顶部按钮
		$(this).append('<a href="#"><button id="toTop" class="toTop" onclick="toTop()"><b>返回<br>顶部</b></button></a>');
		//检测滚动条位置显示返回顶部按钮
		$(this).bind('scroll',function(){
			if($('#body_right').scrollTop()>10){
				$('#toTop').fadeIn(1000);
			}else{
				$('#toTop').fadeOut(500);
			}
		});
	});
}

/**************************************************【页面载入后】**************************************************/

$(function(){
 
	//展开第一层列表
	$('#body_left ul:nth-child(1)>li:nth-child(1)').trigger('click');

	//显示时间
	showTime();
	function showTime(){
		var DT = new Date();
		var y = DT.getFullYear();
		var m = DT.getMonth()+1;
		var d = DT.getDate();
		var h = DT.getHours();
		var i = DT.getMinutes();
		var s = DT.getSeconds();
		var w = DT.getDay();
		var c1 = rgbColor();
		var c2 = rgbColor();
		if(1 == m.toString().length){m = '0'+m;}
		if(1 == d.toString().length){d = '0'+d;}
		if(1 == h.toString().length){h = '0'+h;}
		if(1 == i.toString().length){i = '0'+i;}
		if(1 == s.toString().length){s = '0'+s;}
		var week = ['日','一','二','三','四','五','六'];
		var showdatetime = y+' 年 '+m+' 月 '+d+' 日 '+h+' 时 '+i+' 分 '+s+' 秒';
		var showweek = ' 星期 '+week[w];
		$('#ts_datetime').html(showdatetime);
		$('#ts_week').html(showweek);
		$('#ts_datetime').css({color:c1});
		$('#ts_week').css({color:c2});
		setTimeout(showTime,1000);
	}

});

/**************************************************【】**************************************************/