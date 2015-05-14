<div id="title">Inventory</div>

<form method="post" action="">

<table width="400" border="1">

<tr>
<th><strong>Location:</strong> </th>
<td>
<select name="loc_id">
<?
$sql = "SELECT * FROM location ORDER BY loc_name ASC";
$result = mysql_query($sql);
while($row=mysql_fetch_array($result)){
echo "<option value=\"$row[loc_id]\">$row[loc_name]</option>";
}
?>
</select>
</td>
</tr>

</table>

</form>