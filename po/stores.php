
<?
if ($msgid) {
echo "<center><div class=\"msg\">" . $msg[$_GET['msgid']] . "</div></center>";
}
?>
<div id="title">Store Locations</div>


<table width="600" border="1" class="small_txt">
<tr>
<th><strong>Name</strong></th>
<th><strong>Address</strong></th>
<th><strong>City</strong></th>
<th><strong>State</strong></th>
<th><strong>Zip</strong></th>
<th><strong>Phone</strong></th>
</tr>

<?
$sql = "SELECT * FROM location ORDER BY loc_id ASC";
$result = mysql_query($sql);
while ($row=mysql_fetch_array($result)) {
echo "<tr>";
echo "<td>$row[loc_name]</td>";
echo "<td>$row[loc_address]</td>";
echo "<td>$row[loc_city]</td>";
echo "<td>$row[loc_state]</td>";
echo "<td>$row[loc_zip]</td>";
echo "<td>$row[direct_phone]</td>";
echo "</tr>";
}
?>

</table>
<br>
<br>

<strong>Add Store</strong>

<form method="post" action="stores2.php"><br />

<table border="0" class="submit_table" style="border-width:0px">
<tr>
<th>Store Name:</th>
<td><input type="text" name="loc_name"></td>
</tr>

<tr>
<th>Address:</th>
<td> <input type="text" name="loc_address"></td>
</tr>

<tr>
<th>City:</th>
<td><input type="text" name="loc_city"></td>
</tr>

<tr>
<th>State:</th>
<td><input type="text" name="loc_state"></td>
</tr>

<tr>
<th>Zip:</th>
<td><input type="text" name="loc_zip"></td>
</tr>

<tr>
<th>Direct Phone:</th>
<td><input type="text" name="direct_phone"></td>
</tr>

<tr>
<td colspan="2">
<input type="hidden" name="curr_action" value="add"><input type="hidden" value="index.php?p=stores" name="current_url"><input class="submit" type="submit" value="Add Store">
</td>
</tr>
</table>
</form>