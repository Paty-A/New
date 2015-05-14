<?
require_once("config.php");

$item_id=$_POST['item_id'];

$sql = "UPDATE comm_finalitem SET item_yield=$item_yield WHERE item_id=$item_id LIMIT 1";
mysql_query($sql);

header("Location: index.php?p=comm_editfinal&item_id=$item_id");

?>