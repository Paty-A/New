<?
$show = $_GET['show'];


$sql = "
SELECT po.*,location.*, user.* 
FROM po,location,user 
WHERE po.order_loc=location.loc_id 
AND po.order_user=user.user_id 
AND po.order_complete=1 
ORDER BY po.order_timestamp DESC LIMIT 250";

if ($show=="all") {
$sql = "
SELECT po.*,location.*, user.* 
FROM po,location,user 
WHERE po.order_loc=location.loc_id 
AND po.order_user=user.user_id  
ORDER BY po.order_timestamp DESC";
}

$result = mysql_query($sql);
?>


<div id="title">View Completed Orders</div>


<table style="border-width: 0px;"><tr><td style="width:20px;height:20px;background:#66CC66;border-width:1px;">&nbsp;</td><td style="border-width:0px;">= Order Checked In&nbsp;&nbsp;&nbsp;</td>
<td style="width:20px;height:20px;background:#999999;border-width:1px;">&nbsp;</td><td style="border-width:0px;">= Order Void</td>
</tr></table> <br />



<?
if ($show != "all") {
echo "<div class=\"small_link\"><a href=\"index.php?p=view&show=all\">Show All Orders</a></div>";
}
?><br />


<table border="1" width="700">
<tr>
<th><strong>Date</strong></th>
<th><strong><center>Vendor</center></strong></th>
<th><strong><center>ID</center></strong></th>
<th><strong>Placed by</strong></th>
<th><strong>Location</strong></th>
<th>&nbsp;</th>
</tr>

<?
while ($row=mysql_fetch_array($result)) {
  if ($row['order_checkin']==1) {
  $rowbg = "#66CC66"; // ORDER IS Checked in
  $currlink = "[<a href=\"index.php?p=finalorder&order_id=$row[order_id]\">View</a>]";
  }
  else {
  $rowbg = "#ff6666"; // ORDER IS not checked in
  $currlink = "[<a href=\"index.php?p=checkin&order_id=$row[order_id]\">Check In</a>]";
  }
  
  if ($row['order_void']==1) {
  $rowbg = "#999999";
  $currlink = "Void";
  }

$order_date = substr($row['order_timestamp'],4,2) . "/" . substr($row['order_timestamp'],6,2) . "/"  . substr($row['order_timestamp'],0,4);

$vsql = "
SELECT vendor.v_name 
FROM item_order,vendor,item  
WHERE item.item_vendor=vendor.vid
AND item_order.item_id=item.item_id 
AND item_order.order_id=$row[order_id]
LIMIT 1";
$vresult = mysql_query($vsql);
$vrow = mysql_fetch_array($vresult);
$v_name = $vrow['v_name'];

echo "<tr bgcolor=\"$rowbg\">";
echo "<td>$order_date</td>";
echo "<td>$v_name</td>";
echo "<td align=\"center\">$row[order_id]</td>";
echo "<td>$row[user_fname] $row[user_lname]</td>";
echo "<td>$row[loc_name]</td>";
echo "<td align=\"center\">$currlink</td>";
echo "</tr>";

}
?>
</table>