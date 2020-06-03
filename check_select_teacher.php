<?php
    //检查用户的前三个COOKIE是否有任意一个过期，如果有过期则返回重新注册
    if((!isset($_COOKIE['username'])) ||(!isset($_COOKIE['userid']))||(!isset($_COOKIE['userpassword']))){
        Header("Location:index.html");
    }
    //连接数据库
	$flag1=false;
    header('Content-type:text/html;charset=utf-8');
	$link=@mysqli_connect('localhost','root','Hejinxuan010859','',3306);
	if(mysqli_connect_errno()){
		exit(mysqli_connect_error());
	}
    mysqli_set_charset($link,'utf8');
    //选择数据库
    mysqli_select_db($link,'username_password');
    //$teachername默认值为default
    //此处是用GET方法获取form表单提交的数据
	$teachername = isset($_GET['teachername'])?$_GET['teachername']:"default";
	$query='SELECT tea_name FROM teacher';
	mysqli_query($link,$query);
    $result=mysqli_query($link,$query);
    //查询学生输入的教师是否存在
	while($row = mysqli_fetch_array($result,MYSQLI_ASSOC)){
        if($teachername==$row['tea_name']){	
			$flag1=true;
			break;
        }
    }
    //如果查询的教师存在则注册成功
    if($flag1){
        //设置COOKIE存储此学生选择的教师
        // setcookie("teachername",$teachername,time()+3600);

        //将学生信息存至数据库中
        $query='update student set name="' .$_COOKIE['username']. '" where stu_id="' .$_COOKIE['userid'].'"';
        mysqli_query($link,$query); 
        $query='update student set password="' .$_COOKIE['userpassword']. '" where stu_id="' .$_COOKIE['userid']. '"';
        mysqli_query($link,$query); 
        $query='update student set tea_name='. "'" .$teachername. "'" .' where stu_id='. "'" .$_COOKIE['userid']. "'";
        mysqli_query($link,$query); 
        //跳转至学生管理界面
        Header("Location:student_page.php");
    }
    //教师不存在则返回上一页重新输入
    else{     
        Header("Location:select_teacher.php");
    }





	mysqli_close($link);
?>