<?
$item_id = $_GET['item_id'];
$cid = $_GET['cid'];

$sql = "SELECT comm_component.*,comm_item.item_name,comm_finalitem.item_name AS finalitem_name FROM comm_component,comm_item,comm_finalitem WHERE comm_component.cid=$cid AND comm_component.item_id=$item_id AND comm_component.cid=comm_item.cid AND comm_finalitem.item_id=comm_component.item_id";
//echo $sql;
$result = mysql_query($sql);
$row = mysql_fetch_array($result);
$item_name = $row['item_name'];
$quantity = $row['quantity'];
$finalitem_name = $row['finalitem_name'];
//$item_id = $row['item_id'];
?>


<div id="title">Editing <em><?=$item_name ?></em> from the prepared item: <em><?=$finalitem_name?></em></div>



<form method="post" action="comm_editfinal3.php">
<table width="500" border="1">
<tr>
<th>Ingredient</th>
<td><?=$item_name ?><input type="hidden" name="item_id" value="<?=$item_id?>"><input type="hidden" name="cid" value="<?=$cid?>"></td></tr>

<tr>
<th>Quantity (oz)</th>
<td><input type="text" name="quantity" value="<?=$quantity?>"></td>
</tr>

<tr>
<td colspan="2">
<input type="submit" value="Save Changes">
</td>
</tr>


</table>
</form>

<?
//$sql = "SELECT comm_item.*,comm_component.*,comm_item.item_name AS ingredient FROM comm_item,comm_component WHERE comm_component.item_id=$item_id AND comm_item.cid=comm_component.cid ORDER BY comm_item.item_name ASC";

//$result = mysql_query($sql);
//$row = mysql_fetch_array($result);


?>
<br>
<a href="index.php?p=commissary">Back to Commissary Items Page</a>
