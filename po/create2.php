<?
require_once("config.php");

$user_id = $_POST['user_id'];
$loc_id = $_POST['loc_id'];
$month = $_POST['month'];
$day = $_POST['day'];
$year = $_POST['year'];
$vid = $_POST['vid'];
$order_timestamp = $year . $month . $day;
$user_ip = $_SERVER['REMOTE_ADDR'];

$sql = "INSERT INTO `po` (order_user,order_timestamp,order_loc,user_ip,vid) VALUES ($user_id,$order_timestamp,$loc_id,'$user_ip',$vid)";

//echo $sql;
mysql_query($sql);

$last_id = mysql_insert_id();

header("Location: index.php?p=order&order_id=$last_id");

?>