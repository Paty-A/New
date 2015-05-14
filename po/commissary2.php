<?
require_once("config.php");

$action = $_POST['action'];
//$item_id = $_POST['item_id'];
$item_name = $_POST['item_name'];
$item_price = $_POST['item_price'];
$item_notes = $_POST['item_notes'];
$item_size = $_POST['item_size'];

$current_url = $_POST['current_url'];
$curr_action = $_POST['curr_action'];
if (!$curr_action) {
$curr_action = $_GET['curr_action'];
}

switch ($curr_action) {

case "additem":
$currtime = time();
$sql = "INSERT INTO `comm_item` (item_name, item_price, item_notes, last_updated) VALUES ('$item_name','$item_price','$item_notes',$currtime)";
mysql_query($sql);
$current_url .= "&msgid=1";
header("Location: index.php?p=commissary&msgid=1");
break;

case "addfinalitem":
$currtime = time();
$sql = "INSERT INTO `comm_finalitem` (item_name, item_yield) VALUES ('$item_name','$item_yield')";
mysql_query($sql);
$current_url .= "&msgid=1";
header("Location: index.php?p=commissary&msgid=1");
break;

case "addcomponent":
$quantity = $_POST['quantity'];
$cid = $_POST['cid'];
$item_id = $_POST['item_id'];

$sql = "INSERT INTO `comm_component` (item_id, cid, quantity) VALUES ('$item_id','$cid','$quantity')";
mysql_query($sql);
$current_url .= "&msgid=1";
header("Location: index.php?p=comm_editfinal&item_id=$item_id");
break;


case "hide":
$cid = $_GET['cid'];
$sql = "UPDATE `comm_item` SET `hide` = '1' WHERE cid = $cid LIMIT 1";
//echo $sql;
mysql_query($sql);
header("Location: index.php?p=commissary");
break;

case "hidefinal":
$item_id = $_GET['item_id'];
$sql = "UPDATE `comm_finalitem` SET `hide` = '1' WHERE item_id = $item_id LIMIT 1";
//echo $sql;
mysql_query($sql);
header("Location: index.php?p=commissary");
break;

/*
case "unhide":
$item_id = $_GET['item_id'];
$sql = "UPDATE `item` SET `hide` = '0' WHERE item_id = $item_id LIMIT 1";
//echo $sql;
mysql_query($sql);
header("Location: index.php?p=items&msgid=10&vid=$vid");
break;

*/

// USE WITH EDITINPLACE
case "edit":
	$editable_fields = array("item_name", "item_price", "item_size", "item_notes");
	$edit_field = $_POST['field'];
	$edit_value = $_POST['content'];
	$id = preg_replace("/[a-z]/i", "", $_POST['id']); // item ID

	if(in_array($edit_field, $editable_fields)) {
	$currtime = time();
		$sql = "UPDATE `comm_item` SET `$edit_field` = '$edit_value' WHERE cid = $id LIMIT 1";
		mysql_query($sql);
		$sql = "UPDATE `comm_item` SET last_updated=$currtime WHERE cid=$id LIMIT 1";
		mysql_query($sql);
	}

	echo ($edit_value) ? $edit_value : "&nbsp;";
break;
}

?>