<?php 
    setcookie("remind","remind you",time()+90);
    echo "已成功发出通知，通知将在90s后过期";
?>