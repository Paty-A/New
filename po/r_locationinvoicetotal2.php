<?


$daterange = $_POST['daterange'];

if (!$daterange) {
$daterange = $_GET['daterange'];
}



//if (!is_numeric($date1)||!is_numeric($date2)) {
//    $date1 = "";
//    $date2 = "";
//  }
//20080114-20080120

$date1 = substr($daterange, 0, 8);
$date2 = substr($daterange, 9, 16);

$date1_nice = substr($date1,4,2) . "/" . substr($date1,6,2) . "/"  . substr($date1,0,4);
$date2_nice = substr($date2,4,2) . "/" . substr($date2,6,2) . "/"  . substr($date2,0,4);
  
if ($date1 && $date2) {
  $extrasql = "AND po.order_timestamp BETWEEN $date1 AND $date2 ";
  $limit_dates = true;
  $curr_dates = "<div>Between $date1 and $date2</div><br>";
}
else {
  $extrasql = "";
  $limit_dates = false;
}


if (!is_numeric($date1)||!is_numeric($date2)) {
    $date1 = "";
    $date2 = "";
  }

  
if ($date1 && $date2) {
  $extrasql = "AND po.order_timestamp BETWEEN $date1 AND $date2 ";
  $limit_dates = true;
  $curr_dates = "<div>Between $date1 and $date2</div><br>";
}
else {
  $extrasql = "";
  $limit_dates = false;
}



$loc_id = $_GET['loc_id'];
$vid = $_GET['vid'];

//columns: Vendor name, Total, Check paypable to
$sql = "SELECT location.loc_name FROM location WHERE loc_id=$loc_id";
$result = mysql_query($sql);
$row = mysql_fetch_array($result);
$loc_name = $row['loc_name'];


//echo $daterange . "<br>";
//echo $date1 . " " . $date2; 

?>
<div id="title">Invoices for 
<? 
echo $loc_name . " between ";
echo $date1_nice . " & " . $date2_nice;
?>

</div> <br>


<table>

<tr>
<th>Vendor Name</th>
<th>Invoice Total</th>
<th>Check Payable</th>
<th>Check Sent?</th>
</tr>

<?
//$sql = "SELECT distinct * FROM `po` WHERE order_loc=$loc_id $extrasql
//ORDER BY po.order_timestamp DESC";
$sql = "
SELECT vendor.vid,vendor.v_name,po.check_sent,po.order_id,SUM(po.order_grand_total) AS grand_total,vendor.check_payable 
FROM vendor,po 
WHERE po.order_loc=$loc_id $extrasql
AND po.vid=vendor.vid 
AND po.order_checkin=1 
GROUP BY vendor.v_name 
ORDER BY po.order_timestamp DESC";
//echo $sql;

$result = mysql_query($sql);
while ($row=mysql_fetch_array($result)) {

  $grand_total = round($row['grand_total'],2);
  $v_name = $row['v_name'];
  $check_payable = $row['check_payable'];
  $vid = $row['vid'];
  $check_sent = $row['check_sent'];
  $order_id = $row['order_id'];
echo "<tr>";
echo "<td>$v_name</td>";
echo "<td><a href=\"index.php?p=r_vendor_invoice_total&vid=$vid&loc_id=$loc_id&date1=$date1&date2=$date2\">$$grand_total</a></td>";
echo "<td>$check_payable</td>";
echo "<td align=\"center\">";
if ($check_sent==1) {
echo "<a style=\"text-decoration:none\"  href=\"r_locationinvoicetotal2_action.php?loc_id=$loc_id&daterange=$daterange&order_id=$order_id&check_sent=0\">&#10004;</a>";
}
else {
echo "<a style=\"text-decoration:none\"  href=\"r_locationinvoicetotal2_action.php?loc_id=$loc_id&daterange=$daterange&order_id=$order_id&check_sent=1\">&#9744;</a>";

}
echo "</td>";
//echo "<td><a href=\"index.php?p=finalorder&order_id=$order_id\">$order_id</a></td>";
echo "</tr>";
   //} // end if
}
?>
</table><br />
Click the invoice total for a breakdown of the invoices during this period.