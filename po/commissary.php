<div id="title">Manage Commissary Items</div>
<script type="text/javascript">
var url = "commissary2.php";
var params = {
	id: "",
	content: "",
	field: "",
	curr_action: "edit"
};

var name_params = Object.clone(params);
var price_params = Object.clone(params);
var notes_params = Object.clone(params);
var size_params = Object.clone(params);


name_params.field = "item_name";
price_params.field = "item_price";
notes_params.field = "item_notes";
size_params.field = "item_size";
</script>
[<a href="index.php?p=comm_costs">Run Commissary Costs Sheet Report</a>]<br /><br />

Raw items<br>


<table border="1">
<tr>
<th><strong>Item Name</strong></th>
<th><strong>Current Price</strong></th>
<th><strong>Size (oz)</strong></th>
<th><strong>Notes</strong></th>
<th><strong>Last Updated</strong></th>
<th><strong>&nbsp;</strong></th>
</tr>

<?
$sql = "SELECT * FROM `comm_item` WHERE hide!=1 ORDER BY item_name ASC";

$result = mysql_query($sql);

while ($row=mysql_fetch_array($result)) {

$item_name = ($row[item_name]) ? $row[item_name] : "&nbsp;";
$item_price = ($row[item_price]) ? $row[item_price] : "&nbsp;";
$item_notes = ($row['item_notes']) ? $row['item_notes'] : "&nbsp;";
$item_size = ($row['item_size']) ? $row['item_size'] : "&nbsp;";
$hide = $row['itemhide'];
$last_updated = $row['last_updated'];
$last_updated = date("m/d/y",$last_updated);
$time=time();
$diff=$time-$row['last_updated'];
$diff=$diff/86400;
$diff=round($diff);
if ($diff>=10) {
$last_updated = "<strong>" . $last_updated . "</strong>";	
}



if ($hide==1) {
$hidetoggle = "unhide";
$rowcolor = " bgcolor=\"#CCCCCC\"";
}

else {
$hidetoggle = "hide";
}
echo "<tr$rowcolor>";
echo "<td class='editinplace'><div id='a$row[cid]'>$item_name</div><script type='text/javascript'>makeEditable('a$row[cid]', url, name_params);</script></td>";
echo "<td class='editinplace'><div id='b$row[cid]'>$item_price</div><script type='text/javascript'>makeEditable('b$row[cid]', url, price_params);</script></td>";
echo "<td class='editinplace'><div id='d$row[cid]'>$item_size</div><script type='text/javascript'>makeEditable('d$row[cid]', url, size_params);</script></td>";
echo "<td class='editinplace'><div id='c$row[cid]'>$item_notes</div><script type='text/javascript'>makeEditable('c$row[cid]', url, notes_params);</script></td>";
echo "<td align=\"center\">$last_updated</td>";
echo "<td align=\"center\">[<a href=\"commissary2.php?curr_action=hide&cid=$row[cid]\">Hide</a>]</td>";

//echo "<td>[<a href=\"items2.php?item_id=$row[item_id]&curr_action=$hidetoggle&vid=$vid\">$hidetoggle</a>]</td>";
//echo "<td>&nbsp;</td>";
echo "</tr>";
$rowcolor = "";
} // end while
?>

<tr>
<td colspan="5">
<a name="add"></a>
<form method="post" action="commissary2.php">
<strong>Item Name:</strong> <input type="text" name="item_name"><br />  
<strong>Item price ($):</strong> <input type="text" name="item_price"><br />  
<strong>Notes:</strong> <input type="text" name="item_notes"><br />
 <br />
<input type="hidden" name="curr_action" value="additem"><input type="hidden" value="index.php?p=commissary" name="current_url"><input class="submit" type="submit" value="Add Item">
</form>
</td>
</tr>
</table>
<br />
Cooked items
<br>

<table border="1">
<tr>
<th><strong>Item Name</strong></th>
<th><strong>Item yield (lbs)</strong></th>
<th><strong>&nbsp;</strong></th>
<th><strong>&nbsp;</strong></th>

</tr>

<tr>
<?
$sql = "SELECT * FROM `comm_finalitem` WHERE hide!=1 ORDER BY item_name ASC";
$result = mysql_query($sql);

while ($row=mysql_fetch_array($result)) {
echo "<tr>";
echo "<td>$row[item_name]</td>";
echo "<td>$row[item_yield]</td>";
echo "<td>[<a href=\"index.php?p=comm_editfinal&item_id=$row[item_id]\">Edit</a>]</td>";
echo "<td>[<a href=\"commissary2.php?curr_action=hidefinal&item_id=$row[item_id]\">X</a>]</td>";
echo "</tr>";
}
?>
</tr>

<tr>
<td colspan="4">
<form method="post" action="commissary2.php">
<strong>Item Name:</strong> <input type="text" name="item_name"><br />  
<strong>Item Yield (lbs):</strong> <input type="text" name="item_yield"><br />  
 <br />
<input type="hidden" name="curr_action" value="addfinalitem"><input type="hidden" value="index.php?p=commissary" name="current_url"><input class="submit" type="submit" value="Add Item">
</form>
</td>
</tr>

</table>


[<a href="#top">Top</a>]<br />

<br />

