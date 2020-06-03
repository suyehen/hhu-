<?php
	$flag1=false;
	header('Content-type:text/html;charset=utf-8');
	$link=@mysqli_connect('localhost','root','Hejinxuan010859','',3306);
	if(mysqli_connect_errno()){
		exit(mysqli_connect_error());
	}
	mysqli_set_charset($link,'utf8');
    mysqli_select_db($link,'username_password');
	//本页面$userid、username、userpassword默认值为default
	$userid = isset($_POST['userid'])?$_POST['userid']:"default";
	$username = isset($_POST['username'])?$_POST['username']:"default";
	$userpassword = isset($_POST['userpassword'])?$_POST['userpassword']:"default";
	$query='SELECT stu_id FROM student';
	mysqli_query($link,$query);
	$result=mysqli_query($link,$query);
	while($row = mysqli_fetch_array($result,MYSQLI_ASSOC)){
        if($userid==$row['stu_id']){	
			$flag1=true;
			break;
        }
	}
    if($flag1){
		//设置三个COOKIE分别存储此学生的姓名、密码
		setcookie("username",$username,time()+600);
		setcookie("userid",$userid,time()+600);
		setcookie("userpassword",$userpassword,time()+600);
		Header("Location:select_teacher.php");
    }
    else{
		Header("Location:register_student.html");
		echo "false";
    }




	mysqli_close($link);
?>