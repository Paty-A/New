<?
require 'includes/limitdates.php';

$item_id = $_POST['item_id'];
$sql = "SELECT item.item_name FROM item WHERE item_id=$item_id";
//echo $sql;
$result = mysql_query($sql);
$row = mysql_fetch_array($result);
$item_name = $row['item_name'];
?>
<div id="title"><?=$item_name?> - Item Price Fluctuation</div>
<?
if ($limit_dates) {
echo $curr_dates;
}
?>

<table>
<tr>
<th>Order Date</th>
<th>Qty.</th>
<th>Item Price</th>
<th>Total</th>
</tr>

<?



$sql = "
SELECT po.order_id,po.order_timestamp,item_order.* 
FROM po,item_order 
WHERE item_order.item_id = $item_id
AND item_order.order_id=po.order_id 
$extrasql
ORDER BY po.order_timestamp DESC LIMIT 200";
//echo $sql;

//echo $sql;
//reset
$grand_total = 0;
$total_qty = 0;

//echo $sql;


$result = mysql_query($sql);
while ($row=mysql_fetch_array($result)) {
  $unit_price = round($row['unit_price'],2);
  $order_date = substr($row['order_timestamp'],4,2) . "/" . substr($row['order_timestamp'],6,2) . "/"  . substr($row['order_timestamp'],0,4);
  // Do not calculate OR display for items that were not received.
  // removed the limitation of received order
  if ($unit_price!=0) {
  $qty = $row['qty'];
  $total = $unit_price*$qty;
  $total = round($total,2);
  $grand_total = $grand_total+$total;
  $total_qty = $total_qty+$qty;
  
  echo "<tr>";
  echo "<td><a href=\"index.php?p=finalorder&order_id=$row[order_id]\" target=\"_blank\">$order_date</a></td>";
  echo "<td>$qty</td>";
  echo "<td>$$unit_price</td>";
  echo "<td>$$total</td>";
  echo "</tr>";
  }
}
$grand_total = number_format($grand_total,2);
echo "<tr><td colspan=\"4\">Total Quantity: <strong>$total_qty</strong><br>Grand Total: <strong>$$grand_total</strong></td></tr>";
?>

</table>