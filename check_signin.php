<?php   
    //签到
    //检查之前位用户建立的COOKIE是否有过期，如果过期则返回重新注册
    if(!isset($_COOKIE['userid'])){
        Header("Location:index.html");
    }
    //连接数据库
	header('Content-type:text/html;charset=utf-8');
	$link=@mysqli_connect('localhost','root','Hejinxuan010859','',3306);
	if(mysqli_connect_errno()){
		exit(mysqli_connect_error());
    }
    $stu_id=$_COOKIE['userid'];
	mysqli_set_charset($link,'utf8');
    mysqli_select_db($link,'username_password');
    //连接username_password数据库以获取学生输入的学号所对应的学生姓名
    $query='SELECT name FROM student WHERE stu_id='.$stu_id;
	mysqli_query($link,$query);
	$result=mysqli_query($link,$query);
    $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
    //连接stu_sign数据库以存储学生的签到信息
    mysqli_select_db($link,'stu_sign');
    //insert into stu_id(stu_id,stu_name,stu_signinfo) values($stu_id,"$row['name']",time());
    $query='insert into stu_sign(stu_id,stu_name,stu_signinfo) 
            values('.$stu_id.',"'.$row['name'].'",'.time().')';
	mysqli_query($link,$query);                
    mysqli_close($link);
    header("Location:student_page.php");

?>