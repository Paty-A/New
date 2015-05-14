<?
require_once("config.php");

$curr_action = $_POST['curr_action'];

if (!$curr_action) {
  $curr_action = $_GET['curr_action'];
}

switch ($curr_action) {

////// Get Vendor Items
case "listitems":
	$sql = "SELECT * FROM item WHERE hide != 1";
	if($_POST['vid']) $sql .= " AND item_vendor = ".$_POST['vid'];
	$sql .= " AND item_id NOT IN (SELECT item_id FROM item_order WHERE order_id = ".$_POST['oid'].") ORDER BY item_name ASC";
	$result = mysql_query($sql);
echo mysql_error();
	echo "<select id='item_id' name='item_id'>";
	while($row = mysql_fetch_array($result)) {
		echo "<option value='".$row['item_id']."'>".$row['item_name']."</option>"; 
	}
	echo "</select>";
break;

////////// Edit Comment
case "editcomment":
     $item_id = $_POST['id'];
     $content = ($content = htmlspecialchars($_POST['content'])) ? $content : "&nbsp;";
	 $order_id = $_POST['order_id'];
	 $item_id = ereg_replace('item','',$item_id);
     //echo htmlspecialchars($content);

	 $sql = "
	 UPDATE `item_order` 
	 SET item_comment = '$content' 
	 WHERE order_id = $order_id 
	 AND item_id = $item_id 
	 LIMIT 1";
	 mysql_query($sql);
	 echo $content;

break;
//////////////////////////

///////// ADD ITEM
case "additem":
$item_id = $_POST['item_id'];
$vid = $_POST['vid'];
$order_id = $_POST['order_id'];
$qty = $_POST['qty'];
$item_comment = $_POST['item_comment'];
$sql = "INSERT INTO `item_order` (item_id,order_id,qty,item_comment) VALUES ($item_id,$order_id,$qty,'$item_comment')";

mysql_query($sql);
header("Location: index.php?p=order&order_id=$order_id&vid=$vid");

break;
///////////////////////////

/////////// DELETE ITEM
case "del":
$item_id = $_GET['item'];
$order_id = $_GET['order'];
$vendor_id = $_GET['vid'];

$sql = "DELETE FROM `item_order` WHERE item_id = $item_id AND order_id = $order_id LIMIT 1";
mysql_query($sql);

header("Location: index.php?p=order&order_id=$order_id&vid=$vendor_id");
break;

/////////////////////////

///////// Complete Order

case "complete":
$order_id = $_POST['order_id'];
$timestamp = time();

$sql = "SELECT item.*,item_order.* FROM item,item_order WHERE item_order.order_id=$order_id and item.item_id=item_order.item_id LIMIT 1";
$row = mysql_fetch_array(mysql_query($sql));
$vid = $row['item_vendor'];

$sql = "UPDATE `po` SET order_complete=1,complete_timestamp='$timestamp' WHERE order_id = $order_id LIMIT 1";
mysql_query($sql);

header("Location: index.php?p=completeorder&order_id=$order_id");
break;


}
//////////////////////

?>
