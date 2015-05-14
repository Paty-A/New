<?
require_once("config.php");

$order_id = $_GET['order_id'];

$sql = "UPDATE `archive` SET submitted=0 WHERE order_id=$order_id LIMIT 1";
mysql_query($sql);

header("Location: index.php?p=completeorder&order_id=$order_id");
?>