<?
require_once("config.php");

$cid=$_POST['cid'];
$item_id=$_POST['item_id'];
$quantity=$_POST['quantity'];

$sql = "UPDATE comm_component SET quantity=$quantity WHERE cid=$cid AND item_id=$item_id LIMIT 1";
mysql_query($sql);

header("Location: index.php?p=comm_editfinal&item_id=$item_id");

?>