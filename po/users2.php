<?
require_once("config.php");


switch ($curr_action) {


case "disable":
$user_id = $_GET['user_id'];
$sql = "UPDATE `user` SET `user_disable` = '1' WHERE user_id = $user_id LIMIT 1";
//echo $sql;
mysql_query($sql);
header("Location: index.php?p=users&msgid=9&vid=$vid");
break;

case "permissions":
$user_id = $_GET['user_id'];
if (!$user_id) {
$user_id = $_POST['user_id'];
}
$loc_id = $_GET['loc_id'];
$change = $_GET['change'];
$user_admin = $_POST['user_admin'];

if ($change=="add") {
$sql = "INSERT INTO `user_location` (user_id,loc_id) VALUES ('$user_id','$loc_id')";
mysql_query($sql);
header("Location: index.php?p=edituser&user_id=$user_id");
}

elseif ($change=="remove") {
$sql = "DELETE FROM `user_location` WHERE user_id=$user_id AND loc_id=$loc_id LIMIT 1";
mysql_query($sql);
header("Location: index.php?p=edituser&user_id=$user_id");
}

// regular submitting of form from edituser.php
else {
  if ($user_admin) {
  $sql = "UPDATE `user` SET user_admin=1 WHERE user_id=$user_id LIMIT 1";
  }
  else {
  $sql = "UPDATE `user` SET user_admin=0 WHERE user_id=$user_id LIMIT 1";
  }
  
mysql_query($sql);  
header("Location: index.php?p=edituser&user_id=$user_id");  
} // end else


//print_r( $_POST );
break;

case "changepassword":
$user_id = $_POST['user_id'];
$user_pass = $_POST['user_pass'];
$sql = "UPDATE `user` SET `user_pass` = '$user_pass' WHERE user_id = $user_id LIMIT 1";
//echo $sql;
mysql_query($sql);
header("Location: index.php?p=edituser&user_id=$user_id&msgid=12");
break;

// USE WITH EDITINPLACE
case "edit":
	$editable_fields = array("user_lname", "user_fname", "username", "user_email", "user_cell");
	$edit_field = $_POST['field'];
	$edit_value = $_POST['content'];
	$id = preg_replace("/[a-z]/i", "", $_POST['id']); // item ID

	if(in_array($edit_field, $editable_fields)) {
		$sql = "UPDATE `user` SET `$edit_field` = '$edit_value' WHERE user_id = $id LIMIT 1";
		mysql_query($sql);
	}

	echo ($edit_value) ? $edit_value : "&nbsp;";
break;



}



?>