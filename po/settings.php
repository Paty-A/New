<?
if ($msgid) {
echo "<center><div class=\"msg\">" . $msg[$_GET['msgid']] . "</div></center>";
}
?>

<div id="title">Settings</div>

<form method="post" action="settings2.php">
<table>

<?
$sql = "SELECT * FROM `setting` ORDER BY sname ASC";
$result = mysql_query($sql);
while ($row=mysql_fetch_array($result)) {
?>

<tr>
<th><?=$row['stitle']?>: </th>
<td><input type="text" name="<?=$row['sname']?>" value="<?=$row['svalue']?>" size="40" /></td>
</tr>

<?
} // end while
?>

<tr>
<td colspan="2">
<input type="hidden" name="curr_action" value="update" />
<input type="submit" value="Update" />
</td>
</tr>
</table>
</form>
<br />

<form method="post" action="settings2.php">
<table>

<tr>
<th>Unlock Order</th>
<td><input type="text" onclick="this.value=''" name="order_id" size="15" value="Enter Order ID" /></td>
</tr>

<tr>
<td colspan="2">
<input type="hidden" name="curr_action" value="unlock" />
<input type="submit" value="Unlock Order" />
</td>
</tr>
</table>
</form>
<br />

<form method="post" action="settings2.php">
<table>

<tr>
<th>Void Order</th>
<td><input type="text" onclick="this.value=''" name="order_id" size="15" value="Enter Order ID" /></td>
</tr>

<tr>
<td colspan="2">
<input type="hidden" name="curr_action" value="void_order" />
<input type="submit" value="Void Order" />
</td>
</tr>
</table>
</form>