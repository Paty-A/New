<div id="title">Create Order</div>

<form method="post" action="create2.php">
<table width="400" border="1">
<tr>
<th><strong>User:</strong></th>
<td> 
<select name="user_id">
<?
$sql = "SELECT * FROM user ORDER BY user_lname ASC";
$result = mysql_query($sql);
while($row=mysql_fetch_array($result)){
echo "<option value=\"$row[user_id]\">$row[user_lname], $row[user_fname]</option>";
}
?>
</select>
</td>
</tr>

<tr>
<th><strong>Location:</strong> </th>
<td>
<select name="loc_id">
<?
$sql = "SELECT * FROM location WHERE hide!=1 ORDER BY loc_name ASC";
$result = mysql_query($sql);
while($row=mysql_fetch_array($result)){
echo "<option value=\"$row[loc_id]\">$row[loc_name]</option>";
}
?>
</select>
</td>
</tr>


<tr>
<th><strong>Vendor: </th>
<td>
<select name="vid">
<?
$sql = "SELECT * FROM vendor WHERE hide!=1 ORDER BY v_name ASC";
$result = mysql_query($sql);
while($row=mysql_fetch_array($result)){
echo "<option value=\"$row[vid]\">$row[v_name]</option>";
}
?>
</select>
</td>
</tr>


<tr>
<th><strong>Order Date:</strong></th>
<td><input type="text" name="month" value="<?=date("m")?>" size="4">/<input type="text" name="day" size="4" value="<?=date("d")?>">/<input type="text" name="year" size="4" value="<?=date("Y")?>"></td></tr>

<tr><td colspan="2"><input class="submit" type="submit" value="Create Order"></td></tr>

</table>
</form>