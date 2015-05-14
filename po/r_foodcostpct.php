<?
require 'includes/limitdates.php';

$item_id = $_POST['item_id'];
$sql = "SELECT item.item_name FROM item WHERE item_id=$item_id";
$result = mysql_query($sql);
$row = mysql_fetch_array($result);
$item_name = $row['item_name'];
?>
<div id="title"><?=$item_name?> - Food Cost %</div>

<table>
<tr>
<th>Order Date</th>
<th>Food Cost Percentage</th>
</tr>
<?

$sql = "
SELECT item.*,item_order.unit_price,po.*
FROM item,item_order,po
WHERE item.item_id=item_order.item_id
AND item_order.order_id=po.order_id
AND item.item_id=$item_id
$extrasql
ORDER BY po.order_timestamp DESC";
$result = mysql_query($sql);
while ($row=mysql_fetch_array($result)) {
  $item_yield = $row['item_yield'];
  $item_set_price = $row['item_set_price'];
  $item_menu_price = $row['item_menu_price'];
  $unit_price = $row['unit_price'];
  if ($unit_price!=0) {
  $foodcost = ($unit_price/$item_yield)/$item_menu_price;
  $foodcost = $foodcost*100;
  $foodcost = round($foodcost,2);
  $order_date = substr($row['order_timestamp'],4,2) . "/" . substr($row['order_timestamp'],6,2) . "/"  . substr($row['order_timestamp'],0,4);
  echo "<tr>";
  echo "<td>$order_date</td>";
  echo "<td>$foodcost%</td>";
  echo "</tr>";
  } // end if
}

?>
</table>