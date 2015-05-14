<?php
error_reporting(E_ALL);
include("config.php");

//$sql = "UPDATE `user` SET `user_disable` = '1' WHERE user_id = $user_id LIMIT 1";
$sql = "INSERT into `user` (user_fname,user_lname,username,user_email) VALUES ('$_POST[user_fname]','$_POST[user_lname]','$_POST[username]','$_POST[user_email]')";
//echo $sql;
mysql_query($sql);

header("Location: index.php?p=users");
break;
?>