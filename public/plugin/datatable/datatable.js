function DataTable(tags){
/**************************************************【初始化参数】**************************************************/
	
	var _this = this;//解决 this 冲突
	var option_ajax = null;//保存 Ajax 配置
	var input_search = null;//保存 Search 配置
	var input_page = null;//保存 Page 配置
	var input = null;//保存整体设置
	var output = null;//保存返回值

/**************************************************【初始化节点】**************************************************/

	var tag_table = tags['table'];//保存 表格 节点
	var tag_page_show = tags['page_show'];//保存 每页显示 节点
	var tag_page_jump = tags['page_jump'];//保存 翻页 节点

/**************************************************【节点配置】**************************************************/

	//【定位每页显示】
	if(tag_page_show){
		//布局
		var html = '';
		html += '每页显示&nbsp;';
		html += '<select dt_page_length>';
		html += 	'<option>10</option>';
		html += 	'<option>20</option>';
		html += 	'<option>50</option>';
		html +=		'<option>100</option>';
		html += '</select>';
		html += '&nbsp;条&nbsp;';
		html += '共&nbsp;<span dt_page_number style="font-weight:bold;">0</span>&nbsp;条';
		tag_page_show.html(html);
		//触发器
		tag_page_show.find('select[dt_page_length]').live('change',function(){ _this.pageChange('length'); });//每页显示
	}

	//【定位分页】
	if(tag_page_jump){
		//布局
		var html = '';
		html += '<button dt_page_begin>首页</button>&nbsp;';
		html += '<button dt_page_prev>上一页</button>&nbsp;';
		html += '第&nbsp;<input dt_page_current type="text" value="1" style="width:2ex;" />&nbsp;页&nbsp;';
		html += '共&nbsp;<span dt_page_total style="font-weight:bold;">1</span>&nbsp;页&nbsp;';
		html += '<button dt_page_next>下一页</button>&nbsp;';
		html += '<button dt_page_last>尾页</button>';
		tag_page_jump.html(html);
		//触发器
		tag_page_jump.find('input[dt_page_current]').live('keydown keyup',function(){
			var a = $(this).val();
			var b = a.length;
			var c = b+1;
			var d = (2>c)?2:c;
			var e = d+'ex';
			$(this).css({'width':e});
		});
		tag_page_jump.find('input[dt_page_current]').live('change',function(){ _this.pageChange('current'); });//手输页码
		tag_page_jump.find('button[dt_page_begin]').live('click',function(){ _this.pageChange('begin') });//首页
		tag_page_jump.find('button[dt_page_last]').live('click',function(){ _this.pageChange('last') });//尾页
		tag_page_jump.find('button[dt_page_prev]').live('click',function(){ _this.pageChange('prev') });//上一页
		tag_page_jump.find('button[dt_page_next]').live('click',function(){ _this.pageChange('next') });//下一页
	}

/**************************************************【外部接口】**************************************************/

	//【Ajax 配置】
	this.optionAjax = function(option){
		var _url = ( option && option['url'] ) ? option['url'] : null;
		var _type = ( option && option['type'] ) ? option['type'] : 'GET';
		var _dataType = ( option && option['dataType'] ) ? option['dataType'] : 'JSON';
		this.option_ajax = {
			'url' : _url,
			'type' : _type,
			'dataType' : _dataType,
		}
	}

	//【Search 配置】
	this.inputSearch = function(option){
		this.input_search = option;
	}

	//【Page 配置】
	this.inputPage = function(option){
		this.input_page = option;
	}

	//【执行】
	this.run = function(){
		this.operationPage();//分析页码
		this.operationInputData();//分析 input 数据
		$.ajax({
			url : this.option_ajax['url'],
			type : this.option_ajax['type'],
			dataType : this.option_ajax['dataType'],
			data : {'input':this.input},
			success : function(output){
				_this.output = output;//保存返回 JSON 串
				_this.outputData(output['data']);//生成页面
				_this.outputPage(output['page']);//恢复翻页
				if(_this.callBack){ _this.callBack() };//如果有回调函数 则执行
			}
		});
	}

	//【获取返回值】
	this.getOutput = function(){
		return this.output;
	}
	
	//【回调函数】
	this.callBack = null;

/**************************************************【内部接口】**************************************************/

	//【Page 分析】
	this.operationPage = function(){
		var _current = ( this.input_page && this.input_page['current'] ) ? this.input_page['current'] : 1;
			_current = tag_page_jump ? parseInt(tag_page_jump.find($('input[dt_page_current]')).val()) : _current;//获取当前页
		var _length = ( this.input_page && this.input_page['length'] ) ? this.input_page['length'] : 10;
			_length = tag_page_show ? parseInt(tag_page_show.find($('select[dt_page_length]')).val()) : _length;//获取每页显示数
		var _from = parseInt((_current - 1) * _length);//计算每页起始数
		var _to = parseInt(_from) + parseInt(_length);//计算每页结束数
		this.input_page = {
			'current' : _current,
			'length' : _length,
			'from' : _from,
			'to' : _to,
		}
	}

	//【data 分析】
	this.operationInputData = function(){
		var _search = this.input_search ? this.input_search : null;
		var _page = this.input_page ? this.input_page : null;
		this.input = {
			'search' : _search,//搜索项
			'page' : _page,//页码信息
		}
	}

	//【生成表格】
	this.outputData = function(data){
		var html = '';
		for(var i=0;i<data.length;i++){
			html += '<tr>';
			for(var j=0;j<data[i].length;j++){
				html += '<td>'+data[i][j]+'</td>';
			}
			html += '</tr>';
		}
		tag_table.html(html);
		tag_table.find('tr').live('mouseover',function(){ $(this).css({'background':'#DDDDDD'}) });
		tag_table.find('tr').live('mouseout',function(){ $(this).css({'background':''}) });
	}

	//【恢复翻页】
	this.outputPage = function(page){
		if(tag_page_show){
			tag_page_show.find($('span[dt_page_number]')).html(page['number']);//总条数
		}
		if(tag_page_jump){
			tag_page_jump.find($('span[dt_page_total]')).html(Math.ceil(page['number']/page['length']));//总页数
		}
	}

	//翻页动作
	this.pageChange = function(does){
		var _begin = 1;
		var _last = parseInt(tag_page_jump.find($('span[dt_page_total]')).html());
		var _current = parseInt(tag_page_jump.find($('input[dt_page_current]')).val());
			_current = isNaN(_current)?1:_current;
		var _prev = parseInt(tag_page_jump.find($('input[dt_page_current]')).val()) - 1;
		var _next = parseInt(tag_page_jump.find($('input[dt_page_current]')).val()) + 1;

		var _real = null;
		switch(does){
			case 'length': _real = _begin; break;//每页显示
			case 'current': _real = _current; break;//手输页码
			case 'begin': if(_current != _begin ){ _real = _begin }else{ return }; break;//首页
			case 'last': if(_current != _last ){ _real = _last }else{ return }; break;//尾页
			case 'prev': if(_prev >= _begin ){ _real = _prev }else{ return }; break;//上一页
			case 'next': if(_next <= _last ){ _real = _next }else{ return }; break;//下一页
		}
		tag_page_jump.find($('input[dt_page_current]')).val(_real);
		this.run();
	}

/**************************************************【】**************************************************/
}