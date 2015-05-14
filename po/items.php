<div id="title">Manage Items</div>
<script type="text/javascript">
var url = "items2.php";
var params = {
	id: "",
	content: "",
	field: "",
	curr_action: "edit"
};
var num_params = Object.clone(params);
var name_params = Object.clone(params);
var price_params = Object.clone(params);
var yield_params = Object.clone(params);
var menu_price_params = Object.clone(params);

num_params.field = "item_num";
name_params.field = "item_name";
price_params.field = "item_set_price";
yield_params.field = "item_yield";
menu_price_params.field = "item_menu_price";
</script>
[<a href="#add">Add Item</a>]<br /><br />

<form method="GET" action="index.php?p=items" name="vendorform">
<select name="vid">
<?
$vid = $_GET['vid'];
if (!$vid) {
$vid = 3;
}
$sql = "SELECT * FROM `vendor` ORDER BY v_name ASC";
$result = mysql_query($sql);
while ($vrow=mysql_fetch_array($result)) {
if ($vrow['vid']==$vid) {
  echo "<option value=\"$vrow[vid]\" selected>$vrow[v_name]</option>";
  }
else {
  echo "<option value=\"$vrow[vid]\">$vrow[v_name]</option>";
} // end else  
} // end while
?>
</select>
<input type="hidden" name="p" value="items">
<input type="submit" value="Go">
</form>

<table border="1">
<tr>
<td colspan="7">
<a name="add"></a>
<form method="post" action="items2.php">
<strong>Item #:</strong> <input type="text" name="item_num"><br />  
<strong>Item Name:</strong> <input type="text" name="item_name"><br />  
<strong>Vendor:</strong> <select name="item_vendor">
<?
$sql = "SELECT * FROM vendor ORDER BY v_name ASC";
$result = mysql_query($sql);
while ($row=mysql_fetch_array($result)) {
if ($vid==$row['vid']) {
$selected = " selected";
}
else {
$selected = "";
}
echo "<option value=\"$row[vid]\"$selected>$row[v_name]</option>";
}
?>
</select> <br />
<input type="hidden" name="curr_action" value="additem"><input type="hidden" value="index.php?p=items" name="current_url"><input class="submit" type="submit" value="Add Item">
</form>
</td>
</tr>

<tr>
<th width="55"><strong>Item #</strong></th>
<th><strong>Item</strong></th>
<th><strong>Vendor</strong></th>
<th><strong>Set Price</strong></th>
<th><strong>Yield</strong></th>
<th><strong>Menu Price</strong></th>
<th>&nbsp;</th>
<th>&nbsp;</th>
</tr>

<?
$sql = "SELECT item.*,item.hide AS itemhide,vendor.* FROM item,vendor WHERE item.item_vendor=vendor.vid AND item.item_vendor=$vid ORDER BY item.item_name ASC";
$result = mysql_query($sql);
while ($row=mysql_fetch_array($result)) {
$item_num = ($row[item_num]) ? $row[item_num] : "&nbsp;";
$item_name = ($row[item_name]) ? $row[item_name] : "&nbsp;";
$item_set_price = ($row[item_set_price]) ? $row[item_set_price] : "&nbsp;";
$item_yield = ($row[item_yield]) ? $row[item_yield] : "&nbsp;";
$item_menu_price = ($row[item_menu_price]) ? $row[item_menu_price] : "&nbsp;";
$hide = $row['itemhide'];

if ($hide==1) {
$hidetoggle = "unhide";
$rowcolor = " bgcolor=\"#CCCCCC\"";
}
else {
$hidetoggle = "hide";
}
echo "<tr$rowcolor>";
echo "<td align=\"center\" class='editinplace'><div id='a$row[item_id]'>$item_num</div><script type='text/javascript'>makeEditable('a$row[item_id]', url, num_params);</script></td>";
echo "<td class='editinplace'><div id='b$row[item_id]'>$item_name</div><script type='text/javascript'>makeEditable('b$row[item_id]', url, name_params);</script></td>";
echo "<td>$row[v_name]</td>";
echo "<td class='editinplace'><div id='c$row[item_id]'>$item_set_price</div><script type='text/javascript'>makeEditable('c$row[item_id]', url, price_params);</script></td>";
echo "<td class='editinplace'><div id='d$row[item_id]'>$item_yield</div><script type='text/javascript'>makeEditable('d$row[item_id]', url, yield_params);</script></td>";
echo "<td class='editinplace'><div id='e$row[item_id]'>$item_menu_price</div><script type='text/javascript'>makeEditable('e$row[item_id]', url, menu_price_params);</script></td>";
//echo "<td>$row[item_set_price]</td>";
echo "<td>[<a href=\"items2.php?item_id=$row[item_id]&curr_action=$hidetoggle&vid=$vid\">$hidetoggle</a>]</td>";
echo "<td>&nbsp;</td>";
echo "</tr>";
$rowcolor = "";
}
?>


</table>
<br />
[<a href="#top">Top</a>]<br />

<br />

