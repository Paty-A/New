<?
$order_id = $_GET['order_id'];
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

if ($row['order_checkin']==1) {
$checkin = true;
}

?>
<div id="title">Check In Order #<?=$order_id?></div>
<br><br>
<a href="resend.php?order_id=<?=$order_id?>">Resend Order</a>
<?
$inlinecss ="font-size:10px;padding:1px 1px 1px 1px";
?>
<div id="saving" style="margin-bottom: 1em; visibility: hidden"><span style="background: #DDCC88; padding: 0.4em; font-size: 10px;">Saving...</span></div>

<table border="1">
<tr>
<th style="<?=$inlinecss?>"><strong>Qty.</strong></th>
<th style="<?=$inlinecss?>"><strong>Item #</strong></th>
<th style="<?=$inlinecss?>"><strong>Item</strong></th>
<th style="<?=$inlinecss?>"><strong>Vendor</strong></th>
<th style="<?=$inlinecss?>"><strong>Comment</strong></th>
<th style="<?=$inlinecss?>"><strong>Recv'd</strong></th>
<th style="<?=$inlinecss?>"><strong>Set Price</strong></th>
<th style="<?=$inlinecss?>"><strong>Unit Price</strong></th>
<th style="<?=$inlinecss?>"><strong>Returned</strong></th>
<th style="<?=$inlinecss?>"><strong>Comment 2</strong></th>
</tr>

<? 
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
$sql2 = "SELECT unit_price FROM item_order WHERE item_id=$row[item_id] AND unit_price!=0 ORDER BY order_id DESC LIMIT 1";
$result2 = mysql_query($sql2);
$row2 = mysql_fetch_array($result2);
echo "<tr onMouseOver=\"this.className='highlight'\" onMouseOut=\"this.className='normal'\" id=\"item_$row[item_id]\">";
echo "<td style=\"$inlinecss\">$row[qty]</td>";
echo "<td style=\"$inlinecss\">$row[item_num]</td>";
echo "<td style=\"$inlinecss\">$row[item_name]</td>";
echo "<td style=\"$inlinecss\">$row[v_name]</td>";
echo "<td style=\"$inlinecss\">$item_comment</td>";
echo "<td style=\"$inlinecss\" align=\"center\"><input style=\"$inlinecss\" type=\"checkbox\" name=\"received\" ".(($row[received]==1) ? "checked=\"checked\"" : "")." class=\"edit_check\"></td>";
echo "<td style=\"$inlinecss\">\$$row[item_set_price]</td>";
if (!$row['unit_price']) {
  $unit_price = $row2['unit_price'];
  $usql = "UPDATE item_order SET unit_price=$unit_price WHERE item_id=$row[item_id] AND order_id=$row[order_id] LIMIT 1";
  mysql_query($usql);
}
else {
  $unit_price = $row['unit_price'];
}
echo "<td style=\"$inlinecss\"><input style=\"$inlinecss\" type=\"text\" size=\"5\" name=\"unit_price\" class=\"edit\" value=\"$unit_price\"></td>";
echo "<td style=\"$inlinecss\"><input style=\"$inlinecss\" type=\"text\" name=\"num_returned\" class=\"edit\" size=\"3\" value=\"$row[num_returned]\"></td>";
echo "<td style=\"$inlinecss\"><input style=\"$inlinecss\" type=\"text\" name=\"item_comment2\" class=\"edit\" value=\"$row[item_comment2]\"></td>";
echo "</tr>";
}

?>

</table>
<?
if (!$checkin) {
?>

<script type="text/javascript">
document.getElementsByClassName("edit_check").each(function(el) {
	el.onclick = function() {
		$('saving').style.visibility = "visible";
		new Ajax.Request("checkin2.php", { 
			parameters: {
				order_id: <?=$order_id?>,
				item_id: el.parentNode.parentNode.id.replace("item_", ""),
				field: "received",
				content: el.checked ? 1 : 0,
				action: "edit"
			},
			onSuccess: function(t) { window.setTimeout(function() {$('saving').style.visibility = "hidden" }, 500); }
		});
	}
});
document.getElementsByClassName("edit").each(function(el) {
	el.onblur = function() {
		$('saving').style.visibility = "visible";
		new Ajax.Request("checkin2.php", {
			parameters: {
				order_id: <?=$order_id?>,
				item_id: el.parentNode.parentNode.id.replace("item_", ""),
				field: el.name,
				content: el.value,
				action: "edit"
			},
			onSuccess: function(t) { window.setTimeout(function() {$('saving').style.visibility = "hidden" }, 700); }
		});
	}
});
</script>


<br />

<?
$sql = "SELECT * FROM `po` WHERE order_id=$order_id";
$result = mysql_query($sql);
$row = mysql_fetch_array($result);
$product_credits = $row['product_credits'];
$shipping_tax = $row['shipping_tax'];
$order_check_total = $row['order_check_total'];
?>


<form method="post" action="checkin2.php">
<input type="hidden" name="order_id" value="<?=$order_id?>" />
<input type="hidden" name="action" value="complete" />
Please enter the total listed on the invoice sheet:<br />
$<input type="text" name="order_check_total" value="<?=$order_check_total?>"/>
<br />
<br />
Please enter any product credits:<br />
$<input type="text" name="product_credits" value="<?=$product_credits?>"/><br />
<br />
Enter shipping and tax carges:<br />
$<input type="text" name="shipping_tax" value="<?=$shipping_tax?>" /><br />
<br />


<input type="submit" id="complete_button" value="Complete Check-In" />
</form>
<?
} // end if not checked in
?>