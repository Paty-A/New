<?
require_once("config.php");


switch ($curr_action) {

case "add":
$loc_name=$_POST['loc_name'];
$loc_address=$_POST['loc_address'];
$loc_city=$_POST['loc_city'];
$loc_state=$_POST['loc_state'];
$loc_zip=$_POST['loc_zip'];
$direct_phone=$_POST['direct_phone'];


$sql = "INSERT INTO `location` (loc_name,loc_address,loc_city,loc_state,loc_zip,direct_phone) VALUES ('$loc_name','$loc_address','$loc_city','$loc_state','$loc_zip','$direct_phone')";
mysql_query($sql);
header("Location: index.php?p=stores&msgid=8");
break;

/*
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
*/
}
?>
