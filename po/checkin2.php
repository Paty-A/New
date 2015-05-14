<?
require_once("config.php");

$curr_action = $_POST['action'];
switch ($curr_action) {

// USE WITH EDITINPLACE
case "edit":
	$editable_fields = array("received", "unit_price", "num_returned", "item_comment2");
	$edit_field	= $_POST['field'];
	$edit_value	= $_POST['content'];
	$item_id	= $_POST['item_id'];
	$order_id	= $_POST['order_id'];

	if(in_array($edit_field, $editable_fields)) {
		$sql = "UPDATE `item_order` SET `$edit_field` = '$edit_value' WHERE `item_id` = '$item_id' AND `order_id` = '$order_id' LIMIT 1";
		mysql_query($sql);
	}

	echo "success";
break;

case "complete":
$curr_time = time();
$order_id = $_POST['order_id'];
$order_check_total = $_POST['order_check_total'];
$shipping_tax = $_POST['shipping_tax'];
$product_credits = $_POST['product_credits'];
$sql = "UPDATE `po` SET order_checkin=1,checkin_timestamp=$curr_time,order_check_total=$order_check_total,product_credits=$product_credits,shipping_tax=$shipping_tax WHERE order_id=$order_id LIMIT 1";
mysql_query($sql);
header("Location: index.php?p=finalorder&order_id=$order_id");


break;

}




?>
