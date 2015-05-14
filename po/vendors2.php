<?
require_once("config.php");

if (!$curr_action) {
  $curr_action = $_GET['curr_action'];
}

switch ($curr_action) {

case "add":
$v_name=$_POST['v_name'];
$v_phone=$_POST['v_phone'];
$v_email=$_POST['v_email'];
$check_payable=$_POST['check_payable'];
$v_address=$_POST['v_address'];

$sql = "INSERT INTO `vendor` (v_name,v_phone,v_fax,v_email,check_payable,v_address) VALUES ('$v_name','$v_phone','$v_fax','$v_email','$check_payable','$v_address')";
mysql_query($sql);
header("Location: index.php?p=vendors&msgid=3");
break;

case "hide":
  $action = $_GET['action'];
  $hide = $_GET['hide'];
  $vid = $_GET['vid'];
  $sql = "UPDATE vendor SET hide=$hide WHERE vid=$vid";
  mysql_query($sql);
  header("Location: index.php?p=vendors&msgid=3");
break;


// USE WITH EDITINPLACE
case "edit":
	$editable_fields = array("v_name", "v_phone", "v_fax", "v_email", "check_payable", "v_address");
	$edit_field = $_POST['field'];
	$edit_value = $_POST['content'];
	$id = preg_replace("/[a-z]/i", "", $_POST['id']); // Vendor ID

	if(in_array($edit_field, $editable_fields)) {
		$sql = "UPDATE `vendor` SET `$edit_field` = '$edit_value' WHERE vid = $id LIMIT 1";
		mysql_query($sql);
	}

	echo ($edit_value) ? $edit_value : "&nbsp;";
break;
}

?>
