<?
require_once("config.php");

$action = $_POST['action'];
//$item_id = $_POST['item_id'];
$item_num = $_POST['item_num'];
$item_name = $_POST['item_name'];
$item_set_price = $_POST['item_set_price'];
$item_yield = $_POST['item_yield'];
$item_menu_price = $_POST['item_menu_price'];
$item_vendor = $_POST['item_vendor'];
$current_url = $_POST['current_url'];


switch ($curr_action) {

case "additem":
$sql = "INSERT INTO `item` (item_num, item_name, item_vendor) VALUES ('$item_num','$item_name',$item_vendor)";
mysql_query($sql);
$current_url .= "&msgid=1";
header("Location: index.php?p=items&msgid=1&vid=$item_vendor");
break;

case "delitem":
//$sql = "DELETE FROM `item` WHERE item_id = $item_id LIMIT 1";
//echo $sql;
//mysql_query($sql);
header("Location: index.php?p=items&msgid=2");
break;

case "hide":
$item_id = $_GET['item_id'];
$sql = "UPDATE `item` SET `hide` = '1' WHERE item_id = $item_id LIMIT 1";
//echo $sql;
mysql_query($sql);
header("Location: index.php?p=items&msgid=9&vid=$vid");
break;

case "unhide":
$item_id = $_GET['item_id'];
$sql = "UPDATE `item` SET `hide` = '0' WHERE item_id = $item_id LIMIT 1";
//echo $sql;
mysql_query($sql);
header("Location: index.php?p=items&msgid=10&vid=$vid");
break;



// USE WITH EDITINPLACE
case "edit":
	$editable_fields = array("item_num", "item_name", "item_set_price", "item_yield", "item_menu_price");
	$edit_field = $_POST['field'];
	$edit_value = $_POST['content'];
	$id = preg_replace("/[a-z]/i", "", $_POST['id']); // item ID

	if(in_array($edit_field, $editable_fields)) {
		$sql = "UPDATE `item` SET `$edit_field` = '$edit_value' WHERE item_id = $id LIMIT 1";
		mysql_query($sql);
	}

	echo ($edit_value) ? $edit_value : "&nbsp;";
break;
}

?>