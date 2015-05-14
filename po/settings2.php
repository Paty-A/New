<?
require_once("config.php");

//$svalue = $_POST['sname'];

$curr_action = $_POST['curr_action'];

switch ($curr_action ) {

case "update":
$sql = "SELECT * FROM `setting` ORDER BY sname ASC";
$result = mysql_query($sql);
while ($row=mysql_fetch_array($result)) {
//$sname = $row['sname'];
//$svalue = $sname;
$currsql = "UPDATE `setting` SET svalue='$cc_email' WHERE sname='cc_email' LIMIT 1";
//echo $currsql;
mysql_query($currsql);
header("Location: index.php?p=settings&msgid=4");
}
break;

case "unlock":
$order_id = $_POST['order_id'];
$sql = "UPDATE `po` SET order_checkin=0 WHERE order_id=$order_id LIMIT 1";
mysql_query($sql);
header("Location: index.php?p=settings&msgid=5");

break;

case "void_order":
$order_id = $_POST['order_id'];
$sql = "SELECT * FROM `po` WHERE order_id=$order_id";
//echo $sql;
$result = mysql_query($sql);
$row = mysql_fetch_array($result);
if ($row['order_void']==0) {
$void_set = 1;
$msg_id=6;
}
else {
$void_set = 0;
$msg_id=7;
}

$sql = "UPDATE `po` SET order_void=$void_set WHERE order_id=$order_id LIMIT 1";
mysql_query($sql);
header("Location: index.php?p=settings&msgid=$msg_id");

break;

}
?>