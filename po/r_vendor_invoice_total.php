<?
// Get some variables
$date1 = $_GET['date1'];
$date2 = $_GET['date2'];
$vid = $_GET['vid'];
$loc_id = $_GET['loc_id'];

// maybe a little formatting
$date1_nice = substr($date1,4,2) . "/" . substr($date1,6,2) . "/"  . substr($date1,0,4);
$date2_nice = substr($date2,4,2) . "/" . substr($date2,6,2) . "/"  . substr($date2,0,4);

// Pull info from DB
$sql = "SELECT * FROM vendor WHERE vid=$vid";
$result = mysql_query($sql);
$row = mysql_fetch_array($result);
$v_name = $row['v_name'];

echo "<div id=\"title\">Invoices for $v_name between $date1_nice and $date2_nice</div>";
?>

<table>

<tr>
<th>ID</th>
<th>Date</th>
<th>Invoice Total</th>
</tr>

<?
$sql = "SELECT * FROM po WHERE vid=$vid AND order_loc=$loc_id AND order_checkin=1 AND order_timestamp BETWEEN $date1 AND $date2";
//echo $sql;
$result = mysql_query($sql);
while ($row=mysql_fetch_array($result)) {
$nice_date=nice_date($row['order_timestamp']);
echo "<tr>";
echo "<td><a href=\"index.php?p=finalorder&order_id=$row[order_id]\">$row[order_id]</a></td>";
echo "<td>$nice_date</td>";
echo "<td>$$row[order_grand_total]</td>";
echo "</tr>";
}

$sql = "SELECT SUM(order_grand_total) as grand_total FROM po WHERE vid=$vid AND order_loc=$loc_id AND order_checkin=1 AND order_timestamp BETWEEN $date1 AND $date2";
//echo $sql;
$result = mysql_query($sql);
$row = mysql_fetch_array($result);
$grand_total = round($row['grand_total'],2);
?>
<tr><td colspan="3">Grand Total: <strong>$<?=$grand_total?></strong></td></tr>
</table>
