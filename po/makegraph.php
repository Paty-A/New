<?php

require_once "config.php";
require_once "jpgraph/src/jpgraph.php";
require_once "jpgraph/src/jpgraph_bar.php";


$graph = new Graph(640, 480, "auto");
$graph->img->SetMargin(50, 30, 80, 120);
$graph->SetShadow();
$graph->title->SetMargin(20);
$graph->subtitle->SetMargin(5);

$id = $_GET['id'];

switch ($_GET['report_type']) {

case "item_price":
  $report_name = "Item Price Fluctuation";

  $from_date = $_GET['from'];
  $to_date = $_GET['to'];
  if(!empty($from_date) && !empty($to_date)) {
    $date_sql = " AND DATE(po.order_timestamp) BETWEEN '$from_date' AND '$to_date' ";
  }

  $sql = "
	SELECT item_order.unit_price, DATE_FORMAT(po.order_timestamp, '%Y-%m-%d') as order_timestamp
	FROM item,item_order,po 
	WHERE item.item_id = $id 
	AND item_order.item_id = $id 
	AND item_order.item_id = item.item_id
	AND item_order.order_id = po.order_id 
	AND item_order.unit_price != 0 
	$date_sql
	ORDER BY po.order_timestamp ASC
	LIMIT 15
	";

  $title_sql = "SELECT item_name FROM item WHERE item_id = $id";
  $title_result = mysql_query($title_sql);
  while($row = mysql_fetch_assoc($title_result)) {
	$title = $row['item_name'];
  }

  $result = mysql_query($sql);


  $graph_data = array(
	"prices"	=> array(),
	"dates"		=> array()
  );
  while ($row=mysql_fetch_assoc($result)) {
	$graph_data['prices'][] = $row['unit_price'];
	$graph_data['dates'][]	= $row['order_timestamp'];
  }

  $graph->SetScale("textint", min($graph_data['prices'])*0.95, max($graph_data['prices']));
  $graph->title->Set("Price Fluctuation");
  $graph->subtitle->Set($title);
  $graph->yaxis->SetTitle("Price ($)", "middle");
  $graph->xaxis->SetTitle("Order Date", "middle");
  $graph->xaxis->SetTickLabels($graph_data['dates']);
  $bplot = new BarPlot($graph_data['prices']);
  break;
case "location_totals":
  $from_date = $_GET['from'];
  $to_date = $_GET['to'];
  if(!empty($from_date) && !empty($to_date)) {
    $date_sql = " AND DATE(po.order_timestamp) BETWEEN '$from_date' AND '$to_date' ";
  }

  $sql = "
	SELECT DATE_FORMAT(po.order_timestamp,'%Y-%m-%d') as ordertime, format(sum(qty*unit_price), 2) as total
	FROM item_order, po
	WHERE order_loc = $id
	AND item_order.order_id = po.order_id
	$date_sql
	GROUP BY po.order_id
	ORDER BY po.order_id DESC
	LIMIT 15
  ";
 
  $title_sql = "SELECT loc_name FROM location WHERE loc_id = $id";
  $title_result = mysql_query($title_sql);
  while($row = mysql_fetch_assoc($title_result)) {
    $title = $row['loc_name'];
  }



  $graph_data = array(
	"totals"	=> array(),
	"locations"	=> array()
  );

  $result = mysql_query($sql);
  while ($row=mysql_fetch_assoc($result)) {
	$graph_data['orders'][] = $row['ordertime'];
	$graph_data['totals'][]	= (float)$row['total'];
  }

  $graph->SetScale("textint", min($graph_data['totals'])*0.95, max($graph_data['totals']));
  $graph->title->Set("Location Invoice Totals");
  $graph->subtitle->Set($title);
  $graph->yaxis->SetTitle("Price ($)", "middle");
  $graph->xaxis->SetTitle("Order ID", "middle");
  $graph->xaxis->SetTickLabels($graph_data['orders']);
  $bplot = new BarPlot($graph_data['totals']);
  
  break;
default:
  exit;
  break;
}
//echo "<pre>";
//print_r($graph_data['totals']);
$graph->yaxis->SetTitleMargin(30);
$graph->xaxis->SetLabelAngle(90);
$graph->xaxis->SetTitleMargin(70);


$bplot->SetFillColor("lightgreen");
$bplot->value->Show();
$bplot->value->SetColor("black", "navy");

$graph->Add($bplot);
$graph->Stroke();

?>
