<!-------------------------------------------------------------------------------------------------------------------------------------------------->
<!------------------------------------------------------------【文件系统】 【文件】----------------------------------------------------------------->
【打开文件~只读模式】fopen('文件名或URL','r')								<文件不存在则报错><文件存在则读取>
【打开文件~写入模式】fopen('文件名或URL','w')								<文件不存在则创建><文件存在则清除原内容>
【打开文件~追加模式】fopen('文件名或URL','a')								<文件不存在则创建><文件存在则保留原内容>
【打开文件~抑或模式】fopen('文件名或URL','x')								<文件不存在则创建><文件存在则报错>

【读取文件】fread(已打开的文件,n)											<读取n个字符><遇到0则停止>
【读取文件】feof(已打开的文件)												<检测是否是最后一个字符><一般用于循环>
【写入文件】fwrite(已打开的文件,待输入的字符串,n)							<输入指定字符串中的n个字符到目标文件中>
【关闭文件】fclose(已打开的文件)

【打开、读取、关闭文件】file_get_contents(已打开的文件)					<一次性完成>
【打开、写入、关闭文件】file_put_contents(已打开的文件,写入的内容)		<一次性完成>
<!------------------------------------------------------------【文件系统】 【目录】----------------------------------------------------------------->
【打开目录】			opendir('路径')
【读取目录】			readdir(已打开的目录)
【检测~是否为目录】	is_dir(完整文件名)
【检测~是否为文件】	is_file(完整文件名)
【统计~文件大小】		filesize(完整文件名)


<!-------------------------------------------------------------------------------------------------------------------------------------------------->
<?PHP
[===================================================================================================================================================]
[=================================================================【文件】 【读取】=================================================================]
【打开、读取、关闭步骤】
$file=fopen('1.txt','r');					//以只读模式打开文件
while(!feof($file)){						//检测是否是最后一个字符，直到是为止
	echo $str=fread($file,1);				//显示第 1 个字符，对汉字或0效果不佳
}
fclose($file);								//关闭文件
【一次性的打开、读取、关闭步骤】
echo $content=file_get_contents('1.txt');		//一次性打开读取关闭文件
[=================================================================【文件】 【写入】=================================================================]
【打开、写入、关闭步骤】
$file=fopen('2.txt','w');					//以写入模式打开文件
$content='BlaBlaBla...';
fwrite($file,$content,10);					//写入一个字符串的前 10 个字符
fclose($file);								//关闭文件
【一次性的打开、写入、关闭步骤】
$content='BlaBlaBla...';
file_put_contents('2.txt',$content);		//一次性打开写入关闭文件
[=================================================================【目录】 【浏览】=================================================================]
$dir='C:/wamp';													//指定路径
$dirRes=opendir($dir);											//打开路径
while($name=readdir($dirRes)){									//循环！读取已打开的目录
	if($name=='.' || $name=='..'){continue;}					//过滤 . 和 ..
	$replace=str_replace('\\','/',$dir);						//将反斜线转换成正斜线
	$src=rtrim($replace,'/').'/';								//路径
	$filename=$src.'/'.$name;									//拼接完整路径和名称
	if(is_dir($filename)){										//检测！如果是文件夹
		echo '<font color="green">'.$filename.'</font><br>';	//显示成绿色的完整文件名
	}else if(is_file($filename)){								//检测！如果是文件
		echo '<font color="red">'.$filename.'</font><br>';		//显示成红色的完整文件名
	}
}
closedir($dirRes);												//关闭目录
[=================================================================【目录】 【体积】=================================================================]
function sizedir($dir){
	$dirSize=0;											//文件夹大小变量
	$dirOpen=opendir($dir);								//打开目录
	while($dirRead=readdir($dirOpen)){
		if($dirRead=='.' || $dirRead=='..'){continue;}	//过滤 . 和 ..
		$replace=str_replace('\\','/',$dir);			//将反斜线转换成正斜线
		$src=rtrim($replace,'/').'/';					//路径
		$fileName=$src.'/'.$dirRead;					//拼接完整路径和名称
		if(is_file($fileName)){							//检测！如果是文件
			$dirSize+=filesize($fileName);				//直接测出体积
		}else if(is_dir($fileName)){					//检测！如果是文件夹
			$dirSize+=sizedir($fileName);				//递归循环函数
		}
	}
	closedir($dirOpen);									//关闭目录
	return $dirSize;									//返回文件夹大小
}
echo sizedir('C:/wamp');								//调用函数
[=============================================================【文件目录】 【获取】=================================================================]
echo $dirName=dirname(__FILE__);			//获取路径名
echo $baseName=basename(__FILE__);			//获取文件名
echo getcwd();								//获取当前路径名
echo $fileName=$dirName.'\\'.$baseName;		//获取完整文件名

echo $free=disk_free_space('e:');		//返回目录中的可用空间
echo $total=disk_total_space('e:');		//返回一个目录的磁盘总大小
echo $used=$total-$free;				//计算并返回磁盘已用空间

echo $time=fileatime('E:/php.ini');			//文件的访问时间
echo $time=filectime('E:/php.ini');			//文件的创建时间
echo $time=filemtime('E:/php.ini');			//文件的修改时间

var_dump(is_dir('1'));		 		//判断给定文件名是否是一个目录
var_dump(is_file('1.txt'));			//判断给定文件名是否为一个正常的文件
var_dump(is_link('1'));	 			//判断给定文件名是否为一个符号连接

var_dump(is_executable('1.exe'));		//判断给定文件名是否可执行
var_dump(is_readable('1.txt'));			//判断给定文件名是否可读
var_dump(is_writable('2.txt'));			//判断给定的文件名是否可写

mkdir('A/B/C/D/E',0777,true);		//新建目录，给删改权限，开启递归创建
rmdir('A');							//删除目录，不能删除非空目录	
rename('A','DOUBI');				//重命名一个文件或目录
copy('1.PHP','one.php');			//拷贝文件
unlink('one.php');					//删除文件
[===================================================================================================================================================]
?>
<!-------------------------------------------------------------------------------------------------------------------------------------------------->
<!----------------------------------------------------------------【实例】 【记事本】--------------------------------------------------------------->
【HTML部分】
<!doctype html>
<meta charset="utf-8">
<form action="jsbw.php" method="post">
	<table border="1" width="500" align="center">
		<tr>
			<td>发布人：</td>
			<td><input type="text" name="user" value="某用户"></td>
		</tr>
		<tr>
			<td>内容：</td>
			<td><textarea name="content" cols="30" rows="10"></textarea></td>
		</tr>	
		<tr>
			<td colspan="2" align="center"><button type="submit">点击发言</button></td>
		</tr>
	</table>
</form>
【用于接收数据的PHP部分】
<?php
$user=$_POST['user'];	//接受用户名信息
$content=$_POST['content'];	//接受用户发布的信息
$time=time();			//接受用户发布信息的时间
$ip=ip2long($_SERVER['REMOTE_ADDR']);//接受用户的IP，将IP转换为字符串（long2ip是将字符串转回IP）

//修改信息的传入格式
$message=$user.'++'.$content.'++'.$time.'++'.$ip.'!!';//用 ++ 隔开用户单次上传的各类信息，用 !! 隔开用户多次上传的信息

//将修改后的信息传入数据库文件
$oldcontent=file_get_contents('sql.txt');//获取数据库已有内容
file_put_contents('sql.txt',$oldcontent.$message);//将新信息添入数据库

//跳转到 jsbs.php 中发布信息
header('location:jsbs.php');
?>
【记录数据的PHP部分】
<?php
//读取数据库文件中的信息
$get=file_get_contents('sql.txt');

//拆分修改后的信息成为数组
$get=rtrim($get,'!!');//先清除单次信息后的自定义分隔符
$getExplode=explode('!!',$get);//用自定义分隔符 !! 分隔成新数组

//展示整理后的新信息
echo '<table border="1" width="800" align="center">';
echo '<tr>
		<th>用户名</th>
		<th>内容</th>
		<th>时间</th>
		<th>ip地址</th>
	 </tr>';
foreach($getExplode as $newList){
	echo '<tr>';
	//拆分单条信息的单个字段(时间,IP,用户名,内容)
	$newExplode=explode('++',$newList);
	echo '<td>'.$newExplode[0].'</td>';
	echo '<td>'.$newExplode[1].'</td>';
	echo '<td>'.date('Y-m-d H:i:s',$newExplode[2]).'</td>';	//用新的时间格式显示出来
	echo '<td>'.long2ip($newExplode[3]).'</td>';//用新的IP格式显示出来
	echo '</tr>';
}
echo '</table>';
echo '<hr><a href="jsb.html">返回继续发布</a>';
?>
<!-------------------------------------------------------------------------------------------------------------------------------------------------->