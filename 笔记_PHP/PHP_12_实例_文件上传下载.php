<!-------------------------------------------------------------------------------------------------------------------------------------------------->
<!------------------------------------------------------���ļ��ϴ������ء� �������ļ���------------------------------------------------------------->
�������ļ���file_uploads = On												<�ļ��ϴ����ܿ���>|<Ĭ�Ͽ���>
�������ļ���upload_max_filesize = 2M										<�ϴ��ļ�������>|<Ĭ��2M>
�������ļ���post_max_size = 8M												<post��ʽ�����ʹ�ô�С>|<����upload_max_filesize>|<Ĭ��8M>
�������ļ���memory_limit = 128M											<PHP�������ʹ�õ�����ڴ�>|<����post_max_size>|<Ĭ��128M>
<!------------------------------------------------------���ļ��ϴ������ء� ��HTML���֡�------------------------------------------------------------->
��HTML���֡�<form action="��.php">											<�ύ��Ŀ��php�ļ����д���>
��HTML���֡�<form method="post">											<����ʹ�� post �ϴ���ʽ>
��HTML���֡�<form enctype="multipart/form-data">							<����ʹ�� enctype ����>
��HTML���֡�<input type="hidden" name="MAX_FILE_SIZE" value="����ֽ�" />	<�������û���ʼ�ϴ�ʱ�����ļ���С>
��HTML���֡�<input type="file" name="����" value="" />						<�ϴ��ļ���>
<!------------------------------------------------------���ļ��ϴ������ء� ��PHP���֡�------------------------------------------------------------->
���ж��ļ��Ƿ��ϴ�����ϵͳ��ʱĿ¼��








<!-------------------------------------------------------------------------------------------------------------------------------------------------->
<form action="?.php" method="post" enctype="multipart/form-data">
	<input type="hidden" name="MAX_FILE_SIZE" value="10240" />
	<input type="file" name="face" value="" />
	<button type="submit">�ϴ�ͷ��</button>
</form>
<?PHP
[===================================================================================================================================================]
[=================================================================���ϴ��� ����ⱻ�ϴ����ļ�״̬��=================================================]
var_dump($_FILES);	
[=================================================================���ϴ��� ���ж��ļ��Ƿ��ϴ�����ϵͳ��ʱĿ¼�С�===================================]
//�ж�[face]�µ�[error]
$userError=$_FILES['face']['error'];
if(!$userError){											//�ж�������ϴ��ɹ�...
															//�ϴ��ɹ���Ķ���
}else{														//�ж�������ϴ����ɹ�...
	switch($userError){										//�ϴ����ɹ���Ķ���
		case 1:echo '�ļ���С�����������ļ�������';break;
		case 2:echo '�ļ���С�����˱�������';break;
		case 3:echo 'ֻ�в����ļ����ϴ�';break;
		case 4:echo 'û���ļ����ϴ�';break;
		case 6:echo '�Ҳ���ϵͳ��ʱĿ¼';break;
		case 7:echo '�ļ�д��ʧ��';break;
		default:echo '����㿪��Ц�İ�~';
	}
}
[=================================================================���ϴ��� ���ϴ��ɹ�����PHP���������ϴ��ɹ��ļ���С��============================]
//�ж�[face]�µ�[size]
$tmpSize=1024*1024*1;									//�޶���ʱ�ļ���������
$userSize=$_FILES['face']['size'];						//�û����ϴ��ļ������
if($userSize>$tmpSize){									//�ж������ϴ����ļ���������޶������ʱ...
	exit('�ļ��������');
}
[=================================================================���ϴ��� ���ϴ��ɹ�����֤�ļ���׺�Ƿ�Ϸ���=====================================]
//�ж�[face]�µ�[name]
$tmpName=array('gif','png','jpeg','jpg','jpe');		//�޶���ʱ�ļ��ĺ�׺��
$userName=$_FILES['face']['name'];					//�û����ϴ��ļ���ȫ��
$userNameExplode=explode('.',$userName);			//�� . ���ָ��ļ����ͺ�׺��ʹ֮��Ϊ����Ԫ��
$userNamePop=array_pop($userNameExplode);			//������һ��Ԫ�أ�������ļ��ĺ�׺
$userNameStrtolower=strtolower($userNamePop);		//������ĺ�׺ת����Сд	
if(!in_array($userNameStrtolower,$tmpName)){		//�ж������û��ϴ����ļ���׺������PHP�޶��ĺ�׺ʱ...
	exit('�ļ���׺���Ϸ�');
}
[=================================================================���ϴ��� ���ϴ��ɹ��󣬼���ļ�MIME�����Ƿ�Ϸ���=================================]
//�ж�[face]�µ�[type]
$tmpType=array('image/gif','image/png','image/jpeg');		//��PHP�޶����ļ�����
$userType=$_FILES['face']['type'];							//�û��ϴ����ļ�����
if(!in_array($userType,$tmpType)){							//�ж������ϴ����ļ����Ͳ������޶����ļ�����ʱ...
	exit('�ļ������Ͳ��Ϸ�!');
}
[=================================================================���ϴ��� ���ϴ��ɹ��󣬼����ʱĿ¼�е��ļ��Ƿ����ϴ��ļ���=======================]
//�ж�[face]�µ�[tmp_name]
$userTmp=$_FILES['face']['tmp_name'];				//�ϴ��ļ���Ĭ��·��
if(is_uploaded_file($userTmp)){						//�ж��������ϴ����ļ�����ʱ�ļ�����ʱ...
	$newTmp=rtrim('./uploadface','/').'/';			//�µ�·��
	$newName=uniqid().'.'.$userNamePop;				//�µ��ļ���������ļ���.�û��ϴ��ļ��ĺ�׺
	$newTmpName=$newTmp.$newName;					//��д�µ��ļ�����·����+�µ��ļ���	
	if(!file_exists($newTmp)){						//�ж��������趨��·��������ʱ...
		mkdir($newTmp,0777,true);					//�����µ�·���ļ���
	}
	if(move_uploaded_file($userTmp,$newTmpName)){	//�µ�·���µ��µ��ļ���
		exit('�ļ��ƶ��ɹ����ϴ��ɹ�');
	}else{
		exit('�ļ��ƶ�ʧ��');
	}
}else{												//�ж�����Ŀ���ļ������û��ϴ����ļ�ʱ...
	exit('�����ϴ��ļ����ϴ���ֹ��');
}
[=================================================================�����ء� �����ء�=================================================================]
header('Content-type: text/html');									//����ļ���MIME����
$name=iconv('utf-8','gbk','�ļ�.php');
header('Content-Disposition: attachment; filename="'.$name.'"');	//����ļ�������
readfile('./upload.php');											//��ȡ�ļ�
[=================================================================���ۺϡ� ����д�ɺ�����ʽ��=======================================================]
function userface($face,$newTmp){
	//�ж�[face]�µ�[error]
	$userError=$_FILES[$face]['error'];
	if(!$userError){											//�ж�������ϴ��ɹ�...
		//�ж�[face]�µ�[size]
		$tmpSize=1024*1024*1;									//�޶���ʱ�ļ���������
		$userSize=$_FILES[$face]['size'];						//�û����ϴ��ļ������
		if($userSize>$tmpSize){									//�ж������ϴ����ļ���������޶������ʱ...
			exit('�ļ��������');
		}
		//�ж�[face]�µ�[name]
		$tmpName=array('gif','png','jpeg','jpg','jpe');		//�޶���ʱ�ļ��ĺ�׺��
		$userName=$_FILES[$face]['name'];					//�û����ϴ��ļ���ȫ��
		$userNameExplode=explode('.',$userName);			//�� . ���ָ��ļ����ͺ�׺��ʹ֮��Ϊ����Ԫ��
		$userNamePop=array_pop($userNameExplode);			//������һ��Ԫ�أ�������ļ��ĺ�׺
		$userNameStrtolower=strtolower($userNamePop);		//������ĺ�׺ת����Сд	
		if(!in_array($userNameStrtolower,$tmpName)){		//�ж������û��ϴ����ļ���׺������PHP�޶��ĺ�׺ʱ...
			exit('�ļ���׺���Ϸ�');
		}
		//�ж�[face]�µ�[type]
		$tmpType=array('image/gif','image/png','image/jpeg');		//��PHP�޶����ļ�����
		$userType=$_FILES[$face]['type'];							//�û��ϴ����ļ�����
		if(!in_array($userType,$tmpType)){							//�ж������ϴ����ļ����Ͳ������޶����ļ�����ʱ...
			exit('�ļ������Ͳ��Ϸ�!');
		}
		//�ж�[face]�µ�[tmp_name]
		$userTmp=$_FILES[$face]['tmp_name'];				//�ϴ��ļ���Ĭ��·��
		if(is_uploaded_file($userTmp)){						//�ж��������ϴ����ļ�����ʱ�ļ�����ʱ...
			$newTmp=rtrim($newTmp,'/').'/';					//�µ�·��
			$newName=uniqid().'.'.$userNamePop;				//�µ��ļ���������ļ���.�û��ϴ��ļ��ĺ�׺
			$newTmpName=$newTmp.$newName;					//��д�µ��ļ�����·����+�µ��ļ���	
			if(!file_exists($newTmp)){						//�ж��������趨��·��������ʱ...
				mkdir($newTmp,0777,true);					//�����µ�·���ļ���
			}
			if(move_uploaded_file($userTmp,$newTmpName)){	//�µ�·���µ��µ��ļ���
				exit('�ļ��ƶ��ɹ����ϴ��ɹ�');
			}else{
				exit('�ļ��ƶ�ʧ��');
			}
		}else{												//�ж�����Ŀ���ļ������û��ϴ����ļ�ʱ...
			exit('�����ϴ��ļ����ϴ���ֹ��');
		}
		
		
	}else{														//�ж�������ϴ����ɹ�...
		switch($userError){										//�ϴ����ɹ���Ķ���
			case 1:echo '�ļ���С�����������ļ�������';break;
			case 2:echo '�ļ���С�����˱�������';break;
			case 3:echo 'ֻ�в����ļ����ϴ�';break;
			case 4:echo 'û���ļ����ϴ�';break;
			case 6:echo '�Ҳ���ϵͳ��ʱĿ¼';break;
			case 7:echo '�ļ�д��ʧ��';break;
			default:echo '����㿪��Ц�İ�~';
		}
	}
}
$result=userface('face','./uploaduserface');
echo $result;

[=================================================================���ۺϡ� ����д�ɺ�����ʽ�Ķ��ļ��ϴ���===========================================]

function userface($face,$newTmp){
	//�������ļ�
	for($i=0;$i<count($_FILES[$face]['name']);$i++){
		//�ж�[face]�µ�[error]
		$userError=$_FILES[$face]['error'][$i];
		if(!$userError){											//�ж�������ϴ��ɹ�...
			//�ж�[face]�µ�[size]
			$tmpSize=1024*1024*2;									//�޶���ʱ�ļ���������
			$userSize=$_FILES[$face]['size'][$i];						//�û����ϴ��ļ������
			if($userSize>$tmpSize){									//�ж������ϴ����ļ���������޶������ʱ...
				exit('�ļ��������');
			}
			//�ж�[face]�µ�[name]
			$tmpName=array('gif','png','jpeg','jpg','jpe');		//�޶���ʱ�ļ��ĺ�׺��
			$userName=$_FILES[$face]['name'][$i];					//�û����ϴ��ļ���ȫ��
			$userNameExplode=explode('.',$userName);			//�� . ���ָ��ļ����ͺ�׺��ʹ֮��Ϊ����Ԫ��
			$userNamePop=array_pop($userNameExplode);			//������һ��Ԫ�أ�������ļ��ĺ�׺
			$userNameStrtolower=strtolower($userNamePop);		//������ĺ�׺ת����Сд	
			if(!in_array($userNameStrtolower,$tmpName)){		//�ж������û��ϴ����ļ���׺������PHP�޶��ĺ�׺ʱ...
				exit('�ļ���׺���Ϸ�');
			}
			//�ж�[face]�µ�[type]
			$tmpType=array('image/gif','image/png','image/jpeg');		//��PHP�޶����ļ�����
			$userType=$_FILES[$face]['type'][$i];							//�û��ϴ����ļ�����
			if(!in_array($userType,$tmpType)){							//�ж������ϴ����ļ����Ͳ������޶����ļ�����ʱ...
				exit('�ļ������Ͳ��Ϸ�!');
			}
			//�ж�[face]�µ�[tmp_name]
			$userTmp=$_FILES[$face]['tmp_name'][$i];				//�ϴ��ļ���Ĭ��·��
			if(is_uploaded_file($userTmp)){						//�ж��������ϴ����ļ�����ʱ�ļ�����ʱ...
				$newTmp=rtrim($newTmp,'/').'/';					//�µ�·��
				$newName=uniqid().'.'.$userNamePop;				//�µ��ļ���������ļ���.�û��ϴ��ļ��ĺ�׺
				$newTmpName=$newTmp.$newName;					//��д�µ��ļ�����·����+�µ��ļ���	
				if(!file_exists($newTmp)){						//�ж��������趨��·��������ʱ...
					mkdir($newTmp,0777,true);					//�����µ�·���ļ���
				}
				if(move_uploaded_file($userTmp,$newTmpName)){	//�µ�·���µ��µ��ļ���
					echo '�ļ��ƶ��ɹ����ϴ��ɹ�';
				}else{
					echo '�ļ��ƶ�ʧ��';
				}
			}else{												//�ж�����Ŀ���ļ������û��ϴ����ļ�ʱ...
				exit('�����ϴ��ļ����ϴ���ֹ��');
			}
			
			
		}else{														//�ж�������ϴ����ɹ�...
			switch($userError){										//�ϴ����ɹ���Ķ���
				case 1:echo '�ļ���С�����������ļ�������';break;
				case 2:echo '�ļ���С�����˱�������';break;
				case 3:echo 'ֻ�в����ļ����ϴ�';break;
				case 4:echo 'û���ļ����ϴ�';break;
				case 6:echo '�Ҳ���ϵͳ��ʱĿ¼';break;
				case 7:echo '�ļ�д��ʧ��';break;
				default:echo '����㿪��Ц�İ�~';
			}
		}
	}
}
$result=userface('face','./uploaduserface');
echo $result;
[===================================================================================================================================================]