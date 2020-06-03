<?php
	//检查帐号是否正确
	$flag01=false;
    //获取index.html表单所提交的数据
	$stu_id = isset($_POST['username'])?$_POST['username']:"default";
	$password = isset($_POST['userpassword'])?$_POST['userpassword']:"default";
    //连接数据库username_password
	header('Content-type:text/html;charset=utf-8');
	$link=@mysqli_connect('localhost','root','Hejinxuan010859','',3306);
	if(mysqli_connect_errno()){
		exit(mysqli_connect_error());
	}
	mysqli_set_charset($link,'utf8');
	mysqli_select_db($link,'username_password');
	//检查输入的学号是否存在
	$query='SELECT stu_id FROM student';
	mysqli_query($link,$query);
	$result=mysqli_query($link,$query);
	while($row = mysqli_fetch_array($result,MYSQLI_ASSOC)){
		//如果输入的学号存在
        if($stu_id==$row['stu_id']){
			$flag01=true;
			//检查密码是否正确
			$query='SELECT password FROM student where stu_id="'.$stu_id.'"';
			mysqli_query($link,$query);
			$result=mysqli_query($link,$query);
			$row = mysqli_fetch_array($result,MYSQLI_ASSOC);
			if($row['password']==$password){
				//给学号设置一个cookie,为后面签到做准备
				setcookie("userid",$stu_id,time()+600);                
	            mysqli_close($link);
				header("Location:student_page.php");
			}
			else{
				echo "密码错误，请重新输入";
			}
        }
	}
	if(!$flag01){
		echo "您输入的学号不存在，请重新输入";
		
	}




	mysqli_close($link);
?>
