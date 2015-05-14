<?
$item_id = $_GET['item_id'];
$finalitem = $item_id;

$sql = "SELECT * FROM `comm_finalitem` WHERE item_id=$item_id";
$result = mysql_query($sql);
$row = mysql_fetch_array($result);
$item_name = $row['item_name'];
$item_id = $row['item_id'];
$item_yield = $row['item_yield'];
?>


<div id="title">Edit Commissary Item: <?=$item_name?></div>

<form method="post" action="changeyield.php">
<input type="hidden" name="item_id" value="<?=$item_id?>">A batch of <?=$item_name?> Yields: <input type="text" name="item_yield" value="<?=$item_yield ?>" size="5">lbs 
<input type="submit" value="Save Changes">
</form>
<br>

One batch of <strong><?=$item_name ?></strong> contains:<br><br>


<table width="500" border="1">
<tr>
<th>Ingredient</th>
<th>Quantity (oz)</th>
<th>&nbsp;</th>
<th>&nbsp;</th>
</tr>

<?
$sql = "SELECT comm_item.*,comm_component.*,comm_item.item_name AS ingredient FROM comm_item,comm_component WHERE comm_component.item_id=$item_id AND comm_item.cid=comm_component.cid ORDER BY comm_item.item_name ASC";
//echo $sql;

$result = mysql_query($sql);

while ($row=mysql_fetch_array($result)) {
$cid = $row['cid'];
echo "<tr>";
echo "<td>$row[ingredient]</td>";
echo "<td>$row[quantity]</td>";
echo "<td>[<a href=\"index.php?p=comm_editfinal2&cid=$cid&item_id=$item_id\">Edit</a>]</td>";
echo "<td>[<a href=\"del_component.php?item_id=$item_id&cid=$cid\">X</a>]</td>";
echo "</tr>";
}

?>

<tr>
<td colspan="4">
<form method="post" action="commissary2.php">
<strong>Item:</strong> <select name="cid">
<?
$sql = "SELECT * FROM `comm_item` WHERE hide!=1 ORDER BY item_name ASC";

$result = mysql_query($sql);

while ($row=mysql_fetch_array($result)) {
echo "<option value=\"$row[cid]\">$row[item_name]</option>";
}

?>
</select><br />  
<strong>Quantity (oz):</strong> <input type="text" name="quantity"><br />  
 <br />
<input type="hidden" name="curr_action" value="addcomponent"><input type="hidden" value="<?=$item_id?>" name="item_id"><input class="submit" type="submit" value="Add Item">
</form>
</td>
</tr>


</table>

<a href="index.php?p=commissary">Back to Commissary Items Page</a>
