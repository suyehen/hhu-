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
	$query='SELECT tea_name FROM teacher';
	mysqli_query($link,$query);
	$result=mysqli_query($link,$query);
	while($row = mysqli_fetch_array($result,MYSQLI_ASSOC)){
        //检查数据库中是否有表单提交的教师姓名
        if($username==$row['tea_name']){	
			$flag1=true;
			break;
        }
    }
    //如果有，则将教师的用户名与密码存入数据库username_password的teacher表中
    if($flag1){
        $query='UPDATE teacher SET tea_username="'.$userid.'" WHERE tea_name="'.$username.'"';
        mysqli_query($link,$query);
        $query='UPDATE teacher SET tea_password="'.$userpassword.'" WHERE tea_name="'.$username.'"';
        mysqli_query($link,$query);
		//设置一个COOKIE存储此教师的姓名
		setcookie("tea_name",$username,time()+600);
        mysqli_close($link);
		Header("Location:teacher_page.php");
    }
    //如果没有，则返回注册页面
    else{
        mysqli_close($link);
        Header("Location:register_student.html");   
    }




?>