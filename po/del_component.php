<?
require_once("config.php");

$cid=$_GET['cid'];
$item_id=$_GET['item_id'];

$sql = "DELETE FROM comm_component WHERE cid=$cid AND item_id=$item_id LIMIT 1";
mysql_query($sql);

header("Location: index.php?p=comm_editfinal&item_id=$item_id");

?>