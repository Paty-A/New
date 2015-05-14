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
$vid = $row['vid'];
$vsql = "SELECT * FROM vendor WHERE vid=$vid";
$vresult = mysql_query($vsql);
$vrow = mysql_fetch_array($vresult);
$v_name = $vrow['v_name'];

// CHECK IF ORDER IS COMPLETE
if ($row['order_complete']==1) {
$order_complete = true;
}
else {
$order_complete = false;
}

?>
<script type="text/javascript">var curr_order = '<?=$order_id?>';</script>

<div id="title">Order #<?=$order_id?> - <?=$order_date?> - <?=$row['loc_name']?><br />
Vendor: <?=$v_name?></div>

<strong>Order Created By:</strong> <?=$row['user_fname'] . " " . $row['user_lname']?>
<br />
<br />

<?
if ($order_complete) {
echo "<br>";
echo "<strong>Order Completed On:</strong> $complete_timestamp";
echo "<br><br>";

$sql = "";

}
?>
<script type="text/javascript">
var params = {
	curr_action: "editcomment",
	id: "",
	content: "",
	order_id: <?=$order_id?>
};
var url = "order2.php";

function update_list() {
	new Ajax.Request("order2.php", {
		method: "post",
		parameters: { vid: $F('vid'), curr_action: "listitems", oid: <?=$order_id?> },
		onSuccess: function(transport) {
			$('item_id_w').innerHTML = transport.responseText;
		}	
	});		
}
</script>
<table border="1">
<tr>
<th><strong>Qty.</strong></th>
<th><strong>Item #</strong></th>
<th><strong>Item</strong></th>
<th><strong>Vendor</strong></th>
<th width="150"><strong>Comment</strong></th>
<th>&nbsp;</th>
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
echo "<tr>";
echo "<td>$row[qty]</td>";
echo "<td>$row[item_num]</td>";
echo "<td>$row[item_name]</td>";
echo "<td>$row[v_name]</td>";
echo "<td class=\"editinplace\"><div id=\"item$row[item_id]\">$item_comment</div><script type=\"text/javascript\">makeEditable(\"item$row[item_id]\", url, params);</script></td>";
  if ($order_complete) {
  echo "<td>&nbsp;</td>";
  } // end if
  else {
  echo "<td>[<a href=\"order2.php?curr_action=del&item=$row[item_id]&order=$order_id&vid=$_GET[vid]\">del</a>]</td>";
  } // end else
echo "</tr>";
}

?>


<? if (!$order_complete) { ?>
<tr>
<td colspan="5">
<form method="post" action="order2.php">
	<!--
    <select name="vid" id="vid" onChange="update_list()">
	<option value="">--All Vendors--</option>
	<?
	$sql = "SELECT * FROM vendor ORDER BY v_name ASC";
	$result = mysql_query($sql);
	while ($row=mysql_fetch_array($result)) {
	$selected = ($row['vid'] == $_GET['vid']) ? "selected='selected'" : "";
	echo "<option value=\"$row[vid]\" $selected>$row[v_name]</option>";
	}
	?>
	</select>
    -->
    <br />
<input type="text" name="qty" size="3" value="0">
<span id="item_id_w">
<select name="item_id" id="item_id">
<? 
//$item_vendor = ($_GET['vid']) ? "AND item_vendor = $_GET[vid]" : "";
$item_vendor = ($vid) ? "AND item_vendor = $vid" : "";
$sql = "SELECT * FROM `item` WHERE hide != 1 $item_vendor AND item_id NOT IN (SELECT item_id FROM item_order WHERE order_id = ".$order_id.") ORDER BY item_name ASC";
$result = mysql_query($sql);
while ($row=mysql_fetch_array($result)) {
echo "<option value=\"$row[item_id]\">$row[item_name]</option>";
}

?>

</select>
</span>
<input type="hidden" name="order_id" value="<?=$order_id ?>"><br />
<input type="text" name="item_comment" size="25" title="Comment" alt="Comment">
<input type="hidden" name="curr_action" value="additem">
<input type="submit" value="Add">
</form>
</td>
</tr>
<? } // end if order complete ?>
</table><br />

[<a href="#top">Top</a>]<br />
<br />

<? if (!$order_complete) { ?>
<form method="post" action="order2.php">
<input type="hidden" name="curr_action" value="complete" />
<input type="hidden" name="order_id" value="<?=$order_id?>"><br />


<input id="complete_button" type="submit" value="Complete Order" />

</form>
<? } // end if order complete 



?>
