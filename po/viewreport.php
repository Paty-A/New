<?php

require_once "jpgraph/src/jpgraph.php";
require_once "jpgraph/src/jpgraph_bar.php";

// date-limit settings
  if($_POST['limit_dates']) {
    $from_date = $_POST['from_year']."-".$_POST['from_month']."-".$_POST['from_date'];
    $to_date = $_POST['to_year']."-".$_POST['to_month']."-".$_POST['to_date'];
    $date_sql = " AND DATE(po.order_timestamp) BETWEEN '$from_date' AND '$to_date' ";	
  } else {
    $from_date = "";
    $to_date = "";
    $date_sql = "";
  }

switch ($report_type) {

case "item_price":
  $report_name = "Item Price Fluctuation";
  $item_id = $_POST['item_id'];
  if(empty($item_id)) exit;

  $title_sql = "SELECT item_name FROM item WHERE item_id = $item_id";
  $title_field = "item_name";
  $img = "<img src='makegraph.php?report_type=item_price&id=$item_id&from=$from_date&to=$to_date' />";
break;

case "location_totals":
  $report_name = "Location Totals";
  $location_id = $_POST['location_id'];
  if(empty($location_id)) exit;

  $sql = "
	SELECT DATE_FORMAT(po.order_timestamp,'%Y-%m-%d') as ordertime, format(sum(qty*unit_price), 2) as total
        FROM item_order, po
        WHERE order_loc = $location_id
        AND item_order.order_id = po.order_id
        $date_sql
        GROUP BY po.order_id
        ORDER BY po.order_id DESC
        LIMIT 15";
  $result = mysql_query($sql);
  if(mysql_num_rows($result)==0) {
    $img = "No order invoices found for specified location and date range.";
  }


  $title_sql = "SELECT loc_name FROM location WHERE loc_id = $location_id";
  $title_field = "loc_name";
  if(!isset($img)) $img = "<img src='makegraph.php?report_type=location_totals&id=$location_id&from=$from_date&to=$to_date' />";
break;
}


$title_result = mysql_query($title_sql);
$title = "";
while($row = mysql_fetch_assoc($title_result)) {
	$title = $row[$title_field];
}
?>

<div id="title">
	<?=$report_name?> &#8212; <?=$title?>
	<?=((isset($_POST['limit_dates']))
	? "(" . $from_date . " &#8211; " . $to_date . ")" : "")?>
</div>

<?=$img?>
