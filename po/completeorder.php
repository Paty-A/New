<?
$order_id = $_GET['order_id'];
$emailtxt = "";
$faxemail = "faxout@faxthruemail.com";

// TESTING MODE
$testing = false;

if ($testing) {
echo "TESTING MODE ON";
}
?>

<div id="title">Complete Order #<?=$order_id?></div>


<?
// Pull global order info
$sql = "
SELECT po.*,location.* 
FROM po,location 
WHERE po.order_loc=location.loc_id 
AND order_id = $order_id";
$result = mysql_query($sql);
$order = mysql_fetch_array($result);
$full_addr = $order['full_addr'];
$loc_name = $order['loc_name'];
$confirm_phone = $order['confirm_phone'];
$complete_timestamp = $order['complete_timestamp'];
$complete_timestamp = date('m/d/Y g:i:s A',$complete_timestamp);
$vid = $order['vid'];
$order_user = $order['order_user'];
$usql = "SELECT user_email FROM user WHERE user_id=$order_user";
$uresult = mysql_query($usql);
$urow = mysql_fetch_array($uresult);
$user_email = $urow['user_email'];

// 11=test  19=commissary
// check to see if this is an order for commissary
if ($vid==19) {
$comm=true;	
}

// Loop all ingredients from order
$sql = "
SELECT vendor.*,item_order.*,item.* 
FROM vendor,item_order,item 
WHERE item_order.order_id = $order_id 
AND item_order.item_id = item.item_id 
AND vendor.vid=item.item_vendor ORDER BY vendor.v_name ASC";

//echo $sql . "<Br>";
$result = mysql_query($sql);

  // Create Loop of unique vendors
while ($row=mysql_fetch_array($result)) {
  // Make sure loops through only unique vendors
  if ($tmp == $row['vid']) {
  //vendor has already gone through loop, move to next
  } // end if
  else {
  $tmp = $row['vid'];
  $v_name = $row['v_name'];
  $vid = $row['vid'];
  $v_email = $row['v_email'];
  $v_fax = $row['v_fax'];
  $v_address = $row['v_address']; 
  $v_phone = $row['v_phone'];
  
  
  // Check to see if archive entry has been created for this vendor in this order, if not, create one
  $countsql = "SELECT * FROM `archive` WHERE order_id=$order_id AND vid=$vid";
  $countresult = mysql_query($countsql);
  
  if (mysql_num_rows($countresult)==0) {
    $archsql = "INSERT INTO `archive` (order_id,vid) VALUES ($order_id,$vid)";
    mysql_query($archsql);
    echo "Created Archive Entry for $v_name<Br>";
  }
  
  $sql2 = "
  SELECT item.*,item_order.* 
  FROM item, item_order 
  WHERE item.item_vendor=$vid 
  AND item.item_id=item_order.item_id
  AND item_order.order_id=$order_id;
  ";
  //echo $sql2;
  $result2 = mysql_query($sql2);
  $emailtxt = ""; // reset variable
  $txtcontent = ""; // reset txt content variable
  $emailtxt .= "<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.01 Transitional//EN\">
<html><body>";
  $emailtxt .= "<p style=\"font-size:16px;font-weight:bold;\">Just Salad Purchase Order #$order_id</p>";
  $emailtxt .= "$full_addr<br>\n";
  //$emailtxt .= "<br>Please call $confirm_phone to confirm receipt of this order.\n";  

  //$txtcontent .= "";
  $emailtxt .= "Vendor: " . htmlspecialchars($v_name, ENT_QUOTES) . "<br>";
  $emailtxt .= "Address: " . htmlspecialchars($v_address, ENT_QUOTES) . "<br>";
  $emailtxt .= "Phone: " . htmlspecialchars($v_phone, ENT_QUOTES) . "<br>";
  $emailtxt .= $complete_timestamp;
  $emailtxt .= "<table border=1 cellpadding=3>\n";
  $emailtxt .= "<tr><th>Qty.</th><th>Item #</th><th>Item</th><th width=\"150\" nowrap>Comment</th>";
  if ($comm) {
   $emailtxt .= "<th>Item Price</th><th>Line Total</th>";  
  }
  $emailtxt .= "</tr>";
  // Print ingredients
  while ($vrow=mysql_fetch_array($result2)) {
    $item_name = htmlspecialchars($vrow['item_name'], ENT_QUOTES);
	$item_comment = htmlspecialchars($vrow['item_comment'], ENT_QUOTES);
	$item_set_price = htmlspecialchars($vrow['item_set_price'], ENT_QUOTES);
    $emailtxt .= "<tr>";
    $emailtxt .= "<td>$vrow[qty] &nbsp;</td>\n";
    $emailtxt .= "<td>$vrow[item_num] &nbsp;</td>\n";
	if ($vrow['url']!="") {
	  $emailtxt .= "<td><a href=\"$vrow[url]\">$item_name</a> &nbsp;</td>\n";
	}
	else {
      $emailtxt .= "<td>$item_name &nbsp;</td>\n";
	}
    $emailtxt .= "<td>$item_comment &nbsp;</td>\n";
	if ($comm) {
	  // Reset the line_total
	  $line_total = 0;
	  $emailtxt .= "<td>$$item_set_price &nbsp;</td>\n";
	  $line_total = $item_set_price*$vrow['qty'];
	  $line_total = round($line_total,2);
	  $emailtxt .= "<td>$$line_total &nbsp;</td>\n";
	  $grand_total = $grand_total+$line_total;
	}
	$emailtxt .= "</tr>";
  } // end $vrow while
  $emailtxt .= "</table><br>\n";
  if ($comm) {
	$emailtxt .= "<p style=\"font-size:16px;font-weight:bold;\">Grand Total: $$grand_total</p>";  
  }
  $emailtxt .= "Just Salad<br>\n";
  $emailtxt .= "$full_addr<br>\n";
  $emailtxt .= "<br>Please call $confirm_phone to confirm receipt of this order.\n";
  $emailtxt .= "</body></html>";
  // Store the content for this vendor in the archive
  $updatesql = "UPDATE `archive` SET content='$emailtxt' WHERE order_id=$order_id AND vid=$vid LIMIT 1";
  mysql_query($updatesql);
  
  $archsql = "SELECT * FROM `archive` WHERE order_id=$order_id AND vid=$vid";
  $archresult = mysql_query($archsql);
  $arow = mysql_fetch_array($archresult);
  //echo $arow['content'];
  
  if($arow['submitted']==1) {
  echo "<br>E-mail already sent.";
  }
  
  else {
  
  // SEND EMAIL
  
  $to = $v_email;
  $subject = "Just Salad Purchase Order #$order_id for $v_name";
  $contact_message = $arow['content'];
  $from_email = getSetting("from_email");
  $cc_email = "suling@justsalad.com,po@justsalad.com,ftorres@justsalad.com,$user_email";
  
  // Send to testing e-mail address if in testing mode
  if ($testing) {
    //$to = $faxemail;
	$to = "todo@mattsilv.com";
    $cc_email = "todo@mattsilv.com";
	$v_fax = "480-287-8293";
	$v_email = $faxemail; // test faxing without sending fax
  }
  
  // Reset headers/message
  $headers = "";
  $message = "";
  
  // Send special e-mail if it's a fax to vendor
  if ($v_email==$faxemail) {
    $subject = $v_fax;
    $mime_boundary = "<<<--==+X[".md5(time())."]";	
    $headers .= "From: $from_email\r\n";   
    $headers .= "CC: $cc_email\r\n"; 
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: multipart/mixed;\r\n";
    $headers .= " boundary=\"".$mime_boundary."\"";
    $message .= "This is a multi-part message in MIME format.\r\n";
    $message .= "\r\n";
    $message .= "--".$mime_boundary."\r\n";
    /*$message .= "Content-Type: text/plain; charset=\"iso-8859-1\"\r\n";
    $message .= "Content-Transfer-Encoding: 7bit\r\n";
    $message .= "\r\n";
    $message .= "Email content and what not: \r\n";
    $message .= "This is the file you asked for! \r\n";
    $message .= "--".$mime_boundary."\r\n";*/
    $message .= "Content-Type: application/octet-stream;\r\n";
    $message .= " name=\"justsalad.html\"\r\n";
    $message .= "Content-Transfer-Encoding: quoted-printable\r\n";
    $message .= "Content-Disposition: attachment;\r\n";
    $message .= " filename=\"justsalad.html\"\r\n";
    $message .= "\r\n";
    $message .= $contact_message;
    $message .= "\r\n";
    $message .= "--".$mime_boundary."\r\n";  	 
  
    mail($to, $subject, $message, $headers);	  
  } // end if fax to
  
  // Else, it's a regular e-mail vendor
  else {
  mail($to, $subject, $contact_message,
     "CC: $cc_email\r\n" .
     "From: $from_email\r\n" .
	 "Content-Type: text/html; charset=iso-8859-1\n" .
     "Reply-To: $from_email\r\n" .
     "X-Mailer: PHP/" . phpversion());
	 
   }
	 
  // Update archive row as sent
  
  // Disable IF testing mode is on
  if (!$testing) {
  $sql = "UPDATE `archive` SET submitted=1 WHERE order_id=$order_id AND vid=$vid LIMIT 1";
  mysql_query($sql);
  }
  echo "<Br>Purchase order sent for <strong>$v_name</strong> to $to<Br>";
  // END SEND EMAIL
  
  sleep(2);
  
  }
  
  
  } // end else

  
} // end $row while
//echo $emailtxt;
?>