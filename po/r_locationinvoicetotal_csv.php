<?

require_once("config.php");
require 'includes/limitdates.php';

$loc_id = $_GET['loc_id'];
$vid = $_GET['vid'];
$numrows = 0;


if ($vid=="all") {
$v_name = "All Vendors";
}
else {
$sql = "SELECT vendor.v_name FROM vendor WHERE vid=$vid";
$result = mysql_query($sql);
$row = mysql_fetch_array($result);
$v_name = $row['v_name'];
}
// get location name
$sql = "SELECT location.loc_name FROM location WHERE loc_id=$loc_id";
$result = mysql_query($sql);
$row = mysql_fetch_array($result);
$loc_name = $row['loc_name'];

$v_name = preg_replace ( '# {1,}#', '_', trim ( $v_name ) );
$loc_name = preg_replace ( '# {1,}#', '_', trim ( $loc_name ) );
$filename = $loc_name . "_" . $v_name . "_" . date("Y-m-d");

   $csv_output = "Invoice ID,Order Date,Total"; 
   $csv_output .= "\n"; 
   
   
$super_total = 0;

$sql = "
SELECT po.* 
FROM po 
WHERE order_loc = $loc_id 
$extrasql
ORDER BY po.order_timestamp DESC";
$result = mysql_query($sql);
while ($row=mysql_fetch_array($result)) {
 $order_date = substr($row['order_timestamp'],4,2) . "/" . substr($row['order_timestamp'],6,2) . "/"  . substr($row['order_timestamp'],0,4);
   $result2 = mysql_query($sql2);
   $grand_total = 0; // reset grand total variable
   $line_total = 0; // reset line total before loop runs again
   
   
   if ($vid=="all") {
   $sql2 = "
   SELECT item.*,vendor.*,item_order.* 
   FROM item,vendor,item_order 
   WHERE item.item_vendor=vendor.vid 
   AND item_order.order_id = $row[order_id] 
   AND item.item_id = item_order.item_id 
   ORDER BY vendor.v_name ASC, item.item_name ASC";
   }
   else {
   
   $sql2 = "
   SELECT item.*,vendor.*,item_order.* 
   FROM item,vendor,item_order 
   WHERE item.item_vendor=vendor.vid 
   AND item_order.order_id = $row[order_id] 
   AND item.item_id = item_order.item_id 
   AND item.item_vendor = $vid 
   ORDER BY vendor.v_name ASC, item.item_name ASC";
   }
   
   /*
   $sql3 = $sql2 . " LIMIT 1";
   echo $sql3;
   $result3 = mysql_query($sql3);
   $vrow = mysql_fetch_array($result3);
   $item_vendor = $vrow['item_vendor'];*/
   
   $result2 = mysql_query($sql2);
   
   // Only run queries if it is for selected vendor
  // if ($item_vendor=$vid) {
   
   // Run loop to calculate grand total of each invoice
   while ($row2=mysql_fetch_array($result2)) {
   
   $line_total = $row2['qty']*$row2['unit_price']; // calculate line total
   $line_total = $line_total - $row2['num_returned']*$row2['unit_price']; // subtract returned items
   $line_total = $line_total; // format line total to 2 decimal places
   $grand_total = $grand_total + $line_total;
   $grand_total = round($grand_total,2);
   $super_total = $super_total + $grand_total;
   }
  
  if ($grand_total!=0) {
  //echo "<tr>";
  //echo "<td><a href=\"index.php?p=finalorder&order_id=$row[order_id]\">$row[order_id]</a></td> ";
  //echo "<td>$order_date</td>";
  //echo "<td>$$grand_total</td>";
  //echo "</tr>";
  $csv_output .= $row['order_id'];
  $csv_output .= ",";
  $csv_output .= $order_date;
  $csv_output .= ",";
  $csv_output .= "$$grand_total";
  $csv_output .= "\n";
  $numrows++;
  
  } // end if
  
  //} // end vendor if statement
  
  } // end while

   

  // while($row = mysql_fetch_array($result)) { 
    //   $csv_output .= "$row[col1],$row[col2]\n";
    //   } 
	
	$numrows++;
	$csv_output .= "TOTAL:,,=SUM(C2:C$numrows)\n";


   header("Content-type: application/vnd.ms-excel");
   header("Content-disposition: csv" . date("Y-m-d") . ".csv");
   header("Content-disposition: attachment; filename=" . $filename.".csv");                
   print $csv_output;
   exit;  
   
   
   
?>