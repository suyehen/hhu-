<!doctype html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>实践课程考勤系统</title>
	</head>

<body style="background-image: url(img/login-bg.jpg);">
	<!-- 此处是用GET方法进行提交 -->
	<form action="check_select_teacher.php" action="GET">
		请输入你要选择的教师名称：
		<input type="text" name="teachername" required>
		<input type="submit" value="提交">
	</form>

	<?php
	header('Content-type:text/html;charset=utf-8');
	$link=@mysqli_connect('localhost','root','Hejinxuan010859','',3306);
	if(mysqli_connect_errno()){
		exit(mysqli_connect_error());
	}
	mysqli_set_charset($link,'utf8');
	mysqli_select_db($link,'username_password');
	$query='SELECT tea_name FROM teacher';
	mysqli_query($link,$query);
	$result=mysqli_query($link,$query);
	echo "<br>";
	echo "现有教师:";
	while($row = mysqli_fetch_array($result,MYSQLI_ASSOC))
	{
		echo "<br><tr><td> {$row['tea_name']}</td></tr>";
	}
	





	mysqli_close($link);
?>


</body>
</html>


