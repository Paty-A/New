<?
$order_id = $_GET['order_id'];
$action = $_POST['action'];
// confirm checkin

if ($action=="confirm_checkin") {
  $update = "UPDATE `po` SET order_checkin=1 WHERE order_id=$order_id LIMIT 1";
  mysql_query($update);
  $update = "UPDATE `po` SET check_total_confirm=1 WHERE order_id=$order_id LIMIT 1";
  //echo $update;
  mysql_query($update);
  echo "**System Message** Check-in Completed<br><br>";
}

//


$sql = "
SELECT po.*,location.*, user.* 
FROM po,location,user 
WHERE po.order_loc=location.loc_id 
AND po.order_user=user.user_id 
AND po.order_id = $order_id";

$result = mysql_query($sql);
$row = mysql_fetch_array($result);
$order_date = substr($row['order_timestamp'],4,2) . "/" . substr($row['order_timestamp'],6,2) . "/"  . substr($row['order_timestamp'],0,4);
$complete_timestamp = $row['complete_timestamp'];
$complete_timestamp = date('m/d/Y g:i:s A',$complete_timestamp);
$shipping_tax = $row['shipping_tax'];
$product_credits = $row['product_credits'];

// Has the final order e-mail been sent already?
if ($row['order_final_email']==1) {
$email_sent = true;
}
else {
$email_sent = false;
}

$inlinecss ="font-size:10px;padding:1px 1px 1px 1px";
$grand_total = 0; // reset grand total variable
$final_order = "";


$final_order .= "<div style=\"font-size:larger;font-weight:bold\">Final Order #$order_id</div><br>";


$final_order .= "
<table border=\"1\">
<tr>
<th style=\"$inlinecss\"><strong>Qty.</strong></th>
<th style=\"$inlinecss\"><strong>Item #</strong></th>
<th style=\"$inlinecss\"><strong>Item</strong></th>
<th style=\"$inlinecss\"><strong>Vendor</strong></th>
<th style=\"$inlinecss\"><strong>Comment</strong></th>
<th style=\"$inlinecss\"><strong>Recv'd</strong></th>
<th style=\"$inlinecss\"><strong>Set Price</strong></th>
<th style=\"$inlinecss\"><strong>Unit Price</strong></th>
<th style=\"$inlinecss\"><strong>Returned</strong></th>
<th style=\"$inlinecss\"><strong>Comment 2</strong></th>
<th style=\"$inlinecss\"><strong>Line Total</strong></th>
</tr>";

$sql = "
SELECT item.*,vendor.*,item_order.* 
FROM item,vendor,item_order 
WHERE item.item_vendor=vendor.vid 
AND item_order.order_id = $order_id
AND item.item_id = item_order.item_id 
ORDER BY vendor.v_name ASC, item.item_name ASC";
//echo $sql;

$result = mysql_query($sql);
while ($row=mysql_fetch_array($result)) {
$item_comment = ($item_comment = $row['item_comment']) ? $item_comment : "&nbsp;";
$final_order .= "<tr id=\"item_$row[item_id]\">";
$final_order .= "<td style=\"$inlinecss\">$row[qty]</td>";
$final_order .= "<td style=\"$inlinecss\">$row[item_num]</td>";
$final_order .= "<td style=\"$inlinecss\">$row[item_name]</td>";
$final_order .= "<td style=\"$inlinecss\">$row[v_name]</td>";
$final_order .= "<td style=\"$inlinecss\">$item_comment</td>";
$final_order .= "<td style=\"$inlinecss\" align=\"center\"><input style=\"$inlinecss\" type=\"checkbox\" name=\"received\" ".(($row[received]==1) ? "checked=\"checked\"" : "")." class=\"edit_check\" disabled></td>";
$final_order .= "<td style=\"$inlinecss\">$row[item_set_price]</td>";
$final_order .= "<td style=\"$inlinecss\">$row[unit_price]</td>";
$final_order .= "<td style=\"$inlinecss\">$row[num_returned]</td>";
$final_order .= "<td style=\"$inlinecss\">$row[item_comment2]&nbsp;</td>";
$line_total = $row['qty']*$row['unit_price']; // calculate line total
$line_total = $line_total - $row['num_returned']*$row['unit_price']; // subtract returned items
$line_total = $line_total; // format line total to 2 decimal places
$final_order .= "<td style=\"$inlinecss\"><strong>\$$line_total</strong></td>";
$final_order .= "</tr>";

$grand_total = $grand_total + $line_total;
$grand_total = round($grand_total,2);
}

$grand_total = $grand_total + $shipping_tax - $product_credits;

$final_order .= "</table>";
$final_order .= "<br>Shipping/Tax: <strong>+$$shipping_tax</strong><br>";
$final_order .= "Product Credits: <strong>-$$product_credits</strong><br>";
$final_order .= "<div style=\"font-size:larger;font-weight:bold\">Grand Total: \$$grand_total</div>";

echo $final_order;


// Update Grand Total if it differs
$sql = "SELECT * FROM `po` WHERE order_id=$order_id";
$result = mysql_query($sql);
$row = mysql_fetch_array($result);

if ($grand_total!=$row['order_grand_total']) {
$sql2 = "UPDATE `po` SET order_grand_total='$grand_total' WHERE order_id=$order_id LIMIT 1";
mysql_query($sql2);
echo "<br><bR>**System Message** Total Updated. $row[order_grand_total] --> $grand_total<br>";
}
////////////////////

// Update order vendor if it has not been set.
$sql = "SELECT * FROM `po` WHERE order_id=$order_id";
$result = mysql_query($sql);
$row = mysql_fetch_array($result);
if (!$row['vid']) {
  $sql2 = "SELECT item.*,item_order.* FROM item,item_order WHERE item_order.order_id=$order_id and item.item_id=item_order.item_id LIMIT 1";
  $row2 = mysql_fetch_array(mysql_query($sql2));
  $vid = $row2['item_vendor'];
  $update = "UPDATE `po` SET vid=$vid WHERE order_id=$order_id LIMIT 1";
  mysql_query($update);
  echo "<br><br>**System Message** Vendor ID Update";
}
////////////////

// display warning if total entered on checkin.php differes from grand total calculated on finalorder.php
$sql = "SELECT * FROM `po` WHERE order_id=$order_id";
$result = mysql_query($sql);
$row = mysql_fetch_array($result);
$order_grand_total = $row['order_grand_total'];
$order_check_total = $row['order_check_total'];
$check_total_confirm = $row['check_total_confirm'];
if ($order_check_total!=0) {
  // display warning only if checkin has not been confirmed
  // Update order and set checkin status as false until total is confirmed
  if ($order_grand_total!=$order_check_total && $check_total_confirm!=1) {
  $update = "UPDATE `po` SET order_checkin=0 WHERE order_id=$order_id LIMIT 1";
  mysql_query($update);
  echo "<br><div class=\"warning\"><b>Warning:</b> The total you entered on the check-in page was <b>$$order_check_total</b>, but the grand total of this order calculates to <b>$$order_grand_total</b>.  Please verify that your check-in is correct.<br />
<br />
If $$order_grand_total is the correct total, confirm: <form method=\"post\" action=\"index.php?p=finalorder&order_id=$order_id\"><input type=\"hidden\" name=\"action\" value=\"confirm_checkin\"><input type=\"submit\" value=\"Confirm $$order_grand_total and Check-in Order\"></form><br />
<br />
Otherwise, please go back and <a href=\"index.php?p=checkin&order_id=$order_id\">verify checkin</a> for this order.
</div>";
  
  } // end if grand total check

} // end if checktotal != 0



//// Send E-mail
if (!$email_sent && $row['order_checkin']==1) {
  //$to = "todo@mattsilv.com";
  $to = "suling@justsalad.com";
  $cc_email = "todo@mattsilv.com";
  $from_email = "po@justsalad.com";
  $subject = "Just Salad Order #$order_id";
  mail($to, $subject, $final_order,
     "CC: $cc_email\r\n" .
     "From: $from_email\r\n" .
	 "Content-Type: text/html; charset=iso-8859-1\n" .
     "Reply-To: $from_email\r\n" .
     "X-Mailer: PHP/" . phpversion());
$sql = "UPDATE `po` SET order_final_email=1 WHERE order_id=$order_id LIMIT 1";
mysql_query($sql);
echo "<br><br>Final Order sent to $to";
}


else {
//echo "<br><br>E-mail already sent";
}

//////////////////////

/// ????



echo "<br>Invoice sheet total: <strong>$$order_check_total</strong><br>";
echo "Order Grand Total: <strong>$$order_grand_total</strong>";



//
?>



