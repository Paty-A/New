<?


function costcalc($item_id) {
  $totalcost=0;
  $componentcost=0;
  $sql = "SELECT comm_item.*,comm_component.*,comm_item.item_name AS ingredient FROM comm_item,comm_component WHERE      comm_component.item_id=$item_id AND comm_item.cid=comm_component.cid ORDER BY comm_item.item_name ASC";
  $result = mysql_query($sql);
  while ($row=mysql_fetch_array($result)) {
    $quantity = $row['quantity'];
    $item_size = $row['item_size'];
    $item_price = $row['item_price'];
    if ($item_size!=0) {
	$componentcost = ($quantity/$item_size)*$item_price;
	}
	else {
	$componentcost = 0;
	}
    $totalcost = $totalcost+$componentcost;
  }

return $totalcost;
} // end costcalc()

?>

<div id="title">Commissary Costs</div>




<?

// select all of the items 
$sql = "SELECT * FROM `comm_finalitem` WHERE hide!=1 ORDER BY item_name ASC";
$result = mysql_query($sql);
while ($row=mysql_fetch_array($result)) {
  $item_id = $row['item_id'];
  $type = $row['type'];
  $totalcost = costcalc($item_id);
  if ($row['item_yield']!=0) {
    $totalcost = $totalcost/$row['item_yield'];
    $totalcost = round($totalcost,2); 
  }
  else {
    $totalcost = 0;
  }
  
  // if size in gallons, take the lbs (16oz) and multiply by 8 to get to 128oz (1 gallon)
  if ($type==2) {
  $totalcost = $totalcost*8;	  
  }
  
// Update the current price in comm_finalitem table
$sql2 = "UPDATE `comm_finalitem` SET curr_price='$totalcost' WHERE item_id=$item_id LIMIT 1";
mysql_query($sql2);

// Update items in JS commissary vendor with the latest price
$sql2 = "UPDATE `item` SET item_set_price=$totalcost WHERE item_vendor=19 AND item_num=$item_id LIMIT 1";
mysql_query($sql2);
}

// Print the per pound ingredients

echo "<strong>Cooked Items</strong>";
echo "<table border=\"1\">
	  <tr>
      <th>Product Name</th>
      <th>Cost per Pound</th>
      </tr>";
	  
// select all final items that use per pound (type=1)
$sql = "SELECT * FROM `comm_finalitem` WHERE type=1 AND hide!=1 ORDER BY item_name ASC";
$result = mysql_query($sql);
while ($row=mysql_fetch_array($result)) {
  $item_id = $row['item_id'];
  echo "<tr>";
  echo "<td>$row[item_name]</td>";
  echo "<td align=\"center\"><strong>$$row[curr_price]</strong></td>";
  echo "</tr>";
}
echo "</table><br>";

// Print the per gallon ingredients
echo "<strong>Dressings</strong>";
echo "<table border=\"1\">
	  <tr>
      <th>Product Name</th>
      <th>Cost per Gallon</th>
      </tr>";
	  
// select all final items that use per pound (type=1)
$sql = "SELECT * FROM `comm_finalitem` WHERE type=2 ORDER BY item_name ASC";
$result = mysql_query($sql);
while ($row=mysql_fetch_array($result)) {
  $item_id = $row['item_id'];
  echo "<tr>";
  echo "<td>$row[item_name]</td>";
  echo "<td align=\"center\"><strong>$$row[curr_price]</strong></td>";
  echo "</tr>";
}
?>

</table>