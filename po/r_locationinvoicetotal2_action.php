<?
require_once("config.php");

$loc_id = $_GET['loc_id'];
$daterange = $_GET['daterange'];
$check_sent = $_GET['check_sent'];
$order_id = $_GET['order_id'];

if ($check_sent==1) {
$check_sent=1;
}
else {
$check_sent=0;
}

$sql = "UPDATE `po` SET check_sent=$check_sent WHERE order_id=$order_id LIMIT 1";
mysql_query($sql);


header("Location: index.php?p=r_locationinvoicetotal2&loc_id=$loc_id&daterange=$daterange");
?>