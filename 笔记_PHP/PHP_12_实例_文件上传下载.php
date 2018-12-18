<!-------------------------------------------------------------------------------------------------------------------------------------------------->
<!------------------------------------------------------【文件上传和下载】 【配置文件】------------------------------------------------------------->
【配置文件】file_uploads = On												<文件上传功能开关>|<默认开启>
【配置文件】upload_max_filesize = 2M										<上传文件最大体积>|<默认2M>
【配置文件】post_max_size = 8M												<post方式的最大使用大小>|<大于upload_max_filesize>|<默认8M>
【配置文件】memory_limit = 128M											<PHP程序充许使用的最大内存>|<大于post_max_size>|<默认128M>
<!------------------------------------------------------【文件上传和下载】 【HTML部分】------------------------------------------------------------->
【HTML部分】<form action="？.php">											<提交到目标php文件进行处理>
【HTML部分】<form method="post">											<必须使用 post 上传方式>
【HTML部分】<form enctype="multipart/form-data">							<必须使用 enctype 属性>
【HTML部分】<input type="hidden" name="MAX_FILE_SIZE" value="最大字节" />	<用于在用户开始上传时限制文件大小>
【HTML部分】<input type="file" name="名称" value="" />						<上传文件表单>
<!------------------------------------------------------【文件上传和下载】 【PHP部分】------------------------------------------------------------->
【判断文件是否上传到了系统临时目录】








<!-------------------------------------------------------------------------------------------------------------------------------------------------->
<form action="?.php" method="post" enctype="multipart/form-data">
	<input type="hidden" name="MAX_FILE_SIZE" value="10240" />
	<input type="file" name="face" value="" />
	<button type="submit">上传头像</button>
</form>
<?PHP
[===================================================================================================================================================]
[=================================================================【上传】 【检测被上传的文件状态】=================================================]
var_dump($_FILES);	
[=================================================================【上传】 【判断文件是否上传到了系统临时目录中】===================================]
//判定[face]下的[error]
$userError=$_FILES['face']['error'];
if(!$userError){											//判定！如果上传成功...
															//上传成功后的动作
}else{														//判定！如果上传不成功...
	switch($userError){										//上传不成功后的动作
		case 1:echo '文件大小超过了配置文件的限制';break;
		case 2:echo '文件大小超过了表单的限制';break;
		case 3:echo '只有部分文件被上传';break;
		case 4:echo '没有文件被上传';break;
		case 6:echo '找不到系统临时目录';break;
		case 7:echo '文件写入失败';break;
		default:echo '大哥你开玩笑的吧~';
	}
}
[=================================================================【上传】 【上传成功后，在PHP中限制已上传成功文件大小】============================]
//判定[face]下的[size]
$tmpSize=1024*1024*1;									//限定临时文件的最大体积
$userSize=$_FILES['face']['size'];						//用户已上传文件的体积
if($userSize>$tmpSize){									//判定！当上传的文件体积大于限定的体积时...
	exit('文件体积过大');
}
[=================================================================【上传】 【上传成功后，验证文件后缀是否合法】=====================================]
//判定[face]下的[name]
$tmpName=array('gif','png','jpeg','jpg','jpe');		//限定临时文件的后缀名
$userName=$_FILES['face']['name'];					//用户已上传文件的全名
$userNameExplode=explode('.',$userName);			//用 . 来分割文件名和后缀，使之成为两个元素
$userNamePop=array_pop($userNameExplode);			//提出最后一个元素，即提出文件的后缀
$userNameStrtolower=strtolower($userNamePop);		//把提出的后缀转换成小写	
if(!in_array($userNameStrtolower,$tmpName)){		//判定！当用户上传的文件后缀不符合PHP限定的后缀时...
	exit('文件后缀不合法');
}
[=================================================================【上传】 【上传成功后，检测文件MIME类型是否合法】=================================]
//判定[face]下的[type]
$tmpType=array('image/gif','image/png','image/jpeg');		//用PHP限定的文件类型
$userType=$_FILES['face']['type'];							//用户上传的文件类型
if(!in_array($userType,$tmpType)){							//判定！当上传的文件类型不属于限定的文件类型时...
	exit('文件的类型不合法!');
}
[=================================================================【上传】 【上传成功后，检测临时目录中的文件是否是上传文件】=======================]
//判定[face]下的[tmp_name]
$userTmp=$_FILES['face']['tmp_name'];				//上传文件的默认路径
if(is_uploaded_file($userTmp)){						//判定，当已上传的文件在临时文件夹下时...
	$newTmp=rtrim('./uploadface','/').'/';			//新的路径
	$newName=uniqid().'.'.$userNamePop;				//新的文件名：随机文件名.用户上传文件的后缀
	$newTmpName=$newTmp.$newName;					//改写新的文件名：路径名+新的文件名	
	if(!file_exists($newTmp)){						//判定！当新设定的路径不存在时...
		mkdir($newTmp,0777,true);					//建立新的路径文件夹
	}
	if(move_uploaded_file($userTmp,$newTmpName)){	//新的路径下的新的文件名
		exit('文件移动成功！上传成功');
	}else{
		exit('文件移动失败');
	}
}else{												//判定，当目标文件不是用户上传的文件时...
	exit('不是上传文件，上传终止！');
}
[=================================================================【下载】 【下载】=================================================================]
header('Content-type: text/html');									//输出文件的MIME类型
$name=iconv('utf-8','gbk','文件.php');
header('Content-Disposition: attachment; filename="'.$name.'"');	//输出文件的描述
readfile('./upload.php');											//读取文件
[=================================================================【综合】 【改写成函数形式】=======================================================]
function userface($face,$newTmp){
	//判定[face]下的[error]
	$userError=$_FILES[$face]['error'];
	if(!$userError){											//判定！如果上传成功...
		//判定[face]下的[size]
		$tmpSize=1024*1024*1;									//限定临时文件的最大体积
		$userSize=$_FILES[$face]['size'];						//用户已上传文件的体积
		if($userSize>$tmpSize){									//判定！当上传的文件体积大于限定的体积时...
			exit('文件体积过大');
		}
		//判定[face]下的[name]
		$tmpName=array('gif','png','jpeg','jpg','jpe');		//限定临时文件的后缀名
		$userName=$_FILES[$face]['name'];					//用户已上传文件的全名
		$userNameExplode=explode('.',$userName);			//用 . 来分割文件名和后缀，使之成为两个元素
		$userNamePop=array_pop($userNameExplode);			//提出最后一个元素，即提出文件的后缀
		$userNameStrtolower=strtolower($userNamePop);		//把提出的后缀转换成小写	
		if(!in_array($userNameStrtolower,$tmpName)){		//判定！当用户上传的文件后缀不符合PHP限定的后缀时...
			exit('文件后缀不合法');
		}
		//判定[face]下的[type]
		$tmpType=array('image/gif','image/png','image/jpeg');		//用PHP限定的文件类型
		$userType=$_FILES[$face]['type'];							//用户上传的文件类型
		if(!in_array($userType,$tmpType)){							//判定！当上传的文件类型不属于限定的文件类型时...
			exit('文件的类型不合法!');
		}
		//判定[face]下的[tmp_name]
		$userTmp=$_FILES[$face]['tmp_name'];				//上传文件的默认路径
		if(is_uploaded_file($userTmp)){						//判定！当已上传的文件在临时文件夹下时...
			$newTmp=rtrim($newTmp,'/').'/';					//新的路径
			$newName=uniqid().'.'.$userNamePop;				//新的文件名：随机文件名.用户上传文件的后缀
			$newTmpName=$newTmp.$newName;					//改写新的文件名：路径名+新的文件名	
			if(!file_exists($newTmp)){						//判定！当新设定的路径不存在时...
				mkdir($newTmp,0777,true);					//建立新的路径文件夹
			}
			if(move_uploaded_file($userTmp,$newTmpName)){	//新的路径下的新的文件名
				exit('文件移动成功！上传成功');
			}else{
				exit('文件移动失败');
			}
		}else{												//判定！当目标文件不是用户上传的文件时...
			exit('不是上传文件，上传终止！');
		}
		
		
	}else{														//判定！如果上传不成功...
		switch($userError){										//上传不成功后的动作
			case 1:echo '文件大小超过了配置文件的限制';break;
			case 2:echo '文件大小超过了表单的限制';break;
			case 3:echo '只有部分文件被上传';break;
			case 4:echo '没有文件被上传';break;
			case 6:echo '找不到系统临时目录';break;
			case 7:echo '文件写入失败';break;
			default:echo '大哥你开玩笑的吧~';
		}
	}
}
$result=userface('face','./uploaduserface');
echo $result;

[=================================================================【综合】 【改写成函数形式的多文件上传】===========================================]

function userface($face,$newTmp){
	//处理多个文件
	for($i=0;$i<count($_FILES[$face]['name']);$i++){
		//判定[face]下的[error]
		$userError=$_FILES[$face]['error'][$i];
		if(!$userError){											//判定！如果上传成功...
			//判定[face]下的[size]
			$tmpSize=1024*1024*2;									//限定临时文件的最大体积
			$userSize=$_FILES[$face]['size'][$i];						//用户已上传文件的体积
			if($userSize>$tmpSize){									//判定！当上传的文件体积大于限定的体积时...
				exit('文件体积过大');
			}
			//判定[face]下的[name]
			$tmpName=array('gif','png','jpeg','jpg','jpe');		//限定临时文件的后缀名
			$userName=$_FILES[$face]['name'][$i];					//用户已上传文件的全名
			$userNameExplode=explode('.',$userName);			//用 . 来分割文件名和后缀，使之成为两个元素
			$userNamePop=array_pop($userNameExplode);			//提出最后一个元素，即提出文件的后缀
			$userNameStrtolower=strtolower($userNamePop);		//把提出的后缀转换成小写	
			if(!in_array($userNameStrtolower,$tmpName)){		//判定！当用户上传的文件后缀不符合PHP限定的后缀时...
				exit('文件后缀不合法');
			}
			//判定[face]下的[type]
			$tmpType=array('image/gif','image/png','image/jpeg');		//用PHP限定的文件类型
			$userType=$_FILES[$face]['type'][$i];							//用户上传的文件类型
			if(!in_array($userType,$tmpType)){							//判定！当上传的文件类型不属于限定的文件类型时...
				exit('文件的类型不合法!');
			}
			//判定[face]下的[tmp_name]
			$userTmp=$_FILES[$face]['tmp_name'][$i];				//上传文件的默认路径
			if(is_uploaded_file($userTmp)){						//判定，当已上传的文件在临时文件夹下时...
				$newTmp=rtrim($newTmp,'/').'/';					//新的路径
				$newName=uniqid().'.'.$userNamePop;				//新的文件名：随机文件名.用户上传文件的后缀
				$newTmpName=$newTmp.$newName;					//改写新的文件名：路径名+新的文件名	
				if(!file_exists($newTmp)){						//判定！当新设定的路径不存在时...
					mkdir($newTmp,0777,true);					//建立新的路径文件夹
				}
				if(move_uploaded_file($userTmp,$newTmpName)){	//新的路径下的新的文件名
					echo '文件移动成功！上传成功';
				}else{
					echo '文件移动失败';
				}
			}else{												//判定，当目标文件不是用户上传的文件时...
				exit('不是上传文件，上传终止！');
			}
			
			
		}else{														//判定！如果上传不成功...
			switch($userError){										//上传不成功后的动作
				case 1:echo '文件大小超过了配置文件的限制';break;
				case 2:echo '文件大小超过了表单的限制';break;
				case 3:echo '只有部分文件被上传';break;
				case 4:echo '没有文件被上传';break;
				case 6:echo '找不到系统临时目录';break;
				case 7:echo '文件写入失败';break;
				default:echo '大哥你开玩笑的吧~';
			}
		}
	}
}
$result=userface('face','./uploaduserface');
echo $result;
[===================================================================================================================================================]