<div id="title">View Reports</div>

<h3>Item Price Fluctuation</h3>
<form method="post" action="index.php?p=r_itempricefluc">
<table>
<tr>
<th>Item Price</th>
<td>
<select name="item_id">
<?
$sql = "SELECT * FROM `item` WHERE hide!=1 ORDER BY item_name ASC";
$sql = "SELECT item.item_name,item.item_id,vendor.hide,vendor.vid,vendor.v_name FROM item,vendor WHERE item.item_vendor=vendor.vid AND item.hide!=1 AND vendor.hide!=1 ORDER BY vendor.v_name ASC,item.item_name ASC";
$result = mysql_query($sql);
while ($row=mysql_fetch_array($result)) {
echo "<option value=\"$row[item_id]\">$row[v_name] - $row[item_name]</option>";
}
?>
</select>

<input type="submit" value="Run" /><br />
Limit Dates: 
<input type="text" size="10" value="YYYYMMDD" name="date1" onFocus="doClear(this)" /> to
<input type="text" size="10" value="YYYYMMDD" name="date2" onFocus="doClear(this)" />
</td>
</tr>

</table>
</form>

<h3>Location Invoice Totals</h3>
<form method="post" action="index.php?p=r_locationinvoicetotal">
<table>
<tr>
<th>Location</th>
<td>
<select name="loc_id" style="width:100%">
<?
$sql = "SELECT * FROM `location` ORDER BY loc_name ASC";
$result = mysql_query($sql);
while ($row=mysql_fetch_array($result)) {
echo "<option value=\"$row[loc_id]\">$row[loc_name]</option>";
}
?>
</select>
<br />

<select name="vid">
<option value="all">ALL Vendors</option>
<?
$sql = "SELECT * FROM `vendor` WHERE hide!=1 ORDER BY v_name ASC";
$result = mysql_query($sql);
while ($row=mysql_fetch_array($result)) {
echo "<option value=\"$row[vid]\">$row[v_name]</option>";
}
?>
</select><br />
Limit Dates: 
<input type="text" size="10" value="YYYYMMDD" name="date1" onFocus="doClear(this)" /> to
<input type="text" size="10" value="YYYYMMDD" name="date2" onFocus="doClear(this)" /><br />
<input type="submit" value="Run" />
</td>
</tr>
</table>
</form>


<h3>Food Cost Percentage</h3>
<form method="post" action="index.php?p=r_foodcostpct">
<table>
<tr>
<th>Item</th>
<td>
<select name="item_id">
<?
$sql = "SELECT * FROM `item` WHERE hide!=1 ORDER BY item_name ASC";
$result = mysql_query($sql);
while ($row=mysql_fetch_array($result)) {
echo "<option value=\"$row[item_id]\">$row[item_name]</option>";
}
?>
</select>
</td>
</tr>


<tr>
<td colspan="2">
Limit Dates: 
<input type="text" size="10" value="YYYYMMDD" name="date1" onFocus="doClear(this)" /> to
<input type="text" size="10" value="YYYYMMDD" name="date2" onFocus="doClear(this)" /><br />
<input type="submit" value="Run" /></td>
</tr>
</table>
</form>

<h3>Location Invoice Totals (new)</h3>
<form method="get" action="index.php">
<input type="hidden" name="p" value="r_locationinvoicetotal2" />
<table>
<tr>
<th>Location</th>
<td>
<select name="loc_id" style="width:100%">
<?
$sql = "SELECT * FROM `location` ORDER BY loc_name ASC";
$result = mysql_query($sql);
while ($row=mysql_fetch_array($result)) {
echo "<option value=\"$row[loc_id]\">$row[loc_name]</option>";
}
?>
</select>
<br />

<?
define('weeks',6);
	define('label_df','%A %m/%d/%Y');
	define('value_df','%Y%m%d');
	
	$a = getdate();
	$sun = $a[0] - $a['wday'] * 86400;
	echo '<select name="daterange">';
	for ($weeks_ago = 0;$weeks_ago < weeks;$weeks_ago++)
	{
		$mon = $sun - 6 * 86400;
		$l = strftime(label_df,$mon) . '-' . strftime(label_df,$sun);
		$v = strftime(value_df,$mon) . '-' . strftime(value_df,$sun);
		echo '<option value="' . $v . '" label="' . $l . '">' . $l . '</option>';
		$sun -= 7 * 86400;
	}
	echo '</select>';
?>
<!--
Limit Dates: 
<input type="text" size="10" value="YYYYMMDD" name="date1" onFocus="doClear(this)" /> to
<input type="text" size="10" value="YYYYMMDD" name="date2" onFocus="doClear(this)" />--><br />
<input type="submit" value="Run" />
</td>
</tr>
</table>
</form>
