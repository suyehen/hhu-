<!doctype html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>实践课程考勤系统</title>
		<link rel="stylesheet" href="css/mainpage.css">
	</head>

<body style="background-image: url(img/login-bg.jpg);">
        <table class="table_frame" border="1" cellpadding="10" width="600">
            <!-- 用<th>标签使其成为表头 -->
            <tr><th>学号</th><th>姓名</th><th>签到时间</th></tr>
            <?php 
                //此查看页面每600秒将会自动返回登陆界面
                echo '<meta http-equiv="refresh" content="600;url=login_teacher.html">';
                header('Content-type:text/html;charset=utf-8');
                $link=@mysqli_connect('localhost','root','Hejinxuan010859','',3306);
                if(mysqli_connect_errno()){
                    exit(mysqli_connect_error());
                }
                mysqli_set_charset($link,'utf8');
                mysqli_select_db($link,'username_password');
                //仅输出最后的6条信息
                // $query='SELECT * FROM stu_sign WHERE 
                // stu_id="'.$_COOKIE['userid'] . '" order by stu_signinfo desc limit 6';
                $query='SELECT stu_id FROM student WHERE tea_name="'.$_COOKIE['tea_name'].'"';
                mysqli_query($link,$query);
                $result=mysqli_query($link,$query);
                while($row=mysqli_fetch_array($result,MYSQLI_ASSOC)){
                    // $row['stu_id'];
                    mysqli_select_db($link,'stu_sign');
                    $query01='SELECT * FROM stu_sign WHERE 
                    stu_id="'.$row['stu_id'] . '" order by stu_signinfo desc limit 6';
                    mysqli_query($link,$query01);
                    $result01=mysqli_query($link,$query01);
                    while($row01=mysqli_fetch_array($result01,MYSQLI_ASSOC)){
                        //记得加28800转换成北京时间，而不是格林威治时间
                        $row01['stu_signinfo']= date("Y-m-d H:i:s",$row01['stu_signinfo']+28800);
                        echo "<tr><td> {$row01['stu_id']}</td>
                            <td>{$row01['stu_name']}</td>
                            <td>{$row01['stu_signinfo']}</td>
                                </tr><br>";
                    }
                }



                //while如果要判断两个条件记得分别括起来。。。
                while($row=mysqli_fetch_array($result,MYSQLI_ASSOC)){
                    //记得加28800转换成北京时间，而不是格林威治时间
                    $row['stu_signinfo']= date("Y-m-d H:i:s",$row['stu_signinfo']+28800);
                    echo "<tr><td> {$row['stu_id']}</td>
                        <td>{$row['stu_name']}</td>
                        <td>{$row['stu_signinfo']}</td>
                            </tr><br>";
                }
                mysqli_close($link);
            ?>
        </table>
        <form action="teacher_page.php" method="POST">
            <input type="submit" value="刷新" class="signin_botton01">
        </form>
        <form action="check_remind.php" method="POST">
            <input type="submit" value="发出签到通知" class="signin_botton02">
        </form>


</body>
</html>

