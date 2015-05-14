<?
// LIMIT DATES
$date1 = $_POST['date1'];
$date2 = $_POST['date2'];

if (!$date1 && !$date2) {
$date1 = $_GET['date1'];
$date2 = $_GET['date2'];
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
//////////////
?>