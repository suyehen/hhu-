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
                //此签到页面每20秒刷新一次，以便于接受教师的通知
                echo '<meta http-equiv="refresh" content="20;url=student_page.php">';
                //此签到页面每600秒将会自动返回登陆界面
                echo '<meta http-equiv="refresh" content="600;url=index.html">';
                //连接stu_sign数据库的stu_sign表
                header('Content-type:text/html;charset=utf-8');
                $link=@mysqli_connect('localhost','root','Hejinxuan010859','',3306);
                if(mysqli_connect_errno()){
                    exit(mysqli_connect_error());
                }
                mysqli_set_charset($link,'utf8');
                mysqli_select_db($link,'stu_sign');
                //仅输出最后的6条信息
                $query='SELECT * FROM stu_sign WHERE 
                stu_id="'.$_COOKIE['userid'] . '" order by stu_signinfo desc limit 6';
                mysqli_query($link,$query);
                $result=mysqli_query($link,$query);
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
        <form action="check_signin.php" method="POST">
            <input type="submit" value="签到" class="signin_botton">
        </form>
        <script><?php
            if(isset($_COOKIE['remind'])){
                echo "alert('请立即签到!');";
                setcookie("remind", "sign in!!!!" , time()-1);
                
            }
        ?></script>


</body>
</html>

